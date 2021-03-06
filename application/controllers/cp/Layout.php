<?php

class Layout extends MY_Controller {
	public function __construct() {
		parent::__construct();

		$this->load->model(array('layout_model'));
		$this->load->helper(array('language'));
	}

	public function edit($id = '') {
		$this->load->model(array('site_model'));
		$this->load->helper(array('form', 'url', 'text'));

		$submit = $this->input->post('btn_submit');
		$name = $this->input->post('name');

		if (isset($submit)) {
		}
		else {
			if (isset($name)) {
				$submit = 'save';
			}
		}

		$data = array(
			'lang' => $this->lang,
			'title' => (empty($id) ? $this->lang->line('create') : $this->lang->line('edit')) . ' ' . $this->lang->line('layout'),
			'link_back' => base_url(F_CP .'layout/list')
		);

		switch ($submit) {
			case NULL:
				if ($id == '') {
					$item = array(
						'id' => '',
						'name' => '',
						'content' => '',
						'site_id' => '',
						'created' => ''
					);
				}
				else {
					$item = $this->layout_model->get($id);
				}
			break;

			case 'save':
			case 'save_back':
				$item = array(
					'id' => $id,
					'name' => $this->input->post('name'),
					'content' => $this->input->post('content'),
					'site_id' => $this->input->post('site_id')
				);

				$this->load->library('form_validation');

				if ($this->form_validation->run('layout_edit')) {
					if (!$this->layout_model->save($item)) {
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
			'list_site' => $this->site_model->list_simple(),
			'item' => $item
		));

		$this->set_body(
			'system/layout_edit'
		);

		$this->render($data);
	}

	public function list_all() {
		$this->load->helper(array('url'));
		$this->load->library('pagination');

		$filter = $this->input->get('filter');
		$page = $this->input->get('page');

		$pagy_config = array(
			'base_url' => base_url(F_CP .'layout/list')
		);

		$data = array(
			'lang' => $this->lang,
			'title' => $this->lang->line('list_of') . $this->lang->line('layout'),
			'filter' => $filter,
			'list' => $this->layout_model->list_all($page, $filter, $pagy_config),
			'pagy' => $this->pagination,
			'link_create' => base_url(F_CP .'layout/edit')
		);

		$this->pagination->initialize($pagy_config);

		$this->set_body(array(
			'inc/list_header',
			'system/layout_list',
			'inc/list_footer'
		));

		$this->render($data);
	}

	public function list_select() {
		$callback = $this->input->get('callback');

		$list = $this->layout_model->list_simple();

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
				$this->auth_model->require_right('LAYOUT_LIST');
				$method = 'list_all';
			break;

			case 'edit':
				$this->auth_model->require_right('LAYOUT_EDIT');
			break;

			case 'select':
				$this->auth_model->require_right('LAYOUT_LIST');
				$method = 'select_all';
			break;

			default:
		}

		call_user_func_array(array($this, $method), $params);
	}
}
