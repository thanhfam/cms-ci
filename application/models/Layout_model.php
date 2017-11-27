<?php

class Layout_model extends MY_Model {
	public function __construct() {
		parent::__construct();
	}

	public function save(&$item) {
		if ($item['id'] == '') {
			unset($item['id']);

			$item['created'] = $item['updated'] = get_time();
			$result = $this->db->insert('layout', $item);

			$item['id'] = $this->db->insert_id();
			$item['created'] = $item['updated'] = date_string();
		}
		else {
			$item['updated'] = get_time();
			$this->db->where('id', $item['id']);
			$result = $this->db->update('layout', $item);

			$item['created'] = $this->input->post('created');
			$item['updated'] = date_string();
		}

		return $result;
	}

	public function get($id = '') {
		if (!is_numeric($id)) {
			return FALSE;
		}

		$id = intval($id);

		$this->db
			->select('l.*')
			->from('layout l')
			->where('l.id', $id)
		;
		$item = $this->db->get()->row_array();

		if ($item) {
			$item['created'] = date_string($item['created']);
			$item['updated'] = date_string($item['updated']);
		}

		return $item;
	}

	public function list_simple() {
		$this->db
			->select('id, concat(name, " (", id, ")") name')
			->order_by('name', 'ASC')
		;

		$result = $this->db->get('layout')->result_array();

		return $result;
	}

	public function list_all($page = 1, $filter = '', &$pagy_config) {
		$this->load->library('pagination');

		$filter = $this->db->escape_str(trim(strtolower($filter)));

		$this->db
			->select('l.id, l.name, l.site_id, s.name site_name, s.title site_title, l.created, l.updated')
			->from('layout l')
			->join('site s', 'l.site_id = s.id')
			->order_by('l.name', 'ASC')
		;

		if ($filter != '') {
			$this->db->group_start()
				->like('LOWER(s.id)', $filter)
				->or_like('LOWER(s.name)', $filter)
				->group_end()
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
