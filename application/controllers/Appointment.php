<?php

class Appointment extends FP_Controller {
	public function __construct() {
		parent::__construct();

		$this->load->model(array('menu_item_model', 'appointment_model', 'category_model', 'site_model'));
		$this->load->helper('language');
	}

	public function index($id = '') {
		$this->load->helper(array('form', 'url', 'text'));
		$this->load->library('form_validation');

		$submit = $this->input->post('submit');

		$site = $this->site_model->get(1);
		$cate = $this->category_model->get(28);
		$menu_tree = $this->menu_item_model->get_menu_tree(1);

		$data = array(
			'title' => implode(' - ', [$cate['title'], $site['title'], $site['subtitle']]),
			'meta' => array(
				'description' => $cate['description'],
				'keywords' => $cate['keywords']
			),
			'site' => $site,
			'cate' => $cate,
			'menu_tree' => $menu_tree,
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
						'state_weight' => '0',
						'recapthcha_site_key' => config_item('recaptcha_site_key')
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
					'state_weight' => 0
				);

				$captcha = $this->input->post('g-recaptcha-response');

				if (!isset($captcha) || empty($captcha)) {
					$this->set_message(array(
						'type' => 3,
						'content' => $this->lang->line('captcha_required')
					));

					break;
				}
				else {
					$secret = config_item('recaptcha_secret_key');
					$remoteip = $_SERVER['REMOTE_ADDR'];

					$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secret."&response=".$captcha."&remoteip=".$remoteip);

					$responseKeys = json_decode($response,true);

					if (intval($responseKeys["success"]) !== 1) {
						$this->set_message(array(
							'type' => 3,
							'content' => $this->lang->line('spam_attempt')
						));

						break;
					}
				}

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
