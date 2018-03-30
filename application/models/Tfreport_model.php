<?php

require_once(APPPATH.'models/Post_model.php');

class Tfreport_model extends Post_model {
	public function __construct() {
		parent::__construct();
	}

	public function all($filter = array(), $mine = FALSE) {
		$this->load->library('pagination');

		$this->db
			->select('p.id, p.subtitle, p.title, p.lead, p.avatar_id, p.total_like, p.total_comment, m.file_name avatar_file_name, m.folder avatar_folder, m.type avatar_type, m.file_ext avatar_file_ext, m.content avatar_content, p.attachment_id, s.name state_name, s.weight state_weight, p.cate_id, c.title cate_title, p.created, p.updated, p.creator_id, u1.name creator_name, u1.username creator_username')
			->from('post p')
			->join('user u1', 'p.creator_id = u1.id')
			->join('state s', 'p.state_weight = s.weight AND s.type = "' .ST_CONTENT .'"')
			->join('category c', 'p.cate_id = c.id')
			->join('media m', 'p.avatar_id = m.id', 'left')
			->where('p.type', CT_TF_REPORT)
			->order_by('p.id', 'DESC')
		;

		if ($mine) {
			$this->db->where('p.creator_id', $this->session->user['id']);
		}
		else {
			$this->db->where('s.weight', S_ACTIVATED);
		}

		if (isset($filter['last_id']) && ($filter['last_id'] != '')) {
			$this->db->where('p.id <', $filter['last_id']);
		}

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

		$per_page = $filter['per_page'];

		if (!isset($per_page) || empty($per_page) || !is_numeric($per_page) || $per_page < 1) {
			$per_page = 15;
		}

		$this->db->limit($per_page);

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

			$this->load_attachment_json($item);

			$list[] = $item;
		}

		return $list;
	}

	public function list_mine($page = 1, $filter = array(), &$pagy_config) {
		$this->load->library('pagination');

		$this->db
			->select('p.id, p.subtitle, p.title, p.lead, p.avatar_id, p.total_like, p.total_comment, m.file_name avatar_file_name, m.folder avatar_folder, m.type avatar_type, m.file_ext avatar_file_ext, m.content avatar_content, p.attachment_id, s.name state_name, s.weight state_weight, p.cate_id, c.title cate_title, p.created, p.updated, p.creator_id, u1.name creator_name, u1.username creator_username')
			->from('post p')
			->join('user u1', 'p.creator_id = u1.id')
			->join('state s', 'p.state_weight = s.weight')
			->join('category c', 'p.cate_id = c.id')
			->join('media m', 'p.avatar_id = m.id', 'left')
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


			$this->load_attachment_json($item);

			$list[] = $item;
		}

		return $list;
	}

	public function update($item, $user_update = FALSE) {
		$this->db->where('id', $item['id']);

		if ($user_update) {
			$this->db->where('creator_id', $this->session->user['id']);
		}

		$this->db->update('post', $item);

		$result = $this->db->affected_rows();

		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
		else {
			return FALSE;
		}
	}

	public function user_update($item) {
		return $this->update($item, TRUE);
	}
}
