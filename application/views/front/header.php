<!DOCTYPE html>

<html lang="vi">
<head>
	<meta charset="utf-8">
	<title><?=$title?></title>

	<?php if (isset($meta)): ?>
	<meta name="description" content="<?=$meta['description']?>">
	<meta name="keywords" content="<?=$meta['keywords']?>">
	<?php endif; ?>

	<link rel="stylesheet" href="<?=base_url(F_PUB . F_FRONT .'css/front.css')?>" media="screen, projection" />
	<script src="<?=base_url(F_PUB . F_FRONT .'jquery/jquery-3.2.1.min.js')?>"></script>

	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<body>
	<div id="header" class="header">
		<div id="header-logo-bar">
			<div class="container">
				<div class="row align-items-center no-gutters">
					<div id="logo" class="col-auto mr-auto">
						<?php if ($site['avatar_filename']): ?>
						<a href="/"><img src="<?=base_url(F_FILE .$site['avatar_filename'])?>" class="header-logo img-fluid" /></a>
						<?php else: ?>
						<a href="/"><img src="<?=base_url(F_PUB .F_FRONT .'img/logo-vi.png')?>" class="header-logo img-fluid" /></a>
						<?php endif; ?>
					</div>

					<div class="logo-bar-item item-address-info col-auto d-none d-xl-block">
						<div class="header-details-box">
							<div class="header-details-icon header-address-icon">
								<i class="simple-icon icon-location-pin"></i>
							</div>
							<div class="header-details-info header-address">
								<strong>95 Nguyễn Đình Thi</strong>
								<span>Tây Hồ, Hà Nội</span>
							</div>
						</div>
						<div class="header-details-box">
							<div class="header-details-icon header-business-icon">
								<i class="simple-icon icon-clock"></i>
							</div>
							<div class="header-details-info header-business-hours">
								<strong>Thứ 2 - Thứ 6: 9:00 đến 19:00</strong>
								<span>Thứ 7 - Chủ Nhật: 9:00 đến 17:00</span>
							</div>
						</div>
						<div class="header-details-box">
							<div class="header-details-icon header-contact-icon">
								<i class="simple-icon icon-earphones-alt"></i>
							</div>
							<div class="header-details-info header-contact-details">
								<strong>(+84) 093 335 9733</strong>
								<span><a href="mailto:vietnam@tvngroup.vn">vietnam@tvngroup.vn</a></span>
							</div>
						</div>
					</div>

				</div>
			</div>

		</div>

		<div id="header-menu-bar">
			<div class="container">
				<div class="row align-items-center no-gutters">

					<div class="col-auto mr-auto">
					<ul id="header-nav" class="nav">
						<li class="nav-item">
							<a class="nav-link" href="">Trang chủ</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="">Dịch vụ</a>
						</li>
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">Bệnh viện</a>
							<div class="dropdown-menu">
								<a class="dropdown-item" href="#">Bệnh viện Thái Lan</a>
								<a class="dropdown-item" href="#">Bệnh viện Singapore</a>
								<a class="dropdown-item" href="#">Bệnh viện Hàn Quốc</a>
							</div>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="">Bệnh lý</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="">FAQs</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="">Đối tác</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="">Liên hệ</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="">Đặt lịch hẹn</a>
						</li>
					</ul>
					</div>

					<div class="col-auto d-none d-xl-block">
					<ul class="social-links">
						<li class="facebook"><a target="_blank" href="<?=$site['facebook']?>"><i class="fa fa-facebook"></i></a>
						</li>
						<li class="twitter"><a target="_blank" href="<?=$site['twitter']?>"><i class="fa fa-twitter"></i></a></li>
						<li class="pinterest"><a target="_blank" href="<?=$site['pinterest']?>"><i class="fa fa-pinterest"></i></a></li>
						<li class="google-plus"><a target="_blank" href="<?=$site['gplus']?>"><i class="fa fa-google-plus"></i></a></li>
						<li class="linkedin"><a target="_blank" href="<?=$site['linkedin']?>"><i class="fa fa-linkedin"></i></a></li>
					</ul>
					</div>

					<div class="col-auto d-none d-xl-block">
					<ul id="header-language-switcher" class="nav">
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">VI</a>
							<div class="dropdown-menu">
								<a class="dropdown-item" href="#">EN</a>
							</div>
						</li>
					</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
