<?php

class View extends MY_Controller {
	public function __construct() {
		parent::__construct();

		$this->load->model(array('view_model'));
		$this->load->helper(array('language'));
	}

	public function edit($filename = '') {
		$this->load->helper(array('form'));

		$submit = $this->input->post('btn_submit');
		$content = $this->input->post('content');

		if (isset($submit)) {
		}
		else {
			if (isset($content)) {
				$submit = 'save';
			}
		}

		$data = array(
			'lang' => $this->lang,
			'title' => (empty($filename) ? $this->lang->line('create') : $this->lang->line('edit')) . ' ' . $this->lang->line('view'),
			'link_back' => base_url(F_CP .'view/list')
		);

		switch ($submit) {
			case NULL:
				if ($filename == '') {
					$item = array(
						'name' => '',
						'content' => ''
					);
				}
				else {
					$item = $this->view_model->get($filename);
				}
			break;

			case 'save':
			case 'save_back':
				$item = array(
					'name' => $this->input->post('name'),
					'content' => $this->input->post('content')
				);

				$this->load->library('form_validation');

				if ($this->form_validation->run('view_edit')) {
					if (!$this->view_model->save($item)) {
						$this->set_message(array(
							'type' => 3,
							'content' => $this->lang->line('file_update_danger')
						));
					}
					else {
						$this->set_message(array(
							'type' => 1,
							'content' => $this->lang->line('update_success')
						));

						if ($submit == 'save_back') {
							$this->go_to($data['link_back']);
						}
					}
				}
				else {
					$this->set_message(array(
						'type' => 3,
						'content' => $this->lang->line('input_danger')
					));
				}
			break;
		}

		$data = array_merge($data, array(
			'item' => $item
		));

		$this->set_body(
			'system/view_edit'
		);

		$this->render($data);
	}

	public function list_all() {
		$data = array(
			'lang' => $this->lang,
			'title' => $this->lang->line('list_of') . $this->lang->line('view'),
			'list' => $this->view_model->list_all(),
			'link_create' => base_url(F_CP .'view/edit')
		);

		$this->set_body(array(
			'system/view_list',
		));

		$this->render($data);
	}

	public function list_select() {
		$callback = $this->input->get('callback');

		$list = $this->view_model->list_simple();

		if ($callback) {
			$result = $callback . '(' . json_encode($list) . ');';
		}
		else {
			$result = json_encode($list);
		}

		return $this->output
			->set_content_type('application/json', 'utf-8')
			->set_status_header(200)
			->set_output($result)
		;
	}

	public function _remap($method, $params = array()) {
		switch ($method) {
			case 'index':
			case 'list':
				$this->auth_model->require_right('VIEW_LIST');
				$method = 'list_all';
			break;

			case 'edit':
				$this->auth_model->require_right('VIEW_EDIT');
			break;

			case 'select':
				$this->auth_model->require_right('VIEW_LIST');
				$method = 'select_all';
			break;

			default:
		}

		call_user_func_array(array($this, $method), $params);
	}
}
