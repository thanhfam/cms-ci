<?php

class Menu_item extends MY_Controller {
	public function __construct() {
		parent::__construct();

		$this->load->model('menu_item_model');
	}

	public function remove($menu_id, $id = '') {
		$data = array(
			'lang' => $this->lang,
			'title' => $this->lang->line('remove') .' ' . $this->lang->line('menu_item') . ' #' . $id,
			'link_back' => base_url(F_CP .'menu_item/list/' . $menu_id)
		);

		$result = $this->menu_item_model->remove($id);

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

	public function edit($menu_id, $id = '') {
		$this->load->model(array('menu_model'));
		$this->load->helper(array('form', 'url', 'text'));
		$this->load->library('form_validation');

		$submit = $this->input->post('submit');

		$data = array(
			'lang' => $this->lang,
			'title' => (empty($id) ? $this->lang->line('create') : $this->lang->line('edit')) . ' ' . $this->lang->line('menu_item'),
			'list_menu' => $this->menu_model->list_simple(),
			'list_menu_item' => $this->menu_item_model->list_simple($menu_id, $id),
			'link_back' => base_url(F_CP .'menu_item/list/' . $menu_id)
		);

		switch ($submit) {
			case NULL:
				if ($id == '') {
					$item = array(
						'id' => '',
						'title' => '',
						'url' => '',
						'target' => '',
						'menu_id' => $menu_id,
						'menu_item_id' => '-',
						'position' => 0,
						'created' => '',
						'udpated' => ''
					);
				}
				else {
					$item = $this->menu_item_model->get($id);
				}
			break;

			case 'save':
				$item = array(
					'id' => $this->input->post('id'),
					'title' => $this->input->post('title'),
					'url' => $this->input->post('url'),
					'target' => $this->input->post('target'),
					'menu_id' => $this->input->post('menu_id'),
					'menu_item_id' => $this->input->post('menu_item_id'),
					'position' => $this->input->post('position')
				);

				if ($this->form_validation->run('menu_item_edit')) {
					if (!$this->menu_item_model->save($item)) {
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
			break;
		}

		$data = array_merge($data, array(
			'item' => $item
		));

		$this->set_body(
			'system/menu_item_edit'
		);

		$this->render($data);
	}

	public function list_all($menu_id) {
		$this->load->helper(array('url'));
		$this->load->library('pagination');

		$filter = $this->input->get('filter');
		$page = $this->input->get('page');

		$pagy_config = array(
			'base_url' => base_url(F_CP .'menu_item/list/' . $menu_id)
		);

		$data = array(
			'lang' => $this->lang,
			'title' => $this->lang->line('list_of') . $this->lang->line('menu_item'),
			'filter' => $filter,
			'list' => $this->menu_item_model->list_all($menu_id, $page, $filter, $pagy_config),
			'pagy' => $this->pagination,
			'link_create' => base_url(F_CP .'menu_item/edit/' . $menu_id)
		);

		$this->pagination->initialize($pagy_config);

		$this->set_body(array(
			'inc/list_header',
			'system/menu_item_list',
			'inc/list_footer'
		));

		$this->render($data);
	}

	public function _remap($method, $params = array()) {
		switch ($method) {
			case 'index':
			case 'list':
				$this->auth_model->require_right('MENU_ITEM_LIST');
				$method = 'list_all';
			break;

			case 'edit':
				$this->auth_model->require_right('MENU_ITEM_EDIT');
			break;

			case 'remove':
				$this->auth_model->require_right('MENU_ITEM_REMOVE');
			break;

			default:
		}

		call_user_func_array(array($this, $method), $params);
	}
}
