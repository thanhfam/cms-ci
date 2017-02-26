<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Community Auth - MY Controller
 *
 * Community Auth is an open source authentication application for CodeIgniter 3
 *
 * @package     Community Auth
 * @author      Robert B Gottier
 * @copyright   Copyright (c) 2011 - 2017, Robert B Gottier. (http://brianswebdesign.com/)
 * @license     BSD - http://www.opensource.org/licenses/BSD-3-Clause
 * @link        http://community-auth.com
 */

require_once APPPATH . 'third_party/community_auth/core/Auth_Controller.php';

class MY_Controller extends Auth_Controller {
	protected $view_header = 'inc/header';
	protected $view_footer = 'inc/footer';
	protected $view_nav = 'inc/nav';
	protected $view_message = 'inc/message';

	protected $message;

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

	public function set_message($message) {
		switch($message['type']) {
			case 0: // primary
				$message['cls'] = 'uk-alert-primary';
				$message['title'] = $this->lang->line('message');
			break;

			case 1: // success
				$message['cls'] = 'uk-alert-success';
				$message['title'] = $this->lang->line('success');
			break;

			case 2: // warning
				$message['cls'] = 'uk-alert-warning';
				$message['title'] = $this->lang->line('warning');
			break;

			case 3: // danger
				$message['cls'] = 'uk-alert-danger';
				$message['title'] = $this->lang->line('danger');
			break;
		}

		$this->message = $message;
	}

	public function render($data) {
		$this->load->view($this->view_header, $data);

		if (isset($this->message)) {
			$this->load->view($this->view_message, $this->message);
		}

		switch (gettype($this->view_body)) {
			case 'array':
				foreach ($this->view_body as $item) {
					$this->load->view($item, $data);
				}
			break;
		
			default:
				$this->load->view($this->view_body, $data);
		}
		
		$this->load->view($this->view_footer, $data);
	}
}

/* End of file MY_Controller.php */
/* Location: /community_auth/core/MY_Controller.php */