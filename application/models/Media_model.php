<?php

class Media_model extends MY_Model {
	public function __construct() {
		parent::__construct();

		$this->load->helper('number');
	}

	public function get_current_folder() {
		$folder_month = date_string(get_time(), '%Y%m');

		$folder_month_path = FCPATH .F_FILE .$folder_month;

		$folder_original_path = FCPATH .F_FILE .$folder_month .'/' .F_FILE_ORIGINAL;
		$folder_optimized_path = FCPATH .F_FILE .$folder_month .'/' .F_FILE_OPTIMIZED;
		$folder_thumb_path = FCPATH .F_FILE .$folder_month .'/' .F_FILE_THUMB;

		$oldmask = umask(0);
		if (!file_exists($folder_original_path)) {
			mkdir($folder_original_path, 0775, true);
		}

		if (!file_exists($folder_optimized_path)) {
			mkdir($folder_optimized_path, 0775, true);
		}

		if (!file_exists($folder_thumb_path)) {
			mkdir($folder_thumb_path, 0775, true);
		}
		umask($oldmask);

		return array(
			'month' => $folder_month,
			'original_path' => $folder_original_path,
			'optimized_path' => $folder_optimized_path,
			'thumb_path' => $folder_thumb_path
		);
	}

	function get_type($file_ext) {
		$type = '';

		if (strpos(MT_IMAGE_EXT, $file_ext) !== false) {
			$type = MT_IMAGE;
		}
		else if (strpos(MT_VIDEO_EXT, $file_ext) !== false) {
			$type = MT_VIDEO;
		}
		else if (strpos(MT_AUDIO_EXT, $file_ext) !== false) {
			$type = MT_AUDIO;
		}
		else if (strpos(MT_FLASH_EXT, $file_ext) !== false) {
			$type = MT_FLASH;
		}
		else if (strpos(MT_ATTACH_EXT, $file_ext) !== false) {
			$type = MT_ATTACH;
		}

		return $type;
	}

	public function get_url($item) {
		switch ($item['type']) {
			case MT_IMAGE:
				$url_tmb = base_url(F_FILE .$item['folder'] .'/' .F_FILE_THUMB .$item['file_name']);
				$url_opt = base_url(F_FILE .$item['folder'] .'/' .F_FILE_OPTIMIZED .$item['file_name']);
				$url_ori = base_url(F_FILE .$item['folder'] .'/' .F_FILE_ORIGINAL .$item['file_name']);
				break;

			case MT_VIDEO:
				$file_name = str_replace($item['file_ext'], 'jpg', $item['file_name']);

				$url_tmb = base_url(F_FILE .$item['folder'] .'/' .F_FILE_THUMB .$file_name);
				$url_opt = $url_ori = base_url(F_FILE .$item['folder'] .'/' .F_FILE_ORIGINAL .$item['file_name']);
				break;

			default:
				$url_tmb = $url_opt = $url_ori = base_url(F_FILE .$item['folder'] .'/' .F_FILE_ORIGINAL .$item['file_name']);
				break;
		}


		return array(
			'tmb' => $url_tmb,
			'opt' => $url_opt,
			'ori' => $url_ori
		);
	}

	public function get_file($item) {
		switch ($item['type']) {
			case MT_IMAGE:
				$file_tmb = FCPATH .F_FILE .$item['folder'] .'/' .F_FILE_THUMB .$item['file_name'];
				$file_opt = FCPATH .F_FILE .$item['folder'] .'/' .F_FILE_OPTIMIZED .$item['file_name'];
				$file_ori = FCPATH .F_FILE .$item['folder'] .'/' .F_FILE_ORIGINAL .$item['file_name'];
				break;

			case MT_VIDEO:
				$file_name = str_replace($item['file_ext'], IT_JPG, $item['file_name']);

				$file_tmb = FCPATH .F_FILE .$item['folder'] .'/' .F_FILE_THUMB .$file_name;
				$file_opt = $file_ori = FCPATH .F_FILE .$item['folder'] .'/' .F_FILE_ORIGINAL .$item['file_name'];
				break;

			default:
				$file_tmb = $file_opt = $file_ori = FCPATH .F_FILE .$item['folder'] .'/' .F_FILE_ORIGINAL .$item['file_name'];
				break;
		}

		return array(
			F_FILE_THUMB => $file_tmb,
			F_FILE_OPTIMIZED => $file_opt,
			F_FILE_ORIGINAL => $file_ori
		);
	}

	public function create_video_avatar($item = '') {
		if (!$item) {
			return;
		}

		include APPPATH . 'third_party/vendor/autoload.php';
		$this->load->library('image_lib');

		$file = $this->get_file($item);

		$ffmpeg = FFMpeg\FFMpeg::create(array(
			'ffmpeg.binaries'  => config_item('ffmpeg.binaries'),
			'ffprobe.binaries' => config_item('ffprobe.binaries'),
			'timeout'          => 3600, // The timeout for the underlying process
			'ffmpeg.threads'   => 12,   // The number of threads that FFMpeg should use
		));

		$video = $ffmpeg->open($file[F_FILE_ORIGINAL]);

		$video
			->frame(FFMpeg\Coordinate\TimeCode::fromSeconds(3))
			->save($file[F_FILE_THUMB]);

		$avatar_config = array(
			'image_library' => 'gd2',
			'source_image' => $file[F_FILE_THUMB],
			'maintain_ratio' => TRUE,
			'master_dim' => 'auto',
			'width' => config_item('file_thumb_dim'),
			'height' => config_item('file_thumb_dim')
		);

		$this->image_lib->initialize($avatar_config);

		if ($this->image_lib->resize()) {
			$this->image_lib->clear();

			$watermark_config = array(
				'wm_type' => 'overlay',
				'source_image' => $file[F_FILE_THUMB],
				'wm_vrt_alignment' => 'middle',
				'wm_hor_alignment' => 'center',
				'wm_overlay_path' => FCPATH .F_PUB .F_CP .'/img/play-button-overlay.png',
				'wm_opacity' => 50
			);

			$this->image_lib->initialize($watermark_config);
			$this->image_lib->watermark();
		}
		else {
			$default_avatar = FCPATH .F_PUB .F_CP .'/img/default_video_avatar.png';
			copy($default_avatar, $file[F_FILE_THUMB]);
		}

		$this->image_lib->clear();

		return TRUE;
	}

	public function create_optimized_image($item = '') {
		if (!$item) {
			return;
		}

		$this->load->library('image_lib');

		$file = $this->get_file($item);

		$config = array(
			'image_library' => 'gd2',
			'source_image' => $file[F_FILE_ORIGINAL],
			'maintain_ratio' => TRUE,
			'master_dim' => 'auto'
		);

		$optimized_config = array_merge($config, array(
			'width' => $item['image_width'] > config_item('file_optimized_dim') ? config_item('file_optimized_dim') : $item['image_width'],
			'height' => $item['image_height'] > config_item('file_optimized_dim') ? config_item('file_optimized_dim') : $item['image_height'],
			'new_image' => $file[F_FILE_OPTIMIZED]
		));

		$this->image_lib->initialize($optimized_config);
		if (!$this->image_lib->resize()) {
			return strip_tags($this->image_lib->display_errors());
		}
		$this->image_lib->clear();

		$thumb_config = array_merge($config, array(
			'width' => $item['image_width'] > config_item('file_thumb_dim') ? config_item('file_thumb_dim') : $item['image_width'],
			'height' => $item['image_height'] > config_item('file_thumb_dim') ? config_item('file_thumb_dim') : $item['image_height'],
			'new_image' => $file[F_FILE_THUMB]
		));

		$this->image_lib->initialize($thumb_config);
		if (!$this->image_lib->resize()) {
			return strip_tags($this->image_lib->display_errors());
		}
		$this->image_lib->clear();

		return TRUE;
	}

	public function save(&$item) {
		$result = TRUE;

		$item['type'] = $this->get_type($item['file_ext']);

		if ($item['type'] == MT_IMAGE) {
			$result = $this->create_optimized_image($item);

			if ($result !== TRUE) {
				return $result;
			}
		}
		else if ($item['type'] == MT_VIDEO) {
			$this->create_video_avatar($item);
		}

		if (empty($item['id'])) {
			$item['created'] = $item['updated'] = get_time();
			$item['creator_id'] = $item['updater_id'] = $this->session->user['id'];

			$result = $this->db->insert('media', $item); // TRUE or FALSE

			$item['id'] = $this->db->insert_id();
			$item['created'] = $item['updated'] = date_string();
		}
		else {
			$item['updated'] = get_time();
			$item['updater_id'] = $this->session->user['id'];

			$this->db->where('id', $item['id']);
			$result = $this->db->update('media', $item); // TRUE or FALSE

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

		$file = $this->get_file($item);

		if ($item) {
			$this->db
				->where('id', $id)
				->delete('media');

			$result = $this->db->affected_rows();

			try {
				foreach ($file as $key => $file_path) {
					if (file_exists($file_path)) {
						unlink($file_path);
					}
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

			$url = $this->get_url($item);
			$item['url'] = $url['tmb'];
			$item['url_opt'] = $url['opt'];
			$item['url_ori'] = $url['ori'];
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

		$per_page = $pagy_config['per_page'] ? $pagy_config['per_page'] : $this->pagination->per_page;
		$pagy_config['per_page'] = $per_page;
		$page = ($pagy_config['page']) ? $pagy_config['page'] : 1;

		$last_page = ceil($total_row / $per_page);

		if (! isset($page) || (! is_numeric($page)) || ($page < 1) || ($page > $last_page)) {
			$page = 1;
		}

		$from_row = ($page - 1) * $per_page;

		$this->db->limit($per_page, $from_row);

		$query = $this->db->query($this->db->get_compiled_select());

		$list = array();

		while ($item = $query->unbuffered_row('array')) {
			$item['updated'] = date_string($item['updated']);
			$item['created'] = date_string($item['created']);

			$url = $this->get_url($item);
			$item['url'] = $url['tmb'];
			$item['url_opt'] = $url['opt'];
			$item['url_ori'] = $url['ori'];

			$list[] = $item;
		}

		return $list;
	}
}
