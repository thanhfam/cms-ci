<?php

class District_model extends MY_Model {
	public function __construct() {
		parent::__construct();
	}

	public function set() {
		//$this->load->database();

		$id = $this->input->post('id');

		$data = array(
			'id' => $id,
			'title' => $this->input->post('title'),
			'type' => $this->input->post('type'),
			'city_id' => $this->input->post('city_id')
		);

		if ($id) {
			$result = $this->db->update('district', $data);
		}
		else {
			$result = $this->db->insert('district', $data);
		}

		return $result;
	}

	public function get($id) {
		if ($id) {
			//$this->load->database();

			$query = $this->db
				->select('*')
				->where('id', $id)
				->get('district')
			;

			//echo $this->db->last_query();

			return $query;
		}
		else {
			return FALSE;
		}
	}

	public function list_simple($id = NULL) {
		$this->db
			->select('id, title')
			->order_by('id', 'ASC')
		;

		if ($id) {
			$this->db->where('city_id', $id);
		}

		return $this->db->get('district')->result_array();
	}

	public function list_all($page = 1, $filter = '', &$pagy_config) {
		//$this->load->database();
		$this->load->library('pagination');

		$filter = strtolower($filter);

		$this->db
			->select('d.id, d.title, d.type, c.id city_id, c.title city_title')
			->from('district d')
			->join('city c', 'd.city_id = c.id')
			->order_by('d.id', 'ASC')
			->like('LOWER(d.id)', $filter)
			->or_like('LOWER(d.title)', $filter)
			->or_like('LOWER(d.type)', $filter)
			->or_like('LOWER(c.id)', $filter)
			->or_like('LOWER(c.title)', $filter)
		;

		$total_row = $this->db->count_all_results('', FALSE);
		$pagy_config['total_rows'] = $total_row;

		$per_page = $this->pagination->per_page;
		$last_page = floor($total_row / $per_page);

		if (! isset($page)  || (! is_numeric($page)) || ($page < 1) || ($page > $last_page)) {
			$page = 1;
		}

		$from_row = ($page - 1) * $per_page;

		$this->db->limit($per_page, $from_row);
		$query = $this->db->get();

		//echo $this->db->last_query();

		return $query;
	}
}
