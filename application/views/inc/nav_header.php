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
						<li><a href="<?=base_url('category');?>"><?=$lang->line('category');?></a></li>
						<li><a href="<?=base_url('post');?>"><?=$lang->line('post');?></a></li>
					</ul>
				</div>
			</li>
			<li>
				<a href="#">
					<?=$lang->line('area');?>
				</a>
				<div class="uk-navbar-dropdown">
					<ul class="uk-nav uk-navbar-dropdown-nav">
						<li><a href="<?=base_url('city');?>"><?=$lang->line('city');?></a></li>
						<li><a href="<?=base_url('district');?>"><?=$lang->line('district');?></a></li>
						<li><a href="<?=base_url('ward');?>"><?=$lang->line('ward');?></a></li>
					</ul>
				</div>
			</li>
			<li>
				<a href="#">
					<?=$lang->line('admin');?>
				</a>
				<div class="uk-navbar-dropdown">
					<ul class="uk-nav uk-navbar-dropdown-nav">
						<li><a href="<?=base_url('site');?>"><?=$lang->line('site');?></a></li>
						<li><a href="<?=base_url('state');?>"><?=$lang->line('state');?></a></li>
						<li><a href="<?=base_url('menu');?>"><?=$lang->line('menu');?></a></li>
						<li><a href="<?=base_url('user');?>"><?=$lang->line('user');?></a></li>
					</ul>
				</div>
			</li>
		</ul>
	</div>
</nav>
