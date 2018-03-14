<?php
$CI =& get_instance();
?>

<nav class="uk-navbar-container uk-margin-small uk-background-primary" uk-navbar>
	<div class="uk-navbar-left">
		<a class="uk-navbar-item uk-logo" href="<?=base_url(F_CP)?>">
			<span class="uk-icon uk-margin-small-right" href="#" uk-icon="icon: star"></span>
			CMS
		</a>
		<ul class="uk-navbar-nav">
			<?php if ($CI->has_right(array('CATE_LIST', 'POST_LIST', 'MEDIA_LIST'))): ?>
			<li>
				<a href="#">
					<?=$lang->line('content')?>
				</a>
				<div class="uk-navbar-dropdown" uk-dropdown="offset: 1">
					<ul class="uk-nav uk-navbar-dropdown-nav">
						<?php if ($CI->has_right('CATE_LIST')): ?>
						<li><a href="<?=base_url(F_CP .'category')?>"><?=$lang->line('category')?></a></li>
						<?php endif; ?>
						<?php if ($CI->has_right('POST_LIST')): ?>
						<li><a href="<?=base_url(F_CP .'post')?>"><?=$lang->line('post')?></a></li>
						<?php endif; ?>
						<?php if ($CI->has_right('MEDIA_LIST')): ?>
						<li><a href="<?=base_url(F_CP .'media')?>"><?=$lang->line('media')?></a></li>
						<?php endif; ?>
					</ul>
				</div>
			</li>
			<?php endif; ?>
			<?php if ($CI->has_right(array('LIKE_LIST', 'COMMENT_LIST'))): ?>
			<li>
				<a href="#">
					<?=$lang->line('social')?>
				</a>
				<div class="uk-navbar-dropdown" uk-dropdown="offset: 1">
					<ul class="uk-nav uk-navbar-dropdown-nav">
						<?php if ($CI->has_right('COMMENT_LIST')): ?>
						<li class="uk-nav-header"><?=$lang->line('comment')?></li>
						<li><a href="<?=base_url(F_CP .'comment/post')?>"><?=$lang->line('post')?></a></li>
						<li><a href="<?=base_url(F_CP .'comment/comment')?>"><?=$lang->line('comment')?></a></li>
						<?php endif; ?>
						<?php if ($CI->has_right('LIKE_LIST')): ?>
						<li class="uk-nav-divider"></li>
						<li class="uk-nav-header"><?=$lang->line('like')?></li>
						<li><a href="<?=base_url(F_CP .'like/post')?>"><?=$lang->line('post')?></a></li>
						<li><a href="<?=base_url(F_CP .'like/comment')?>"><?=$lang->line('comment')?></a></li>
						<?php endif; ?>
					</ul>
				</div>
			</li>
			<?php endif; ?>
			<?php if ($CI->has_right(array('APPOINTMENT_LIST'))): ?>
			<li>
				<a href="#">
					<?=$lang->line('tvn')?>
				</a>
				<div class="uk-navbar-dropdown" uk-dropdown="offset: 1">
					<ul class="uk-nav uk-navbar-dropdown-nav">
						<?php if ($CI->has_right(array('APPOINTMENT_LIST', 'TREATMENT_LIST'))): ?>
						<li><a href="<?=base_url(F_CP .'appointment')?>"><?=$lang->line('appointment')?></a></li>
						<li><a href="<?=base_url(F_CP .'treatment')?>"><?=$lang->line('treatment')?></a></li>
						<?php endif; ?>
						<?php if ($CI->has_right('CONTACT_LIST')): ?>
						<li class="uk-nav-divider"></li>
						<li><a href="<?=base_url(F_CP .'contact/list?group=customer')?>"><?=$lang->line('customer')?></a></li>
						<li><a href="<?=base_url(F_CP .'contact/list?group=agency')?>"><?=$lang->line('agency')?></a></li>
						<li><a href="<?=base_url(F_CP .'contact/list?group=staff')?>"><?=$lang->line('staff')?></a></li>
						<?php endif; ?>
						<?php if ($CI->has_right('ENUM_LIST')): ?>
						<li class="uk-nav-divider"></li>
						<li><a href="<?=base_url(F_CP .'enum/list?type=tvn_service')?>"><?=$lang->line('service')?></a></li>
						<li><a href="<?=base_url(F_CP .'enum/list?type=hospital')?>"><?=$lang->line('hospital')?></a></li>
						<?php endif; ?>
					</ul>
				</div>
			</li>
			<?php endif; ?>
			<?php if ($CI->has_right(array('SITE_LIST', 'STATE_LIST', 'LAYOUT_LIST', 'MENU_LIST', 'USER_GROUP_LIST', 'USER_LIST', 'RIGHT_LIST'))): ?>
			<li>
				<a href="#">
					<?=$lang->line('system')?>
				</a>
				<div class="uk-navbar-dropdown" uk-dropdown="offset: 1">
					<ul class="uk-nav uk-navbar-dropdown-nav">
						<?php if ($CI->has_right('ENUM_LIST')): ?>
						<li><a href="<?=base_url(F_CP .'enum')?>"><?=$lang->line('enum')?></a></li>
						<?php endif; ?>
						<?php if ($CI->has_right('MENU_LIST')): ?>
						<li><a href="<?=base_url(F_CP .'menu')?>"><?=$lang->line('menu')?></a></li>
						<?php endif; ?>
						<?php if ($CI->has_right('SITE_LIST')): ?>
						<li><a href="<?=base_url(F_CP .'site')?>"><?=$lang->line('site')?></a></li>
						<?php endif; ?>
						<?php if ($CI->has_right('LAYOUT_LIST')): ?>
						<li class="uk-nav-divider"></li>
						<li><a href="<?=base_url(F_CP .'layout')?>"><?=$lang->line('layout')?></a></li>
						<?php endif; ?>
						<?php if ($CI->has_right('VIEW_LIST')): ?>
						<li><a href="<?=base_url(F_CP .'view')?>"><?=$lang->line('view')?></a></li>
						<?php endif; ?>
						<?php if ($CI->has_right('STATE_LIST')): ?>
						<li><a href="<?=base_url(F_CP .'state')?>"><?=$lang->line('state')?></a></li>
						<?php endif; ?>
						<?php if ($CI->has_right('USER_GROUP_LIST')): ?>
						<li class="uk-nav-divider"></li>
						<li><a href="<?=base_url(F_CP .'user_group')?>"><?=$lang->line('user_group')?></a></li>
						<?php endif; ?>
						<?php if ($CI->has_right('USER_LIST')): ?>
						<li><a href="<?=base_url(F_CP .'user')?>"><?=$lang->line('user')?></a></li>
						<?php endif; ?>
						<?php if ($CI->has_right('RIGHT_LIST')): ?>
						<li><a href="<?=base_url(F_CP .'right')?>"><?=$lang->line('right')?></a></li>
						<?php endif; ?>
					</ul>
				</div>
			</li>
			<?php endif; ?>
		</ul>
	</div>

	<div class="uk-navbar-right">
		<ul class="uk-navbar-nav uk-background-secondary">
			<li>
				<a href="#"><span uk-icon="icon: user"></span>&nbsp;<?=$user['name']?></a>
				<div class="uk-navbar-dropdown" uk-dropdown="offset: 1">
					<ul class="uk-nav uk-navbar-dropdown-nav">
						<li><a href="<?=base_url(F_CP .'user/edit_profile')?>"><?=$lang->line('profile')?></a></li>
						<li><a href="<?=base_url(F_CP .'user/change_password')?>"><?=$lang->line('change_password')?></a></li>
						<li class="uk-nav-divider"></li>
						<li><a href="<?=base_url(F_CP .'user/logout')?>"><?=$lang->line('logout')?></a></li>
					</ul>
				</div>
			</li>
		</ul>
	</div>
</nav>
