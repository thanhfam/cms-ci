<?php

class City_model extends MY_Model {
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
			'nation_id' => $this->input->post('nation_id')
		);

		if ($id) {
			$result = $this->db->update('city', $data);
		}
		else {
			$result = $this->db->insert('city', $data);
		}

		return $result;
	}

	public function get($id) {
		if ($id) {
			//$this->load->database();

			$query = $this->db
				->select('*')
				->where('id', $id)
				->get('city')
			;

			//echo $this->db->last_query();

			return $query;
		}
		else {
			return FALSE;
		}
	}

	public function list_simple($nation_id = NULL) {
		$this->db
			->select('id, title')
			->order_by('id', 'ASC')
		;

		if ($nation_id) {
			$this->db->where('nation_id', $nation_id);
		}

		return $this->db->get('city')->result_array();
	}

	public function list_all($page = 1, $filter = '', &$pagy_config) {
		//$this->load->database();
		$this->load->library('pagination');

		$filter = strtolower($filter);

		$this->db
			->select('city.id, city.title, city.type, nation.id nation_id, nation.title nation_title')
			->from('city')
			->join('nation', 'city.nation_id = nation.id')
			->order_by('city.id', 'ASC')
			->like('LOWER(city.id)', $filter)
			->or_like('LOWER(city.title)', $filter)
			->or_like('LOWER(city.type)', $filter)
			->or_like('LOWER(nation.id)', $filter)
			->or_like('LOWER(nation.title)', $filter)
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
