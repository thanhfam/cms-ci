<?php

class Like extends MY_Controller {
	public function __construct() {
		parent::__construct();

		$this->load->model(array('like_model'));
	}

	public function list_all($type = '') {
		$this->load->library('pagination');

		$filter = $this->input->get('filter', TRUE);
		$page = $this->input->get('page');

		switch ($type) {
			case CT_POST:
			case CT_TF_REPORT:
				$title = $this->lang->line('list_of') . $this->lang->line('like') .' ' .$this->lang->line('post');

				$pagy_config = array(
					'base_url' => base_url(F_CP .'like/post')
				);

				$list = $this->like_model->list_all_post($page, $filter, $pagy_config);
			break;

			case CT_COMMENT:
				$title = $this->lang->line('list_of') . $this->lang->line('like') .' ' .$this->lang->line('comment');

				$pagy_config = array(
					'base_url' => base_url(F_CP .'like/comment')
				);

				$list = $this->like_model->list_all_comment($page, $filter, $pagy_config);
				break;

			default:
				return;
		}

		$data = array(
			'lang' => $this->lang,
			'title' => $title,
			'filter' => $filter,
			'list' => $list,
			'total_rows' => $pagy_config['total_rows'],
			'pagy' => $this->pagination
		);

		$this->pagination->initialize($pagy_config);

		$this->set_body(array(
			'inc/list_header',
			'social/like_list',
			'inc/list_footer'
		));

		$this->render($data);
	}

	public function _remap($method, $params = array()) {
		switch ($method) {
			case 'post':
				$this->auth_model->require_right('LIKE_LIST');
				$method = 'list_all';
				$params[] = CT_POST;
			break;

			case 'comment':
				$this->auth_model->require_right('LIKE_LIST');
				$method = 'list_all';
				$params[] = CT_COMMENT;
			break;

			default:
		}

		call_user_func_array(array($this, $method), $params);
	}
}
