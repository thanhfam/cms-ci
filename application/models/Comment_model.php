<?php

class Comment_model extends MY_Model {
	public function __construct() {
		parent::__construct();
	}

	public function save(&$item) {
		$this->db->trans_begin();

		if (isset($item['old_state_weight'])) {
			$old_state_weight = $item['old_state_weight'];
			unset($item['old_state_weight']);
		}
		else {
			$old_state_weight = $item['state_weight'];
		}

		if (empty($item['id'])) {
			$item['created'] = $item['updated'] = get_time();

			$this->db->insert('comment', $item);

			$item['id'] = $this->db->insert_id();
		}
		else {
			$item['updated'] = get_time();

			$this->db
				->where('id', $item['id'])
				->update('comment', $item);

			$item['created'] = $this->input->post('created');
			$item['updated'] = date_string();
		}

		if ($old_state_weight != $item['state_weight']) {
			if ($item['state_weight'] == S_ACTIVATED) {
				echo 123;
				$this->increase_total($item);
			}

			if ($old_state_weight == S_ACTIVATED) {
				echo 456;
				$this->decrease_total($item);
			}
		}

		$item['old_state_weight'] = $item['state_weight'];

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();

			return FALSE;
		}
		else {
			$this->db->trans_commit();

			return TRUE;
		}
	}

	public function get($id = '') {
		if (!is_numeric($id)) {
			return FALSE;
		}

		$id = intval($id);

		$this->db
			->select('c.id, p.title content_title, c.content_id, c.content_type, c.comment, c.state_weight, c.created, c.updated, c.user_id, s.name state_name, u.name name, u.username username, u.avatar_id, m.file_name, m.folder, m.type avatar_type, m.file_ext avatar_file_ext, m.content avatar_content')
			->from('comment c')
			->join('user u', 'c.user_id = u.id')
			->join('post p', 'c.content_id = p.id')
			->join('media m', 'u.avatar_id = m.id', 'left')
			->join('state s', 'c.state_weight = s.weight')
			->where('s.type', ST_CONTENT)
			->where('c.id', $id)
		;

		$item = $this->db->get()->row_array();

		if ($item) {
			$item['created'] = date_string($item['created']);
			$item['updated'] = date_string($item['updated']);

			$item['old_state_weight'] = $item['state_weight'];

			if ($item['file_name']) {
				$item['avatar_url'] = base_url(F_FILE .$item['folder'] .'/' .$item['file_name']);
			}
			else {
				$item['avatar_url'] = '';
			}
		}

		return $item;
	}

	function increase_total($item) {
		$this->db
			->set('total_comment', 'total_comment + 1', FALSE)
			->where('id', $item['content_id']);

		$result =  FALSE;

		switch ($item['content_type']) {
			case CT_POST:
			case CT_TF_REPORT:
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
			->set('total_comment', 'total_comment - 1', FALSE)
			->where('id', $item['content_id']);

		$result =  FALSE;

		switch ($item['content_type']) {
			case CT_POST:
			case CT_TF_REPORT:
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
			->from('comment')
		;

		$total_sql = $this->db->get_compiled_select();

		$this->db
			->set('total_like', "($total_sql)", FALSE)
			->where('id', $item['content_id'])
		;

		$result =  FALSE;

		switch ($type) {
			case CT_POST:
			case CT_TF_REPORT:
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
			->delete('comment');

		if ($item['state_weight'] == S_ACTIVATED) {
			$this->decrease_total($item);
		}

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();

			return FALSE;
		}
		else {
			$this->db->trans_commit();

			return TRUE;
		}
	}

	public function list_all_comment($page = 1, $filter = array(), &$pagy_config) {
		$this->load->library('pagination');

		$this->db
			->select('c.id, p.comment content_title, c.content_id, c.content_type, c.comment, c.state_weight, c.created, c.updated, c.user_id, s.name state_name, u.name name, u.username username, u.avatar_id, m.file_name, m.folder, m.type avatar_type, m.file_ext avatar_file_ext, m.content avatar_content')
			->from('comment c')
			->join('user u', 'c.user_id = u.id')
			->join('comment p', 'c.content_id = p.id')
			->join('media m', 'u.avatar_id = m.id', 'left')
			->join('state s', 'c.state_weight = s.weight')
			->where('s.type', ST_CONTENT)
			->order_by('c.id', 'ASC')
		;

		if (isset($filter['state_weight']) && ($filter['state_weight'] != '')) {
			$this->db->where('c.state_weight', $filter['state_weight']);
		}

		if (isset($filter['keyword']) && ($filter['keyword'] != '')) {
			$keyword = $this->to_utf8($filter['keyword']);

			$this->db->group_start()
				->like('LOWER(c.id)', $keyword)
				->or_like('LOWER(c.comment)', $keyword)
				->or_like('LOWER(p.comment)', $keyword)
				->or_like('LOWER(c.content_id)', $keyword)
				->or_like('LOWER(u.username)', $keyword)
				->or_like('LOWER(c.user_id)', $keyword)
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

	public function list_all_post($page = 1, $filter = array(), &$pagy_config) {
		$this->load->library('pagination');

		$this->db
			->select('c.id, p.title content_title, c.content_id, c.content_type, c.comment, c.state_weight, c.created, c.updated, c.user_id, s.name state_name, u.name name, u.username username, u.avatar_id, m.file_name, m.folder, m.type avatar_type, m.file_ext avatar_file_ext, m.content avatar_content')
			->from('comment c')
			->join('user u', 'c.user_id = u.id')
			->join('post p', 'c.content_id = p.id')
			->join('media m', 'u.avatar_id = m.id', 'left')
			->join('state s', 'c.state_weight = s.weight')
			->where('s.type', ST_CONTENT)
			->order_by('c.id', 'ASC')
		;

		if (isset($filter['state_weight']) && ($filter['state_weight'] != '')) {
			$this->db->where('c.state_weight', $filter['state_weight']);
		}

		if (isset($filter['keyword']) && ($filter['keyword'] != '')) {
			$keyword = $this->to_utf8($filter['keyword']);

			$this->db->group_start()
				->like('LOWER(c.id)', $keyword)
				->or_like('LOWER(comment)', $keyword)
				->or_like('LOWER(title)', $keyword)
				->or_like('LOWER(content_type)', $keyword)
				->or_like('LOWER(content_id)', $keyword)
				->or_like('LOWER(username)', $keyword)
				->or_like('LOWER(user_id)', $keyword)
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

	public function list_all_activated($page = 1, $filter = array(), &$pagy_config) {
		$this->load->library('pagination');

		$this->db
			->select('c.id, c.content_id, c.content_type, c.comment, c.state_weight, c.created, c.updated, c.user_id, s.name state_name, u.name name, u.username username, u.avatar_id, m.file_name, m.folder, m.type avatar_type, m.file_ext avatar_file_ext, m.content avatar_content')
			->from('comment c')
			->where('c.content_type', $filter['content_type'])
			->where('c.content_id', $filter['content_id'])
			->join('user u', 'c.user_id = u.id')
			->join('media m', 'u.avatar_id = m.id', 'left')
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
