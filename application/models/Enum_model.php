<?php

class Enum_model extends MY_Model {
	public function __construct() {
		parent::__construct();
	}

	public function save(&$item) {
		if (empty($item['id'])) {
			$item['created'] = $item['updated'] = get_time();
			$result = $this->db->insert('enum', $item);

			$item['id'] = $this->db->insert_id();
			$item['created'] = $item['updated'] = date_string();
		}
		else {
			$item['updated'] = get_time();
			$this->db->where('id', $item['id']);
			$result = $this->db->update('enum', $item);

			$item['created'] = $this->input->post('created');
			$item['updated'] = date_string();
		}

		//echo $this->db->last_query();

		return $result;
	}

	public function remove($id = '') {
		if ($id == '') {
			return FALSE;
		}

		$this->db
			->where('id', $id)
			->delete('enum');

		$result = $this->db->affected_rows();

		return $result;
	}

	public function get($id = '') {
		if (!is_numeric($id)) {
			return FALSE;
		}

		$id = intval($id);

		$this->db
			->select('e.id, e.name, e.title, e.lang, e.parent_id, e.weight, e.type, e.created, e.updated')
			->from('enum e')
			->where('e.id', $id)
		;

		$item = $this->db->get()->row_array();

		if ($item) {
			$item['created'] = date_string($item['created']);
			$item['updated'] = date_string($item['updated']);
		}

		return $item;
	}

	public function list_2_level($type = NULL) {
		$this->db
			->select('e1.id, e1.weight, e1.name, e1.title, concat(e1.title, " (", e1.id, ")") display_title')
			->from('enum e1')
			->where('e1.type', $type)
			->order_by('e1.name', 'ASC')
		;

		$result = $this->db->get()->result_array();

		return $result;
	}

	public function list_simple($type = NULL, $lang = NULL) {
		$this->db
			->select('id, weight, name, title, concat(title, " (", id, ")") display_title')
			->order_by('id', 'DESC')
			->order_by('name', 'ASC')
		;

		if ($type) {
			$this->db->where('type', $type);
		}

		if ($lang) {
			$this->db->where('lang', $lang);
		}

		$result = $this->db->get('enum')->result_array();
		return $result;
	}

	public function list_parent($type = NULL, $avoid_name = NULL, $lang = NULL) {
		$this->db
			->select('id, name, title, concat(title, " (", id, ")") display_title')
			->where('parent_id', 0)
			->order_by('id', 'DESC')
			->order_by('name', 'ASC')
		;

		if ($type) {
			$this->db->where('type', $type);
		}

		if ($avoid_name) {
			$this->db->where('name !=', $avoid_name);
		}

		if ($lang) {
			$this->db->where('lang', $lang);
		}

		$result = $this->db->get('enum')->result_array();
		array_unshift($result, array(
			'id' => '',
			'name' => '',
			'title' => '',
			'display_title' => '-'
		));

		return $result;
	}

	public function list_all($type = '', $page = 1, $filter = '', &$pagy_config) {
		//$this->load->database();
		$this->load->library('pagination');

		$filter = strtolower($filter);

		$this->db
			->select('e1.id, e1.name, e1.title, e1.lang, e1.weight, e1.parent_id, e2.name parent_name, e2.title parent_title, e1.type, e1.created, e1.updated')
			->from('enum e1')
			->join('enum e2', 'e1.parent_id = e2.id', 'LEFT')
			->order_by('e1.name', 'ASC')
		;

		if ($type) {
			$this->db->where('e1.type', $type);
		}

		if ($filter != '') {
			$this->db->group_start()
				->like('LOWER(e1.id)', $filter)
				->or_like('LOWER(e1.type)', $filter)
				->or_like('LOWER(e1.name)', $filter)
				->or_like('LOWER(e1.title)', $filter)
				->or_like('LOWER(e2.name)', $filter)
				->or_like('LOWER(e2.title)', $filter)
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

		//echo $this->db->last_query();

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
