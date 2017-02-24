<?php

class Ward_model extends MY_Model {
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

			$this->db
				->select('w.id, w.title, w.type, d.id district_id, d.title district_title, c.id city_id, c.title city_title')
				->from('ward w')
				->join('district d', 'w.district_id = d.id')
				->join('city c', 'd.city_id = c.id')
				->where('w.id', $id)
			;

			//echo $this->db->last_query();

			$query = $this->db->get();
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
			->select('w.id, w.title, w.type, d.id district_id, d.title district_title, c.id city_id, c.title city_title')
			->from('ward w')
			->join('district d', 'w.district_id = d.id')
			->join('city c', 'd.city_id = c.id')
			->order_by('w.id', 'ASC')
			->like('LOWER(w.id)', $filter)
			->or_like('LOWER(w.title)', $filter)
			->or_like('LOWER(w.type)', $filter)
			->or_like('LOWER(d.id)', $filter)
			->or_like('LOWER(d.title)', $filter)
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
