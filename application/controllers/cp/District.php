<?php

class District extends MY_Controller {
	public function edit($id = 0) {
		$this->load->model(array('city_model', 'district_model'));
		$this->load->helper(array('language', 'form', 'url'));
		$this->load->library('form_validation');

		$submit = $this->input->post('submit');

		$data = array(
			'lang' => $this->lang,
			'title' => (empty($id) ? $this->lang->line('create') : $this->lang->line('edit')) . ' ' . $this->lang->line('district'),
			'list_city' => $this->city_model->list_simple(),
			'link_back' => base_url('cp/district/list')
		);

		switch ($submit) {
			case NULL:
				if (empty($id)) {
					$item = array(
						'id' => '',
						'title' => '',
						'code' => '',
						'type' => '',
						'city_id' => '',
						'created' => ''
					);
				}
				else {
					$item = $this->district_model->get($id);
				}
			break;

			case 'save':
				$item = array(
					'id' => $id,
					'title' => $this->input->post('title'),
					'code' => $this->input->post('code'),
					'type' => $this->input->post('type'),
					'city_id' => $this->input->post('city_id')
				);

				if ($this->form_validation->run('district_edit')) {
					if (!$this->district_model->save($item)) {
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
			break;
		}

		$data = array_merge($data, array(
			'item' => $item
		));

		$this->set_body(
			'area/district_edit'
		);

		$this->render($data);
	}

	public function list_all() {
		$this->load->model('district_model');
		$this->load->helper(array('language', 'url'));
		$this->load->library('pagination');

		$filter = $this->input->get('filter');
		$page = $this->input->get('page');

		$pagy_config = array(
			'base_url' => base_url('cp/district/list')
		);

		$data = array(
			'lang' => $this->lang,
			'title' => $this->lang->line('list_of') . $this->lang->line('district'),
			'filter' => $filter,
			'list' => $this->district_model->list_all($page, $filter, $pagy_config),
			'pagy' => $this->pagination,
			'link_create' => base_url('cp/district/edit')
		);

		$this->pagination->initialize($pagy_config);

		$this->set_body(array(
			'inc/list_header',
			'area/district_list',
			'inc/list_footer'
		));

		$this->render($data);
	}

	public function list_select() {
		$this->load->model('district_model');

		$city_id = $this->input->get('id');
		$callback = $this->input->get('callback');

		$list = $this->district_model->list_simple($city_id);

		if ($callback) {
			$result = $callback . '(' . json_encode($list) . ');';
		}
		else {
			$result = json_encode($list);
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
				$method = 'list_all';
			break;

			case 'select':
				$method = 'list_select';
			break;

			default:
		}

		call_user_func_array(array($this, $method), $params);
	}
}
