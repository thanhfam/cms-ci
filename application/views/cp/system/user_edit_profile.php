<?php
if (isset($item) && !empty($item['created'])):
?>
<div class="uk-margin-small time">
	<div class="created"><?=$lang->line('created_at') . $item['created'];?></div>
	<div class="udpated"><?=$lang->line('updated_at') . $item['updated'];?></div>
	<?php
	if (isset($item) && !empty($item['last_login'])):
	?>
	<div class="last-login"><?=$lang->line('last_login_at') . $item['last_login'];?></div>
	<?php
	endif;
	?>
</div>
<?php
endif;
?>

<form method="post" accept-charset="utf-8" action="<?=current_url()?>" class="uk-form-stacked">

<div class="uk-margin-small uk-width-large" >
	<label class="uk-form-label" for="name"><?=$lang->line('name')?> (*)</label>
	<div class="uk-form-controls">
		<input type="text" name="name" id="name" value="<?=$item['name']?>" class="uk-input uk-form-small <?=(form_error('name') ? 'uk-form-danger' : '')?>" />
		<?=form_error('name')?>
	</div>
</div>

<div class="uk-margin-small uk-width-large" >
	<label class="uk-form-label" for="email"><?=$lang->line('email')?> (*)</label>
	<div class="uk-form-controls">
		<input type="text" name="email" id="name" value="<?=$item['email']?>" class="uk-input uk-form-small <?=(form_error('email') ? 'uk-form-danger' : '')?>" />
		<?=form_error('email')?>
	</div>
</div>

<div class="uk-margin-small uk-width-medium">
	<label class="uk-form-label" for="state-selector"><?=$lang->line('timezone')?></label>
	<div class="uk-form-controls">
		<?=timezone_menu($item['timezone'] ? $item['timezone'] : 'UP7', 'uk-select uk-form-small', 'timezone')?>
		<?=form_error('timezone')?>
	</div>
</div>

<div class="uk-margin-small uk-width-medium">
	<label class="uk-form-label" for="state-selector"><?=$lang->line('date_format')?></label>
	<div class="uk-form-controls">
		<?=date_format_menu($item['date_format'] ? $item['date_format'] : '', 'uk-select uk-form-small', 'date_format')?>
		<?=form_error('date_format')?>
	</div>
</div>

<div class="uk-margin-small">
	<input type="hidden" name="created" value="<?=$item['created']?>" />
	<button class="uk-button uk-button-small uk-button-primary" type="submit" name="submit" value="save"><?=$lang->line('save')?></button>
</div>

</form>
