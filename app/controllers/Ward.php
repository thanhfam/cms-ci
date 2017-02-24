<?php

class Ward extends MY_Controller {
	public function edit($id = -1) {
		$this->load->model(array('ward_model', 'district_model', 'city_model'));
		$this->load->helper(array('language', 'form', 'url'));
		$this->load->library('form_validation');

		//$this->lang->load('label_lang', 'vietnamese');
		$data['lang'] = $this->lang;

		if ($id) {
			$data['title'] = $this->lang->line('edit') . ' ' . $this->lang->line('ward');

			if ($item = $this->ward_model->get($id)) {
				$data['item'] = $item->row_array();
			}
		}
		else {
			$data['title'] = $this->lang->line('create') . ' ' . $this->lang->line('ward');
			$data['item'] = array(
				'id' => '',
				'title' => '',
				'type' => '',
				'city_id' => '',
				'district_id' => ''
			);
		}

		$data['list_district'] = $this->district_model->get_list_all()->result_array();
		$data['list_city'] = $this->city_model->get_list_all()->result_array();

		if ($this->form_validation->run() == FALSE) {
			$this->set_body('area/ward_edit');
			$this->render($data);
		}
		else {
			$this->ward_model->set();
		}
	}

	public function list_all() {
		$this->load->model('ward_model');
		$this->load->helper(array('language', 'url'));
		$this->load->library('pagination');

		//$this->lang->load('label_lang', 'vietnamese');
		$data['lang'] = $this->lang;

		$data['title'] = $this->lang->line('list_of') . $this->lang->line('ward');

		$filter = $this->input->get('filter');
		$page = $this->input->get('page');

		$data['filter'] = $filter;

		$pagy_config = array(
			'base_url' => base_url("ward/list")
		);

		$data['list'] = $this->ward_model->list_all($page, $filter, $pagy_config)->result_array();

		$this->pagination->initialize($pagy_config);
		$data['pagy'] = $this->pagination;

		$this->set_body(array(
			'inc/list_header',
			'area/ward_list',
			'inc/list_footer'
		));

		$this->render($data);
	}

	public function _remap($method, $params = array()) {
		switch ($method) {
			case 'list':
			case 'index':
				$method = 'list_all';
			break;

			default:
		}

		call_user_func_array(array($this, $method), $params);
	}
}
