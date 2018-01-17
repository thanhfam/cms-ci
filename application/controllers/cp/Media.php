<?php

class Media extends MY_Controller {
	public function __construct() {
		parent::__construct();

		$this->load->model(array('media_model'));
		$this->load->helper(array('language'));
	}

	public function upload() {
		$this->load->library('upload');

		$submit = $this->input->post('submit');

		switch ($submit) {
			case NULL:
				$data = array(
					'lang' => $this->lang,
					'title' => $this->lang->line('upload'),
					'link_back' => base_url(F_CP .'media/list'),
					'allowed_types' => $this->upload->get_allowed_types()
				);

				$this->set_body(
					'content/media_upload'
				);

				$this->render($data);
			break;

			case 'save':
				$folder = date_string(get_time(), '%Y%m');
				$folder_path = FCPATH .F_FILE .$folder;

				if (!file_exists($folder_path)) {
					mkdir($folder_path, 775, true);
				}

				$this->upload->set_upload_path(F_FILE .$folder_path);

				if (!$this->upload->do_upload('files')) {
					$result = 0;

					$message = array(
						'type' => 3,
						'content' => $this->upload->display_errors()
					);
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
						$result = 1;

						$message = array(
							'type' => 1,
							'content' => $this->lang->line('upload_successfully')
						);
					}
					else {
						$result = 0;

						$message = array(
							'type' => 3,
							'content' => $this->lang->line('upload_failed')
						);
					}

					$data['item'] = $item;
				}

				$data = array(
					'result' => $result,
					'message' => $message
				);

				$this->render_json($data);
			break;
		}
	}

	public function remove($id = '') {
		$data = array(
			'lang' => $this->lang,
			'title' => $this->lang->line('remove') .' ' . $this->lang->line('media') . ' #' . $id,
			'link_back' => base_url(F_CP .'media/list')
		);

		$result = $this->media_model->remove($id);

		if ($result == 0) {
			$message = array(
				'type' => 3,
				'content' => $this->lang->line('item_not_found'),
				'show_link_back' => TRUE
			);
		}
		else {
			$message = array(
				'type' => 1,
				'content' => $this->lang->line('remove_successfully'),
				'show_link_back' => TRUE
			);
		}

		$this->set_message($message);

		$this->render($data);
	}

	public function download($id = '') {
		if ($item = $this->media_model->get($id)) {
			$item_path = FCPATH .F_FILE .$item['folder'] .'/' .$item['file_name'];

			if (file_exists($item_path)) {
				header('Content-Description: File Transfer');
				header('Content-Type: ' .$item['file_type']);
				header('Content-Disposition: attachment; filename=' . $item['orig_name']); 
				header('Content-Transfer-Encoding: binary');
				header('Connection: Keep-Alive');
				header('Expires: 0');
				header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
				header('Pragma: public');
				header('Content-Length: ' . $item['file_size'] * 1024);
				readfile($item_path);
				exit(0);
			}
		}
	}

	public function edit($id = '') {
		$this->load->helper(array('form', 'url', 'text'));
		$this->load->library('form_validation');

		$submit = $this->input->post('submit');

		$data = array(
			'lang' => $this->lang,
			'title' => $this->lang->line('media'),
			'link_back' => base_url(F_CP .'media/list')
		);

		switch ($submit) {
			case NULL:
				if ($id == '') {
					$item = array(
					);
				}
				else {
					$item = $this->media_model->get($id);
				}
			break;

			case 'save':
			case 'save_back':
				$item = array(
					'id' => $this->input->post('id'),
					'content' => $this->input->post('content')
				);

				$this->load->library('form_validation');

				if ($this->form_validation->run('media_edit')) {
					if (!$this->media_model->save($item)) {
						$this->set_message(array(
							'type' => 3,
							'content' => $this->lang->line('db_update_danger')
						));
					}
					else {
						if ($submit == 'save_back') {
							$this->go_to($data['link_back']);
						}

						$this->set_message(array(
							'type' => 1,
							'content' => $this->lang->line('update_success')
						));
					}
				}
				else {
					$this->set_message(array(
						'type' => 3,
						'content' => $this->lang->line('input_danger')
					));
				}

				if (!isset($item['created'])) {
					$item['created'] = '';
				}

				$item = array_merge($item, array(
					'filename' => $this->input->post('filename'),
					'oriname' => $this->input->post('oriname'),
					'type' => $this->input->post('type'),
					'size' => $this->input->post('size'),
					'filetype' => $this->input->post('filetype'),
				));
			break;
		}

		$data = array_merge($data, array(
			'item' => $item
		));

		$this->set_body(
			'content/media_edit'
		);

		$this->render($data);
	}

	public function insert() {
		$data = $this->list_all(TRUE);

		$this->set_body(array(
			'content/media_insert'
		));

		$this->load->library('upload');

		$data = array_merge($data, array(
			'allowed_types' => $this->upload->get_allowed_types(),
			'multi_select' => $this->input->get('multi_select'),
			'callback' => $this->input->get('callback')
		));

		$this->set_empty_page();
		$this->render($data);
	}

	public function list_all_json() {
		$data = $this->list_all(TRUE);

		$data = array_diff_key($data, [
			'lang' => '',
			'link_create' => '',
			'message_show_type' => ''
		]);

		$data['pagy'] = $data['pagy']->create_links();

		$this->render_json($data);
	}

	public function list_all($buffered_data = FALSE) {
		$this->load->helper(array('language', 'url'));
		$this->load->library('pagination');

		$filter = array(
			'keyword' => $this->input->get('keyword', TRUE),
			'type' => $this->input->get('type')
		);

		$pagy_config = array(
			'base_url' => current_url(),
			'page' => $this->input->get('page'),
			'per_page' => $this->input->get('per_page')
		);

		$data = array(
			'lang' => $this->lang,
			'title' => $this->lang->line('list_of') . $this->lang->line('media'),
			'filter' => $filter,
			'list' => $this->media_model->list_all($filter, $pagy_config),
			'list_type' => array(
				MT_IMAGE,
				MT_VIDEO,
				MT_AUDIO,
				MT_FLASH,
				MT_ATTACH
			),
			'pagy' => $this->pagination,
			'link_create' => base_url(F_CP .'media/upload')
		);

		$this->pagination->initialize($pagy_config);

		if ($buffered_data) {
			return $data;
		}

		$this->set_body(array(
			'content/media_list',
			'inc/list_footer'
		));

		$this->render($data);
	}

	public function _remap($method, $params = array()) {
		switch ($method) {
			case 'index':
			case 'list':
				$this->auth_model->require_right('MEDIA_LIST');
				$method = 'list_all';
			break;

			case 'download':
			case 'list_all_json':
				$this->auth_model->require_right('MEDIA_LIST');
			break;

			case 'remove':
				$this->auth_model->require_right('MEDIA_REMOVE');
			break;

			case 'edit':
			case 'upload':
			case 'insert':
				$this->auth_model->require_right('MEDIA_EDIT');
			break;

			case 'select':
				$this->auth_model->require_right('MEDIA_LIST');
				$method = 'select_all';
			break;

			default:
		}

		call_user_func_array(array($this, $method), $params);
	}
}
