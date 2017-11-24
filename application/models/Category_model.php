<?php

class Category_model extends MY_Model {
	public function __construct() {
		parent::__construct();
	}

	public function save(&$item) {
		$this->load->model(array('page_model'));

		$uri = empty($item['uri']) ? $this->page_model->generate_uri($item['title']) : $item['uri'];
		unset($item['uri']);

		$this->db->trans_begin();

		if (empty($item['id'])) {
			$this->db->insert('category', $item);

			$item['id'] = $this->db->insert_id();
			$item['created'] = $item['updated'] = $this->get_time();

			$item_page = array(
				'content_id' => $item['id'],
				'content_type' => CT_CATEGORY,
				'uri' => $uri
			);

			$this->page_model->save($item_page);
		}
		else {
			$this->db->where('id', $item['id']);
			$this->db->update('category', $item);

			$item['created'] = $this->input->post('created');
			$item['updated'] = $this->get_time();

			$item_page = $this->page_model->get_by_content($item['id'], CT_CATEGORY);

			if ($uri != $item_page['uri']) {
				$item_page['uri'] = $uri;
				//$item_page['content_type'] = CT_CATEGORY;
				//$item_page['content_id'] = $item['id'];

				$this->page_model->save($item_page);
			}
		}

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();

			return FALSE;
		}
		else {
			$this->db->trans_commit();
			$item['uri'] = $item_page['uri'];

			return TRUE;
		}
	}

	public function get_by_uri($uri = '') {
		if ($uri == '') {
			return FALSE;
		}

		$this->db
			->select('c.id, c.subtitle, c.title, c.name, p.uri, c.description, c.keywords, c.lead, c.content, c.site_id, c.cate_id, c.cate_layout_id, l.content cate_layout_content, c.state_weight, c.created, c.updated')
			->from('category c')
			->join('layout l', 'c.cate_layout_id = l.id')
			->join('page p', 'c.id = p.content_id')
			->where('p.uri', $uri)
			->where('c.state_weight', S_ACTIVATED)
			->where('p.content_type', CT_CATEGORY)
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
			->select('c.id, c.subtitle, c.title, c.name, p.uri, c.description, c.keywords, c.lead, c.content, c.type, c.site_id, c.cate_id, c.cate_layout_id, c.post_layout_id, c.state_weight, c.created, c.updated')
			->from('category c')
			->join('page p', 'c.id = p.content_id')
			->where('p.content_type', CT_CATEGORY)
			->where('c.id', $id)
		;

		$item = $this->db->get()->row_array();

		if ($item) {
			$item['created'] = $this->get_time($item['created']);
			$item['updated'] = $this->get_time($item['updated']);
		}

		return $item;
	}

	public function list_simple_for_post($for_post_list = FALSE) {
		$this->db
			->select('id, concat(title, " (", id, ")") title, name')
			->where('state_weight', S_ACTIVATED)
			->order_by('name', 'ASC')
			->order_by('title', 'ASC')
		;

		$result = $this->db->get('category')->result_array();

		if ($for_post_list) {
			array_unshift($result, array(
				'id' => '',
				'title' => '-'
			));
		}

		return $result;
	}


	public function list_simple($cate_id = '', $site_id = '') {
		$this->db
			->select('id, concat(title, " (", id, ")") title, name')
			->order_by('name', 'ASC')
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
		$this->load->library('pagination');

		$filter = strtolower($filter);

		$this->db
			->select('c1.id, c1.subtitle, c1.title, c1.name, p.uri, si.id site_id, si.title site_title, si.url site_url, st.name state_name, st.weight state_weight, c2.id parent_id, c2.title parent_title, c1.created, c1.updated, c1.creator_id, u1.name creator_name, u1.username creator_username, c1.updater_id, u2.name updater_name, u2.username updater_username')
			->from('category c1')
			->join('user u1', 'c1.creator_id = u1.id')
			->join('user u2', 'c1.updater_id = u2.id')
			->join('state st', 'c1.state_weight = st.weight')
			->join('site si', 'c1.site_id = si.id')
			->join('category c2', 'c1.cate_id = c2.id', 'left')
			->join('page p', 'c1.id = p.content_id')
			->where('p.content_type', CT_CATEGORY)
			->where('st.type', ST_CONTENT)
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
