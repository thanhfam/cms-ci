<?php

class Page extends FP_Controller {
	public function __construct() {
		parent::__construct();

		$this->load->model(array(
			'page_model',
			'site_model',
			'menu_item_model',
			'category_model',
			'post_model'
		));
	}

	public function index($uri = '') {
		if ($uri == '') {
			$uri = 'vi';
		}

		$item = $this->page_model->get_by_uri($uri);

		if ($item) {
			switch ($page_type = $item['content_type']) {
				case 'category':
					$this->show_category($uri);
				break;

				case 'post':
					$this->show_post($uri);
				break;
			}
		}
		else {
			$this->show_404();
		}
	}

	public function show_home() {
	}

	public function show_category($uri) {
		$cate = $this->category_model->get_by_uri($uri);

		if ($cate === FALSE) {
			$this->show_404();
		}

		$site = $this->site_model->get($cate['site_id']);
		$menu_tree = $this->menu_item_model->get_menu_tree(1);

		$data = array(
			'title' => implode(' - ', [$cate['title'], $site['title'], $site['subtitle']]),
			'site' => $site,
			'meta' => array(
				'description' => $cate['description'],
				'keywords' => $cate['keywords']
			),
			'menu_tree' => $menu_tree
		);

		if ($cate['uri'] == 'vi' || $cate['uri'] == 'en') {
			$data = array_merge($data, array(
				'cate' => $cate,
				'list_top' => $this->post_model->get_top_activated(11, 6),
				'list_service' => $this->post_model->get_top_activated(1, 4),
				'list_hospital' => $this->post_model->get_top_activated(array(4, 5, 6, 7, 8, 9), 8),
				'list_about' => $this->post_model->get_top_activated(16, 3),
				'list_news' => $this->post_model->get_top_activated(12, 2),
				'list_sick' => $this->post_model->get_top_activated(2, 9)
			));
		}
		else {
			$this->load->library('pagination');

			$filter = $this->input->get('filter');
			$page = $this->input->get('page');

			$pagy_config = array(
				'base_url' => base_url('category/' .$uri)
			);

			if ($cate['id'] == 36) {
				$list_post = $this->post_model->get_activated($cate['id'], $page, $filter, $pagy_config, TRUE);
			}
			else {
				$list_post = $this->post_model->get_activated($cate['id'], $page, $filter, $pagy_config, FALSE);
			}

			$data = array_merge($data, array(
				'cate' => $cate,
				'list_post' => $list_post,
				'pagy' => $this->pagination
			));

			$this->pagination->initialize($pagy_config);
		}

		if ($cate['cate_layout_content']) {
			$this->set_body($cate['cate_layout_content']);
		}

		$this->render($data);
	}

	public function show_post($uri) {
		$post = $this->post_model->get_by_uri($uri);

		if ($post === FALSE) {
			$this->show_404();
		}

		$site = $this->site_model->get($post['site_id']);
		$menu_tree = $this->menu_item_model->get_menu_tree(1);

		$data = array(
			'title' => implode(' - ', [$post['title'], $site['title'], $site['subtitle']]),
			'site' => $site,
			'meta' => array(
				'description' => $post['lead'],
				'keywords' => $post['tags']
			),
			'menu_tree' => $menu_tree,
			'post' => $post
		);

		if ($post['post_layout_content']) {
			$this->set_body($post['post_layout_content']);
		}

		$this->render($data);
	}

	public function show_404() {
		header("HTTP/1.0 404 Not Found");
		exit(0);
	}
}
