<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model
{
	public function __construct() {
		parent::__construct();
	}

	public function get_time($timestamp = NULL ) {
		if (empty($timestamp)) {
			$timestamp = time();
		}
		else {
			$timestamp = strtotime($timestamp);
		}
		return date(DateTime::COOKIE, $timestamp);
	}
}