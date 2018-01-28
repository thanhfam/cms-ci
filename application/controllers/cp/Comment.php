<?php

class Comment extends MY_Controller {
	public function __construct() {
		parent::__construct();

		$this->load->model(array('comment_model'));
	}

	public function remove($id = '') {
		$this->load->helper(array('url'));

		$data = array(
			'lang' => $this->lang,
			'title' => $this->lang->line('remove') .' ' . $this->lang->line('comment') . ' #' . $id,
			'link_back' => $this->input->get('link_back')
		);

		$item = $this->comment_model->get($id);

		if ($item) {
			$result = $this->comment_model->remove($item);
		}
		else {
			$result = 0;
		}

		if ($result == 0) {
			$message = array(
				'type' => 3,
				'content' => $this->lang->line('item_not_found'),
				'show_link_back' => TRUE
			);
		}
		else {
			$message = array(
				'type' => 1,
				'content' => $this->lang->line('remove_successfully'),
				'show_link_back' => TRUE
			);
		}

		$this->set_message($message);

		$this->render($data);
	}

	public function edit($id = '') {
		$this->load->model(array('state_model'));
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');

		$submit = $this->input->post('submit');
		$link_back = $this->input->post('link_back') ? $this->input->post('link_back') : $this->input->get('link_back');

		$data = array(
			'lang' => $this->lang,
			'title' => (empty($id) ? $this->lang->line('create') : $this->lang->line('edit')) . ' ' . $this->lang->line('comment'),
			'link_back' => $link_back
		);

		switch ($submit) {
			case NULL:
				if ($id == '') {
					$item = array(
						'id' => '',
						'comment' => '',
						'content' => '',
						'content_id' => '',
						'content_type' => '',
						'username' => '',
						'user_id' => '',
						'state_weight' => 0,
						'old_state_weight' => 0
					);
				}
				else {
					$item = $this->comment_model->get($id);
				}
			break;

			case 'save':
			case 'save_back':
			case 'activate_back':
				$item = array(
					'id' => $this->input->post('id'),
					'comment' => $this->input->post('comment'),
					'content_id' => $this->input->post('content_id'),
					'content_type' => $this->input->post('content_type'),
					'state_weight' => ($submit == 'activate_back') ? S_ACTIVATED : $this->input->post('state_weight'),
					'old_state_weight' => $this->input->post('old_state_weight')
				);

				if (empty($item['id'])) {
					$item['creator_id'] = $this->session->user['id'];
				}

				$this->form_validation->set_rules('comment', 'lang:comment', 'trim|required|max_length[1024]');
				$this->form_validation->set_rules('state_weight', 'lang:state', 'trim|required|integer');

				if ($this->form_validation->run()) {
					if (!$this->comment_model->save($item)) {
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

						if ($submit == 'save_back' || $submit == 'activate_back') {
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
					'content_title' => $this->input->post('content_title'),
					'content_type' => $this->input->post('content_type'),
					'content_id' => $this->input->post('content_id'),
					'username' => $this->input->post('username'),
					'user_id' => $this->input->post('user_id')
				));
			break;
		}

		$data = array_merge($data, array(
			'list_state' => $this->state_model->list_simple(),
			'item' => $item
		));

		$this->set_body(
			'social/comment_edit'
		);

		$this->render($data);
	}

	public function list_all($type = '') {
		$this->load->model('state_model');
		$this->load->helper(array('language', 'url'));
		$this->load->library('pagination');

		$filter = array(
			'keyword' => $this->input->get('keyword', TRUE),
			'state_weight' => $this->input->get('state_weight')
		);

		$page = $this->input->get('page');

		switch ($type) {
			case CT_POST:
			case CT_TF_REPORT:
				$title = $this->lang->line('list_of') . $this->lang->line('comment') .' ' .$this->lang->line('post');

				$pagy_config = array(
					'base_url' => base_url(F_CP .'comment/post')
				);

				$list = $this->comment_model->list_all_post($page, $filter, $pagy_config);
			break;

			case CT_COMMENT:
				$title = $this->lang->line('list_of') . $this->lang->line('comment') .' ' .$this->lang->line('comment');

				$pagy_config = array(
					'base_url' => base_url(F_CP .'comment/comment')
				);

				$list = $this->comment_model->list_all_comment($page, $filter, $pagy_config);
				break;

			default:
				return;
		}

		$data = array(
			'lang' => $this->lang,
			'title' => $title,
			'filter' => $filter,
			'list_state' => $this->state_model->list_simple(ST_CONTENT, TRUE),
			'list' => $list,
			'pagy' => $this->pagination,
			'total_rows' => $pagy_config['total_rows']
		);

		$this->pagination->initialize($pagy_config);

		$this->set_body(array(
			'social/comment_list',
			'inc/list_footer'
		));

		$this->render($data);
	}

	public function list_select() {
		$this->load->model('comment_model');

		$nation_id = $this->input->get('id');
		$callback = $this->input->get('callback');

		$list = $this->comment_model->list_simple($nation_id);

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
			case 'post':
				$this->auth_model->require_right('COMMENT_LIST');
				$method = 'list_all';
				$params[] = CT_POST;
			break;

			case 'comment':
				$this->auth_model->require_right('COMMENT_LIST');
				$method = 'list_all';
				$params[] = CT_COMMENT;
			break;

			case 'edit':
				$this->auth_model->require_right('COMMENT_EDIT');
			break;

			case 'remove':
				$this->auth_model->require_right('COMMENT_REMOVE');
			break;

			default:
		}

		call_user_func_array(array($this, $method), $params);
	}
}
