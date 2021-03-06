<?php

class Post_model extends MY_Model {
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

		if (isset($item['attachment_id'])) {
			$this->save_attachment($item);
		}

		$this->db->trans_begin();

		if (empty($item['id'])) {
			$item['created'] = $item['updated'] = get_time();
			$this->db->insert('post', $item);

			$item['id'] = $this->db->insert_id();
			$item['created'] = $item['updated'] = date_string();

			$item_page = array(
				'content_id' => $item['id'],
				'content_type' => CT_POST,
				'uri' => $uri
			);

			$this->page_model->save($item_page);
		}
		else {
			$item['updated'] = get_time();
			$this->db->where('id', $item['id']);
			$this->db->update('post', $item);

			$item['created'] = $this->input->post('created');
			$item['updated'] = date_string();

			$item_page = $this->page_model->get_by_content($item['id'],  CT_POST);

			if ($uri != $item_page['uri']) {
				$item_page['uri'] = $uri;
				//$item_page['content_type'] = CT_POST;
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

	public function save_attachment(&$item) {
		$attachment_id = $item['attachment_id'];
		if (gettype($attachment_id) == 'array') {
			$item['attachment_id'] = implode(",", $attachment_id);
		}
	}

	public function load_attachment(&$item, $fm = '') {
		if ($item['attachment_id'] == '') {
			$item['attachment_type'] = '';
			$item['attachment_file_ext'] = '';
			$item['attachment_url'] = $item['attachment_url_opt'] = $item['attachment_url_ori'] = '';

			return;
		}

		$attachment_id = explode(',', $item['attachment_id']);

		$this->db
			->select('m.id, m.file_name, m.folder, m.type, m.file_ext, m.content')
			->from('media m')
			->where_in('m.id', $attachment_id)
		;

		$query = $this->db->query($this->db->get_compiled_select());

		if ($fm == 'json') {
			$item['attachment'] = array();

			while ($row = $query->unbuffered_row('array')) {
				$url = $this->media_model->get_url($row);

				$attachment = array(
					'id' => $row['id'],
					'type' => $row['type'],
					'file_ext' => $row['file_ext'],
					'url' => $url['tmb'],
					'url_opt' => $url['opt'],
					'url_ori' => $url['ori']
				);

				$item['attachment'][] = $attachment;
			}
		}
		else {
			$item['attachment_id'] = $item['attachment_type'] = $item['attachment_url'] = $item['attachment_url_opt'] = $item['attachment_url_ori'] = $item['attachment_file_ext'] = array();

			while ($row = $query->unbuffered_row('array')) {
				$url = $this->media_model->get_url($row);

				$item['attachment_id'][] = $row['id'];
				$item['attachment_type'][] = $row['type'];
				$item['attachment_file_ext'][] = $row['file_ext'];
				$item['attachment_url'][] = $url['tmb'];
				$item['attachment_url_opt'][] = $url['opt'];
				$item['attachment_url_ori'][] = $url['ori'];
			}
		}
	}

	public function load_attachment_json(&$item) {
		$this->load_attachment($item, 'json');
	}

	public function get_by_uri($uri = '') {
		if ($uri == '') {
			return FALSE;
		}

		$this->db
			->select('p.id, p.subtitle, p.title, pg.uri, p.lead, p.content, p.tags, c.site_id, p.cate_id, c.post_layout_id, l.content post_layout_content, p.state_weight, p.created, p.updated')
			->from('post p')
			->join('category c', 'c.id = p.cate_id')
			->join('layout l', 'c.post_layout_id = l.id')
			->join('page pg', 'p.id = pg.content_id')
			->where('pg.uri', $uri)
			->where('p.state_weight', S_ACTIVATED)
			->where('pg.content_type', CT_POST)
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
			->select('p.id, p.subtitle, p.title, pg.uri, p.lead, p.content, p.tags, p.cate_id, p.avatar_id, m.file_name avatar_file_name, m.folder avatar_folder, m.type avatar_type, m.file_ext avatar_file_ext, m.content avatar_content, p.attachment_id, p.state_weight, p.created, p.updated')
			->from('post p')
			->join('media m', 'p.avatar_id = m.id', 'left')
			->join('page pg', 'p.id = pg.content_id', 'left')
			->where('pg.content_type', CT_POST)
			->where('p.id', $id)
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

			$this->load_attachment($item);
		}

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

	public function list_all($page = 1, $filter = array(), &$pagy_config) {
		$this->load->library('pagination');

		$this->db
			->select('p.id, p.subtitle, p.title, pg.uri, si.url site_url, s.name state_name, s.weight state_weight, p.cate_id, c.title cate_title, p.created, p.updated, p.creator_id, u1.name creator_name, u1.username creator_username, p.updater_id, u2.name updater_name, u2.username updater_username')
			->from('post p')
			->join('user u1', 'p.creator_id = u1.id')
			->join('user u2', 'p.updater_id = u2.id')
			->join('state s', 'p.state_weight = s.weight')
			->join('category c', 'p.cate_id = c.id')
			->join('site si', 'c.site_id = si.id')
			->join('page pg', 'p.id = pg.content_id', 'left')
			->where('pg.content_type', CT_POST)
			->where('s.type', ST_CONTENT)
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
			$list[] = $row;
		}

		//echo $this->db->last_query();

		return $list;
	}

	public function get_top_activated($cate_id, $limit, $get_content = FALSE) {
		$this->db
			->select('p.id, p.subtitle, p.title, p.lead, p.content, p.tags, pg.uri, p.state_weight, p.cate_id, c.title cate_title, m.file_name avatar_file_name, m.folder avatar_folder, m.type avatar_type, m.file_ext avatar_file_ext, m.content avatar_content, p.created, p.updated')
			->from('post p')
			->where('p.state_weight', S_ACTIVATED)
			->join('page pg', 'pg.content_id = p.id')
			->where('pg.content_type', CT_POST)
			->join('state st', 'st.weight = p.state_weight')
			->where('st.type', ST_CONTENT)
			->join('category c', 'p.cate_id = c.id')
			->join('media m', 'p.avatar_id = m.id', 'left')
			->order_by('p.id', 'DESC')
			->limit($limit)
		;

		if (gettype($cate_id) == 'array') {
			$this->db->where_in('p.cate_id', $cate_id);
		}
		else {
			$this->db->where('p.cate_id', intval($cate_id));
		}

		$query = $this->db->query($this->db->get_compiled_select());

		$list = array();

		while ($item = $query->unbuffered_row('array')) {
			$item['updated'] = date_string($item['updated']);
			$item['created'] = date_string($item['created']);

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

		//echo $this->db->last_query();

		return $list;
	}

	public function get_activated($cate_id, $page = 1, $filter = '', &$pagy_config, $get_content = FALSE) {
		$this->load->library('pagination');

		$filter = strtolower($filter);

		$this->db
			->select('p.id, p.subtitle, p.title, p.lead, p.tags, pg.uri, p.state_weight, p.cate_id, c.title cate_title, m.file_name, m.folder, m.type avatar_type, m.file_ext avatar_file_ext, m.content avatar_content, p.created, p.updated' . ($get_content ? ', p.content' : ''))
			->from('post p')
			->where('p.cate_id', intval($cate_id))
			->where('p.state_weight', S_ACTIVATED)
			->join('state st', 'st.weight = p.state_weight')
			->where('st.type', ST_CONTENT)
			->join('page pg', 'pg.content_id = p.id')
			->where('pg.content_type', CT_POST)
			->join('category c', 'p.cate_id = c.id')
			->join('media m', 'p.avatar_id = m.id', 'left')
			->order_by('p.id', 'DESC')
		;

		if ($filter != '') {
			$this->db->group_start()
				->like('LOWER(p.id)', $filter)
				->or_like('LOWER(p.subtitle)', $filter)
				->or_like('LOWER(p.title)', $filter)
				->or_like('LOWER(p.name)', $filter)
				->or_like('LOWER(p.title)', $filter)
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

		while ($item = $query->unbuffered_row('array')) {
			$item['updated'] = date_string($item['updated']);
			$item['created'] = date_string($item['created']);
			if ($item['file_name']) {
				$item['avatar_url'] = base_url(F_FILE .$item['folder'] .'/' .$item['file_name']);
			}
			else {
				$item['avatar_url'] = '';
			}
			$list[] = $item;
		}

		//echo $this->db->last_query();

		return $list;
	}
}
