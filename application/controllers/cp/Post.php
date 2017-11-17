<?php

class Post extends MY_Controller {
	public function edit($id = '') {
		$this->load->model(array('post_model', 'category_model', 'state_model'));
		$this->load->helper(array('language', 'form', 'url', 'text'));
		$this->load->library('form_validation');

		$submit = $this->input->post('submit');

		$data = array(
			'lang' => $this->lang,
			'title' => ($id == '' ? $this->lang->line('create') : $this->lang->line('edit')) . ' ' . $this->lang->line('post'),
			'list_category' => $this->category_model->list_simple_for_post(),
			'list_state' => $this->state_model->list_simple(),
			'link_back' => base_url(F_CP .'/post/list')
		);

		switch ($submit) {
			case NULL:
				if ($id == '') {
					$item = array(
						'id' => '',
						'subtitle' => '',
						'title' => '',
						'name' => '',
						'lead' => '',
						'content' => '',
						'cate_id' => '',
						'avatar_id' => '',
						'avatar_filename' => '',
						'state_weight' => 0,
						'created' => '',
						'udpated' => ''
					);
				}
				else {
					$item = $this->post_model->get($id);
				}
			break;

			case 'save':
				$item = array(
					'id' => $this->input->post('id'),
					'subtitle' => $this->input->post('subtitle'),
					'title' => $this->input->post('title'),
					'name' => $this->input->post('name') ? $this->input->post('name') : url_title(convert_accented_characters($this->input->post('title')), 'dash', TRUE),
					'avatar_id' => $this->input->post('avatar_id'),
					'lead' => $this->input->post('lead'),
					'content' => $this->input->post('content'),
					'cate_id' => $this->input->post('cate_id'),
					'state_weight' => $this->input->post('state_weight')
				);

				if ($this->form_validation->run('post_edit')) {
					if (!$this->post_model->save($item)) {
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
			'content/post_edit'
		);

		$this->render($data);
	}

	public function list_all() {
		$this->load->model('post_model');
		$this->load->helper(array('language', 'url'));
		$this->load->library('pagination');

		$filter = $this->input->get('filter');
		$page = $this->input->get('page');

		$pagy_config = array(
			'base_url' => base_url(F_CP .'post/list')
		);

		$data = array(
			'lang' => $this->lang,
			'title' => $this->lang->line('list_of') . $this->lang->line('post'),
			'filter' => $filter,
			'list' => $this->post_model->list_all($page, $filter, $pagy_config),
			'pagy' => $this->pagination,
			'link_create' => base_url(F_CP .'post/edit')
		);

		$this->pagination->initialize($pagy_config);

		$this->set_body(array(
			'inc/list_header',
			'content/post_list',
			'inc/list_footer'
		));

		$this->render($data);
	}

	public function list_select() {
		$this->load->model('post_model');

		$nation_id = $this->input->get('id');
		$callback = $this->input->get('callback');

		$list = $this->post_model->list_simple($nation_id);

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
