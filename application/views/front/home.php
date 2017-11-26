<script src="<?=base_url(F_PUB .F_FRONT .'slick/slick.min.js')?>"></script>

<div class="container">
<div id="carousel-top">
	<?php foreach ($list_top as $row): ?>
	<div class="carousel-item">
		<div class="card card-inverse">
			<?php if ($row['avatar_filename']): ?>
			<img class="card-img img-fluid" src="<?=base_url(F_FILE .$row['avatar_filename'])?>">
			<?php endif; ?>
			<div class="card-img-overlay">
				<h4 class="card-title"><a href="<?=$row['uri']?>"><?=$row['title']?></a></h4>
				<p class="card-text"><?=$row['lead']?></p>
			</div>
		</div>
	</div>
	<?php endforeach; ?>
</div>
</div>

<!-- Service - BEGIN -->
<div id="service-list" class="service-list">
	<div class="container">
	<div class="row no-gutters">
		<?php foreach ($list_service as $row): ?>
		<div class="col-sm-12 col-md-6 col-lg-3 bg-service">
			<div class="card">
				<i class="fa <?=$row['subtitle']?>"></i>
				<h5 class="card-title"><a href="<?=$row['uri']?>"><?=$row['title']?></a></h5>
				<p class="card-text"><?=$row['lead']?></p>
			</div>
		</div>
		<?php endforeach; ?>
	</div>
	</div>
</div>
<!-- Service - END -->

<!-- Hospitl - BEGIN -->
<div id="hospital-list" class="hospital-list">
	<div class="container">
		<div id="carousel-hospital" class="row no-gutters">
			<?php foreach ($list_hospital as $row): ?>
			<div class="col-sm-12 col-md-3">
				<div class="card">
					<?php if ($row['avatar_filename']): ?>
					<img class="card-img-top img-fluid" src="<?=base_url(F_FILE .$row['avatar_filename'])?>">
					<?php endif; ?>
					<h5 class="card-title"><a href="<?=$row['uri']?>"><?=$row['title']?></a></h5>
					<p class="card-text"><?=$row['lead']?></p>
				</div>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>
<!-- Hospital - END -->

<!-- About - BEGIN -->
<div id="about" class="about">
	<div class="about-bg">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-lg-6">
				<?php if ($list_about[0] && $list_about[0]['avatar_filename']): ?>
				<div class="card">
					<img class="card-img img-fluid" src="<?=base_url(F_FILE .$list_about[0]['avatar_filename'])?>">
				</div>
				<?php endif; ?>
			</div>
			<div class="col-sm-12 col-lg-6">
				<div class="card">
					<?php foreach ($list_about as $row): ?>
					<h5 class="card-title"><a href="<?=$row['uri']?>"><?=$row['title']?></a></h5>
					<p class="card-text"><?=$row['lead']?></p>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
	</div>
</div>
<!-- About - END -->

<!-- News & Sick - BEGIN -->
<div id="news-sick" class="news-sick">
	<div class="container">
		<div class="row align-items-start">
			<div id="news" class="news col-sm-12 col-lg-6">
				<div class="section-title"><h2><a href="<?=base_url('/tin-tuc')?>">Tin tức</a></h2></div>
				<div class="row align-items-start">
				<?php foreach ($list_news as $row): ?>
				<div class="col-sm-12 col-lg-6">
					<div class="card">
					<?php if ($row['avatar_filename']): ?>
					<img class="card-img-top img-fluid" src="<?=base_url(F_FILE .$row['avatar_filename'])?>">
					<?php endif; ?>
					<div class="card-body">
						<h4 class="card-title"><a href="<?=$row['uri']?>"><?=$row['title']?></a></h4>
						<p class="card-date"><?=$row['updated']?></p>
						<p class="card-text"><?=$row['lead']?></p>
						<a class="card-link" href="<?=$row['uri']?>">Xem chi tiết</a>
					</div>
					</div>
				</div>
				<?php endforeach; ?>
				</div>
			</div>
			<div id="sick" class="sick col-sm-12 col-lg-6">
				<div class="section-title"><h2><a href="<?=base_url('/benh-ly')?>">Bệnh lý</a></h2></div>
				<div class="row align-items-start">
					<?php foreach ($list_sick as $row): ?>
					<div class="col-sm-6 col-lg-4">
						<div class="card">
							<?php if ($row['avatar_filename']): ?>
							<img class="card-img img-fluid" src="<?=base_url(F_FILE .$row['avatar_filename'])?>">
							<?php endif; ?>
							<h4 class="card-title"><a href="<?=$row['uri']?>"><?=$row['title']?></a></h4>
						</div>
					</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- News & Sick - END -->

<!-- Partner - BEGIN -->
<div id="partner-list" class="partner-list">
	<div class="container">
		<div id="carousel-partner" class="row no-gutters">
			<div class="col-sm-6 col-md-2">
				<img class="header-logo img-fluid" src="<?=base_url(F_PUB .F_FRONT .'img/client-1.png')?>">
			</div>
			<div class="col-sm-6 col-md-2">
				<img class="header-logo img-fluid" src="<?=base_url(F_PUB .F_FRONT .'img/client-2.png')?>">
			</div>
			<div class="col-sm-6 col-md-2">
				<img class="header-logo img-fluid" src="<?=base_url(F_PUB .F_FRONT .'img/client-3.png')?>">
			</div>
			<div class="col-sm-6 col-md-2">
				<img class="header-logo img-fluid" src="<?=base_url(F_PUB .F_FRONT .'img/client-6.png')?>">
			</div>
			<div class="col-sm-6 col-md-2">
				<img class="header-logo img-fluid" src="<?=base_url(F_PUB .F_FRONT .'img/client-7.png')?>">
			</div>
			<div class="col-sm-6 col-md-2">
				<img class="header-logo img-fluid" src="<?=base_url(F_PUB .F_FRONT .'img/client-8.png')?>">
			</div>
			<div class="col-sm-6 col-md-2">
				<img class="header-logo img-fluid" src="<?=base_url(F_PUB .F_FRONT .'img/client-3.png')?>">
			</div>
			<div class="col-sm-6 col-md-2">
				<img class="header-logo img-fluid" src="<?=base_url(F_PUB .F_FRONT .'img/client-6.png')?>">
			</div>
		</div>
	</div>
</div>
<!-- Partner - END -->

<script>
$(document).ready(function() {

	$('#carousel-top').slick({
		infinite: true,
		slidesToShow: 1,
		slidesToScroll: 1,
		adaptiveHeight: true,
		autoplay: true,
		autoplaySpeed: 8000,
		fade: true,
		cssEase: 'linear'
	});

	$('#carousel-hospital').slick({
		infinite: true,
		slidesToShow: 4,
		slidesToScroll: 4,
		adaptiveHeight: true,
		responsive: [{
			breakpoint: 768,
			settings: {
				slidesToShow: 2,
				slidesToScroll: 2
			}
		}, {
			breakpoint: 576,
			settings: {
				slidesToShow: 1,
				slidesToScroll: 1
			}
		}]
	});

	$('#carousel-partner').slick({
		infinite: true,
		slidesToShow: 6,
		slidesToScroll: 1,
		adaptiveHeight: true,
		autoplay: true,
		autoplaySpeed: 2000,
		arrows: false,
		responsive: [{
			breakpoint: 992,
			settings: {
				slidesToShow: 4
			}
		}, {
			breakpoint: 576,
			settings: {
				slidesToShow: 2
			}
		}]
	});
});
</script>