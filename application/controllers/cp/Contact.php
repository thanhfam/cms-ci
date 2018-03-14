<?php

class Contact extends MY_Controller {
	public function __construct() {
		parent::__construct();

		$this->load->model(array('enum_model', 'contact_model'));
		$this->load->helper('language');
	}

	public function edit($id = '') {
		$this->load->model(array('city_model', 'district_model', 'ward_model'));
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');

		$group = $this->input->get('group') ? $this->input->get('group') : $this->input->post('group');
		$submit = $this->input->post('submit');

		$data = array(
			'lang' => $this->lang,
			'group_name' => $group,
			'title' => (empty($id) ? $this->lang->line('create') : $this->lang->line('edit')) . ' ' . $this->lang->line('contact'),
			'link_back' => base_url(F_CP .'contact/list' .($group ? '?group=' .$group : ''))
		);

		switch ($submit) {
			case NULL:
				if ($id == '') {
					$item = array(
						'id' => 0,
						'title' => '',
						'first_name' => '',
						'middle_name' => '',
						'last_name' => '',
						'birthday' => '',
						'email' => '',
						'phone' => '',
						'address' => '',
						'dad_id' => 0,
						'mom_id' => 0,
						'partner_id' => 0,
						'city_id' => 0,
						'district_id' => 0,
						'ward_id' => 0,
						'group_name' => '',
						'note' => '',
						'created' => ''
					);
				}
				else {
					$item = $this->contact_model->get($id);
				}
			break;

			case 'save':
			case 'save_back':
				$item = array(
					'id' => $this->input->post('id'),
					'title' => $this->input->post('title'),
					'first_name' => $this->input->post('first_name'),
					'middle_name' => $this->input->post('middle_name'),
					'last_name' => $this->input->post('last_name'),
					'birthday' => $this->input->post('birthday'),
					'email' => $this->input->post('email'),
					'phone' => $this->input->post('phone'),
					'address' => $this->input->post('address'),
					'dad_id' => $this->input->post('dad_id'),
					'mom_id' => $this->input->post('mom_id'),
					'partner_id' => $this->input->post('partner_id'),
					'city_id' => $this->input->post('city_id'),
					'district_id' => $this->input->post('district_id'),
					'ward_id' => $this->input->post('ward_id'),
					'group_name' => $this->input->post('group_name'),
					'note' => $this->input->post('note')
				);


				if ($this->form_validation->run('contact_edit')) {
					if ($this->contact_model->save($item)) {
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
			'list_title' => $this->enum_model->list_simple(ET_PERSON_TITLE),
			'list_relative' => $this->contact_model->list_simple($group, $item['id']),
			'list_group' => $this->enum_model->list_simple(ET_CONTACT_GROUP),
			'list_city' => $this->city_model->list_simple(),
			'list_district' => $this->district_model->list_simple($item['city_id']),
			'list_ward' => $this->ward_model->list_simple($item['district_id'])
		));

		$this->set_body(
			'admin/contact_edit'
		);

		$this->render($data);
	}

	public function remove($id = '') {
		$group = $this->input->get('group');

		$data = array(
			'lang' => $this->lang,
			'title' => $this->lang->line('remove') .' ' . $this->lang->line('contact') . ' #' . $id,
			'link_back' => base_url(F_CP .'contact/list' .($group ? '?group=' .$group : ''))
		);

		$result = $this->contact_model->remove($id);

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

		$group = $this->input->get('group');
		$filter = $this->input->get('filter');
		$page = $this->input->get('page');

		$pagy_config = array(
			'base_url' => base_url(F_CP .'contact/list' .($group ? '?group=' .$group : ''))
		);

		$data = array(
			'lang' => $this->lang,
			'title' => $this->lang->line('list_of') . $this->lang->line('contact'),
			'group' => $group,
			'filter' => $filter,
			'list' => $this->contact_model->list_all($group, $page, $filter, $pagy_config),
			'pagy' => $this->pagination,
			'link_create' => base_url(F_CP .'contact/edit' .($group ? '?group=' .$group : ''))
		);

		$this->pagination->initialize($pagy_config);

		$this->set_body(array(
			'admin/contact_list',
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
				$this->auth_model->require_right('CONTACT_LIST');
				$method = 'list_all';
			break;

			case 'select':
				$this->auth_model->require_right('CONTACT_LIST');
				$method = 'select_all';
			break;

			case 'edit':
				$this->auth_model->require_right('CONTACT_EDIT');
			break;

			case 'remove':
				$this->auth_model->require_right('CONTACT_REMOVE');
			break;

			default:
		}

		call_user_func_array(array($this, $method), $params);
	}
}
