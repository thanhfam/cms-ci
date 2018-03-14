<?php

class Treatment_model extends MY_Model {
	public function __construct() {
		parent::__construct();
	}

	public function save(&$item) {
		$item['date_consult'] = get_date($item['date_consult']);
		$item['date_exam'] = get_date($item['date_exam']);

		if (empty($item['id'])) {
			$item['created'] = $item['updated'] = get_time();
			$result = $this->db->insert('treatment', $item);

			$item['id'] = $this->db->insert_id();
			$item['created'] = $item['updated'] = date_string();
		}
		else {
			$item['updated'] = get_time();
			$this->db->where('id', $item['id']);
			$result = $this->db->update('treatment', $item);

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
			->delete('treatment');

		$result = $this->db->affected_rows();

		return $result;
	}

	public function get($id = '') {
		if (!is_numeric($id)) {
			return FALSE;
		}

		$id = intval($id);

		$this->db
			->select('t.*')
			->from('treatment t')
			->where('t.id', $id)
		;

		$item = $this->db->get()->row_array();

		if ($item) {
			$item['created'] = date_string($item['created']);
			$item['updated'] = date_string($item['updated']);

			if ($item['date_consult']) {
				$item['date_consult'] = date_only_string($item['date_consult']);
			}

			if ($item['date_exam']) {
				$item['date_exam'] = date_only_string($item['date_exam']);
			}
		}

		return $item;
	}

	public function list_all($page = 1, $filter = '', &$pagy_config) {
		//$this->load->database();
		$this->load->library('pagination');

		$filter = strtolower($filter);

		$this->db
			->select('
				t.id, t.service_title, t.service_price, , t.created, t.updated,
				t.service_id s_id, sv.title sv_title, sv.weight sv_price,
				t.hospital_id h_id, h.title h_title,
				t.customer_1_id c1_id, c1.first_name c1_first_name, c1.middle_name c1_middle_name, c1.last_name c1_last_name,
				t.customer_2_id c2_id, c2.first_name c2_first_name, c2.middle_name c2_middle_name, c2.last_name c2_last_name,
				t.agency_id a_id, a.first_name a_first_name, a.middle_name a_middle_name, a.last_name a_last_name,
				t.staff_id st_id, st.first_name st_first_name, st.middle_name st_middle_name, st.last_name st_last_name
			')
			->from('treatment t')
			->join('contact c1', 'c1.id = t.customer_1_id AND c1.group_name = "' .CONTACT_T_CUSTOMER .'"', 'LEFT')
			->join('contact c2', 'c2.id = t.customer_2_id AND c2.group_name = "' .CONTACT_T_CUSTOMER .'"', 'LEFT')
			->join('contact st', 'st.id = t.staff_id AND st.group_name = "' .CONTACT_T_STAFF .'"', 'LEFT')
			->join('contact a', 'a.id = t.agency_id AND a.group_name = "' .CONTACT_T_AGENCY .'"', 'LEFT')
			->join('enum sv', 't.service_id = sv.id AND sv.type = "' .ET_TVN_SERVICE .'"', 'LEFT')
			->join('enum h', 't.hospital_id = h.id AND h.type = "' .ET_HOSPITAL .'"', 'LEFT')
			->order_by('t.id', 'DESC')
		;

		if ($filter != '') {
			$this->db->group_start()
				->like('LOWER(e1.id)', $filter)
				->or_like('LOWER(e1.name)', $filter)
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
