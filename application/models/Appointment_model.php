<?php

class Appointment_model extends MY_Model {
	public function __construct() {
		parent::__construct();
	}

	public function save(&$item) {
		if (empty($item['id'])) {
			$result = $this->db->insert('appointment', $item);

			$item['id'] = $this->db->insert_id();
			$item['created'] = $item['updated'] = $this->get_time();
		}
		else {
			$this->db->where('id', $item['id']);
			$result = $this->db->update('appointment', $item);

			$item['created'] = $this->input->post('created');
			$item['updated'] = $this->get_time();
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
			->select('a.id, a.name, a.phone, a.email, a.address, a.time, a.summary, a.content, a.state_weight, a.updated, a.created')
			->from('appointment a')
			->where('a.id', $id)
		;

		$item = $this->db->get()->row_array();

		if ($item) {
			$item['created'] = $this->get_time($item['created']);
			$item['updated'] = $this->get_time($item['updated']);
		}

		return $item;
	}

	public function list_simple($site_id = '') {
		$this->db
			->select('id, concat(name, " (", id, ")") title')
			->order_by('id', 'ASC')
		;

		if ($site_id != '') {
			$this->db->where('site_id', $site_id);
		}

		//echo $this->db->last_query();

		$result = $this->db->get('appointment')->result_array();

		return $result;
	}

	public function list_all($page = 1, $filter = '', &$pagy_config) {
		//$this->load->database();
		$this->load->library('pagination');

		$filter = strtolower($filter);

		$this->db
			->select('a.id, a.name, a.phone, a.email, a.time, a.summary, a.content, a.state_weight, s.name state_name, a.updated, a.created')
			->from('appointment a')
			->join('state s', 'a.state_weight = s.weight')
			->where('s.type', 'appointment')
			->order_by('a.id', 'DESC')
		;

		if ($filter != '') {
			$this->db->like('LOWER(a.id)', $filter)
				->or_like('LOWER(a.name)', $filter)
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

		$result = $this->db->get()->result_array();

		return $result;
	}
}
