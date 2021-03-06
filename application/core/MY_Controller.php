<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
	protected $folder_view = F_CP;

	protected $view_header = 'inc/header';
	protected $view_header_simple = 'inc/header_simple';
	protected $view_header_empty= 'inc/header_empty';
	protected $view_footer = 'inc/footer';
	protected $view_footer_simple = 'inc/footer_simple';
	protected $view_footer_empty = 'inc/footer_empty';
	protected $view_nav = 'inc/nav';
	protected $view_message = 'inc/message';

	protected $view_body = NULL;

	protected $page_type = NULL;

	protected $data = array(
		'message_show_type' => 0
	);

	public function __construct(array $params = []) {
		parent::__construct($params);

		$this->load->library([
			'session'
		]);

		if (($this->router->class != 'user') || ($this->router->method != 'login')) {
			if ($this->not_logged_in()) {
				$this->go_to_login();
			}
		}

		$this->load->helper([
			'url'
		]);

		$this->load->model([
			'user_model',
			'auth_model'
		]);

		$this->lang->load('cp');
	}

	public function has_right($item) {
		if (!isset($this->session->menu_data)) {
			return FALSE;
		}

		switch (gettype($item)) {
			case 'string':
				if ($pos = strpos($this->session->menu_data, $item) > -1) {
					return TRUE;
				}
			break;

			case 'array':
				foreach ($item as $str) {
					if ($pos = strpos($this->session->menu_data, $str) > -1) {
						return TRUE;
					}
				}
			break;
		}

		return FALSE;
	}

	public function go_to($address) {
		redirect($address);
		exit(0);
	}

	public function go_to_dashboard() {
		$this->go_to(base_url(F_CP .'dashboard'));
	}

	public function go_to_login() {
		$this->go_to(base_url(F_CP));
	}

	public function not_logged_in() {
		return !$this->is_logged_in();
	}

	public function is_logged_in() {
		if (isset($this->session->user)) {
			return TRUE;
		}
		else {
			return FALSE;
		}
	}

	public function set_header($header) {
		$this->view_header = $header;
	}

	public function set_nav($header) {
		$this->view_nav = $nav;
	}

	public function set_body($body) {
		$this->view_body = $body;
	}

	public function set_footer($footer) {
		$this->view_footer = $footer;
	}

	public function set_simple_page() {
		$this->page_type = 'simple';
	}

	public function set_empty_page() {
		$this->page_type = 'empty';
	}

	public function set_msg_alert() {
		$this->data['message_show_type'] = 0;
	}

	public function set_msg_notification() {
		$this->data['message_show_type'] = 1;
	}

	public function set_message($message) {
		switch($message['type']) {
			case 0: // primary
				$message['cls'] = 'uk-alert-primary';
				$message['status'] = 'primary';
				//$message['title'] = $this->lang->line('message');
			break;

			case 1: // success
				$message['cls'] = 'uk-alert-success';
				$message['status'] = 'success';
				//$message['title'] = $this->lang->line('success');
			break;

			case 2: // warning
				$message['cls'] = 'uk-alert-warning';
				$message['status'] = 'warning';
				//$message['title'] = $this->lang->line('warning');
			break;

			case 3: // danger
				$message['cls'] = 'uk-alert-danger';
				$message['status'] = 'danger';
				//$message['title'] = $this->lang->line('danger');
			break;
		}

		$this->data['message'] = $message;
	}

	public function render_output($content_type, $content) {
		$this->output
			->set_content_type($content_type)
			->set_output($content);
	}

	public function render_json($data) {
		$this->data = array_merge($this->data, $data);

		if (isset($data)) {
			$this->data = $data;
		}

		return $this->output
			->set_content_type('application/json', 'utf-8')
			->set_status_header(200)
			->set_output(json_encode($this->data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
		;
	}

	public function render($data = array()) {
		$this->data['lang'] = $this->lang;

		$this->data = array_merge($this->data, $data);

		if (isset($this->session->user)) {
			$this->data['user'] = $this->session->user;
		}

		if (isset($this->session->menu_data)) {
			$this->data['menu_data'] = $this->session->menu_data;
		}

		switch ($this->page_type) {
			case 'simple':
				$this->load->view($this->folder_view .$this->view_header_simple, $this->data);
			break;

			case 'empty':
				$this->load->view($this->folder_view .$this->view_header_empty, $this->data);
			break;

			default:
				$this->load->view($this->folder_view .$this->view_header, $this->data);
		}

		if (isset($this->data['message'])) {
			$this->load->view($this->folder_view .$this->view_message, $this->data);
		}

		switch (gettype($this->view_body)) {
			case 'array':
				foreach ($this->view_body as $item) {
					$this->load->view($this->folder_view .$item, $this->data);
				}
			break;

			case 'string':
				$this->load->view($this->folder_view .$this->view_body, $this->data);

			default:
		}

		switch ($this->page_type) {
			case 'simple':
				$this->load->view($this->folder_view .$this->view_footer_simple, $this->data);
			break;

			case 'empty':
				$this->load->view($this->folder_view .$this->view_footer_empty, $this->data);
			break;

			default:
				$this->load->view($this->folder_view .$this->view_footer, $this->data);
		}
	}
}

class JSON_Controller extends CI_Controller {
	public function __construct(array $params = []) {
		parent::__construct($params);

		$this->load->library([
			'session'
		]);

		$this->load->model(array('auth_model'));

		if (($this->router->class != 'user') || ($this->router->method != 'login')) {
			if ($this->not_logged_in()) {

			}
			else {

			}
		}

		$this->lang->load('front');

		$this->data = array();
	}

	public function require_right($right) {
		if ($this->not_logged_in()) {
			$state = RS_AUTH_DANGER;
		}
		else {
			$state = $this->auth_model->require_right_json($right);
		}

		$this->data['state'] = $state;

		switch ($state) {
			case RS_AUTH_DANGER:
			case RS_RIGHT_DANGER:
				$this->render();
				exit(0);

			case RS_NICE:
				break;

			default:
				break;
		}
	}

	public function not_logged_in() {
		return !$this->is_logged_in();
	}

	public function is_logged_in() {
		if (isset($this->session->user)) {
			return TRUE;
		}
		else {
			return FALSE;
		}
	}

	public function set_message($message) {
		$this->data['message'] = $message;
	}

	public function render($data = array()) {
		$this->data = array_merge($this->data, $data);

		$this->output
			->set_content_type('application/json', 'utf-8')
			->set_status_header(200)
			->set_output(json_encode($this->data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
			->_display()
		;

		exit(0);
	}
}

class FP_Controller extends CI_Controller {
	protected $folder_view = F_FRONT;

	protected $view_header = 'header';
	protected $view_footer = 'footer';
	protected $view_message = 'message';
	protected $view_body = NULL;

	public function __construct(array $params = []) {
		parent::__construct($params);

		$this->load->helper([
			'url'
		]);

		$this->lang->load('front');
		$this->data['lang'] = $this->lang;
	}

	public function set_header($header) {
		$this->view_header = $header;
	}

	public function set_body($body) {
		$this->view_body = $body;
	}

	public function set_footer($footer) {
		$this->view_footer = $footer;
	}

	public function render_json($data) {
		$this->data = array_merge($this->data, $data);

		if (isset($data)) {
			$this->data = $data;
		}

		return $this->output
			->set_content_type('application/json', 'utf-8')
			->set_status_header(200)
			->set_output(json_encode($this->data))
		;
	}

	public function render($data) {
		$this->data = array_merge($this->data, $data);

		$this->load->view($this->folder_view .$this->view_header, $this->data);

		/* leave the position for the template maker
		if (isset($this->data['message'])) {
			$this->load->view($this->folder_view .$this->view_message, $this->data);
		}
		*/

		switch (gettype($this->view_body)) {
			case 'array':
				foreach ($this->view_body as $item) {
					$this->load->view($this->folder_view .$item, $this->data);
				}
			break;

			case 'string':
				$this->load->view($this->folder_view .$this->view_body, $this->data);

			default:
		}

		$this->load->view($this->folder_view .$this->view_footer, $this->data);
	}

	public function set_message($message) {
		switch($message['type']) {
			case 0: // primary
				$message['status'] = 'primary';
			break;

			case 2: // success
				$message['status'] = 'secondary';
			break;

			case 1: // warning
				$message['status'] = 'success';
			break;

			case 3: // danger
				$message['status'] = 'danger';
			break;

			case 4: // warning
				$message['status'] = 'warning';
			break;

			case 5: // danger
				$message['status'] = 'info';
			break;

			case 6: // warning
				$message['status'] = 'light';
			break;

			case 7: // danger
				$message['status'] = 'dark';
			break;
		}

		$this->data['message'] = $message;
	}
}
