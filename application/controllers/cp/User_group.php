<?php

class User_group extends MY_Controller {
	public function __construct() {
		parent::__construct();

		$this->load->model('user_group_model');
		$this->load->helper('language');
	}

	public function assign($id = '') {
		$this->load->model('right_model');
		$this->load->helper(array('form', 'url'));

		$submit = $this->input->post('submit');
		$filter = $this->input->get('filter');

		$other_right_filter = array(
			'keyword' => $filter,
			'not_user_group_id' => $id
		);

		$current_right_filter = array(
			'keyword' => $filter,
			'user_group_id' => $id
		);

		// for adding
		$other_right = $this->input->post('other_right');

		// for removing
		$current_right = $this->input->post('current_right');

		switch ($submit) {
			case 'add':
				if (count($other_right) <= 0) {
					break;
				}

				if ($this->user_group_model->assign($id, $other_right)) {
					$this->set_message(array(
						'type' => 1,
						'content' => $this->lang->line('update_success')
					));
				}
				else {
					$this->set_message(array(
						'type' => 3,
						'content' => $this->lang->line('db_update_danger')
					));
				}
			break;

			case 'remove':
				if (count($current_right) <= 0) {
					break;
				}

				if ($this->user_group_model->unassign($id, $current_right)) {
					$this->set_message(array(
						'type' => 1,
						'content' => $this->lang->line('update_success')
					));
				}
				else {
					$this->set_message(array(
						'type' => 3,
						'content' => $this->lang->line('db_update_danger')
					));
				}
			break;
		}

		$data = array(
			'lang' => $this->lang,
			'title' => $this->lang->line('right_assign'),
			'link_back' => base_url(F_CP .'user_group/list'),
			'filter' => $filter,
			'other_right_filter' => $other_right_filter,
			'current_right_filter' => $current_right_filter,
			'list_other_right' => $this->right_model->list_all($other_right_filter),
			'list_current_right' => $this->right_model->list_all($current_right_filter),
			'other_right' => $other_right,
			'current_right' => $current_right
		);

		$this->set_body(array(
			'inc/list_header',
			'system/user_group_assign'
		));

		$this->render($data);
	}

	public function edit($id = '') {
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');

		$submit = $this->input->post('submit');

		$data = array(
			'lang' => $this->lang,
			'title' => (empty($id) ? $this->lang->line('create') : $this->lang->line('edit')) . ' ' . $this->lang->line('user_group'),
			'link_back' => base_url(F_CP .'user_group/list')
		);

		switch ($submit) {
			case NULL:
				if ($id == '') {
					$item = array(
						'id' => '',
						'name' => '',
						'title' => '',
						'created' => '',
					);
				}
				else {
					$item = $this->user_group_model->get($id);
				}
			break;

			case 'save':
			case 'save_back':
				$item = array(
					'id' => $this->input->post('id'),
					'name' => $this->input->post('name'),
					'title' => $this->input->post('title')
				);

				if ($this->form_validation->run('user_group_edit')) {
					if (!$this->user_group_model->save($item)) {
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
			break;
		}

		$data = array_merge($data, array(
			'item' => $item
		));

		$this->set_body(
			'system/user_group_edit'
		);

		$this->render($data);
	}

	public function list_all() {
		$this->load->helper(array('url'));
		$this->load->library('pagination');

		$filter = $this->input->get('filter');
		$page = $this->input->get('page');

		$pagy_config = array(
			'base_url' => base_url(F_CP .'user_group/list')
		);

		$data = array(
			'lang' => $this->lang,
			'title' => $this->lang->line('list_of') . $this->lang->line('user_group'),
			'filter' => $filter,
			'list' => $this->user_group_model->list_all($page, $filter, $pagy_config),
			'pagy' => $this->pagination,
			'link_create' => base_url(F_CP .'user_group/edit')
		);

		$this->pagination->initialize($pagy_config);

		$this->set_body(array(
			'inc/list_header',
			'system/user_group_list',
			'inc/list_footer'
		));

		$this->render($data);
	}

	public function list_select() {
		$nation_id = $this->input->get('id');
		$callback = $this->input->get('callback');

		$list = $this->user_group_model->list_simple($nation_id);

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
				$this->auth_model->require_right('USER_GROUP_LIST');
				$method = 'list_all';
			break;

			case 'edit':
			case 'assign':
				$this->auth_model->require_right('USER_GROUP_EDIT');
			break;

			case 'select':
				$this->auth_model->require_right('USER_GROUP_LIST');
				$method = 'select_all';
			break;

			default:
		}

		call_user_func_array(array($this, $method), $params);
	}
}
