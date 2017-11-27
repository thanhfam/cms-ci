<?php

if ( ! function_exists('date_format_menu')) {

	function date_format_menu($default = '%d/%m/%Y %H:%i', $class = '', $name = 'date_format', $attributes = '', $timezone = 'UP7') {
		$CI =& get_instance();
		$CI->lang->load('date');

		$menu = '<select name="'.$name.'"';

		if ($class !== '') {
			$menu .= ' class="'.$class.'"';
		}

		$menu .= _stringify_attributes($attributes).">\n";

		foreach (date_formats() as $val) {
			$selected = ($default === $val) ? ' selected="selected"' : '';
			$menu .= '<option value="'.$val.'"'.$selected.'>'.mdate($val, now())."</option>\n";
		}

		return $menu.'</select>';
	}
}

if ( ! function_exists('date_formats')) {
	function date_formats() {
		$formats = array(
			'%d/%m/%Y %h:%i %a',
			'%d/%m/%Y %h:%i %A',
			'%d/%m/%Y %H:%i',
			'%d-%m-%Y %h:%i %a',
			'%d-%m-%Y %h:%i %A',
			'%d-%m-%Y %H:%i'
		);

		return $formats;
	}
}

if ( ! function_exists('get_date_format')) {
	function get_date_format() {
		$CI = & get_instance();

		if (isset($CI->session)) {
			$date_format = $CI->session->date_format;
		}
		
		if (!isset($date_format) || empty($date_format)) {
			$date_format = config_item('date_format');
		}

		return $date_format;
	}
}

if ( ! function_exists('get_timezone')) {
	function get_timezone() {
		$CI = & get_instance();

		if (isset($CI->session)) {
			$timezone = $CI->session->timezone;
		}

		if (!isset($timezone) || empty($timezone)) {
			$timezone = config_item('timezone');
		}

		return $timezone;
	}
}

if ( ! function_exists('get_time')) {
	function get_time() {
		return local_to_gmt(now());
	}
}

if ( ! function_exists('date_string')) {
	function date_string($ts = '') {
		$CI = & get_instance();

		$df = get_date_format();
		$tz = get_timezone();

		if ($ts == '') {
			$ts = get_time();
		}

		return mdate($df, gmt_to_local($ts, $tz));
	}
}
