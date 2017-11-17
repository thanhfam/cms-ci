<!DOCTYPE html>

<html lang="">
<head>
	<meta charset="utf-8">
	<title><?=$title?></title>

	<link rel="stylesheet" href="<?=base_url(F_PUB .F_CP .'css/cp.css');?>" media="screen, projection" />

	<script src="<?=base_url(F_PUB .F_CP .'jquery/jquery-3.2.1.min.js');?>"></script>
	<script src="<?=base_url(F_PUB .F_CP .'uikit/js/uikit.min.js');?>"></script>
	<script src="<?=base_url(F_PUB .F_CP .'uikit/js/uikit-icons.min.js');?>"></script>

	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<body>
	<header class="uk-margin-small">
	<?php
		$this->load->view('cp/inc/nav_header');
	?>
	</header>

	<div class="uk-container uk-margin-small uk-background-default">
		<h3 class="uk-text-primary"><?=$title?></h3>