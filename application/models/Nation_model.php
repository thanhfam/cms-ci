<?php

class Nation_model extends MY_Model {
	public function __construct() {
		parent::__construct();
	}

	public function save(&$item) {
		if (empty($item['id'])) {
			$item['created'] = $item['updated'] = get_time();
			$result = $this->db->insert('nation', $item);

			$item['id'] = $this->db->insert_id();
			$item['created'] = $item['updated'] = date_string();
		}
		else {
			$item['updated'] = get_time();
			$this->db->where('id', $item['id']);
			$result = $this->db->update('nation', $item);

			$item['created'] = $this->input->post('created');
			$item['updated'] = date_string();
		}

		return $result;
	}

	public function get($id = 0) {
		if ($id == 0) {
			return FALSE;
		}

		$this->db
			->select('n.id, n.title, n.code, n.type, n.created, n.updated')
			->from('nation n')
			->where('n.id', $id)
		;

		$item = $this->db->get()->row_array();

		if ($item) {
			$item['created'] = date_string($item['created']);
			$item['updated'] = date_string($item['updated']);
		}

		return $item;
	}

	public function list_simple($continent_id = 0) {
		$this->db
			->select('id, title')
			->order_by('id', 'ASC')
		;

		if ($continent_id) {
			$this->db->where('continent_id', $continent_id);
		}

		return $this->db->get('nation')->result_array();
	}

	public function list_all($page = 1, $filter = '', &$pagy_config) {
		//$this->load->database();
		$this->load->library('pagination');

		$filter = strtolower($filter);

		$this->db
			->select('n.id, n.title, n.type, c.id continent_id, c.title continent_title')
			->from('nation n')
			->join('continent c', 'n.continent_id = c.id')
			->order_by('n.id', 'ASC')
			->like('LOWER(n.id)', $filter)
			->or_like('LOWER(n.title)', $filter)
			->or_like('LOWER(n.type)', $filter)
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
