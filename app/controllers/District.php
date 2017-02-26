<?php

class District extends MY_Controller {
	public function edit($id = -1) {
		$this->load->model(array('city_model', 'district_model'));
		$this->load->helper(array('language', 'form', 'url'));
		$this->load->library('form_validation');

		//$this->lang->load('label_lang', 'vietnamese');
		$data['lang'] = $this->lang;

		if ($id) {
			$data['title'] = $this->lang->line('edit') . ' ' . $this->lang->line('district');

			if ($item = $this->district_model->get($id)) {
				$data['item'] = $item->row_array();
			}
		}
		else {
			$data['title'] = $this->lang->line('create') . ' ' . $this->lang->line('district');
			$data['item'] = array(
				'id' => '',
				'title' => '',
				'type' => '',
				'city_id' => ''
			);
		}

		$data['list_city'] = $this->city_model->get_list_all()->result_array();

		if ($this->form_validation->run() == FALSE) {
			$this->load->view('inc/header', $data);
			$this->load->view('area/district_edit', $data);
			$this->load->view('inc/footer');
		}
		else {
			$this->district_model->set();
		}
	}

	public function list_all() {
		$this->load->model('district_model');
		$this->load->helper(array('language', 'url'));
		$this->load->library('pagination');

		//$this->lang->load('label_lang', 'vietnamese');
		$data['lang'] = $this->lang;

		$data['title'] = $this->lang->line('list_of') . $this->lang->line('district');

		$filter = $this->input->get('filter');
		$page = $this->input->get('page');

		$data['filter'] = $filter;

		$pagy_config = array(
			'base_url' => base_url("district/list")
		);

		$data['list'] = $this->district_model->list_all($page, $filter, $pagy_config)->result_array();

		$this->pagination->initialize($pagy_config);
		$data['pagy'] = $this->pagination;

		$this->load->view('inc/header', $data);
		$this->load->view('inc/list_header', $data);
		$this->load->view('area/district_list', $data);
		$this->load->view('inc/list_footer', $data);
		$this->load->view('inc/footer', $data);
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
