<?php

class Site extends MY_Controller {
	public function edit($id = '') {
		$this->load->model(array('site_model', 'nation_model'));
		$this->load->helper(array('language', 'form', 'url', 'text'));
		$this->load->library('form_validation');

		$submit = $this->input->post('submit');

		$data = array(
			'lang' => $this->lang,
			'title' => (empty($id) ? $this->lang->line('create') : $this->lang->line('edit')) . ' ' . $this->lang->line('site'),
			'link_back' => base_url('cp/site/list')
		);

		switch ($submit) {
			case NULL:
				if ($id == '') {
					$item = array(
						'id' => '',
						'title' => '',
						'name' => '',
						'url' => '',
						'language' => '',
						'facebook' => '',
						'twitter' => '',
						'pinterest' => '',
						'gplus' => '',
						'linkedin' => '',
						'avatar_id' => '',
						'avatar_filename' => '',
						'created' => ''
					);
				}
				else {
					$item = $this->site_model->get($id);
				}
			break;

			case 'save':
				$item = array(
					'id' => $id,
					'title' => $this->input->post('title'),
					'name' => $this->input->post('name') ? $this->input->post('name') : url_title(convert_accented_characters($this->input->post('title')), 'dash', TRUE),
					'url' => $this->input->post('url'),
					'language' => $this->input->post('language'),
					'facebook' => $this->input->post('facebook'),
					'twitter' => $this->input->post('twitter'),
					'pinterest' => $this->input->post('pinterest'),
					'gplus' => $this->input->post('gplus'),
					'linkedin' => $this->input->post('linkedin'),
					'avatar_id' => $this->input->post('avatar_id')
				);

				if ($this->form_validation->run('site_edit')) {
					if (!$this->site_model->save($item)) {
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

				$item['avatar_filename'] = $this->input->post('avatar_filename');
			break;
		}

		$data = array_merge($data, array(
			'item' => $item
		));

		$this->set_body(
			'system/site_edit'
		);

		$this->render($data);
	}

	public function list_all() {
		$this->load->model('site_model');
		$this->load->helper(array('language', 'url'));
		$this->load->library('pagination');

		$filter = $this->input->get('filter');
		$page = $this->input->get('page');

		$pagy_config = array(
			'base_url' => base_url('cp/site/list')
		);

		$data = array(
			'lang' => $this->lang,
			'title' => $this->lang->line('list_of') . $this->lang->line('site'),
			'filter' => $filter,
			'list' => $this->site_model->list_all($page, $filter, $pagy_config),
			'pagy' => $this->pagination,
			'link_create' => base_url('cp/site/edit')
		);

		$this->pagination->initialize($pagy_config);

		$this->set_body(array(
			'inc/list_header',
			'system/site_list',
			'inc/list_footer'
		));

		$this->render($data);
	}

	public function list_select() {
		$this->load->model('site_model');

		$callback = $this->input->get('callback');

		$list = $this->site_model->list_simple();

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
				$method = 'list_all';
			break;

			case 'select':
				$method = 'select_all';
			break;

			default:
		}

		call_user_func_array(array($this, $method), $params);
	}
}
