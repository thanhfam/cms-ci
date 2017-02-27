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
						<li><a href="<?=base_url('city/list');?>"><?=$lang->line('city');?></a></li>
						<li><a href="<?=base_url('district/list');?>"><?=$lang->line('district');?></a></li>
						<li><a href="<?=base_url('ward/list');?>"><?=$lang->line('ward');?></a></li>
					</ul>
				</div>
			</li>
		</ul>
	</div>
</nav>
