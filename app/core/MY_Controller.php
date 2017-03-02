<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
	protected $view_header = 'cp/inc/header';
	protected $view_header_simple = 'cp/inc/header_simple';
	protected $view_footer = 'cp/inc/footer';
	protected $view_footer_simple = 'cp/inc/footer_simple';
	protected $view_nav = 'cp/inc/nav';
	protected $view_message = 'cp/inc/message';

	protected $simple_page = FALSE;

	protected $message;

	protected $data = [];

	public function __construct() {
		parent::__construct();
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
		$this->simple_page = TRUE;
	}

	public function set_message($message) {
		switch($message['type']) {
			case 0: // primary
				$message['cls'] = 'uk-alert-primary';
				//$message['title'] = $this->lang->line('message');
			break;

			case 1: // success
				$message['cls'] = 'uk-alert-success';
				//$message['title'] = $this->lang->line('success');
			break;

			case 2: // warning
				$message['cls'] = 'uk-alert-warning';
				//$message['title'] = $this->lang->line('warning');
			break;

			case 3: // danger
				$message['cls'] = 'uk-alert-danger';
				//$message['title'] = $this->lang->line('danger');
			break;
		}

		$this->data['message'] = $message;
	}

	public function render($data) {
		$this->data = array_merge($this->data, $data);

		if ($this->simple_page) {
			$this->load->view($this->view_header_simple, $this->data);
		}
		else {
			$this->load->view($this->view_header, $this->data);
		}

		if (isset($this->data['message'])) {
			$this->load->view($this->view_message, $this->data);
		}

		switch (gettype($this->view_body)) {
			case 'array':
				foreach ($this->view_body as $item) {
					$this->load->view($item, $this->data);
				}
			break;
		
			default:
				$this->load->view($this->view_body, $this->data);
		}
		
		if ($this->simple_page) {
			$this->load->view($this->view_footer_simple, $this->data);
		}
		else {
			$this->load->view($this->view_footer, $this->data);
		}
	}
}
