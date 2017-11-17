<nav class="uk-navbar-container uk-margin-small uk-background-primary" uk-navbar>
	<div class="uk-navbar-left">
		<a class="uk-navbar-item uk-logo" href="#">
			<span class="uk-icon uk-margin-small-right" href="#" uk-icon="icon: star"></span>
			CMS
		</a>
		<ul class="uk-navbar-nav">
			<li>
				<a href="#">
					<?=$lang->line('content');?>
				</a>
				<div class="uk-navbar-dropdown">
					<ul class="uk-nav uk-navbar-dropdown-nav">
						<li><a href="<?=base_url('cp/category');?>"><?=$lang->line('category');?></a></li>
						<li><a href="<?=base_url('cp/post');?>"><?=$lang->line('post');?></a></li>
					</ul>
				</div>
			</li>
			<li>
				<a href="#">
					<?=$lang->line('admin');?>
				</a>
				<div class="uk-navbar-dropdown">
					<ul class="uk-nav uk-navbar-dropdown-nav">
						<li><a href="<?=base_url('cp/site');?>"><?=$lang->line('site');?></a></li>
						<li><a href="<?=base_url('cp/state');?>"><?=$lang->line('state');?></a></li>
						<li><a href="<?=base_url('cp/layout');?>"><?=$lang->line('layout');?></a></li>
						<li><a href="<?=base_url('cp/menu');?>"><?=$lang->line('menu');?></a></li>
						<li><a href="<?=base_url('cp/user_group');?>"><?=$lang->line('user_group');?></a></li>
						<li><a href="<?=base_url('cp/user');?>"><?=$lang->line('user');?></a></li>
					</ul>
				</div>
			</li>
		</ul>
	</div>

	<div class="uk-navbar-right">
		<ul class="uk-navbar-nav">
			<li>
				<a href="#"><?=$lang->line('user');?></a>
				<div class="uk-navbar-dropdown">
					<ul class="uk-nav uk-navbar-dropdown-nav">
						<li><a href="<?=base_url(F_CP .'user/logout');?>"><?=$lang->line('logout');?></a></li>
					</ul>
				</div>
			</li>
		</ul>
	</div>
</nav>
