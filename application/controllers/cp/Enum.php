<?php

class Enum extends MY_Controller {
	public function __construct() {
		parent::__construct();

		$this->load->model('enum_model');
		$this->load->helper('language');
	}

	public function edit($id = '') {
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');

		$type = $this->input->get('type') ? $this->input->get('type') : $this->input->post('type_name');
		$submit = $this->input->post('submit');

		$data = array(
			'lang' => $this->lang,
			'type' => $type,
			'title' => (empty($id) ? $this->lang->line('create') : $this->lang->line('edit')) . ' ' . $this->lang->line('enum'),
			'link_back' => base_url(F_CP .'enum/list' .($type ? '?type=' .$type : ''))
		);

		switch ($submit) {
			case NULL:
				if ($id == '') {
					$item = array(
						'id' => '',
						'name' => '',
						'title' => '',
						'parent_id' => 0,
						'lang' => '',
						'type' => $type ? $type : '',
						'weight' => 0,
						'created' => ''
					);
				}
				else {
					$item = $this->enum_model->get($id);
				}
			break;

			case 'save':
			case 'save_back':
				$item = array(
					'id' => $this->input->post('id'),
					'name' => $this->input->post('name'),
					'title' => $this->input->post('title'),
					'parent_id' => $this->input->post('parent_id'),
					'lang' => $this->input->post('lang'),
					'weight' => $this->input->post('weight'),
					'type' => $this->input->post('type')
				);

				if ($this->form_validation->run('enum_edit')) {
					if ($this->enum_model->save($item)) {
						$this->set_message(array(
							'type' => 1,
							'content' => $this->lang->line('update_success')
						));

						if ($submit == 'save_back') {
							$this->go_to($data['link_back']);
						}
					}
					else {
						$this->set_message(array(
							'type' => 3,
							'content' => $this->lang->line('db_update_danger')
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
			'item' => $item,
			'list_parent' => $this->enum_model->list_parent($type)
		));

		$this->set_body(
			'system/enum_edit'
		);

		$this->render($data);
	}

	public function remove($id = '') {
		$data = array(
			'lang' => $this->lang,
			'title' => $this->lang->line('remove') .' ' . $this->lang->line('enum') . ' #' . $id,
			'link_back' => base_url(F_CP .'enum/list' .(isset($type) ? '?type=' .$type : ''))
		);

		$result = $this->enum_model->remove($id);

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

	public function list_all() {
		$this->load->helper(array('url'));
		$this->load->library('pagination');

		$type = $this->input->get('type');
		$filter = $this->input->get('filter');
		$page = $this->input->get('page');

		$pagy_config = array(
			'base_url' => base_url(F_CP .'enum/list' .($type ? '?type=' .$type : ''))
		);

		$data = array(
			'lang' => $this->lang,
			'title' => $this->lang->line('list_of') . $this->lang->line('enum'),
			'type' => $type,
			'filter' => $filter,
			'list' => $this->enum_model->list_all($type, $page, $filter, $pagy_config),
			'pagy' => $this->pagination,
			'link_create' => base_url(F_CP .'enum/edit' .($type ? '?type=' .$type : ''))
		);

		$this->pagination->initialize($pagy_config);

		$this->set_body(array(
			'system/enum_list',
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
				$this->auth_model->require_right('ENUM_LIST');
				$method = 'list_all';
			break;

			case 'select':
				$this->auth_model->require_right('ENUM_LIST');
				$method = 'select_all';
			break;

			case 'edit':
				$this->auth_model->require_right('ENUM_EDIT');
			break;

			case 'remove':
				$this->auth_model->require_right('ENUM_REMOVE');
			break;

			default:
		}

		call_user_func_array(array($this, $method), $params);
	}
}
