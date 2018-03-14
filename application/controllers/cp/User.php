<?php

class User extends MY_Controller {
	public function __construct(array $params = []) {
		parent::__construct($params);

		$this->load->model('user_model');
	}

	public function reset_password($id = '') {
		if ($id == '') {
			show404();
		}

		$item = array(
			'id' => $id,
			'password_new' => $this->user_model->generate_password()
		);

		$message = $this->user_model->save_password($item);

		if ($message['type'] == 1) {
			$message['content'] = $this->lang->line('new_password_is') . $item['password_new'];
		}

		$message['show_link_back'] = TRUE;

		$this->set_message($message);

		$data = array(
			'title' => $this->lang->line('reset_password'),
			'link_back' => base_url(F_CP .'user/list')
		);

		$this->render($data);

	}

	public function not_granted() {
		$data = array(
			'title' => $this->lang->line('not_granted'),
		);

		$this->set_message(array(
			'type' => 3,
			'content' => $this->lang->line('permission_not_grannted')
		));

		$this->set_simple_page();
		$this->render($data);
	}

	public function change_password() {
		$id = $this->session->user['id'];

		$this->load->helper('form');
		$this->load->library('form_validation');

		$submit = $this->input->post('submit');

		$data = array(
			'title' => $this->lang->line('change_password'),
			'link_back' => base_url(F_CP .'user/list')
		);

		switch ($submit) {
			case NULL:
				$item = $this->user_model->get($id);

				$item = array_merge($item, array(
					'password' => '',
					'password_new' => '',
					'password_new_confirm' => ''
				));
			break;

			case 'save':
				$item = array(
					'id' => $id,
					'password' => $this->input->post('password'),
					'password_new' => $this->input->post('password_new'),
					'password_new_confirm' => $this->input->post('password_new_confirm'),
					'created' => $this->input->post('created'),
					'updated' => $this->input->post('updated')
				);

				if ($this->form_validation->run('user_change_password')) {
					$message = $this->user_model->change_password($item);
					$this->set_message($message);

					if ($message['type'] == 1) {
						$item = array_merge($item, array(
							'password' => '',
							'password_new' => '',
							'password_new_confirm' => ''
						));
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
			'system/user_change_password'
		);

		$this->render($data);
	}

	public function remove($id = '') {
		$data = array(
			'lang' => $this->lang,
			'title' => $this->lang->line('remove') .' ' . $this->lang->line('user') . ' #' . $id,
			'link_back' => base_url(F_CP .'user/list')
		);

		$result = $this->user_model->remove($id);

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

	public function edit($id = '') {
		$this->load->model(array('state_model', 'user_group_model'));
		$this->load->helper('form');
		$this->load->library('form_validation');

		$submit = $this->input->post('submit');

		$data = array(
			'title' => (empty($id) ? $this->lang->line('create') : $this->lang->line('edit')) . ' ' . $this->lang->line('user'),
			'list_state' => $this->state_model->list_simple(),
			'list_group' => $this->user_group_model->list_simple(),
			'link_back' => base_url(F_CP .'user/list')
		);

		switch ($submit) {
			case NULL:
				if ($id == '') {
					$item = array(
						'id' => '',
						'username' => '',
						'name' => '',
						'email' => '',
						'phone' => '',
						'state_weight' => '',
						'user_group_id' => '',
						'created' => '',
						'avatar_id' => 0,
						'avatar_url' => '',
						'avatar_url_opt' => '',
						'avatar_url_ori' => '',
						'avatar_type' => '',
						'avatar_file_ext' => ''
					);
				}
				else {
					$item = $this->user_model->get($id);
				}
			break;

			case 'save':
			case 'save_back':
				$item = array(
					'id' => $this->input->post('id'),
					'username' => $this->input->post('username'),
					'name' => $this->input->post('name'),
					'email' => $this->input->post('email'),
					'phone' => $this->input->post('phone'),
					'user_group_id' => $this->input->post('user_group_id'),
					'state_weight' => $this->input->post('state_weight'),
					'avatar_id' => $this->input->post('avatar_id')
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

					$item['created'] = '';
				}

				$item = array_merge($item, array(
					'avatar_id' => $this->input->post('avatar_id'),
					'avatar_url' => $this->input->post('avatar_url'),
					'avatar_url_opt' => $this->input->post('avatar_url_opt'),
					'avatar_url_ori' => $this->input->post('avatar_url_ori'),
					'avatar_type' => $this->input->post('avatar_type'),
					'avatar_file_ext' => $this->input->post('avatar_file_ext')
				));

			break;
		}

		$data = array_merge($data, array(
			'item' => $item
		));

		$this->set_body(
			'system/user_edit'
		);
		$this->render($data);
	}

	public function edit_profile() {
		$id = $this->session->user['id'];

		$this->load->helper(array('form', 'date'));
		$this->load->library('form_validation');

		$submit = $this->input->post('submit');

		$data = array(
			'title' => $this->lang->line('profile')
		);

		switch ($submit) {
			case NULL:
				$item = $this->user_model->get($id);
			break;

			case 'save':
				$item = array(
					'id' => $id,
					'name' => $this->input->post('name'),
					'email' => $this->input->post('email'),
					'timezone' => $this->input->post('timezone'),
					'date_format' => $this->input->post('date_format'),
					'phone' => $this->input->post('phone'),
					'avatar_id' => $this->input->post('avatar_id')
				);

				if ($this->form_validation->run('user_edit_profile')) {
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

						$this->session->date_format = $item['date_format'];
						$this->session->timezone = $item['timezone'];
					}
				}
				else {
					$this->set_message(array(
						'type' => 3,
						'content' => $this->lang->line('input_danger')
					));

					$item['created'] = '';
				}

				$item = array_merge($item, array(
					'avatar_id' => $this->input->post('avatar_id'),
					'avatar_url' => $this->input->post('avatar_url'),
					'avatar_url_opt' => $this->input->post('avatar_url_opt'),
					'avatar_url_ori' => $this->input->post('avatar_url_ori'),
					'avatar_type' => $this->input->post('avatar_type'),
					'avatar_file_ext' => $this->input->post('avatar_file_ext')
				));

			break;
		}

		$data = array_merge($data, array(
			'item' => $item
		));

		$this->set_body(
			'system/user_edit_profile'
		);
		$this->render($data);
	}

	public function logout() {
		unset($this->session->user);
		$this->session->sess_destroy();
		$this->go_to_login();
	}

	public function login() {
		if ($this->is_logged_in()) {
			$this->go_to_dashboard();
		}

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
					'username' => $this->input->post('username', TRUE),
					'password' => $this->input->post('password', TRUE),
					'remember_me' => $this->input->post('remember_me', TRUE)
				);

				if ($this->form_validation->run('user_login')) {
					if ($user = $this->user_model->login($item)) {
						$this->init_session($user);

						if ($item['remember_me']) {
							$this->session->set_userdata('remember_me', TRUE);
						}

						$this->go_to_dashboard();
					}
					else {
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

		$this->set_empty_page();
		$this->set_msg_notification();
		$this->set_body(
			'system/user_login'
		);
		$this->render($data);
	}

	public function init_session($user) {
		$this->session->user = $user;
		$this->session->menu_data = $this->user_model->get_menu_data($user);

		$this->session->date_format = $user['date_format'];
		$this->session->timezone = $user['timezone'];
	}

	public function list_all() {
		$this->load->library('pagination');

		$filter = $this->input->get('filter');
		$page = $this->input->get('page');

		$pagy_config = array(
			'base_url' => base_url(F_CP .'user/list')
		);

		$data = array(
			'title' => $this->lang->line('list_of') . $this->lang->line('user'),
			'filter' => $filter,
			'list' => $this->user_model->list_all($page, $filter, $pagy_config),
			'pagy' => $this->pagination,
			'link_create' => base_url(F_CP .'user/edit')
		);

		$this->pagination->initialize($pagy_config);

		$this->set_body(array(
			'inc/list_header',
			'system/user_list',
			'inc/list_footer'
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
				$this->auth_model->require_right('USER_LIST');
				$method = 'list_all';
			break;

			case 'remove':
				$this->auth_model->require_right('USER_REMOVE');
			break;

			case 'edit':
				$this->auth_model->require_right('USER_EDIT');
			break;

			case 'reset_password':
				$this->auth_model->require_right('USER_RESET_PASSWORD');
			break;

			case 'select':
				$this->auth_model->require_right('USER_LIST');
				$method = 'list_select';
			break;

			default:
		}

		call_user_func_array(array($this, $method), $params);
	}
}
