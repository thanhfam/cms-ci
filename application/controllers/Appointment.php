<?php

class Appointment extends FP_Controller {
	public function __construct() {
		parent::__construct();

		$this->load->model(array('appointment_model', 'category_model', 'site_model'));
		$this->load->helper('language');
	}

	public function index($id = '') {
		$this->load->helper(array('form', 'url', 'text'));
		$this->load->library('form_validation');

		$submit = $this->input->post('submit');

		$site = $this->site_model->get(1);
		$cate = $this->category_model->get(28);

		$data = array(
			'title' => implode(' - ', [$cate['title'], $site['title'], $site['subtitle']]),
			'meta' => array(
				'description' => $cate['description'],
				'keywords' => $cate['keywords']
			),
			'site' => $site,
			'cate' => $cate,
			'lang' => $this->lang
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
						'content' => '',
						'state_weight' => '0'
					);
				}
			break;

			case 'save':
				$item = array(
					'id' => $this->input->post('id'),
					'name' => $this->input->post('name'),
					'email' => $this->input->post('email'),
					'phone' => $this->input->post('phone'),
					'address' => $this->input->post('address'),
					'time' => $this->input->post('time'),
					'content' => $this->input->post('content'),
					'state_weight' => 0,
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
					}

					$data['hide_form'] = 'abc';
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
			'appointment'
		);

		$this->render($data);
	}

	public function _remap($method, $params = array()) {
		switch ($method) {
			case 'index':
			break;

			default:
		}

		call_user_func_array(array($this, $method), $params);
	}
}
