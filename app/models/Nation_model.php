<?php

class Nation_model extends CI_Model {
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
			'continent_id' => $this->input->post('continent_id')
		);

		if ($id) {
			$result = $this->db->update('nation', $data);
		}
		else {
			$result = $this->db->insert('nation', $data);
		}

		return $result;
	}

	public function get($id) {
		if ($id) {
			//$this->load->database();

			$query = $this->db
				->select('*')
				->where('id', $id)
				->get('nation')
			;

			//echo $this->db->last_query();

			return $query;
		}
		else {
			return FALSE;
		}
	}

	public function get_list_all() {
		$query = $this->db
			->select('id, title')
			->get('nation')
		;

		return $query;
	}

	public function list_all($page = 1, $filter = '', &$pagy_config) {
		//$this->load->database();
		$this->load->library('pagination');

		$filter = strtolower($filter);

		$this->db
			->select('nation.id, nation.title, nation.type, continent.id continent_id, continent.title continent_title')
			->from('nation')
			->join('continent', 'nation.continent_id = continent.id')
			->order_by('nation.id', 'ASC')
			->like('LOWER(nation.id)', $filter)
			->or_like('LOWER(nation.title)', $filter)
			->or_like('LOWER(nation.type)', $filter)
			->or_like('LOWER(continent.id)', $filter)
			->or_like('LOWER(continent.title)', $filter)
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
