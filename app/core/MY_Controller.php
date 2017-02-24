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
	protected $header = 'inc/header';
	protected $footer = 'inc/footer';

	public function __construct() {
		parent::__construct();
	}

	public function set_header($header) {
		$this->header = $header;
	}

	public function set_body($body) {
		$this->body = $body;
	}

	public function set_footer($footer) {
		$this->footer = $footer;
	}

	public function render($data) {
		$this->load->view($this->header, $data);

		switch (gettype($this->body)) {
			case 'array':
				foreach ($this->body as $item) {
					$this->load->view($item, $data);
				}
			break;
		
			default:
				$this->load->view($this->body, $data);
		}
		
		$this->load->view($this->footer, $data);
	}
}

/* End of file MY_Controller.php */
/* Location: /community_auth/core/MY_Controller.php */