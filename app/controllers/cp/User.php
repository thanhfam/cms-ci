<?php

class User extends MY_Controller {
	public function __construct(array $params = []) {
		parent::__construct($params);

		$this->load->model('user_model');
	}

	public function change_password($id) {
		if (empty($id)) {
			show404();
		}

		$this->load->helper('form');
		$this->load->library('form_validation');

		$submit = $this->input->post('submit');

		$data = array(
			'title' => $this->lang->line('change_password'),
			'link_back' => base_url('cp/user/list')
		);

		switch ($submit) {
			case NULL:
				$item = $this->user_model->get($id);

				$item = array_merge($item, array(
					'password' => '',
					'password_confirm' => '',
					'password_new' => ''
				));
			break;

			case 'save':
				$item = array(
					'user_id' => $this->input->post('user_id'),
					'password' => $this->input->post('password_new'),
					'password_confirm' => $this->input->post('password_confirm'),
					'password_new' => $this->input->post('password_new')
				);

				if ($this->form_validation->run('user_change_password')) {
					if (!$this->user_model->save_password($item)) {
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

					$item['created_at'] = '';
				}
			break;
		}

		$data = array_merge($data, array(
			'item' => $item
		));

		$this->set_body(
			'cp/user/user_change_password'
		);
		$this->render($data);
	}

	public function edit($id = 0) {
		$this->load->helper('form');
		$this->load->library('form_validation');

		$submit = $this->input->post('submit');

		$data = array(
			'title' => (empty($id) ? $this->lang->line('create') : $this->lang->line('edit')) . ' ' . $this->lang->line('user'),
			'link_back' => base_url('cp/user/list')
		);

		switch ($submit) {
			case NULL:
				if (empty($id)) {
					$item = array(
						'user_id' => '',
						'username' => '',
						'email' => '',
						'created_at' => ''
					);
				}
				else {
					$item = $this->user_model->get($id);
				}
			break;

			case 'save':
				$item = array(
					'user_id' => $this->input->post('user_id'),
					'username' => $this->input->post('username'),
					'email' => $this->input->post('email')
				);

				if ($this->form_validation->run('user_edit')) {
					if (!$this->user_model->save($item)) {
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

						$item['created_at'] = '';
				}
			break;
		}

		$data = array_merge($data, array(
			'item' => $item
		));

		$this->set_body(
			'cp/user/user_edit'
		);
		$this->render($data);
	}

	public function login() {
		$this->load->helper('form');
		$this->load->library('form_validation');

		$submit = $this->input->post('submit');

		$data = array(
			'title' => $this->lang->line('login')
		);

		switch ($submit) {
			case NULL:
				$item = array(
					'username' => '',
					'password' => '',
					'remember_me' => 0
				);
			break;

			case 'login':
				$item = array(
					'username' => $this->input->post('username'),
					'password' => $this->input->post('password'),
					'remember_me' => $this->input->post('remember_me'),
				);

				if ($this->form_validation->run('user_login')) {
					if (!$this->user_model->check_login($item)) {
						$this->set_message(array(
							'type' => 3,
							'content' => $this->lang->line('invalid_username_password')
						));
					}
				}
			break;
		}

		$data = array_merge($data, array(
			'item' => $item
		));

		$this->set_simple_page();
		$this->set_msg_notification();
		$this->set_body(
			'cp/user/user_login'
		);
		$this->render($data);
	}

	public function list_all() {
		$this->load->library('pagination');

		$filter = $this->input->get('filter');
		$page = $this->input->get('page');

		$pagy_config = array(
			'base_url' => base_url('cp/user/list')
		);

		$data = array(
			'title' => $this->lang->line('list_of') . $this->lang->line('user'),
			'filter' => $filter,
			'list' => $this->user_model->list_all($page, $filter, $pagy_config),
			'pagy' => $this->pagination,
			'link_create' => base_url('cp/user/edit')
		);

		$this->pagination->initialize($pagy_config);

		$this->set_body(array(
			'cp/inc/list_header',
			'cp/user/user_list',
			'cp/inc/list_footer'
		));

		$this->render($data);
	}

	public function list_select() {
		$category = $this->input->get('category');
		$callback = $this->input->get('callback');

		$list = $this->user_model->list_simple($category);

		if ($callback) {
			$result = $callback . '(' . json_encode($list->result_array()) . ');';
		}
		else {
			$result = json_encode($list->result_array());
		}

		//json_encode($list->result_array(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)

		return $this->output
			->set_content_type('application/json', 'utf-8')
			->set_status_header(200)
			->set_output($result)
		;
	}

	public function _remap($method, $params = array()) {
		$method = str_replace('-', '_', $method);
		
		switch ($method) {
			case 'list':
			case 'index':
				$method = 'list_all';
			break;

			case 'select':
				$method = 'list_select';
			break;

			default:
		}

		call_user_func_array(array($this, $method), $params);
	}
}
