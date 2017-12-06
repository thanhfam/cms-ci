<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config = array(
	'upload_path' => F_FILE,
	'allowed_types' => implode('|', array(MT_IMAGE_EXT, MT_VIDEO_EXT, MT_AUDIO_EXT, MT_FLASH_EXT, MT_ATTACH_EXT)),
	'encrypt_name' => TRUE,
	'file_ext_tolower' => TRUE,
	'max_size' => 204800, // KB
	'max_width' => 0,
	'max_height' => 0,
	'remove_spaces' => FALSE
);
