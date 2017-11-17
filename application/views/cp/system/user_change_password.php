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
	<label class="uk-form-label" for="password"><?=$lang->line('password')?> (*)</label>
	<div class="uk-form-controls">
		<input type="password" name="password" id="name" value="<?=$item['password']?>" class="uk-input uk-form-small <?=(form_error('password') ? 'uk-form-danger' : '')?>" />
		<?=form_error('password')?>
	</div>
</div>

<div class="uk-margin-small uk-width-large" >
	<label class="uk-form-label" for="password_new"><?=$lang->line('password_new')?> (*)</label>
	<div class="uk-form-controls">
		<input type="password" name="password_new" id="name" value="<?=$item['password_new']?>" class="uk-input uk-form-small <?=(form_error('password_new') ? 'uk-form-danger' : '')?>" />
		<?=form_error('password_new')?>
	</div>
</div>

<div class="uk-margin-small uk-width-large" >
	<label class="uk-form-label" for="password_new_confirm"><?=$lang->line('password_new_confirm')?> (*)</label>
	<div class="uk-form-controls">
		<input type="password" name="password_new_confirm" id="name" value="<?=$item['password_new_confirm']?>" class="uk-input uk-form-small <?=(form_error('password_new_confirm') ? 'uk-form-danger' : '')?>" />
		<?=form_error('password_new_confirm')?>
	</div>
</div>

<div class="uk-margin-small">
	<input type="hidden" name="id" value="<?=$item['id']?>" />
	<input type="hidden" name="created" value="<?=$item['created']?>" />
	<input type="hidden" name="updated" value="<?=$item['updated']?>" />
	<button class="uk-button uk-button-small uk-button-primary" type="submit" name="submit" value="save"><?=$lang->line('save')?></button>
	<a class="uk-button uk-button-small" name="btn-back" href="<?=$link_back?>"><?=$lang->line('back')?></a>
</div>

</form>
