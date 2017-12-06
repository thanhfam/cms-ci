<?php

class Site_model extends MY_Model {
	public function __construct() {
		parent::__construct();
	}

	public function save(&$item) {
		if ($item['id'] == '') {
			unset($item['id']);
			$item['created'] = $item['updated'] = get_time();
			$result = $this->db->insert('site', $item);

			$item['id'] = $this->db->insert_id();
			$item['created'] = $item['updated'] = date_string();
		}
		else {
			$item['updated'] = get_time();
			$this->db->where('id', $item['id']);
			$result = $this->db->update('site', $item);

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
			->select('s.id, s.title, s.subtitle, s.name, s.url, s.language, s.facebook, s.twitter, s.pinterest, s.gplus, s.linkedin, s.avatar_id, m.file_name, m.folder, m.type avatar_type, m.file_ext avatar_file_ext, m.content avatar_content, s.created, s.updated')
			->from('site s')
			->where('s.id', $id)
			->join('media m', 's.avatar_id = m.id', 'left')
		;

		$item = $this->db->get()->row_array();

		if ($item) {
			$item['created'] = date_string($item['created']);
			$item['updated'] = date_string($item['updated']);

			if ($item['file_name']) {
				$item['avatar_url'] = base_url(F_FILE .$item['folder'] .'/' .$item['file_name']);
			}
			else {
				$item['avatar_url'] = '';
			}
		}

		return $item;
	}

	public function list_simple() {
		$this->db
			->select('id, concat(name, " (", id, ")") title')
			->order_by('id', 'ASC')
		;

		$result = $this->db->get('site')->result_array();

		return $result;
	}

	public function list_all($page = 1, $filter = '', &$pagy_config) {
		$this->load->library('pagination');

		$filter = $this->db->escape_str(trim(strtolower($filter)));

		$this->db
			->select('s.id, s.subtitle, s.title, s.name, s.url, s.language, s.created, s.updated')
			->from('site s')
			->order_by('s.id', 'ASC')
		;

		if ($filter != '') {
			$this->db->group_start()
				->like('LOWER(s.id)', $filter)
				->or_like('LOWER(s.subtitle)', $filter)
				->or_like('LOWER(s.title)', $filter)
				->or_like('LOWER(s.name)', $filter)
				->or_like('LOWER(s.url)', $filter)
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
