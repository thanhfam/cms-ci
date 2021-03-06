<?php

class View_model extends MY_Model {
	protected $folder_view = APPPATH .'views/front/';

	public function __construct() {
		parent::__construct();

		$this->load->helper('file');
	}

	public function save($item) {
		$filepath = $this->folder_view .$item['name'];

		$content = file_put_contents($filepath, $item['content']);

		if ($content === FALSE) {
			return FALSE;
		}

		return TRUE;
	}

	public function get($filename = '') {
		if ($filename == '') {
			return NULL;
		}

		$filepath = $this->folder_view .$filename;
		$content = file_get_contents($filepath);

		if ($content === FALSE) {
			return FALSE;
		}

		return array(
			'name' => $filename,
			'content' => $content
		);
	}

	public function list_all() {
		$this->load->helper('number');

		$file_list = get_dir_file_info($this->folder_view, TRUE);

		if (is_array($file_list) || is_object($file_list)) {
			foreach ($file_list as &$file) {
				$file['size'] = byte_format($file['size']);
				$file['date'] = date_string($file['date']);
			}
		}

		return $file_list;
	}
}
