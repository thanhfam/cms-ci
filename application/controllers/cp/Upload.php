<?php

class Upload extends MY_Controller {
	public function __construct() {
		parent::__construct();

		$this->load->helper(array('language', 'form', 'url'));
		$this->set_simple_page();
	}

	public function upload_image($id = '') {
		$this->load->model(array('image_model'));

		$submit = $this->input->post('submit');

		$data = array(
			'lang' => $this->lang,
			'title' => $this->lang->line('image'),
			'link_back' => base_url(F_CP .'image/list')
		);

		switch ($submit) {
			case NULL:
				if ($id == '') {
					$item = array(
						'id' => '',
						'filename' => '',
						'content' => '',
						'created' => '',
						'udpated' => ''
					);
				}
				else {
					$item = $this->image_model->get($id);
				}
			break;

			case 'save':
				$item = array(
					'id' => $this->input->post('id'),
					'filename' => $this->input->post('filename'),
					'content' => $this->input->post('content')
				);

				$this->load->library('upload');

				if (!$this->upload->do_upload('image')) {
					$data['file_error'] = $this->upload->display_errors();

					$this->set_message(array(
						'type' => 3,
						'content' => $this->lang->line('input_danger')
					));
				}
				else {
					$file_data = $this->upload->data();

					$item = array_merge($item, array(
						'filename' => $file_data['file_name'],
						'oriname' => $file_data['orig_name'],
						'filepath' => $file_data['file_path'],
						'fullpath' => $file_data['full_path'],
						'width' => $file_data['image_width'],
						'height' => $file_data['image_height'],
						'type' => $file_data['image_type'],
						'size' => $file_data['file_size'],
						'direction' => ($file_data['image_width'] >= $file_data['image_height']) ? 'horizontal' : 'vertical'
					));

					$this->load->library('form_validation');

					if ($this->form_validation->run('image_upload')) {
						if (!$this->image_model->save($item)) {
							$this->set_message(array(
								'type' => 3,
								'content' => $this->lang->line('db_update_danger')
							));
						}
						else {
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
				}

				if (!isset($item['created'])) {
					$item['created'] = '';
				}
			break;
		}

		$data = array_merge($data, array(
			'item' => $item
		));

		$this->set_body(
			'content/upload_image'
		);

		$this->render($data);
	}

	public function upload_ck() {
		if(isset($_FILES['upload'])) {
			// ------ Process your file upload code -------
			$filen = $_FILES['upload']['tmp_name']; 
			$con_images = "file/content/" .$_FILES['upload']['name'];
			move_uploaded_file($filen, $con_images);
			$url = base_url($con_images);

			$funcNum = $_GET['CKEditorFuncNum'] ;
			// Optional: instance name (might be used to load a specific configuration file or anything else).
			$CKEditor = $_GET['CKEditor'] ;
			// Optional: might be used to provide localized messages.
			$langCode = $_GET['langCode'] ;

			// Usually you will only assign something here if the file could not be uploaded.
			$message = '';
			echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '$url', '$message');</script>";
		}
	}

	public function _remap($method, $params = array()) {
		switch ($method) {
			case 'ck':
				$this->auth_model->require_right('IMAGE_UPLOAD');
				$method = 'upload_ck';
			break;

			case 'image':
				$this->auth_model->require_right('IMAGE_UPLOAD');
				$method = 'upload_image';
			break;

			case 'video':
				$this->auth_model->require_right('VIDEO_UPLOAD');
				$method = 'upload_video';
			break;

			case 'index':
			case 'file':
				$this->auth_model->require_right('FILE_UPLOAD');
				$method = 'upload_file';
			break;

			default:
		}

		call_user_func_array(array($this, $method), $params);
	}
}
