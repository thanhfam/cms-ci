<?php

class Tfreport extends JSON_Controller {
	public function __construct() {
		parent::__construct();
	}

	public function get_category() {
		$this->load->model(array('category_model'));
		$data = array();

		$data['list'] = $this->category_model->list_activated_by_type(CT_TF_REPORT);

		$this->render($data);
	}

	public function upload() {
		$this->load->model(array('media_model'));
		$this->load->library('upload');
		$this->load->helper('number');

		$folder = date_string(get_time(), '%Y%m');
		$folder_path = FCPATH .F_FILE .$folder;

		if (!file_exists($folder_path)) {
			mkdir($folder_path, 775, true);
		}

		$this->upload->set_upload_path($folder_path);

		$files = $_FILES['files'];
		$list = $list_error = [];
		$result = true;

		for($i = 0; $i < count($files['name']); $i++) {
			$_FILES = array();

			foreach ($files as $k => $v) {
				$_FILES['files'][$k] = $v[$i];
			}

			if (!$this->upload->do_upload('files')) {
				$result = false;

				$item = array(
					'file_name' => $files['name'][$i],
					'file_type' => $files['type'][$i],
					'file_ext' => pathinfo($files['name'][$i], PATHINFO_EXTENSION),
					'orig_name' => $files['name'][$i],
					'file_size' => byte_format($files['size'][$i]),
					'error' => strip_tags($this->upload->display_errors())
				);

				$list_error[] = $item;
			}
			else {
				$file_data = $this->upload->data();

				$item = array(
					'folder' => $folder,
					'file_name' => $file_data['file_name'],
					'file_type' => $file_data['file_type'],
					'file_ext' => trim($file_data['file_ext'], '.'),
					'orig_name' => $file_data['orig_name'],
					'file_size' => $file_data['file_size']
				);

				if ($file_data['is_image']) {
					$item = array_merge($item, array(
						'image_width' => $file_data['image_width'],
						'image_height' => $file_data['image_height'],
						'image_dir' => ($file_data['image_width'] >= $file_data['image_height']) ? ID_HORIZONTAL : ID_VERTICAL
					));
				}

				if ($this->media_model->save($item)) {
					$list[] = $item;
				}
				else {
					$result = false;
					$item['error'] = RS_DB_DANGER;
					$list_error[] = $item;
				}
			}
		}

		if ($result) {
			$state = RS_NICE;
			$message = $this->lang->line('upload_successfully');
		}
		else {
			$state = RS_DANGER;
			$message = $this->lang->line('upload_failed');
		}

		$data = array(
			'list' => $list,
			'list_error' => $list_error,
			'state' => $state,
			'message' => $message
		);

		$this->render($data);
	}

	public function my_upload() {
		$this->load->model(array('media_model'));

		$folder = date_string(get_time(), '%Y%m');
		$folder_path = FCPATH .F_FILE .$folder;

		if (!file_exists($folder_path)) {
			mkdir($folder_path, 775, true);
		}

		$files = $_FILES['file'];
		$total = count($files['name']);
		$result = true;
		$list = $list_error = [];

		for ($i = 0; $i < $total; $i++) {
			$tmpFilePath = $files['tmp_name'][$i];

			if ($tmpFilePath != "") {
				//Setup our new file path
				$newFilePath = $folder_path .'/' .$files['name'][$i];

				if (move_uploaded_file($tmpFilePath, $newFilePath)) {
					$item = array(
						'folder' => $folder,
						'file_name' => $files['name'][$i],
						'file_type' => $files['type'][$i],
						'file_ext' => pathinfo($files['name'][$i], PATHINFO_EXTENSION),
						'orig_name' => $files['name'][$i],
						'file_size' => $files['size'][$i]
					);

					if ($this->media_model->save($item)) {
						$list[] = $item;
					}
					else {
						$list_error[] = $item;
						$result = false;
					}
				}
				else {
					$result = false;
				}
			}
		}

		if ($result) {
			$state = RS_NICE;
			$message = $this->lang->line('upload_successfully');
		}
		else {
			$state = RS_DANGER;
			$message = $this->lang->line('upload_failed');
		}

		$data = array(
			'list' => $list,
			'list_error' => $list_error,
			'state' => $state,
			'message' => $message
		);

		$this->render($data);
	}

	public function upload_file() {
		$this->load->model(array('media_model'));
		$this->load->library('upload');

		$folder = date_string(get_time(), '%Y%m');
		$folder_path = FCPATH .F_FILE .$folder;

		if (!file_exists($folder_path)) {
			mkdir($folder_path, 775, true);
		}

		$this->upload->set_upload_path(F_FILE .$folder);

		if (!$this->upload->do_upload('files')) {
			$state = RS_INPUT_DANGER;
			$message = $this->upload->display_errors();
		}
		else {
			$file_data = $this->upload->data();

			$item = array(
				'folder' => $folder,
				'file_name' => $file_data['file_name'],
				'file_type' => $file_data['file_type'],
				'file_ext' => trim($file_data['file_ext'], '.'),
				'orig_name' => $file_data['orig_name'],
				'file_size' => $file_data['file_size']
			);

			if ($file_data['is_image']) {
				$item = array_merge($item, array(
					'image_width' => $file_data['image_width'],
					'image_height' => $file_data['image_height'],
					'image_dir' => ($file_data['image_width'] >= $file_data['image_height']) ? ID_HORIZONTAL : ID_VERTICAL
				));
			}

			if ($this->media_model->save($item)) {
				$state = RS_NICE;
				$message = $this->lang->line('upload_successfully');
			}
			else {
				$state = RS_DANGER;
				$message = $this->lang->line('upload_failed');
			}

			$data['item'] = $item;
		}

		$data = array(
			'state' => $state,
			'message' => $message
		);

		$this->render($data);
	}

	public function user_remove() {
		$this->load->model(array('tfreport_model'));
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');

		$data = array();

		$this->form_validation->set_rules('id', 'lang:id', 'trim|required');

		$item = array(
			'id' => $this->input->post('id'),
			'state_weight' => S_USER_REMOVED
		);

		if ($this->form_validation->run()) {
			if ($this->tfreport_model->user_update($item)) {
				$state = RS_NICE;
				$message = $this->lang->line('remove_successfully');
			}
			else {
				$state = RS_DB_DANGER;
				$message = $this->lang->line('db_update_danger');
			}
		}
		else {
			$state = RS_INPUT_DANGER;
			$message = $this->lang->line('input_danger');
			$data['input_error'] = $this->form_validation->error_array();
		}

		$data = array_merge($data, array(
			'state' => $state,
			'message' => $message
		));

		$this->render($data);
	}

	public function edit($id = '') {
		$this->load->model(array('tfreport_model'));
		$this->load->helper(array('form', 'url', 'text'));
		$this->load->library('form_validation');

		$data = array();

		$this->form_validation->set_rules('title', 'lang:title', 'trim|required|max_length[255]');

		$item = array(
			'id' => $this->input->post('id'),
			'title' => $this->input->post('title', TRUE),
			'lead' => $this->input->post('lead', TRUE),
			'type' => CT_TF_REPORT,
			'avatar_id' => $this->input->post('avatar_id'),
			'attachment_id' => $this->input->post('attachment_id'),
			'cate_id' => $this->input->post('cate_id'),
			'state_weight' => S_INACTIVATED,
			'updater_id' => $this->session->user['id']
		);

		if (empty($item['id'])) {
			$item['creator_id'] = $this->session->user['id'];
		}

		if ($this->form_validation->run()) {
			if (!$this->tfreport_model->save($item)) {
				$state = RS_DB_DANGER;
				$message = $this->lang->line('db_update_danger');
			}
			else {
				$state = RS_NICE;
				$message = $this->lang->line('update_success');
			}
		}
		else {
			$state = RS_INPUT_DANGER;
			$message = $this->lang->line('input_danger');
			$data['input_error'] = $this->form_validation->error_array();
		}

		$data = array_merge($data, array(
			'item' => $item,
			'state' => $state,
			'message' => $message
		));

		$this->render($data);
	}

	public function all($mine = FALSE) {
		$this->load->model(array('tfreport_model', 'category_model', 'state_model'));
		$this->load->library('pagination');

		$filter = array(
			'keyword' => $this->input->get('keyword', TRUE),
			'cate_id' => $this->input->get('cate_id'),
			'state_weight' => $this->input->get('state_weight')
		);

		$page = $this->input->get('page');

		$pagy_config = array(
			'base_url' => base_url('tfreport/all')
		);

		$data = array(
			'filter' => $filter,
			'list' => ($mine) ? $this->tfreport_model->list_mine($page, $filter, $pagy_config) : $this->tfreport_model->list_all($page, $filter, $pagy_config),
			'pagy' => $this->pagination
		);

		$this->pagination->initialize($pagy_config);
		$this->render($data);
	}

	public function mine() {
		$this->all(TRUE);
	}

	public function _remap($method, $params = array()) {
		$method = str_replace('-', '_', $method);

		switch ($method) {
			case 'get_category':
				$this->require_right('TF_REPORT_GET_CATEGORY');
				break;

			case 'upload_file':
			case 'upload':
				$this->require_right('TF_REPORT_UPLOAD_FILE');
				break;

			case 'create':
			case 'edit':
				$this->require_right('TF_REPORT_EDIT');
				break;

			case 'remove':
				$this->require_right('TF_REPORT_EDIT');
				$method = 'user_remove';
				break;

			case 'all':
				$this->require_right('TF_REPORT_ALL');
				break;

			case 'mine':
				$this->require_right('TF_REPORT_MINE');
				break;

			default:
				exit(0);
		}

		call_user_func_array(array($this, $method), $params);
	}
}
