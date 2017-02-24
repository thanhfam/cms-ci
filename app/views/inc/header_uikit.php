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
		<nav class="uk-navbar-container uk-margin uk-background-primary" uk-navbar>
			<div class="uk-navbar-left">
				<a class="uk-navbar-item uk-logo" href="#">
					<span class="uk-icon uk-margin-small-right" href="#" uk-icon="icon: star"></span>
					CMS
				</a>
				<ul class="uk-navbar-nav">
					<li>
						<a href="#">
							<?=$lang->line('area');?>
						</a>
						<div class="uk-navbar-dropdown">
							<ul class="uk-nav uk-navbar-dropdown-nav">
								<li><a href="#">Active</a></li>
								<li><a href="#">Item</a></li>
								<li><a href="#">Item</a></li>
							</ul>
						</div>
					</li>
				</ul>
			</div>
		</nav>
	</header>

	<div class="uk-container uk-margin">
		<h1 class="uk-heading-bullet"><?=$title?></h2>