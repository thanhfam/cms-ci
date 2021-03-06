<?php

class Menu extends MY_Controller {
	public function __construct() {
		parent::__construct();

		$this->load->model('menu_model');
		$this->load->helper('language');
	}

	public function edit($id = '') {
		$this->load->model(array('site_model'));
		$this->load->helper(array('form', 'url', 'text'));
		$this->load->library('form_validation');

		$submit = $this->input->post('submit');

		$data = array(
			'lang' => $this->lang,
			'title' => (empty($id) ? $this->lang->line('create') : $this->lang->line('edit')) . ' ' . $this->lang->line('menu'),
			'list_site' => $this->site_model->list_simple(),
			'link_back' => base_url(F_CP .'menu/list')
		);

		switch ($submit) {
			case NULL:
				if ($id == '') {
					$item = array(
						'id' => '',
						'name' => '',
						'site_id' => '',
						'created' => '',
						'udpated' => ''
					);
				}
				else {
					$item = $this->menu_model->get($id);
				}
			break;

			case 'save':
			case 'save_back':
				$item = array(
					'id' => $this->input->post('id'),
					'name' => $this->input->post('name'),
					'site_id' => $this->input->post('site_id')
				);

				if ($this->form_validation->run('menu_edit')) {
					if (!$this->menu_model->save($item)) {
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
			'system/menu_edit'
		);

		$this->render($data);
	}

	public function list_all() {
		$this->load->helper(array('language', 'url'));
		$this->load->library('pagination');

		$filter = $this->input->get('filter');
		$page = $this->input->get('page');

		$pagy_config = array(
			'base_url' => base_url(F_CP .'menu/list')
		);

		$data = array(
			'lang' => $this->lang,
			'title' => $this->lang->line('list_of') . $this->lang->line('menu'),
			'filter' => $filter,
			'list' => $this->menu_model->list_all($page, $filter, $pagy_config),
			'pagy' => $this->pagination,
			'link_create' => base_url(F_CP .'menu/edit')
		);

		$this->pagination->initialize($pagy_config);

		$this->set_body(array(
			'inc/list_header',
			'system/menu_list',
			'inc/list_footer'
		));

		$this->render($data);
	}

	public function list_select() {
		$nation_id = $this->input->get('id');
		$callback = $this->input->get('callback');

		$list = $this->menu_model->list_simple($nation_id);

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
				$this->auth_model->require_right('MENU_LIST');
				$method = 'list_all';
			break;

			case 'edit':
				$this->auth_model->require_right('MENU_EDIT');
			break;

			case 'select':
				$this->auth_model->require_right('MENU_LIST');
				$method = 'select_all';
			break;

			default:
		}

		call_user_func_array(array($this, $method), $params);
	}
}
