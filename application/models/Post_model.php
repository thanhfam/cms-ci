<?php

class Post_model extends MY_Model {
	public function __construct() {
		parent::__construct();
	}

	public function save(&$item) {
		if (empty($item['id'])) {
			$result = $this->db->insert('post', $item);

			$item['id'] = $this->db->insert_id();
			$item['created'] = $item['updated'] = $this->get_time();
		}
		else {
			$this->db->where('id', $item['id']);
			$result = $this->db->update('post', $item);

			$item['created'] = $this->input->post('created');
			$item['updated'] = $this->get_time();
		}

		//echo $this->db->last_query();

		return $result;
	}

	public function get($id = '') {
		if ($id == '') {
			return FALSE;
		}

		$this->db
			->select('p.id, p.subtitle, p.title, p.name, p.lead, p.content, p.cate_id, p.avatar_id, i.filename avatar_filename, p.state_weight, p.created, p.updated')
			->from('post p')
			->join('image i', 'p.avatar_id = i.id', 'left')
			->where('p.id', $id)
		;

		$item = $this->db->get()->row_array();

		$item['created'] = $this->get_time($item['created']);
		$item['updated'] = $this->get_time($item['updated']);

		return $item;
	}

	public function list_simple($cate_id = '') {
		$this->db
			->select('id, concat(title, " (", id, ")") title')
			->order_by('id', 'ASC')
		;

		if ($cate_id != '') {
			$this->db->where('id !=', $cate_id);
		}

		$result = $this->db->get('post')->result_array();
		array_unshift($result, array(
			'id' => '',
			'title' => '-'
		));

		return $result;
	}

	public function list_all($page = 1, $filter = '', &$pagy_config) {
		$this->load->library('pagination');

		$filter = strtolower($filter);

		$this->db
			->select('p.id, p.subtitle, p.title, p.name, si.url site_url, s.name state_name, s.weight state_weight, p.cate_id, c.title cate_title, p.created, p.updated')
			->from('post p')
			->join('state s', 'p.state_weight = s.weight')
			->join('category c', 'p.cate_id = c.id')
			->join('site si', 'c.site_id = si.id')
			->order_by('p.id', 'DESC')
		;

		if ($filter != '') {
			$this->db->like('LOWER(p.id)', $filter)
				->or_like('LOWER(p.subtitle)', $filter)
				->or_like('LOWER(p.title)', $filter)
				->or_like('LOWER(c.name)', $filter)
				->or_like('LOWER(c.title)', $filter)
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

		return $this->db->get()->result_array();
	}

	public function get_activated($cate_id, $page = 1, $filter = '', &$pagy_config) {
		$this->load->library('pagination');

		$filter = strtolower($filter);

		$this->db
			->select('p.id, p.subtitle, p.title, p.name, p.lead, p.uri, p.state_weight, p.cate_id, c.title cate_title, i.filename avatar_filename, p.created, p.updated')
			->from('post p')
			->where('p.cate_id', intval($cate_id))
			->where('p.state_weight', S_ACTIVATED)
			->join('category c', 'p.cate_id = c.id')
			->join('image i', 'p.avatar_id = i.id', 'left')
			->order_by('p.id', 'DESC')
		;

		if ($filter != '') {
			$this->db->like('LOWER(p.id)', $filter)
				->or_like('LOWER(p.subtitle)', $filter)
				->or_like('LOWER(p.title)', $filter)
				->or_like('LOWER(c.name)', $filter)
				->or_like('LOWER(c.title)', $filter)
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

		$result = $this->db->get()->result_array();

		//echo $this->db->last_query();

		return $result;
	}
}
