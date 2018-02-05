<?php

class Like extends JSON_Controller {
	public function __construct(array $params = []) {
		parent::__construct($params);

		$this->load->model('like_model');
	}

	public function check() {
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');

		$data = array();

		$this->form_validation->set_rules('content_id', 'lang:content', 'trim|required');
		$this->form_validation->set_rules('content_type', 'lang:content_type', 'trim|required');

		$item = array(
			'content_id' => $this->input->post('content_id'),
			'content_type' => $this->input->post('content_type'),
			'user_id' => $this->session->user['id']
		);

		if ($this->form_validation->run()) {
			if ($this->like_model->is_liked($item)) {
				$state = RS_NICE;
			}
			else {
				$state = RS_DANGER;
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
		));

		$this->render($data);
	}

	public function add() {
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');

		$data = array();

		$this->form_validation->set_rules('content_id', 'lang:content', 'trim|required');
		$this->form_validation->set_rules('content_type', 'lang:content_type', 'trim|required');

		$item = array(
			'content_id' => $this->input->post('content_id'),
			'content_type' => $this->input->post('content_type'),
			'user_id' => $this->session->user['id']
		);

		if ($this->form_validation->run()) {
			if ($this->like_model->is_liked($item)) {
				$state = RS_DANGER;
				$message = $this->lang->line('input_duplicated');
			}
			else {
				if ($this->like_model->save($item)) {
					$state = RS_NICE;
					$message = $this->lang->line('update_success');
				}
				else {
					$state = RS_DB_DANGER;
					$message = $this->lang->line('db_update_danger');
				}
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

	public function remove() {
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');

		$data = array();

		$this->form_validation->set_rules('content_id', 'lang:content', 'trim|required');
		$this->form_validation->set_rules('content_type', 'lang:content_type', 'trim|required');

		$item = array(
			'content_id' => $this->input->post('content_id'),
			'content_type' => $this->input->post('content_type'),
			'user_id' => $this->session->user['id']
		);

		if ($this->form_validation->run()) {
			if ($liked_item = $this->like_model->is_liked($item)) {
				if ($this->like_model->remove($liked_item)) {
					$state = RS_NICE;
					$message = $this->lang->line('update_success');
				}
				else {
					$state = RS_DB_DANGER;
					$message = $this->lang->line('db_update_danger');
				}
			}
			else {
				$state = RS_DANGER;
				$message = $this->lang->line('content_not_liked');
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

	public function _remap($method, $params = array()) {
		$method = str_replace('-', '_', $method);

		switch ($method) {
			case 'check':
			case 'add':
				$this->require_right('LIKE_ADD');
			break;

			case 'remove':
				$this->require_right('LIKE_REMOVE');
			break;

			default:
				exit(0);
		}

		call_user_func_array(array($this, $method), $params);
	}
}
