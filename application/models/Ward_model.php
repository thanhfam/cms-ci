<?php

class Ward_model extends MY_Model {
	public function __construct() {
		parent::__construct();
	}

	public function save(&$item) {
		if (empty($item['id'])) {
			$result = $this->db->insert('ward', $item);

			$item['id'] = $this->db->insert_id();
			$item['created'] = $item['updated'] = $this->get_time();
		}
		else {
			$this->db->where('id', $item['id']);
			$result = $this->db->update('ward', $item);

			$item['created'] = $this->input->post('created');
			$item['updated'] = $this->get_time();
		}

		return $result;
	}

	public function get($id = 0) {
		if ($id == 0) {
			return FALSE;
		}

		$this->db
			->select('w.id, w.title, w.code, w.type, w.created, w.updated, d.id district_id, c.id city_id')
			->from('ward w')
			->join('district d', 'w.district_id = d.id')
			->join('city c', 'd.city_id = c.id')
			->where('w.id', $id)
		;

		$item = $this->db->get()->row_array();

		$item['created'] = $this->get_time($item['created']);
		$item['updated'] = $this->get_time($item['updated']);

		return $item;
	}

	public function list_simple($district_id = 0) {
		$this->db
			->select('id, title')
			->order_by('id', 'ASC')
		;

		if ($district_id) {
			$this->db->where('district_id', $district_id);
		}

		return $this->db->get('ward')->result_array();
	}

	public function remove($id) {
		$this->db->where('id', $id);
		return $this->db->delete('ward');
	}

	public function list_all($page = 1, $filter = '', &$pagy_config) {
		//$this->load->database();
		$this->load->library('pagination');

		$filter = strtolower($filter);

		$this->db
			->select('w.id, w.title, w.code, w.type, d.id district_id, d.title district_title, c.id city_id, c.title city_title')
			->from('ward w')
			->join('district d', 'w.district_id = d.id')
			->join('city c', 'd.city_id = c.id')
			->order_by('w.id', 'ASC')
			->like('LOWER(w.id)', $filter)
			->or_like('LOWER(w.title)', $filter)
			->or_like('LOWER(w.type)', $filter)
			->or_like('LOWER(w.code)', $filter)
			->or_like('LOWER(d.id)', $filter)
			->or_like('LOWER(d.title)', $filter)
			->or_like('LOWER(c.id)', $filter)
			->or_like('LOWER(c.title)', $filter)
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

		//echo $this->db->last_query();

		return $this->db->get()->result_array();
	}
}
