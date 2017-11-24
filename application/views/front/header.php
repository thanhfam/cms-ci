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

		<?php $this->load->view('front/nav'); ?>
	</div>
