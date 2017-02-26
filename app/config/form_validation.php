<?php

defined('BASEPATH') OR exit('No direct script access allowed');

$config = array(
	'ward_edit' => array(
		array(
			'field' => 'code',
			'label' => 'lang:code',
			'rules' => 'required'
		),
		array(
			'field' => 'title',
			'label' => 'lang:title',
			'rules' => 'required'
		),
		array(
			'field' => 'type',
			'label' => 'lang:type',
			'rules' => 'required'
		),
		array(
			'field' => 'district_id',
			'label' => 'lang:district',
			'rules' => 'required'
		),
		array(
			'field' => 'city_id',
			'label' => 'lang:city',
			'rules' => 'required'
		)
	),
	'district_edit' => array(
		array(
			'field' => 'code',
			'label' => 'lang:code',
			'rules' => 'required'
		),
		array(
			'field' => 'title',
			'label' => 'lang:title',
			'rules' => 'required'
		),
		array(
			'field' => 'type',
			'label' => 'lang:type',
			'rules' => 'required'
		),
		array(
			'field' => 'city_id',
			'label' => 'lang:city',
			'rules' => 'required'
		)
	),
	'city_edit' => array(
		array(
			'field' => 'code',
			'label' => 'lang:code',
			'rules' => 'required'
		),
		array(
			'field' => 'title',
			'label' => 'lang:title',
			'rules' => 'required'
		),
		array(
			'field' => 'type',
			'label' => 'lang:type',
			'rules' => 'required'
		),
		array(
			'field' => 'nation_id',
			'label' => 'lang:nation',
			'rules' => 'required'
		)
	)
);

$config['error_prefix'] = '<div class="input-field-invalid">';
$config['error_suffix'] = '</div>';
