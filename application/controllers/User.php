<?php

class User extends JSON_Controller {
	public function __construct(array $params = []) {
		parent::__construct($params);

		$this->load->model('user_model');
	}

	public function change_password() {
		$this->load->helper('form');
		$this->load->library('form_validation');

		$id = $this->session->user['id'];
		$data = array();

		if ($this->form_validation->run('user_change_password')) {
			$item = array(
				'id' => $id,
				'password' => $this->input->post('password', TRUE),
				'password_new' => $this->input->post('password_new', TRUE),
				'password_new_confirm' => $this->input->post('password_new_confirm', TRUE)
			);

			$message = $this->user_model->change_password($item);
			$this->set_message($message);

			if ($message['type'] == 1) {
				$data['state'] = RS_NICE;
				$data['message'] = $message['content'];
			}
			else {
				$data['state'] = RS_DANGER;
				$data['message'] = $message['content'];
			}
		}
		else {
			$data['state'] = RS_INPUT_DANGER;
			$data['message'] = $this->lang->line('input_danger');
			$data['input_error'] = $this->form_validation->error_array();
		}

		$this->render($data);
	}

	public function get_session() {
		if ($this->is_logged_in()) {
			$data['state'] = RS_NICE;
			$data['user'] = $this->session->user;
			$data['message'] = $this->lang->line('sign_in_already');
		}
		else {
			$data['state'] = RS_AUTH_DANGER;
		}

		$this->render($data);
	}

	public function sign_in() {
		if ($this->is_logged_in()) {
			//unset($this->session->user);
			//$this->session->sess_destroy();

			$this->get_session();
			return;
		}

		$this->load->helper('form');
		$this->load->library('form_validation');

		$data = array();

		$this->form_validation->set_rules('username', 'lang:username', 'trim|required|max_length[255]');
		$this->form_validation->set_rules('password', 'lang:password', 'trim|required|min_length[8]|max_length[3000]');

		if ($this->form_validation->run()) {
			$item = array(
				'username' => $this->input->post('username', TRUE),
				'password' => $this->input->post('password', TRUE)
			);

			if ($user = $this->user_model->login($item)) {
				$this->init_session($user);

				$data['user'] = $user;
				$data['state'] = RS_NICE;
				$data['message'] = $this->lang->line('sign_in_successfully');
			}
			else {
				$data['state'] = RS_DANGER;
				$data['message'] = $this->lang->line('incorrect_username_password');
			}
		}
		else {
			$data['state'] = RS_INPUT_DANGER;
			$data['message'] = $this->lang->line('input_danger');
			$data['input_error'] = $this->form_validation->error_array();
		}

		$this->render($data);
	}

	public function sign_up_google() {
		$this->sign_up("google");
	}

	public function sign_up_facebook() {
		$this->sign_up("facebook");
	}

	public function sign_up($type = "email") {

		$this->load->helper('form');
		$this->load->library('form_validation');

		$data = array();
		$username = $this->input->post('username', TRUE);

		$this->form_validation->set_rules('name', 'lang:name', 'trim|required|max_length[255]');
		$this->form_validation->set_rules('password', 'lang:password', 'trim|required|min_length[8]|max_length[3000]');

		if ($type == "email") {
			$this->form_validation->set_rules('email', 'lang:email', 'trim|required|valid_email|max_length[255]|is_unique[user.email]');
			$this->form_validation->set_rules('phone', 'lang:phone', 'trim|numeric|required|min_length[10]|max_length[11]|is_unique[user.phone]');

			$username = $this->input->post('email', TRUE);
		}
		else {
			$this->form_validation->set_rules('username', 'lang:username', 'trim|required|min_length[3]|max_length[255]');
		}

		if ($this->form_validation->run()) {
			$item = array(
				'name' => $this->input->post('name', TRUE),
				'username' => $username,
				'email' => $this->input->post('email', TRUE),
				'phone' => $this->input->post('phone', TRUE),
				'password_plain' => $this->input->post('password', TRUE),
				'password' => $this->user_model->hash_password($this->input->post('password', TRUE)),
				'user_group_id' => 3,
				'state_weight' => S_ACTIVATED,
				'type' => $type
			);

			if (!$this->user_model->save($item)) {
				$data['state'] = RS_DB_DANGER;
				$data['message'] = $this->lang->line('db_update_danger');
			}
			else {
				$data['state'] = RS_NICE;
				$data['message'] = $this->lang->line('sign_up_successfully');
			}

			unset($item['password']);
			unset($item['password_plain']);
			unset($item['user_group_id']);
			unset($item['state_weight']);

			$data['item'] = $item;
		}
		else {
			$data['state'] = RS_INPUT_DANGER;
			$data['message'] = $this->lang->line('input_danger');
			$data['input_error'] = $this->form_validation->error_array();
		}

		$this->render($data);
	}

	public function edit_profile() {
		$id = $this->session->user['id'];

		$this->load->helper(array('form', 'date'));
		$this->load->library('form_validation');

		$data = array();

		$this->form_validation->set_rules('name', 'lang:name', 'trim|required|max_length[255]');
		$this->form_validation->set_rules('phone', 'lang:phone', 'trim|numeric|required|min_length[10]|max_length[11]');

		if ($this->form_validation->run('user_edit_profile')) {
			$item = array(
				'id' => $id,
				'name' => $this->input->post('name', TRUE),
				'phone' => $this->input->post('phone', TRUE)
			);

			if (!$this->user_model->save($item)) {
				$data['state'] = RS_DB_DANGER;
				$data['message'] = $this->lang->line('db_update_danger');
			}
			else {
				$data['state'] = RS_NICE;
				$data['message'] = $this->lang->line('update_success');
			}
		}
		else {
			$data['state'] = RS_INPUT_DANGER;
			$data['message'] = $this->lang->line('input_danger');
			$data['input_error'] = $this->form_validation->error_array();
		}

		$this->render($data);
	}

	public function sign_out() {
		unset($this->session->user);
		$this->session->sess_destroy();

		$data['state'] = RS_NICE;

		$this->render($data);
	}

	public function init_session($user) {
		$this->session->user = $user;
	}

	public function _remap($method, $params = array()) {
		$method = str_replace('-', '_', $method);

		switch ($method) {
			case 'sign_up':
			case 'sign_in':
			case 'sign_up_google':
			case 'sign_up_facebook':
				break;

			case 'sign_out':
			case 'get_session':
			case 'edit_profile':
			case 'change_password':
				$this->require_right('TF_REPORT_USER');
			break;

			default:
				exit(0);
		}

		call_user_func_array(array($this, $method), $params);
	}
}
