<?php

class Appointment_model extends MY_Model {
	public function __construct() {
		parent::__construct();
	}

	public function save(&$item) {
		if (empty($item['id'])) {
			$item['created'] = $item['updated'] = get_time();
			if (isset($this->session)) {
				$item['creator_id'] = $item['updater_id'] = $this->session->user['id'];
			}

			$result = $this->db->insert('appointment', $item);

			$item['id'] = $this->db->insert_id();
			$item['created'] = $item['updated'] = date_string();
		}
		else {
			$item['updated'] = get_time();
			if (isset($this->session)) {
				$item['updater_id'] = $this->session->user['id'];
			}

			$this->db->where('id', $item['id']);
			$result = $this->db->update('appointment', $item);

			$item['created'] = $this->input->post('created');
			$item['updated'] = date_string();
		}

		//echo $this->db->last_query();

		return $result;
	}

	public function get($id = '') {
		if (!is_numeric($id)) {
			return FALSE;
		}

		$id = intval($id);

		$this->db
			->select('a.id, a.name, a.phone, a.email, a.address, a.time, a.summary, a.content, a.state_weight, a.updated, a.created')
			->from('appointment a')
			->where('a.id', $id)
		;

		$item = $this->db->get()->row_array();

		if ($item) {
			$item['created'] = date_string($item['created']);
			$item['updated'] = date_string($item['updated']);
		}

		return $item;
	}

	public function list_simple($site_id = '') {
		$this->db
			->select('id, concat(name, " (", id, ")") title')
			->order_by('id', 'ASC')
		;

		if ($site_id != '') {
			$this->db->where('site_id', $site_id);
		}

		//echo $this->db->last_query();

		$result = $this->db->get('appointment')->result_array();

		return $result;
	}

	public function list_all($filter = array(), $page = 1, &$pagy_config = NULL) {
		$this->load->library('pagination');

		$this->db
			->select('a.id, a.name, a.phone, a.email, a.time, a.summary, a.content, a.state_weight, s.name state_name, a.updated, a.created, a.creator_id, u1.name creator_name, a.updater_id, u2.name updater_name')
			->from('appointment a')
			->join('state s', 'a.state_weight = s.weight')
			->join('user u1', 'a.creator_id = u1.id', 'left')
			->join('user u2', 'a.updater_id = u2.id', 'left')
			->where('s.type', 'appointment')
			->order_by('a.id', 'DESC')
		;

		if (isset($filter['state_weight']) && ($filter['state_weight'] != '')) {
			$this->db->where('a.state_weight', $filter['state_weight']);
		}

		if (isset($filter['keyword']) && ($filter['keyword'] != '')) {
			$keyword = $this->to_utf8($filter['keyword']);

			$this->db->group_start()
				->like('LOWER(a.id)', $keyword)
				->or_like('LOWER(a.name)', $keyword)
				->or_like('LOWER(a.phone)', $keyword)
				->or_like('LOWER(a.email)', $keyword)
				->or_like('LOWER(a.summary)', $keyword)
				->or_like('LOWER(a.content)', $keyword)
				->group_end()
			;
		}

		if ($pagy_config) {
			$total_row = $this->db->count_all_results('', FALSE);
			$pagy_config['total_rows'] = $total_row;

			$per_page = $this->pagination->per_page;
			$last_page = ceil($total_row / $per_page);

			if (! isset($page)  || (! is_numeric($page)) || ($page < 1) || ($page > $last_page)) {
				$page = 1;
			}

			$from_row = ($page - 1) * $per_page;

			$this->db->limit($per_page, $from_row);
		}

		$query = $this->db->query($this->db->get_compiled_select());

		$list = array();

		while ($row = $query->unbuffered_row('array')) {
			$row['updated'] = date_string($row['updated']);
			$row['created'] = date_string($row['created']);
			$list[] = $row;
		}

		return $list;
	}
}
