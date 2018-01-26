<?php

class Like_model extends MY_Model {
	public function __construct() {
		parent::__construct();
	}

	public function save(&$item) {
		$item['created'] = get_time();

		$this->db->trans_begin();

		$this->db->insert('like', $item);

		$item['id'] = $this->db->insert_id();

		$this->increase_total($item);

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();

			return FALSE;
		}
		else {
			$this->db->trans_commit();

			return TRUE;
		}
	}

	public function is_liked($item) {
		$this->db
			->select('l.id, l.content_id, l.content_type, l.user_id, l.created')
			->from('like l')
			->where('l.content_id', $item['content_id'])
			->where('l.content_type', $item['content_type'])
			->where('l.user_id', $item['user_id'])
		;

		$item = $this->db->get()->row_array();

		return $item;
	}

	function increase_total($item) {
		$this->db
			->set('total_like', 'total_like + 1', FALSE)
			->where('id', $item['content_id']);

		$result =  FALSE;

		switch ($item['content_type']) {
			case 'tfreport':
			case 'post':
				$result = $this->db->update('post');
				break;

			case 'comment':
				$result = $this->db->update('comment');
				break;
			
			default:
		}

		return $result;
	}

	function decrease_total($item) {
		$this->db
			->set('total_like', 'total_like - 1', FALSE)
			->where('id', $item['content_id']);

		$result =  FALSE;

		switch ($item['content_type']) {
			case 'tfreport':
			case 'post':
				$result = $this->db->update('post');
				break;

			case 'comment':
				$result = $this->db->update('comment');
				break;
			
			default:
		}

		return $result;
	}

	public function update_total($item) {
		$this->db
			->select('COUNT(*)')
			->where('content_id', $item['content_id'])
			->where('content_type', $item['content_type'])
			->from('like')
		;

		$total_sql = $this->db->get_compiled_select();

		$this->db
			->set('total_like', "($total_sql)", FALSE)
			->where('id', $item['content_id'])
		;

		$result =  FALSE;

		switch ($item['content_type']) {
			case 'tfreport':
			case 'post':
				$result = $this->db->update('post');
				break;

			case 'comment':
				$result = $this->db->update('comment');
				break;
			
			default:
		}

		return $result;
	}

	public function get_total($item) {}

	public function remove($item) {
		$this->db->trans_begin();

		$this->db
			->where('id', $item['id'])
			->delete('like');

		$this->decrease_total($item);

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();

			return FALSE;
		}
		else {
			$this->db->trans_commit();

			return TRUE;
		}
	}

	public function list_all($page = 1, $filter = array(), &$pagy_config) {
		$this->load->library('pagination');

		$this->db
			->select('p.id, p.subtitle, p.title, pg.uri, si.url site_url, s.name state_name, s.weight state_weight, p.cate_id, c.title cate_title, p.created, p.updated, p.creator_id, u1.name creator_name, u1.username creator_username, p.updater_id, u2.name updater_name, u2.username updater_username')
			->from('post p')
			->join('user u1', 'p.creator_id = u1.id')
			->join('user u2', 'p.updater_id = u2.id')
			->join('state s', 'p.state_weight = s.weight')
			->join('category c', 'p.cate_id = c.id')
			->join('site si', 'c.site_id = si.id')
			->join('page pg', 'p.id = pg.content_id', 'left')
			->where('pg.content_type', CT_POST)
			->where('s.type', ST_CONTENT)
			->order_by('p.id', 'DESC')
		;

		if (isset($filter['cate_id']) && ($filter['cate_id'] != '')) {
			$this->db->where('p.cate_id', $filter['cate_id']);
		}

		if (isset($filter['state_weight']) && ($filter['state_weight'] != '')) {
			$this->db->where('p.state_weight', $filter['state_weight']);
		}

		if (isset($filter['keyword']) && ($filter['keyword'] != '')) {
			$keyword = $this->to_utf8($filter['keyword']);

			$this->db->group_start()
				->like('LOWER(p.id)', $keyword)
				->or_like('LOWER(p.subtitle)', $keyword)
				->or_like('LOWER(p.title)', $keyword)
				->group_end()
			;
		}

		$total_row = $this->db->count_all_results('', FALSE);
		$pagy_config['total_rows'] = $total_row;

		$per_page = $this->pagination->per_page;
		$last_page = ceil($total_row / $per_page);

		if (! isset($page)  || (! is_numeric($page)) || ($page < 1) || ($page > $last_page)) {
			$page = 1;
		}

		$from_row = ($page - 1) * $per_page;

		$this->db->limit($per_page, $from_row);

		$query = $this->db->query($this->db->get_compiled_select());

		$list = array();

		while ($row = $query->unbuffered_row('array')) {
			$row['updated'] = date_string($row['updated']);
			$row['created'] = date_string($row['created']);
			$list[] = $row;
		}

		//echo $this->db->last_query();

		return $list;
	}
}
