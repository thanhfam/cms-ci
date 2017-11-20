<?php

class state_model extends MY_Model {
	public function __construct() {
		parent::__construct();
	}

	public function save(&$item) {
		if ($item['id'] == '') {
			unset($item['id']);
			$result = $this->db->insert('state', $item);

			$item['id'] = $this->db->insert_id();
			$item['created'] = $item['updated'] = $this->get_time();
		}
		else {
			$this->db->where('id', $item['id']);
			$result = $this->db->update('state', $item);

			$item['created'] = $this->input->post('created');
			$item['updated'] = $this->get_time();
		}

		return $result;
	}

	public function get($id) {
		if (!isset($id)) {
			return FALSE;
		}

		$this->db
			->select('s.id, s.name, s.weight, s.type, s.created, s.updated')
			->from('state s')
			->where('s.id', $id)
		;

		$item = $this->db->get()->row_array();

		if ($item) {
			$item['created'] = $this->get_time($item['created']);
			$item['updated'] = $this->get_time($item['updated']);
		}

		return $item;
	}

	public function list_simple($type = 'content') {
		$this->load->helper(array('language'));

		$this->db
			->select('id, name, weight')
			->where('type', $type)
			->where('weight > -1')
			->order_by('id', 'ASC')
		;

		$result = $this->db->get('state')->result_array();

		return $result;
	}

	public function list_all($page = 1, $filter = '', &$pagy_config) {
		//$this->load->database();
		$this->load->library('pagination');

		$filter = $this->db->escape_str(trim(strtolower($filter)));

		$this->db
			->select('s.id, s.name, s.weight, s.type')
			->from('state s')
			->order_by('s.type', 'ASC')
			->order_by('s.weight', 'ASC')
		;

		if ($filter != '') {
			$this->db->like('LOWER(s.id)', $filter)
				->or_like('LOWER(s.name)', $filter)
				->or_like('LOWER(s.weight)', $filter)
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

		return $this->db->get()->result_array();
	}
}
