<?php

defined('BASEPATH') OR exit('No direct script access allowed');

$config = array(
	'user_login' => array(
		array(
			'field' => 'username',
			'label' => 'lang:username',
			'rules' => 'trim|required|min_length[3]|max_length[30]'
		),
		array(
			'field' => 'password',
			'label' => 'lang:password',
			'rules' => 'trim|required|min_length[8]|max_length[255]'
		)
	),
	'user_change_password' => array(
		array(
			'field' => 'password',
			'label' => 'lang:password',
			'rules' => 'trim|required|max_length[255]'
		),
		array(
			'field' => 'password_new',
			'label' => 'lang:password_new',
			'rules' => 'trim|required|min_length[8]|max_length[255]'
		),
		array(
			'field' => 'password_new_confirm',
			'label' => 'lang:password_new_confirm',
			'rules' => 'trim|required|max_length[255]|matches[password_new]'
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
	),
	'site_edit' => array(
		array(
			'field' => 'name',
			'label' => 'lang:name',
			'rules' => 'trim|max_length[255]'
		),
		array(
			'field' => 'title',
			'label' => 'lang:title',
			'rules' => 'trim|required|max_length[255]'
		),
		array(
			'field' => 'type',
			'label' => 'lang:type',
			'rules' => 'trim|max_length[255]'
		)
	),
	'category_edit' => array(
		array(
			'field' => 'name',
			'label' => 'lang:name',
			'rules' => 'trim|max_length[255]'
		),
		array(
			'field' => 'uri',
			'label' => 'lang:uri',
			'rules' => 'trim|max_length[255]'
		),
		array(
			'field' => 'title',
			'label' => 'lang:title',
			'rules' => 'trim|required|max_length[255]'
		),
		array(
			'field' => 'subtitle',
			'label' => 'lang:subtitle',
			'rules' => 'trim|max_length[255]'
		),
		array(
			'field' => 'lead',
			'label' => 'lang:lead',
			'rules' => 'trim'
		),
		array(
			'field' => 'content',
			'label' => 'lang:content',
			'rules' => 'trim'
		)
	),
	'menu_edit' => array(
		array(
			'field' => 'name',
			'label' => 'lang:name',
			'rules' => 'trim|required|max_length[255]'
		),
		array(
			'field' => 'site_id',
			'label' => 'lang:site',
			'rules' => 'trim|required|integer'
		)
	),
	'right_edit' => array(
		array(
			'field' => 'name',
			'label' => 'lang:name',
			'rules' => 'trim|required|max_length[255]'
		)
	),
	'layout_edit' => array(
		array(
			'field' => 'name',
			'label' => 'lang:name',
			'rules' => 'trim|required|max_length[255]'
		),
		array(
			'field' => 'site_id',
			'label' => 'lang:site',
			'rules' => 'trim|required|integer'
		)
	),
	'menu_item_edit' => array(
		array(
			'field' => 'title',
			'label' => 'lang:name',
			'rules' => 'trim|required|max_length[255]'
		),
		array(
			'field' => 'url',
			'label' => 'lang:url',
			'rules' => 'trim|required|max_length[255]'
		),
		array(
			'field' => 'target',
			'label' => 'lang:target',
			'rules' => 'trim|max_length[255]'
		),
		array(
			'field' => 'menu_id',
			'label' => 'lang:menu',
			'rules' => 'trim|required|integer'
		),
		array(
			'field' => 'position',
			'label' => 'lang:position',
			'rules' => 'trim|required|integer'
		)
	),
	'post_edit' => array(
		array(
			'field' => 'name',
			'label' => 'lang:name',
			'rules' => 'trim|max_length[255]'
		),
		array(
			'field' => 'uri',
			'label' => 'lang:uri',
			'rules' => 'trim|max_length[255]'
		),
		array(
			'field' => 'title',
			'label' => 'lang:title',
			'rules' => 'trim|required|max_length[255]'
		),
		array(
			'field' => 'subtitle',
			'label' => 'lang:subtitle',
			'rules' => 'trim|max_length[255]'
		),
		array(
			'field' => 'lead',
			'label' => 'lang:lead',
			'rules' => 'trim'
		),
		array(
			'field' => 'content',
			'label' => 'lang:content',
			'rules' => 'trim'
		)
	),
	'state_edit' => array(
		array(
			'field' => 'weight',
			'label' => 'lang:weight',
			'rules' => 'trim|required|integer'
		),
		array(
			'field' => 'name',
			'label' => 'lang:name',
			'rules' => 'trim|required|max_length[255]'
		)
	),
	'user_group_edit' => array(
		array(
			'field' => 'title',
			'label' => 'lang:title',
			'rules' => 'trim|required|max_length[255]'
		),
		array(
			'field' => 'name',
			'label' => 'lang:name',
			'rules' => 'trim|max_length[255]'
		)
	),
	'user_edit' => array(
		array(
			'field' => 'username',
			'label' => 'lang:username',
			'rules' => 'trim|required|min_length[3]|max_length[30]'
		),
		array(
			'field' => 'name',
			'label' => 'lang:name',
			'rules' => 'trim|required|max_length[255]'
		),
		array(
			'field' => 'email',
			'label' => 'lang:email',
			'rules' => 'trim|required|valid_email|max_length[255]'
		)
	),
	'image_upload' => array(
		array(
			'field' => 'name',
			'label' => 'lang:name',
			'rules' => 'trim|max_length[255]'
		),
		array(
			'field' => 'content',
			'label' => 'lang:content',
			'rules' => 'trim'
		)
	)
);

$config['error_prefix'] = '<div class="input-field-invalid">';
$config['error_suffix'] = '</div>';
