<?php

class Treatment extends MY_Controller {
	public function __construct() {
		parent::__construct();

		$this->load->model(array('treatment_model'));
		$this->load->helper('language');
	}

	public function edit($id = '') {
		$this->load->model(array('contact_model', 'enum_model'));
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');

		$submit = $this->input->post('submit');

		$data = array(
			'lang' => $this->lang,
			'title' => (empty($id) ? $this->lang->line('create') : $this->lang->line('edit')) . ' ' . $this->lang->line('treatment'),
			'link_back' => base_url(F_CP .'treatment/list')
		);

		switch ($submit) {
			case NULL:
				if ($id == '') {
					$item = array(
						'id' => 0,
						'code' => 0,
						'date_consult' => '',
						'date_exam' => '',
						'hospital_id' => 0,
						'service_id' => 0,
						'service_title' => '',
						'service_price' => 0,
						'customer_1_id' => 0,
						'customer_2_id' => 0,
						'agency_id' => 0,
						'staff_id' => 0,
						'created' => '',
						'updated' => ''
					);
				}
				else {
					$item = $this->treatment_model->get($id);
				}
			break;

			case 'save':
			case 'save_back':
				$item = array(
					'id' => $this->input->post('id'),
					'code' => $this->input->post('code'),
					'date_consult' => $this->input->post('date_consult'),
					'date_exam' => $this->input->post('date_exam'),
					'hospital_id' => $this->input->post('hospital_id'),
					'service_id' => $this->input->post('service_id'),
					'service_title' => $this->input->post('service_title'),
					'service_price' => $this->input->post('service_price'),
					'customer_1_id' => $this->input->post('customer_1_id'),
					'customer_2_id' => $this->input->post('customer_2_id'),
					'agency_id' => $this->input->post('agency_id'),
					'staff_id' => $this->input->post('staff_id')
				);

				if ($this->form_validation->run('treatment_edit')) {
					if ($this->treatment_model->save($item)) {
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
			'list_customer' => $this->contact_model->list_simple(CONTACT_T_CUSTOMER),
			'list_agency' => $this->contact_model->list_simple(CONTACT_T_AGENCY),
			'list_staff' => $this->contact_model->list_simple(CONTACT_T_STAFF),
			'list_hospital' => $this->enum_model->list_simple(ET_HOSPITAL),
			'list_service' => $this->enum_model->list_simple(ET_TVN_SERVICE)
		));

		$this->set_body(
			'client/treatment_edit'
		);

		$this->render($data);
	}

	public function remove($id = '') {
		$group = $this->input->get('group');

		$data = array(
			'lang' => $this->lang,
			'title' => $this->lang->line('remove') .' ' . $this->lang->line('treatment') . ' #' . $id,
			'link_back' => base_url(F_CP .'treatment/list' .($group ? '?group=' .$group : ''))
		);

		$result = $this->treatment_model->remove($id);

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
			'base_url' => base_url(F_CP .'treatment/list')
		);

		$data = array(
			'lang' => $this->lang,
			'title' => $this->lang->line('list_of') . $this->lang->line('treatment'),
			'filter' => $filter,
			'list' => $this->treatment_model->list_all($page, $filter, $pagy_config),
			'pagy' => $this->pagination,
			'link_create' => base_url(F_CP .'treatment/edit' .($group ? '?group=' .$group : ''))
		);

		$this->pagination->initialize($pagy_config);

		$this->set_body(array(
			'client/treatment_list',
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
				$this->auth_model->require_right('TREATMENT_LIST');
				$method = 'list_all';
			break;

			case 'edit':
				$this->auth_model->require_right('TREATMENT_EDIT');
			break;

			case 'remove':
				$this->auth_model->require_right('TREATMENT_REMOVE');
			break;

			default:
		}

		call_user_func_array(array($this, $method), $params);
	}
}
