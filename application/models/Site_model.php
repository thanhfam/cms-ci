<?php

class Site_model extends MY_Model {
	public function __construct() {
		parent::__construct();
	}

	public function save(&$item) {
		if ($item['id'] == '') {
			unset($item['id']);
			$result = $this->db->insert('site', $item);

			$item['id'] = $this->db->insert_id();
			$item['created'] = $item['updated'] = $this->get_time();
		}
		else {
			$this->db->where('id', $item['id']);
			$result = $this->db->update('site', $item);

			$item['created'] = $this->input->post('created');
			$item['updated'] = $this->get_time();
		}

		return $result;
	}

	public function get($id = '') {
		if (!is_numeric($id)) {
			return FALSE;
		}

		$id = intval($id);

		$this->db
			->select('s.id, s.title, s.name, s.url, s.language, s.facebook, s.twitter, s.pinterest, s.gplus, s.linkedin, s.avatar_id, i.filename avatar_filename, s.created, s.updated')
			->from('site s')
			->where('s.id', $id)
			->join('image i', 's.avatar_id = i.id', 'left')
		;
		//echo $this->db->last_query();
		$item = $this->db->get()->row_array();

		$this->db->close();

		$item['created'] = $this->get_time($item['created']);
		$item['updated'] = $this->get_time($item['updated']);

		return $item;
	}

	public function list_simple() {
		$this->db
			->select('id, concat(title, " (", id, ")") title')
			->order_by('id', 'ASC')
		;

		$result = $this->db->get('site')->result_array();

		$this->db->close();

		return $result;
	}

	public function list_all($page = 1, $filter = '', &$pagy_config) {
		$this->load->library('pagination');

		$filter = $this->db->escape_str(trim(strtolower($filter)));

		$this->db
			->select('s.id, s.title, s.name, s.url, s.language')
			->from('site s')
			->order_by('s.id', 'ASC')
		;

		if ($filter != '') {
			$this->db
				->like('LOWER(s.id)', $filter)
				->or_like('LOWER(s.title)', $filter)
				->or_like('LOWER(s.name)', $filter)
				->or_like('LOWER(s.url)', $filter)
			;
		}

		$total_row = $this->db->count_all_results('', FALSE);
		$pagy_config['total_rows'] = $total_row;

		$per_page = $this->pagination->per_page;
		$last_page = floor($total_row / $per_page);

		if (! isset($page)  || (! is_numeric($page)) || ($page < 1) || ($page > $last_page)) {
			$page = 1;
		}

		$from_row = ($page - 1) * $per_page;

		$this->db->limit($per_page, $from_row);

		//echo $this->db->last_query();

		$result = $this->db->get()->result_array();

		$this->db->close();

		return $result;
	}
}
