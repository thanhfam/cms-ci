<?php

class Right_model extends MY_Model {
	public function __construct() {
		parent::__construct();
	}

	public function save(&$item) {
		if (empty($item['id'])) {
			$item['created'] = $item['updated'] = get_time();
			$result = $this->db->insert('right', $item);

			$item['id'] = $this->db->insert_id();
			$item['created'] = $item['updated'] = date_string();
		}
		else {
			$item['updated'] = get_time();
			$this->db->where('id', $item['id']);
			$result = $this->db->update('right', $item);

			$item['created'] = $this->input->post('created');
			$item['updated'] = date_string();
		}

		//echo $this->db->last_query();

		return $result;
	}

	public function get($id = '') {
		if (!is_numeric($id)) {
			return FALSE;
		}

		$id = intval($id);

		$this->db
			->select('r.id, r.name, r.created, r.updated')
			->from('right r')
			->where('r.id', $id)
		;

		$item = $this->db->get()->row_array();

		if ($item) {
			$item['created'] = date_string($item['created']);
			$item['updated'] = date_string($item['updated']);
		}

		return $item;
	}

	public function list_simple() {
		$this->db
			->select('id, name')
			->order_by('name', 'ASC')
		;

		//echo $this->db->last_query();

		$result = $this->db->get('right')->result_array();

		return $result;
	}

	public function list_all($filter = array(), $page = 1, &$pagy_config = NULL) {
		$this->load->library('pagination');

		$this->db
			->select('r.id, r.name, r.created, r.updated')
			->from('right r')
			->order_by('r.name', 'ASC')
		;

		if (isset($filter['not_user_group_id']) && ($filter['not_user_group_id'] != '')) {
			$this->db
				->where_not_in('r.id', 'SELECT right_id FROM user_group_right WHERE user_group_id = ' .$filter['not_user_group_id'], FALSE)
			;
		}

		if (isset($filter['user_group_id']) && ($filter['user_group_id'] != '')) {
			$this->db
				->join('user_group_right ugr', 'r.id = ugr.right_id')
				->where('ugr.user_group_id', $filter['user_group_id'])
			;
		}

		// not allow others than ROOT assign RIGHT-*
		if ($this->session && $this->session->user['id'] != 1) {
			$this->db
				->not_like('name', 'RIGHT');
		}

		if (isset($filter['keyword']) && ($filter['keyword'] != '')) {
			$keyword = $this->to_utf8($filter['keyword']);

			$this->db->group_start()
				->like('LOWER(r.id)', $keyword)
				->or_like('LOWER(r.name)', $keyword)
				->group_end()
			;
		}

		if ($pagy_config) {
			$total_row = $this->db->count_all_results('', FALSE);
			$pagy_config['total_rows'] = $total_row;

			$per_page = $this->pagination->per_page;
			$last_page = ceil($total_row / $per_page);

			if (! isset($page)  || (! is_numeric($page)) || ($page < 1) || ($page > $last_page)) {
				$page = 1;
			}

			$from_row = ($page - 1) * $per_page;

			$this->db->limit($per_page, $from_row);
		}

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
