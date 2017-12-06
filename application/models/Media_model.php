<?php

class Media_model extends MY_Model {
	public function __construct() {
		parent::__construct();

		$this->load->helper('number');
	}

	public function save(&$item) {
		if (strpos(MT_IMAGE_EXT, $item['file_ext']) !== false) {
			$item['type'] = MT_IMAGE;
		}
		else if (strpos(MT_VIDEO_EXT, $item['file_ext']) !== false) {
			$item['type'] = MT_VIDEO;
		}
		else if (strpos(MT_AUDIO_EXT, $item['file_ext']) !== false) {
			$item['type'] = MT_AUDIO;
		}
		else if (strpos(MT_FLASH_EXT, $item['file_ext']) !== false) {
			$item['type'] = MT_FLASH;
		}
		else if (strpos(MT_ATTACH_EXT, $item['file_ext']) !== false) {
			$item['type'] = MT_ATTACH;
		}

		if (empty($item['id'])) {
			$item['created'] = $item['updated'] = get_time();
			$item['creator_id'] = $item['updater_id'] = $this->session->user['id'];

			$result = $this->db->insert('media', $item);

			$item['id'] = $this->db->insert_id();
			$item['created'] = $item['updated'] = date_string();
		}
		else {
			$item['updated'] = get_time();
			$item['updater_id'] = $this->session->user['id'];

			$this->db->where('id', $item['id']);
			$result = $this->db->update('media', $item);

			$item['created'] = $this->input->post('created');
			$item['updated'] = date_string();
		}

		return $result;
	}

	public function remove($id = '') {
		if (!is_numeric($id)) {
			return FALSE;
		}

		$id = intval($id);

		$item = $this->get($id);
		$item_path = FCPATH .F_FILE .$item['folder'] .'/' .$item['file_name'];


		if ($item) {
			$this->db
				->where('id', $id)
				->delete('media');

			$result = $this->db->affected_rows();

			try {
				if (file_exists($item_path)) {
					unlink($item_path);
				}
			}
			catch (Exception $e) {}
		}
		else {
			$result = 0;
		}

		return $result;
	}

	public function get($id = '') {
		if (!is_numeric($id)) {
			return FALSE;
		}

		$id = intval($id);

		$this->db
			->select('m.id, m.file_name, m.orig_name, m.content, m.image_width, m.image_height, m.file_size, m.file_type, m.file_ext, m.type, m.folder, m.image_dir, m.created, m.updated, m.creator_id, u1.name creator_name, u1.username creator_username, m.updater_id, u2.name updater_name, u2.username updater_username')
			->from('media m')
			->join('user u1', 'm.creator_id = u1.id')
			->join('user u2', 'm.updater_id = u2.id')
			->where('m.id', $id)
		;

		$item = $this->db->get()->row_array();

		if ($item) {
			$item['created'] = date_string($item['created']);
			$item['updated'] = date_string($item['updated']);
			$item['url'] = base_url(F_FILE .$item['folder'] .'/' .$item['file_name']);
		}

		return $item;
	}

	public function list_all($filter = array(), &$pagy_config) {
		$this->load->library('pagination');

		$this->db
			->select('m.id, m.file_name, m.orig_name, m.content, m.image_width, m.image_height, m.file_size, m.file_type, m.file_ext, m.type, m.folder, m.image_dir, m.created, m.updated, m.creator_id, u1.name creator_name, u1.username creator_username, m.updater_id, u2.name updater_name, u2.username updater_username')
			->from('media m')
			->join('user u1', 'm.creator_id = u1.id')
			->join('user u2', 'm.updater_id = u2.id')
			->order_by('m.id', 'DESC')
		;

		if (isset($filter['keyword']) && ($filter['keyword'] != '')) {
			$keyword = $this->to_utf8($filter['keyword']);

			$this->db
				->group_start()
					->like('LOWER(m.id)', $keyword)
					->or_like('LOWER(m.orig_name)', $keyword)
					->or_like('LOWER(m.content)', $keyword)
				->group_end()
			;
		}

		if (isset($filter['type']) && ($filter['type'] != '')) {
			$this->db->where('m.type', $filter['type']);
		}

		$total_row = $this->db->count_all_results('', FALSE);
		$pagy_config['total_rows'] = $total_row;

		$per_page = ($pagy_config['per_page']) ? $pagy_config['per_page'] : $this->pagination->per_page;
		$page = ($pagy_config['page']) ? $pagy_config['page'] : 1;

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
			$item['url'] = base_url(F_FILE .$item['folder'] .'/' .$item['file_name']);
			$list[] = $item;
		}

		return $list;
	}
}
