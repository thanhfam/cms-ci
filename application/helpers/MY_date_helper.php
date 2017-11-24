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

// ------------------------------------------------------------------------

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