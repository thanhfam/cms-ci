<div id="header-menu-bar">
	<div class="container">
		<div class="row align-items-center no-gutters">

			<div class="col-auto mr-auto">
				<nav class="navbar navbar-expand-lg navbar-light">
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#header-nav">
					<span class="navbar-toggler-icon"></span>
				</button>

				<div class="collapse navbar-collapse" id="header-nav">
					<ul class="navbar-nav mr-auto">
						<?php
						if (isset($menu_tree)):
						foreach ($menu_tree[''] as $item):
						?>

						<?php
							if (isset($menu_tree[$item['title']])):
						?>
						<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);"><?=$item['title']?></a>
						<div class="dropdown-menu">
							<?php
							foreach ($menu_tree[$item['title']] as $item):
							?>
							<a class="dropdown-item" href="<?=$item['url']?>"><?=$item['title']?></a>
							<?php
							endforeach;
							?>
						</div>
						</li>
						<?php
							else:
						?>
						<li class="nav-item">
						<a class="nav-link" href="<?=$item['url']?>"><?=$item['title']?></a>
						</li>
						<?php
							endif;
						?>

						<?php
						endforeach;
						endif;
						?>
					</ul>
				</div>
				</nav>
			</div>

			<div class="col-auto">
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