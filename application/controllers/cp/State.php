<?php

class state extends MY_Controller {
	public function edit($id = '') {
		$this->load->model(array('state_model'));
		$this->load->helper(array('language', 'form', 'url', 'text'));
		$this->load->library('form_validation');

		$submit = $this->input->post('submit');

		$data = array(
			'lang' => $this->lang,
			'title' => (empty($id) ? $this->lang->line('create') : $this->lang->line('edit')) . ' ' . $this->lang->line('state'),
			'link_back' => base_url('cp/state/list')
		);

		switch ($submit) {
			case NULL:
				if ($id == '') {
					$item = array(
						'id' => '',
						'name' => '',
						'weight' => '',
						'created' => ''
					);
				}
				else {
					$item = $this->state_model->get($id);
				}
			break;

			case 'save':
				$item = array(
					'id' => $id,
					'name' => $this->input->post('name'),
					'weight' => $this->input->post('weight'),
				);

				if ($this->form_validation->run('state_edit')) {
					if (!$this->state_model->save($item)) {
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

					$item['created'] = '';
				}
			break;
		}

		$data = array_merge($data, array(
			'item' => $item
		));

		$this->set_body(
			'system/state_edit'
		);

		$this->render($data);
	}

	public function list_all() {
		$this->load->model('state_model');
		$this->load->helper(array('language', 'url'));
		$this->load->library('pagination');

		$filter = $this->input->get('filter');
		$page = $this->input->get('page');

		$pagy_config = array(
			'base_url' => base_url('cp/state/list')
		);

		$data = array(
			'lang' => $this->lang,
			'title' => $this->lang->line('list_of') . $this->lang->line('state'),
			'filter' => $filter,
			'list' => $this->state_model->list_all($page, $filter, $pagy_config),
			'pagy' => $this->pagination,
			'link_create' => base_url('cp/state/edit')
		);

		$this->pagination->initialize($pagy_config);

		$this->set_body(array(
			'inc/list_header',
			'system/state_list',
			'inc/list_footer'
		));

		$this->render($data);
	}

	public function list_select() {
		$this->load->model('state_model');

		$callback = $this->input->get('callback');

		$list = $this->state_model->list_simple();

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
				$this->auth_model->require_right('STATE_LIST');
				$method = 'list_all';
			break;

			case 'edit':
				$this->auth_model->require_right('STATE_EDIT');
			break;

			case 'select':
				$this->auth_model->require_right('STATE_LIST');
				$method = 'select_all';
			break;

			default:
		}

		call_user_func_array(array($this, $method), $params);
	}
}
