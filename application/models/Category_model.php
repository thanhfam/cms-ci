<?php

class Category_model extends MY_Model {
	public function __construct() {
		parent::__construct();
	}

	public function save(&$item) {
		if (empty($item['id'])) {
			$result = $this->db->insert('category', $item);

			$item['id'] = $this->db->insert_id();
			$item['created'] = $item['updated'] = $this->get_time();
		}
		else {
			$this->db->where('id', $item['id']);
			$result = $this->db->update('category', $item);

			$item['created'] = $this->input->post('created');
			$item['updated'] = $this->get_time();
		}

		//echo $this->db->last_query();

		return $result;
	}

	public function get_by_uri($uri = '') {
		if ($uri == '') {
			return FALSE;
		}

		$this->db
			->select('c1.id, c1.subtitle, c1.title, c1.name, c1.uri, c1.lead, c1.content, c1.site_id, c1.cate_id, c1.cate_layout_id, l.content cate_layout_content, c1.state_weight, c1.created, c1.updated')
			->from('category c1')
			->where('c1.uri', $uri)
			->join('layout l', 'c1.cate_layout_id = l.id')
		;

		$item = $this->db->get()->row_array();

		if ($item) {
			$item['created'] = $this->get_time($item['created']);
			$item['updated'] = $this->get_time($item['updated']);
		}

		return $item;
	}

	public function get($id = '') {
		if (!is_numeric($id)) {
			return FALSE;
		}

		$id = intval($id);

		$this->db
			->select('c1.id, c1.subtitle, c1.title, c1.name, c1.uri, c1.lead, c1.content, c1.site_id, c1.cate_id, c1.cate_layout_id, c1.post_layout_id, c1.state_weight, c1.created, c1.updated')
			->from('category c1')
			->where('c1.id', $id)
		;

		$item = $this->db->get()->row_array();

		if ($item) {
			$item['created'] = $this->get_time($item['created']);
			$item['updated'] = $this->get_time($item['updated']);
		}

		return $item;
	}

	public function list_simple_for_post() {
		$this->db
			->select('id, concat(title, " (", id, ")") title, name')
			->order_by('title', 'ASC')
		;

		$result = $this->db->get('category')->result_array();

		return $result;
	}


	public function list_simple($cate_id = '', $site_id = '') {
		$this->db
			->select('id, concat(title, " (", id, ")") title, name')
			->order_by('title', 'ASC')
		;

		if ($site_id != '') {
			$this->db->where('site_id', 1);
		}

		if ($cate_id != '') {
			$this->db->where('id !=', $cate_id);
		}

		//echo $this->db->last_query();

		$result = $this->db->get('category')->result_array();
		array_unshift($result, array(
			'id' => '',
			'title' => '-'
		));

		return $result;
	}

	public function list_all($page = 1, $filter = '', &$pagy_config) {
		//$this->load->database();
		$this->load->library('pagination');

		$filter = strtolower($filter);

		$this->db
			->select('c1.id, c1.subtitle, c1.title, c1.name, c1.uri, si.id site_id, si.title site_title, si.url site_url, st.name state_name, st.weight state_weight, c2.id parent_id, c2.title parent_title, c1.created, c1.updated')
			->from('category c1')
			->join('state st', 'c1.state_weight = st.weight')
			->join('site si', 'c1.site_id = si.id')
			->join('category c2', 'c1.cate_id = c2.id', 'left')
			->order_by('c1.id', 'DESC')
		;

		if ($filter != '') {
			$this->db->like('LOWER(c1.id)', $filter)
				->or_like('LOWER(c1.subtitle)', $filter)
				->or_like('LOWER(c1.title)', $filter)
				->or_like('LOWER(c1.name)', $filter)
				->or_like('LOWER(c2.title)', $filter)
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

		$result = $this->db->get()->result_array();

		return $result;
	}
}
