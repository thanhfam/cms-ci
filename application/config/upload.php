<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config = array(
	'upload_path' => 'file',
	'allowed_types' => 'gif|jpg|png',
	'encrypt_name' => TRUE,
	'file_ext_tolower' => TRUE,
	'max_size' => 1024, // 1024 KB
	'max_width' => 0,
	'max_height' => 0
);
