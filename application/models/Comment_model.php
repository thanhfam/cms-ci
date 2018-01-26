<?php

class Comment_model extends MY_Model {
	public function __construct() {
		parent::__construct();
	}

	public function save(&$item) {
		$item['created'] = $item['updated'] = get_time();

		$this->db->trans_begin();

		$this->db->insert('comment', $item);

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

	function increase_total($item) {
		$this->db
			->set('total_comment', 'total_comment + 1', FALSE)
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
			->set('total_comment', 'total_comment - 1', FALSE)
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
			->from('comment')
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
			->select('c.id, c.content_id, c.content_type, c.comment, c.state_weight, c.created, c.updated, c.user_id, s.name state_name, u.name name, u.username username')
			->from('comment c')
			->where('c.content_type', $filter['content_type'])
			->where('c.content_id', $filter['content_id'])
			->join('user u', 'c.user_id = u.id')
			->join('state s', 'c.state_weight = s.weight')
			->where('s.type', ST_CONTENT)
			->where('c.state_weight', S_INACTIVATED)
			->order_by('c.id', 'ASC')
		;

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
