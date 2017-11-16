<nav class="uk-navbar-container uk-margin-small" uk-navbar>
	<div class="uk-navbar-left">
		<div class="uk-navbar-item">
			<form method="get" accept-charset="utf-8" action="<?=current_url()?>">
			<div class="uk-form-controls uk-inline">
				<span class="uk-form-icon" uk-icon="icon: search"></span>
				<input class="uk-input uk-form-small keyword" type="search" placeholder="<?=$lang->line('keyword');?>" name="filter" value="<?=$filter;?>" />
			</div>
			<input class="uk-button-small uk-button uk-button-primary filter" type="submit" value="<?=$lang->line('filter');?>">
			<input class="uk-button-small uk-button unfilter" type="submit" value="<?=$lang->line('unfilter');?>">
			</form>
		</div>
	</div>
	<div class="uk-navbar-right">
		<div class="uk-navbar-item">
		<?php
			//$pagy->create_links();

			if ($link_create) {
		?>
			<a class="uk-button-small uk-button uk-button-primary" href="<?=$link_create;?>"><?=$lang->line('create');?></a>
		<?php
			}
		?>
		</div>
	</div>
</nav>

