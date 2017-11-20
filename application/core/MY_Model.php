<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model
{
	public function __construct() {
		parent::__construct();
	}

	function to_utf8( $string ) { 
	// From http://w3.org/International/questions/qa-forms-utf-8.html 
		if (preg_match('%^(?: 
		  [\x09\x0A\x0D\x20-\x7E]            # ASCII 
		| [\xC2-\xDF][\x80-\xBF]             # non-overlong 2-byte 
		| \xE0[\xA0-\xBF][\x80-\xBF]         # excluding overlongs 
		| [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}  # straight 3-byte 
		| \xED[\x80-\x9F][\x80-\xBF]         # excluding surrogates 
		| \xF0[\x90-\xBF][\x80-\xBF]{2}      # planes 1-3 
		| [\xF1-\xF3][\x80-\xBF]{3}          # planes 4-15 
		| \xF4[\x80-\x8F][\x80-\xBF]{2}      # plane 16 
	)*$%xs', $string)) {
			return $string; 
		}
		else {
			return iconv( 'CP1252', 'UTF-8', $string); 
		}
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