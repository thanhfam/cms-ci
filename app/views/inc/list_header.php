<nav>
	<div class="nav-wrapper">
		<form method="get" accept-charset="utf-8" action="<?=base_url('ward/list')?>">
			<div class="input-field">
				<input id="filter" type="search" name="filter" required value="<?=$filter;?>">
				<label class="label-icon" for="filter"><i class="material-icons">search</i></label>
				<i class="material-icons">close</i>
			</div>
		</form>
	</div>
</nav>

<?=$pagy->create_links();?>