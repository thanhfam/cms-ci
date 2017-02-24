<?php

defined('BASEPATH') OR exit('No direct script access allowed');

$config = array(
	array(
		'field' => 'id',
		'label' => 'lang:id',
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
	),
	array(
		'field' => 'nation_id',
		'label' => 'lang:nation',
		'rules' => 'required'
	)
);

$config['error_prefix'] = '<div class="input-field-invalid">';
$config['error_suffix'] = '</div>';
