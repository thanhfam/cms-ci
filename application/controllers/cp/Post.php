<?php

class Post extends MY_Controller {
	public function __construct() {
		parent::__construct();

		$this->load->model(array('post_model'));
		$this->load->helper(array('language'));
	}

	public function edit($id = '') {
		$this->load->model(array('category_model', 'state_model'));
		$this->load->helper(array('language', 'form', 'url', 'text'));
		$this->load->library('form_validation');

		$submit = $this->input->post('submit');

		$data = array(
			'lang' => $this->lang,
			'title' => ($id == '' ? $this->lang->line('create') : $this->lang->line('edit')) . ' ' . $this->lang->line('post'),
			'link_back' => base_url(F_CP .'post/list')
		);

		switch ($submit) {
			case NULL:
				if ($id == '') {
					$item = array(
						'id' => '',
						'subtitle' => '',
						'title' => '',
						'uri' => '',
						'lead' => '',
						'content' => '',
						'tags' => '',
						'cate_id' => '',
						'avatar_id' => 0,
						'avatar_url' => '',
						'avatar_type' => '',
						'avatar_file_ext' => '',
						'attachment_id' => 0,
						'attachment_url' => '',
						'attachment_type' => '',
						'attachment_file_ext' => '',
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
			case 'save_back':
				$item = array(
					'id' => $this->input->post('id'),
					'subtitle' => $this->input->post('subtitle'),
					'title' => $this->input->post('title'),
					'uri' => $this->input->post('uri'),
					'lead' => $this->input->post('lead'),
					'content' => $this->input->post('content'),
					'tags' => $this->input->post('tags'),
					'avatar_id' => $this->input->post('avatar_id'),
					'attachment_id' => $this->input->post('attachment_id'),
					'cate_id' => $this->input->post('cate_id'),
					'state_weight' => $this->input->post('state_weight'),
					'updater_id' => $this->session->user['id']
				);

				if (empty($item['id'])) {
					$item['creator_id'] = $this->session->user['id'];
				}

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

				$item = array_merge($item, array(
					'avatar_id' => $this->input->post('avatar_id'),
					'avatar_url' => $this->input->post('avatar_url'),
					'avatar_type' => $this->input->post('avatar_type'),
					'avatar_file_ext' => $this->input->post('avatar_file_ext'),
					'attachment_id' => $this->input->post('attachment_id'),
					'attachment_url' => $this->input->post('attachment_url'),
					'attachment_type' => $this->input->post('attachment_type'),
					'attachment_file_ext' => $this->input->post('attachment_file_ext')
				));
			break;
		}

		$data = array_merge($data, array(
			'list_category' => $this->category_model->list_simple_for_post(),
			'list_state' => $this->state_model->list_simple(),
			'item' => $item
		));

		$this->set_body(
			'content/post_edit'
		);

		$this->render($data);
	}

	public function list_all() {
		$this->load->model(array('category_model', 'state_model'));
		$this->load->library('pagination');

		$filter = array(
			'keyword' => $this->input->get('keyword', TRUE),
			'cate_id' => $this->input->get('cate_id'),
			'state_weight' => $this->input->get('state_weight')
		);

		$page = $this->input->get('page');

		$pagy_config = array(
			'base_url' => base_url(F_CP .'post/list')
		);

		$data = array(
			'lang' => $this->lang,
			'title' => $this->lang->line('list_of') . $this->lang->line('post'),
			'filter' => $filter,
			'list_category' => $this->category_model->list_simple_for_post(TRUE),
			'list_state' => $this->state_model->list_simple('content', TRUE),
			'list' => $this->post_model->list_all($page, $filter, $pagy_config),
			'pagy' => $this->pagination,
			'link_create' => base_url(F_CP .'post/edit')
		);

		$this->pagination->initialize($pagy_config);

		$this->set_body(array(
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
				$this->auth_model->require_right('POST_LIST');
				$method = 'list_all';
			break;

			case 'edit':
				$this->auth_model->require_right('POST_EDIT');
			break;

			case 'select':
				$this->auth_model->require_right('POST_LIST');
				$method = 'select_all';
			break;

			default:
		}

		call_user_func_array(array($this, $method), $params);
	}
}
