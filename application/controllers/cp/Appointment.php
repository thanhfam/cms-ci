<?php

class Appointment extends MY_Controller {
	public function __construct() {
		parent::__construct();

		$this->load->model('appointment_model');
		$this->load->helper('language');
	}

	public function edit($id = '') {
		$this->load->model(array('state_model'));
		$this->load->helper(array('form', 'url', 'text'));
		$this->load->library('form_validation');

		$submit = $this->input->post('submit');

		$data = array(
			'lang' => $this->lang,
			'title' => (empty($id) ? $this->lang->line('create') : $this->lang->line('edit')) . ' ' . $this->lang->line('appointment'),
			'list_state' => $this->state_model->list_simple(ST_APPOINTMENT),
			'link_back' => base_url(F_CP .'appointment/list')
		);

		switch ($submit) {
			case NULL:
				if ($id == '') {
					$item = array(
						'id' => '',
						'name' => '',
						'email' => '',
						'phone' => '',
						'address' => '',
						'time' => '',
						'summary' => '',
						'content' => '',
						'state_weight' => '',
						'created' => '',
						'udpated' => ''
					);
				}
				else {
					$item = $this->appointment_model->get($id);
				}
			break;

			case 'save':
			case 'save_back':
				$item = array(
					'id' => $this->input->post('id'),
					'name' => $this->input->post('name'),
					'email' => $this->input->post('email'),
					'phone' => $this->input->post('phone'),
					'address' => $this->input->post('address'),
					'time' => $this->input->post('time'),
					'summary' => $this->input->post('summary'),
					'content' => $this->input->post('content'),
					'state_weight' => $this->input->post('state_weight'),
				);

				if ($this->form_validation->run('appointment_edit')) {
					if (!$this->appointment_model->save($item)) {
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
			'client/appointment_edit'
		);

		$this->render($data);
	}

	public function list_all() {
		$this->load->model(array('state_model'));
		$this->load->helper(array('language', 'url'));
		$this->load->library('pagination');

		$filter = array(
			'keyword' => $this->input->get('keyword', TRUE),
			'state_weight' => $this->input->get('state_weight')
		);

		$page = $this->input->get('page');

		$pagy_config = array(
			'base_url' => base_url(F_CP .'appointment/list')
		);

		$data = array(
			'lang' => $this->lang,
			'title' => $this->lang->line('list_of') . $this->lang->line('appointment'),
			'filter' => $filter,
			'list_state' => $this->state_model->list_simple('appointment', TRUE),
			'list' => $this->appointment_model->list_all($filter, $page, $pagy_config),
			'pagy' => $this->pagination,
			'link_excel' => base_url(F_CP .'appointment/excel'),
			'link_create' => base_url(F_CP .'appointment/edit')
		);

		$this->pagination->initialize($pagy_config);

		$this->set_body(array(
			'client/appointment_list',
			'inc/list_footer'
		));

		$this->render($data);
	}

	public function excel() {
		$filter = array(
			'keyword' => $this->input->get('keyword', TRUE),
			'state_weight' => $this->input->get('state_weight')
		);

		$list = $this->appointment_model->list_all($filter);

		include APPPATH . 'third_party/PHPExcel.php';
		$excel = new PHPExcel();

		$data = array(
			'lang' => $this->lang,
			'title' => $this->lang->line('list_of') . $this->lang->line('appointment'),
			'filter' => $filter,
			'list' => $list,
			'excel' => $excel
		);

		$this->load->view(F_CP .'client/appointment_excel', $data);
	}

	public function list_select() {
		$nation_id = $this->input->get('id');
		$callback = $this->input->get('callback');

		$list = $this->appointment_model->list_simple($nation_id);

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
				$this->auth_model->require_right('APPOINTMENT_LIST');
				$method = 'list_all';
			break;

			case 'excel':
				$this->auth_model->require_right('APPOINTMENT_LIST');
			break;

			case 'edit':
				$this->auth_model->require_right('APPOINTMENT_EDIT');
			break;

			case 'select':
				$this->auth_model->require_right('APPOINTMENT_LIST');
				$method = 'select_all';
			break;

			default:
		}

		call_user_func_array(array($this, $method), $params);
	}
}
