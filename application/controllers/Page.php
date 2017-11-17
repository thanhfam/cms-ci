<?php

class Page extends FP_Controller {
	public function __construct() {
		parent::__construct();

		$this->load->model(array('category_model'));
	}

	public function index($uri = '') {
		if (TRUE) {
			$item = $this->category_model->get_by_uri($uri);
		}
		else {
			$item = $this->post_model->get_by_uri($uri);
		}

		$data = array();

		if ($item) {
			$this->load->model(array('site_model', 'post_model'));
			$this->load->library('pagination');

			$filter = $this->input->get('filter');
			$page = $this->input->get('page');

			$pagy_config = array(
				'base_url' => base_url('category/' .$uri)
			);

			$data = array_merge($data, array(
				'cate' => $item,
				'site' => $this->site_model->get($item['site_id']),
				'list_post' => $this->post_model->get_activated($item['id'], $page, $filter, $pagy_config),
				'pagy' => $this->pagination
			));

			$this->pagination->initialize($pagy_config);
		}

		if ($item['cate_layout_content']) {
			$this->set_body($item['cate_layout_content']);
		}

		$this->render($data);
	}
}
