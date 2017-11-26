<?php

class City_model extends MY_Model {
	public function __construct() {
		parent::__construct();
	}

	public function save(&$item) {
		if (empty($item['id'])) {
			$item['created'] = $item['updated'] = get_time();
			$result = $this->db->insert('city', $item);

			$item['id'] = $this->db->insert_id();
			$item['created'] = $item['updated'] = date_string();
		}
		else {
			$item['updated'] = get_time();
			$this->db->where('id', $item['id']);
			$result = $this->db->update('city', $item);

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
			->select('c.id, c.title, c.code, c.type, c.created, c.updated, c.nation_id')
			->from('city c')
			->join('nation n', 'c.nation_id = n.id')
			->where('c.id', $id)
		;

		$item = $this->db->get()->row_array();

		if ($item) {
			$item['created'] = date_string($item['created']);
			$item['updated'] = date_string($item['updated']);
		}

		return $item;
	}

	public function list_simple($nation_id = 0) {
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
			->select('c.id, c.title, c.code, c.type, n.id nation_id, n.title nation_title')
			->from('city c')
			->join('nation n', 'c.nation_id = n.id')
			->order_by('c.id', 'ASC')
			->group_start()
				->like('LOWER(c.id)', $filter)
				->or_like('LOWER(c.title)', $filter)
				->or_like('LOWER(c.type)', $filter)
				->or_like('LOWER(n.id)', $filter)
				->or_like('LOWER(n.title)', $filter)
			->group_end()
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
