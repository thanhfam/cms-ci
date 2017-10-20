<?php
if (isset($item) && !empty($item['created_at'])) {
?>
<div class="uk-margin time">
	<div class="created"><?=$lang->line('created_at') . $item['created_at'];?></div>
	<div class="udpated"><?=$lang->line('updated_at') . $item['modified_at'];?></div>

	<?php
	if (!empty($item['last_login'])) {
	?>
	<div class="last-login"><?=$lang->line('last_login') . $item['last_login'];?></div>
	<?php
	}
	?>
</div>
<?php
}
?>

<form method="post" accept-charset="utf-8" action="<?=current_url()?>" class="uk-form-stacked">

<div class="uk-margin uk-child-width-1-2@s">
	<label class="uk-form-label" for="password"><?=$lang->line('password')?></label>
	<div class="uk-form-controls">
		<input type="text" name="password" id="password" value="<?=isset($item) ? $item['password'] : '';?>" class="uk-input <?=(form_error('password') ? 'uk-form-danger' : '');?>" />
		<?=form_error('password');?>
	</div>
</div>

<div class="uk-margin uk-child-width-1-2@s" >
	<label class="uk-form-label" for="password_confirm"><?=$lang->line('password_confỉm')?></label>
	<div class="uk-form-controls">
		<input type="password" name="password_confirm" id="password_confirm" value="<?=isset($item) ? $item['password_confirm'] : '';?>" class="uk-input <?=(form_error('password_confirm') ? 'uk-form-danger' : '');?>" />
		<?=form_error('password_confirm');?>
	</div>
</div>

<div class="uk-margin uk-child-width-1-2@s" >
	<label class="uk-form-label" for="password_new"><?=$lang->line('password_new')?></label>
	<div class="uk-form-controls">
		<input type="password" name="password_new" id="password_new" value="<?=isset($item) ? $item['password_new'] : '';?>" class="uk-input <?=(form_error('password_new') ? 'uk-form-danger' : '');?>" />
		<?=form_error('password_new');?>
	</div>
</div>

<div class="uk-margin ">
	<input type="hidden" name="user_id" value="<?=isset($item) ? $item['user_id'] : '';?>" />
	<input type="hidden" name="last_login" value="<?=isset($item) ? $item['last_login'] : '';?>" />
	<input type="hidden" name="created_at" value="<?=isset($item) ? $item['created_at'] : '';?>" />
	<button class="uk-button uk-button-primary" type="submit" name="submit" value="save"><?=$lang->line('save');?></button>
	<a class="uk-button" name="btn-back" href="<?=$link_back;?>"><?=$lang->line('back');?></a>
</div>

</form>
