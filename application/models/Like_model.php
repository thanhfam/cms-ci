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
			case CT_TF_REPORT:
			case CT_POST:
				$result = $this->db->update('post');
				break;

			case CT_COMMENT:
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
			case CT_TF_REPORT:
			case CT_POST:
				$result = $this->db->update('post');
				break;

			case CT_COMMENT:
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
			case CT_TF_REPORT:
			case CT_POST:
				$result = $this->db->update('post');
				break;

			case CT_COMMENT:
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

	public function list_all_post($page = 1, $filter = '', &$pagy_config) {
		$this->load->library('pagination');

		$this->db
			->select('l.id, p.title content_title, l.content_id, l.content_type, l.user_id, u.username, l.created, u.avatar_id, m.file_name, m.folder, m.type avatar_type, m.file_ext avatar_file_ext, m.content avatar_content')
			->from('like l')
			->join('user u', 'l.user_id = u.id')
			->join('media m', 'u.avatar_id = m.id', 'left')
			->join('post p', 'l.content_id = p.id')
			->order_by('l.id', 'DESC')
		;

		if (isset($filter) && ($filter != '')) {
			$filter = $this->to_utf8($filter);

			$this->db->group_start()
				->like('LOWER(l.id)', $filter)
				->or_like('LOWER(title)', $filter)
				->or_like('LOWER(content_type)', $filter)
				->or_like('LOWER(content_id)', $filter)
				->or_like('LOWER(username)', $filter)
				->or_like('LOWER(user_id)', $filter)
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
			$row['created'] = date_string($row['created']);

			if ($row['file_name']) {
				$row['avatar_url'] = base_url(F_FILE .$row['folder'] .'/' .$row['file_name']);
			}
			else {
				$row['avatar_url'] = '';
			}

			$list[] = $row;
		}

		//echo $this->db->last_query();

		return $list;
	}

	public function list_all_comment($page = 1, $filter = '', &$pagy_config) {
		$this->load->library('pagination');

		$this->db
			->select('l.id, c.comment content_title, l.content_id, l.content_type, l.user_id, u.username, l.created, u.avatar_id, m.file_name, m.folder, m.type avatar_type, m.file_ext avatar_file_ext, m.content avatar_content')
			->from('like l')
			->join('user u', 'l.user_id = u.id')
			->join('media m', 'u.avatar_id = m.id', 'left')
			->join('comment c', 'l.content_id = c.id')
			->order_by('l.id', 'DESC')
		;

		if (isset($filter) && ($filter != '')) {
			$filter = $this->to_utf8($filter);

			$this->db->group_start()
				->like('LOWER(l.id)', $filter)
				->or_like('LOWER(comment)', $filter)
				->or_like('LOWER(content_type)', $filter)
				->or_like('LOWER(content_id)', $filter)
				->or_like('LOWER(username)', $filter)
				->or_like('LOWER(user_id)', $filter)
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
			$row['created'] = date_string($row['created']);

			if ($row['file_name']) {
				$row['avatar_url'] = base_url(F_FILE .$row['folder'] .'/' .$row['file_name']);
			}
			else {
				$row['avatar_url'] = '';
			}

			$list[] = $row;
		}

		//echo $this->db->last_query();

		return $list;
	}
}
