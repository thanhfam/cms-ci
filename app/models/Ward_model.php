<?php

class Ward_model extends CI_Model {
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
			'district_id' => $this->input->post('district_id')
		);

		if ($id) {
			$result = $this->db->update('ward', $data);
		}
		else {
			$result = $this->db->insert('ward', $data);
		}

		return $result;
	}

	public function get($id) {
		if ($id) {
			//$this->load->database();

			$query = $this->db
				->select('*')
				->where('id', $id)
				->get('ward')
			;

			//echo $this->db->last_query();

			return $query;
		}
		else {
			return FALSE;
		}
	}

	public function list_all($page = 1, $filter = '', &$pagy_config) {
		//$this->load->database();
		$this->load->library('pagination');

		$filter = strtolower($filter);

		$this->db
			->select('ward.id, ward.title, ward.type, district.id district_id, district.title district_title')
			->from('ward')
			->join('district', 'ward.district_id = district.id')
			->order_by('ward.id', 'ASC')
			->like('LOWER(ward.id)', $filter)
			->or_like('LOWER(ward.title)', $filter)
			->or_like('LOWER(ward.type)', $filter)
			->or_like('LOWER(district.id)', $filter)
			->or_like('LOWER(district.title)', $filter)
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
