<?php

class Comment extends JSON_Controller {
	public function __construct(array $params = []) {
		parent::__construct($params);

		$this->load->model('comment_model');
	}

	public function add() {
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');

		$data = array();

		$this->form_validation->set_rules('content_id', 'lang:content', 'trim|required|max_length[255]');
		$this->form_validation->set_rules('content_type', 'lang:content_type', 'trim|required|max_length[255]');
		$this->form_validation->set_rules('comment', 'lang:comment', 'trim|required|max_length[1024]');

		$item = array(
			'content_id' => $this->input->post('content_id'),
			'content_type' => $this->input->post('content_type'),
			'comment' => $this->input->post('comment'),
			'user_id' => $this->session->user['id'],
			'state_weight' => S_INACTIVATED
		);

		if ($this->form_validation->run()) {
			if ($this->comment_model->save($item)) {
				$state = RS_NICE;
				$message = $this->lang->line('update_success');
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
			'item' => $item,
			'state' => $state,
			'message' => $message
		));

		$this->render($data);
	}

	public function all() {
		$this->load->library('pagination');
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');

		$data = array();

		$this->form_validation->set_rules('content_id', 'lang:content', 'trim|required|max_length[255]');
		$this->form_validation->set_rules('content_type', 'lang:content_type', 'trim|required|max_length[255]');
		$this->form_validation->set_rules('comment', 'lang:comment', 'trim|required|max_length[1024]');

		$filter = array(
			'content_id' => $this->input->post('content_id'),
			'content_type' => $this->input->post('content_type')
		);

		if ($this->form_validation->run()) {
			$state = RS_NICE;
			$page = $this->input->post('page');

			$pagy_config = array(
				'base_url' => base_url('comment/list')
			);

			$data = array(
				'filter' => $filter,
				'list' => $this->comment_model->list_all($page, $filter, $pagy_config),
				'pagy' => $this->pagination
			);

			$this->pagination->initialize($pagy_config);
			
		}
		else {
			$state = RS_INPUT_DANGER;
			$message = $this->lang->line('input_danger');
			$data['input_error'] = $this->form_validation->error_array();
		}

		$this->render($data);
	}

	public function _remap($method, $params = array()) {
		$method = str_replace('-', '_', $method);

		switch ($method) {
			case 'add':
				$this->require_right('COMMENT_ADD');
				break;

			case 'all':
				$this->require_right('COMMENT_LIST');
				break;

			default:
				exit(0);
		}

		call_user_func_array(array($this, $method), $params);
	}
}
