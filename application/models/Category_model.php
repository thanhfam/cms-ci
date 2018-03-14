<?php

class Category_model extends MY_Model {
	public function __construct() {
		parent::__construct();
	}

	public function save(&$item) {
		$this->load->model(array('page_model'));

		$uri = empty($item['uri']) ? $this->page_model->generate_uri($item['title']) : $item['uri'];
		unset($item['uri']);

		if (isset($item['avatar_id'])) {
			$avatar_id = $item['avatar_id'];

			if (gettype($avatar_id) == 'array') {
				$item['avatar_id'] = $avatar_id[0];
			}

			if (empty($item['avatar_id'])) {
				$item['avatar_id'] = 0;
			}
		}

		$this->db->trans_begin();

		if (empty($item['id'])) {
			$item['created'] = $item['updated'] = get_time();
			$this->db->insert('category', $item);

			$item['id'] = $this->db->insert_id();
			$item['created'] = $item['updated'] = date_string();

			$item_page = array(
				'content_id' => $item['id'],
				'content_type' => CT_CATEGORY,
				'uri' => $uri
			);

			$this->page_model->save($item_page);
		}
		else {
			$item['updated'] = get_time();
			$this->db->where('id', $item['id']);
			$this->db->update('category', $item);

			$item['created'] = $this->input->post('created');
			$item['updated'] = date_string();

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

	public function remove($id = '') {
		if ($id == '') {
			return FALSE;
		}

		$item = array(
			'id' => $id,
			'state_weight' => S_REMOVED,
			'updated' => get_time()
		);

		$this->db
			->where('id', $id)
			->update('category', $item);

		$result = $this->db->affected_rows();

		return $result;
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
			$item['created'] = date_string($item['created']);
			$item['updated'] = date_string($item['updated']);
		}

		return $item;
	}

	public function get($id = '') {
		if (!is_numeric($id)) {
			return FALSE;
		}

		$this->load->model(array('media_model'));

		$id = intval($id);

		$this->db
			->select('c.id, c.subtitle, c.title, c.name, p.uri, c.description, c.keywords, c.lead, c.content, c.type, c.site_id, c.cate_id, c.cate_layout_id, c.post_layout_id, c.state_weight, c.created, c.updated, c.avatar_id, m.file_name avatar_file_name, m.folder avatar_folder, m.type avatar_type, m.file_ext avatar_file_ext, m.content avatar_content')
			->from('category c')
			->join('page p', 'c.id = p.content_id')
			->join('media m', 'c.avatar_id = m.id', 'left')
			->where('p.content_type', CT_CATEGORY)
			->where('c.id', $id)
		;

		$item = $this->db->get()->row_array();

		if ($item) {
			$item['created'] = date_string($item['created']);
			$item['updated'] = date_string($item['updated']);

			if ($item['avatar_file_name']) {
				$url = $this->media_model->get_url(array(
					'file_ext' => $item['avatar_file_ext'],
					'type' => $item['avatar_type'],
					'folder' => $item['avatar_folder'],
					'file_name' => $item['avatar_file_name']
				));

				$item['avatar_url'] = $url['tmb'];
				$item['avatar_url_opt'] = $url['opt'];
				$item['avatar_url_ori'] = $url['ori'];
			}
			else {
				$item['avatar_url'] = $item['avatar_url_opt'] = $item['avatar_url_ori'] = '';
			}
		}

		return $item;
	}

	public function list_simple_for_post($for_list = FALSE) {
		$this->db
			->select('id, concat(title, " (", id, ")") title, name')
			->where('state_weight', S_ACTIVATED)
			->order_by('name', 'ASC')
			->order_by('title', 'ASC')
		;
		//->where('type', CT_POST)

		$result = $this->db->get('category')->result_array();

		if ($for_list) {
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

	public function list_activated_by_type($type = '') {
		$this->load->model(array('media_model'));

		$this->db
			->select('c.id, c.title, c.avatar_id, m.file_name avatar_file_name, m.folder avatar_folder, m.type avatar_type, m.file_ext avatar_file_ext, m.content avatar_content')
			->from('category c')
			->where('c.state_weight', S_ACTIVATED)
			->where('c.type', $type)
			->join('media m', 'c.avatar_id = m.id', 'left')
			->order_by('id', 'ASC')
			->order_by('title', 'ASC')
		;

		$query = $this->db->query($this->db->get_compiled_select());

		$list = array();

		while ($item = $query->unbuffered_row('array')) {
			if ($item['avatar_file_name']) {
				$url = $this->media_model->get_url(array(
					'file_ext' => $item['avatar_file_ext'],
					'type' => $item['avatar_type'],
					'folder' => $item['avatar_folder'],
					'file_name' => $item['avatar_file_name']
				));

				$item['avatar_url'] = $url['tmb'];
				$item['avatar_url_opt'] = $url['opt'];
				$item['avatar_url_ori'] = $url['ori'];
			}
			else {
				$item['avatar_url'] = $item['avatar_url_opt'] = $item['avatar_url_ori'] = '';
			}

			$list[] = $item;
		}

		return $list;
	}

	public function list_all($page = 1, $filter = array(), &$pagy_config) {
		$this->load->library('pagination');

		$this->db
			->select('c1.id, c1.subtitle, c1.title, c1.name, c1.type, p.uri, si.id site_id, si.title site_title, si.url site_url, st.name state_name, st.weight state_weight, c2.id parent_id, c2.title parent_title, c1.created, c1.updated, c1.creator_id, u1.name creator_name, u1.username creator_username, c1.updater_id, u2.name updater_name, u2.username updater_username')
			->from('category c1')
			->join('user u1', 'c1.creator_id = u1.id')
			->join('user u2', 'c1.updater_id = u2.id')
			->join('state st', 'c1.state_weight = st.weight')
			->join('site si', 'c1.site_id = si.id')
			->join('category c2', 'c1.cate_id = c2.id', 'left')
			->join('page p', 'c1.id = p.content_id')
			->where('p.content_type', CT_CATEGORY)
			->where('st.type', ST_CONTENT)
			->where('st.weight >', S_REMOVED)
			->order_by('c1.id', 'DESC')
		;

		if (isset($filter['state_weight']) && ($filter['state_weight'] != '')) {
			$this->db->where('c1.state_weight', $filter['state_weight']);
		}

		if (isset($filter['keyword']) && ($filter['keyword'] != '')) {
			$keyword = $this->to_utf8($filter['keyword']);

			$this->db->group_start()
				->like('LOWER(c1.id)', $keyword)
				->or_like('LOWER(c1.name)', $keyword)
				->or_like('LOWER(c1.title)', $keyword)
				->or_like('LOWER(c1.subtitle)', $keyword)
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
