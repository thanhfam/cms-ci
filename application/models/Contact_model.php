<?php

class Contact_model extends MY_Model {
	public function __construct() {
		parent::__construct();
	}

	public function save(&$item) {
		$item['birthday'] = get_date($item['birthday']);

		if (empty($item['id'])) {
			$item['created'] = $item['updated'] = get_time();
			$result = $this->db->insert('contact', $item);

			$item['id'] = $this->db->insert_id();
			$item['created'] = $item['updated'] = date_string();
		}
		else {
			$item['updated'] = get_time();
			$this->db->where('id', $item['id']);
			$result = $this->db->update('contact', $item);

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
			->delete('contact');

		$result = $this->db->affected_rows();

		return $result;
	}

	public function get($id = '') {
		if (!is_numeric($id)) {
			return FALSE;
		}

		$id = intval($id);

		$this->db
			->select('*')
			->from('contact c')
			->where('c.id', $id)
		;

		$item = $this->db->get()->row_array();

		if ($item) {
			$item['created'] = date_string($item['created']);
			$item['updated'] = date_string($item['updated']);

			if ($item['birthday']) {
				$item['birthday'] = date_only_string($item['birthday']);
			}
		}

		return $item;
	}

	public function list_simple($group_name = NULL, $avoid_id = NULL) {
		$this->db
			->select('id, concat(first_name, " ", middle_name, " ", last_name, " (", id, ")") name')
			->order_by('id', 'DESC')
			->order_by('first_name', 'ASC')
		;

		if ($group_name) {
			$this->db->where('group_name', $group_name);
		}

		if ($avoid_id) {
			$this->db->where('id !=', $avoid_id);
		}

		$result = $this->db->get('contact')->result_array();

		array_unshift($result, array(
			'id' => '',
			'name' => '-'
		));

		return $result;
	}

	public function list_all($group = '', $page = 1, $filter = '', &$pagy_config) {
		//$this->load->database();
		$this->load->library('pagination');

		$filter = strtolower($filter);

		$this->db
			->select('c.id, c.title, c.first_name, c.middle_name, c.last_name, c.birthday, c.email, c.phone, c.address, c.group_name, e.title group_title, c.dad_id, c.mom_id, c.partner_id, c.created, c.updated')
			->from('contact c')
			->join('enum e', 'c.group_name = e.name')
			->order_by('c.id', 'DESC')
		;

		if ($group) {
			$this->db->where('c.group_name', $group);
		}

		if ($filter != '') {
			$this->db->group_start()
				->like('LOWER(c.id)', $filter)
				->or_like('LOWER(c.first_name)', $filter)
				->or_like('LOWER(c.middle_name)', $filter)
				->or_like('LOWER(c.last_name)', $filter)
				->or_like('LOWER(c.email)', $filter)
				->or_like('LOWER(c.phone)', $filter)
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
