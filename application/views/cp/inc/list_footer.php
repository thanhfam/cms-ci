<nav class="uk-navbar-container uk-margin-small" uk-navbar>
	<div class="uk-navbar-left">
		<div class="uk-navbar-item">
			<?=(isset($total_rows) ? $lang->line('total') .': ' .$total_rows : '')?>
		</div>
	</div>

	<div class="uk-navbar-center">
		<div class="uk-navbar-item">
		<?=$pagy->create_links()?>
		</div>
	</div>
</nav>
