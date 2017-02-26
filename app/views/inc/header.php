<!DOCTYPE html>

<html lang="">
<head>
	<meta charset="utf-8">
	<title><?=$title?></title>

	<link rel="stylesheet" href="<?=base_url('pub/css/cp.css');?>" media="screen, projection" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<body>
	<header class="uk-margin">
	<?php
		$this->load->view('inc/nav_header');
	?>
	</header>

	<div class="uk-container uk-margin">
		<h1 class="uk-heading-bullet"><?=$title?></h2>