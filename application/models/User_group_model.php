<?php

class User_group_model extends MY_Model {
	public function __construct() {
		parent::__construct();
	}

	public function save(&$item) {
		if (empty($item['id'])) {
			$item['created'] = $item['updated'] = get_time();
			$result = $this->db->insert('user_group', $item);

			$item['id'] = $this->db->insert_id();
			$item['created'] = $item['updated'] = date_string();
		}
		else {
			$item['updated'] = get_time();
			$this->db->where('id', $item['id']);
			$result = $this->db->update('user_group', $item);

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
			->select('ug.id, ug.name, ug.title, ug.created, ug.updated')
			->from('user_group ug')
			->where('ug.id', $id)
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
			->select('id, concat(title, " (", id, ")") title, name')
			->order_by('title', 'ASC')
		;

		//echo $this->db->last_query();

		$result = $this->db->get('user_group')->result_array();

		return $result;
	}

	public function list_all($page = 1, $filter = '', &$pagy_config) {
		//$this->load->database();
		$this->load->library('pagination');

		$filter = strtolower($filter);

		$this->db
			->select('ug.id, ug.name, ug.title, ug.created, ug.updated')
			->from('user_group ug')
			->order_by('ug.title', 'ASC')
		;

		if ($filter != '') {
			$this->db->like('LOWER(ug.id)', $filter)
				->or_like('LOWER(ug.title)', $filter)
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

		//echo $this->db->last_query();

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
