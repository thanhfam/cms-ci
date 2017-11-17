<?php

class Ward extends MY_Controller {
	public function edit($id = 0) {
		$this->load->model(array('ward_model', 'district_model', 'city_model'));
		$this->load->helper(array('language', 'form', 'url'));
		$this->load->library('form_validation');

		$submit = $this->input->post('submit');

		$data = array(
			'lang' => $this->lang,
			'title' => (empty($id) ? $this->lang->line('create') : $this->lang->line('edit')) . ' ' . $this->lang->line('ward'),
			'list_city' => $this->city_model->list_simple(),
			'link_back' => base_url('cp/ward/list')
		);

		switch ($submit) {
			case NULL:
				if (empty($id)) {
					$item = array(
						'id' => '',
						'title' => '',
						'code' => '',
						'type' => '',
						'city_id' => '1',
						'district_id' => '',
						'created' => ''
					);
				}
				else {
					$item = $this->ward_model->get($id);
				}
			break;

			case 'save':
				$item = array(
					'id' => $id,
					'title' => $this->input->post('title'),
					'code' => $this->input->post('code'),
					'type' => $this->input->post('type'),
					'district_id' => $this->input->post('district_id')
				);

				if ($this->form_validation->run('ward_edit')) {
					if (!$this->ward_model->save($item)) {
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

				$item['city_id'] = $this->input->post('city_id');
			break;
		}

		$data = array_merge($data, array(
			'item' => $item,
			'list_district' => $this->district_model->list_simple($item['city_id'])
		));

		$this->set_body(
			'area/ward_edit'
		);
		$this->render($data);
	}

	public function list_all() {
		$this->load->model('ward_model');
		$this->load->helper(array('language', 'url'));
		$this->load->library('pagination');

		$filter = $this->input->get('filter');
		$page = $this->input->get('page');

		$pagy_config = array(
			'base_url' => base_url('cp/ward/list')
		);

		$data = array(
			'lang' => $this->lang,
			'title' => $this->lang->line('list_of') . $this->lang->line('ward'),
			'filter' => $filter,
			'list' => $this->ward_model->list_all($page, $filter, $pagy_config),
			'pagy' => $this->pagination,
			'link_create' => base_url('cp/ward/edit')
		);

		$this->pagination->initialize($pagy_config);

		$this->set_body(array(
			'inc/list_header',
			'area/ward_list',
			'inc/list_footer'
		));

		$this->render($data);
	}

	public function list_select() {
		$this->load->model('ward_model');

		$district = $this->input->get('district');
		$callback = $this->input->get('callback');

		$list = $this->ward_model->list_simple($district);

		if ($callback) {
			$result = $callback . '(' . json_encode($list->result_array()) . ');';
		}
		else {
			$result = json_encode($list->result_array());
		}

		//json_encode($list->result_array(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)

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
				$this->auth_model->require_right('WARD_LIST');
				$method = 'list_all';
			break;

			case 'edit':
				$this->auth_model->require_right('WARD_EDIT');
			break;

			case 'select':
				$this->auth_model->require_right('WARD_LIST');
				$method = 'select_all';
			break;

			default:
		}

		call_user_func_array(array($this, $method), $params);
	}
}
