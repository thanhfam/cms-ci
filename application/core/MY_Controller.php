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

	protected $data = [
		'message_show_type' => 0
	];

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

		$this->data['lang'] = $this->lang;
	}

	public function go_to($address) {
		redirect($address);
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

	public function render($data) {
		$this->data = array_merge($this->data, $data);

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

class FP_Controller extends CI_Controller {
	protected $folder_view = F_FRONT;

	protected $view_header = 'header';
	protected $view_footer = 'footer';
	protected $view_body = NULL;

	public function __construct(array $params = []) {
		parent::__construct($params);

		$this->load->helper([
			'url'
		]);

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

	public function render($data) {
		$this->data = array_merge($this->data, $data);

		$this->load->view($this->folder_view .$this->view_header, $this->data);

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
}
