<?php

require_once(APPPATH.'models/Post_model.php');

class Tfreport_model extends Post_model {
	public function __construct() {
		parent::__construct();
	}

	public function list_all($page = 1, $filter = array(), &$pagy_config) {
		$this->load->library('pagination');

		$this->db
			->select('p.id, p.subtitle, p.title, p.attachment_id, s.name state_name, s.weight state_weight, p.cate_id, c.title cate_title, p.created, p.updated, p.creator_id, u1.name creator_name, u1.username creator_username')
			->from('post p')
			->join('user u1', 'p.creator_id = u1.id')
			->join('state s', 'p.state_weight = s.weight')
			->join('category c', 'p.cate_id = c.id')
			->where('s.type', ST_CONTENT)
			->where('s.weight', S_ACTIVATED)
			->where('p.type', CT_TF_REPORT)
			->order_by('p.id', 'DESC')
		;

		if (isset($filter['cate_id']) && ($filter['cate_id'] != '')) {
			$this->db->where('p.cate_id', $filter['cate_id']);
		}

		if (isset($filter['keyword']) && ($filter['keyword'] != '')) {
			$keyword = $this->to_utf8($filter['keyword']);

			$this->db->group_start()
				->like('LOWER(p.id)', $keyword)
				->or_like('LOWER(p.subtitle)', $keyword)
				->or_like('LOWER(p.title)', $keyword)
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

			$this->load_attachment_json($row);

			$list[] = $row;
		}

		return $list;
	}

	public function list_mine($page = 1, $filter = array(), &$pagy_config) {
		$this->load->library('pagination');

		$this->db
			->select('p.id, p.subtitle, p.title, p.attachment_id, s.name state_name, s.weight state_weight, p.cate_id, c.title cate_title, p.created, p.updated, p.creator_id, u1.name creator_name, u1.username creator_username')
			->from('post p')
			->join('user u1', 'p.creator_id = u1.id')
			->join('state s', 'p.state_weight = s.weight')
			->join('category c', 'p.cate_id = c.id')
			->where('s.type', ST_CONTENT)
			->where('p.creator_id', $this->session->user['id'])
			->where('p.type', CT_TF_REPORT)
			->order_by('p.id', 'DESC')
		;

		if (isset($filter['cate_id']) && ($filter['cate_id'] != '')) {
			$this->db->where('p.cate_id', $filter['cate_id']);
		}

		if (isset($filter['state_weight']) && ($filter['state_weight'] != '')) {
			$this->db->where('p.state_weight', $filter['state_weight']);
		}

		if (isset($filter['keyword']) && ($filter['keyword'] != '')) {
			$keyword = $this->to_utf8($filter['keyword']);

			$this->db->group_start()
				->like('LOWER(p.id)', $keyword)
				->or_like('LOWER(p.subtitle)', $keyword)
				->or_like('LOWER(p.title)', $keyword)
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

			$this->load_attachment_json($row);

			$list[] = $row;
		}

		return $list;
	}
}
