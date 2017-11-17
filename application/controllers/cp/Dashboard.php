<?php

class Dashboard extends MY_Controller {
	public function __construct() {
		parent::__construct();

		$this->load->helper('language');
	}

	public function index($id = '') {
		$data = array(
			'lang' => $this->lang,
			'title' => $this->lang->line('dashboard')
		);

		$this->set_body(
			'inc/dashboard'
		);

		$this->render($data);
	}
}
