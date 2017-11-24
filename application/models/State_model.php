<?php

class state_model extends MY_Model {
	public function __construct() {
		parent::__construct();
	}

	public function save(&$item) {
		if ($item['id'] == '') {
			unset($item['id']);
			$item['created'] = $item['updated'] = get_time();
			$result = $this->db->insert('state', $item);

			$item['id'] = $this->db->insert_id();
			$item['created'] = $item['updated'] = date_string();
		}
		else {
			$item['updated'] = get_time();
			$this->db->where('id', $item['id']);
			$result = $this->db->update('state', $item);

			$item['created'] = $this->input->post('created');
			$item['updated'] = date_string();
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
			$item['created'] = date_string($item['created']);
			$item['updated'] = date_string($item['updated']);
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
		$this->load->library('pagination');

		$filter = $this->db->escape_str(trim(strtolower($filter)));

		$this->db
			->select('s.id, s.name, s.weight, s.type, s.created, s.updated')
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
