<?php

class Category extends MY_Controller {
	public function __construct() {
		parent::__construct();

		$this->load->model(array('category_model'));
		$this->load->helper(array('language'));
	}

	public function edit($id = '') {
		$this->load->model(array('state_model', 'layout_model', 'page_model'));
		$this->load->helper(array('form', 'url', 'text'));
		$this->load->library('form_validation');

		$submit = $this->input->post('submit');

		$data = array(
			'lang' => $this->lang,
			'title' => (empty($id) ? $this->lang->line('create') : $this->lang->line('edit')) . ' ' . $this->lang->line('category'),
			'link_back' => base_url('cp/category/list')
		);

		switch ($submit) {
			case NULL:
				if ($id == '') {
					$item = array(
						'id' => '',
						'subtitle' => '',
						'title' => '',
						'name' => '',
						'uri' => '',
						'description' => '',
						'keywords' => '',
						'lead' => '',
						'content' => '',
						'type' => '',
						'site_id' => '',
						'cate_id' => '',
						'cate_layout_id' => '',
						'post_layout_id' => '',
						'state_weight' => 0,
						'created' => '',
						'udpated' => ''
					);
				}
				else {
					$item = $this->category_model->get($id);
				}
			break;

			case 'save':
			case 'save_back':
				$item = array(
					'id' => $this->input->post('id'),
					'subtitle' => $this->input->post('subtitle'),
					'title' => $this->input->post('title'),
					'name' => $this->input->post('name') ? $this->input->post('name') : $this->input->post('title'),
					'uri' => $this->input->post('uri'),
					'description' => $this->input->post('description'),
					'keywords' => $this->input->post('keywords'),
					'lead' => $this->input->post('lead'),
					'content' => $this->input->post('content'),
					'type' => $this->input->post('type'),
					'site_id' => 1, //$this->input->post('site_id'),
					'cate_id' => $this->input->post('cate_id'),
					'cate_layout_id' => $this->input->post('cate_layout_id'),
					'post_layout_id' => $this->input->post('post_layout_id'),
					'state_weight' => $this->input->post('state_weight'),
					'updater_id' => $this->session->user['id']
				);

				if (empty($item['id'])) {
					$item['creator_id'] = $this->session->user['id'];
				}

				if ($this->form_validation->run('category_edit')) {
					if (!$this->category_model->save($item)) {
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
			'list_category' => $this->category_model->list_simple($id),
			'list_state' => $this->state_model->list_simple(),
			'list_layout' => $this->layout_model->list_simple(),
			'item' => $item
		));

		$this->set_body(
			'content/category_edit'
		);

		$this->render($data);
	}

	public function list_all() {
		$this->load->model('category_model');
		$this->load->helper(array('language', 'url'));
		$this->load->library('pagination');

		$filter = $this->input->get('filter');
		$page = $this->input->get('page');

		$pagy_config = array(
			'base_url' => base_url('cp/category/list')
		);

		$data = array(
			'lang' => $this->lang,
			'title' => $this->lang->line('list_of') . $this->lang->line('category'),
			'filter' => $filter,
			'list' => $this->category_model->list_all($page, $filter, $pagy_config),
			'pagy' => $this->pagination,
			'link_create' => base_url('cp/category/edit')
		);

		$this->pagination->initialize($pagy_config);

		$this->set_body(array(
			'inc/list_header',
			'content/category_list',
			'inc/list_footer'
		));

		$this->render($data);
	}

	public function list_select() {
		$this->load->model('category_model');

		$nation_id = $this->input->get('id');
		$callback = $this->input->get('callback');

		$list = $this->category_model->list_simple($nation_id);

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
				$this->auth_model->require_right('CATE_LIST');
				$method = 'list_all';
			break;

			case 'edit':
				$this->auth_model->require_right('CATE_EDIT');
			break;

			case 'select':
				$this->auth_model->require_right('CATE_LIST');
				$method = 'select_all';
			break;

			default:
		}

		call_user_func_array(array($this, $method), $params);
	}
}
