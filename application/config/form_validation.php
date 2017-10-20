<?php

defined('BASEPATH') OR exit('No direct script access allowed');

$config = array(
	'user_edit' => array(
		array(
			'field' => 'username',
			'label' => 'lang:username',
			'rules' => 'trim|required|max_length[255]'
		),
		array(
			'field' => 'email',
			'label' => 'lang:email',
			'rules' => 'trim|required|valid_email|max_length[255]'
		)
	),
	'user_login' => array(
		array(
			'field' => 'username',
			'label' => 'lang:username',
			'rules' => 'trim|required|max_length[255]'
		),
		array(
			'field' => 'password',
			'label' => 'lang:password',
			'rules' => 'trim|required|max_length[255]'
		)
	),
	'user_change_password' => array(
		array(
			'field' => 'password',
			'label' => 'lang:password',
			'rules' => 'trim|required|max_length[255]'
		),
		array(
			'field' => 'password_confirm',
			'label' => 'lang:password_confirm',
			'rules' => 'trim|required|max_length[255]|matches[password]'
		),
		array(
			'field' => 'password_new',
			'label' => 'lang:password_new',
			'rules' => 'trim|required|min_length[8]|max_length[255]'
		)
	),
	'ward_edit' => array(
		array(
			'field' => 'code',
			'label' => 'lang:code',
			'rules' => 'trim|required|max_length[255]'
		),
		array(
			'field' => 'title',
			'label' => 'lang:title',
			'rules' => 'trim|required|max_length[255]'
		),
		array(
			'field' => 'type',
			'label' => 'lang:type',
			'rules' => 'trim|required|max_length[255]'
		),
		array(
			'field' => 'district_id',
			'label' => 'lang:district',
			'rules' => 'trim|required|max_length[255]'
		),
		array(
			'field' => 'city_id',
			'label' => 'lang:city',
			'rules' => 'trim|required|max_length[255]'
		)
	),
	'district_edit' => array(
		array(
			'field' => 'code',
			'label' => 'lang:code',
			'rules' => 'trim|required|max_length[255]'
		),
		array(
			'field' => 'title',
			'label' => 'lang:title',
			'rules' => 'trim|required|max_length[255]'
		),
		array(
			'field' => 'type',
			'label' => 'lang:type',
			'rules' => 'trim|required|max_length[255]'
		),
		array(
			'field' => 'city_id',
			'label' => 'lang:city',
			'rules' => 'trim|required|max_length[255]'
		)
	),
	'city_edit' => array(
		array(
			'field' => 'code',
			'label' => 'lang:code',
			'rules' => 'trim|required|max_length[255]'
		),
		array(
			'field' => 'title',
			'label' => 'lang:title',
			'rules' => 'trim|required|max_length[255]'
		),
		array(
			'field' => 'type',
			'label' => 'lang:type',
			'rules' => 'trim|required|max_length[255]'
		),
		array(
			'field' => 'nation_id',
			'label' => 'lang:nation',
			'rules' => 'trim|required|max_length[255]'
		)
	)
);

$config['error_prefix'] = '<div class="input-field-invalid">';
$config['error_suffix'] = '</div>';
