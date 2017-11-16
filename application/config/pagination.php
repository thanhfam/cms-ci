<?php

defined('BASEPATH') OR exit('No direct script access allowed');

$CI =& get_instance();

$config = array(
	// uikit - begin
	'full_tag_open' => '<ul class="uk-pagination">',
	'full_tag_close' => '</ul>',

	'first_link' => '&laquo; ' . $CI->lang->line('first'),
	'first_tag_open' => '<li>',
	'first_tag_close' => '</li>',

	'last_link' => $CI->lang->line('last') . ' &raquo;',
	'last_tag_open' => '<li>',
	'last_tag_close' => '</li>',

	'prev_link' => '&lsaquo; ' . $CI->lang->line('prev'),
	'prev_tag_open' => '<li>',
	'prev_tag_close' => '</li>',

	'next_link' => $CI->lang->line('next') . ' &rsaquo;',
	'next_tag_open' => '<li>',
	'next_tag_close' => '</li>',

	'cur_tag_open' => '<li class="uk-active"><span>',
	'cur_tag_close' => '</span></li>',

	'num_tag_open' => '<li>',
	'num_tag_close' => '</li>',
	// uikit

	/* materialize - begin
	'full_tag_open' => '<ul class="pagination">',
	'full_tag_close' => '</ul>',

	'first_link' => '&laquo; ' . $CI->lang->line('first'),
	'first_tag_open' => '<li class="waves-effect">',
	'first_tag_close' => '</li>',

	'last_link' => $CI->lang->line('last') . ' &raquo;',
	'last_tag_open' => '<li class="waves-effect">',
	'last_tag_close' => '</li>',

	'prev_link' => '&lsaquo; ' . $CI->lang->line('prev'),
	'prev_tag_open' => '<li class="waves-effect">',
	'prev_tag_close' => '</li>',

	'next_link' => $CI->lang->line('next') . ' &rsaquo;',
	'next_tag_open' => '<li class="waves-effect">',
	'next_tag_close' => '</li>',

	'cur_tag_open' => '<li class="active"><a>',
	'cur_tag_close' => '</a></li>',

	'num_tag_open' => '<li class="waves-effect">',
	'num_tag_close' => '</li>',
	// materialize - end */

	'uri_segment' => 3,
	'display_pages' => TRUE,
	'num_links' => 2,
	'use_page_numbers' => TRUE,
	'per_page' => 15,
	'reuse_query_string' => TRUE,
	'page_query_string' => TRUE,
	'query_string_segment' => 'page'
);