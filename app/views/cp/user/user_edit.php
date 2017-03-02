<?php
if (isset($item) && !empty($item['created'])) {
?>
<div class="uk-margin time">
	<div class="created"><?=$lang->line('created_at') . $item['created_at'];?></div>
	<div class="udpated"><?=$lang->line('updated_at') . $item['modified_at'];?></div>
	<div class="last-login"><?=$lang->line('last_login') . $item['last_login'];?></div>
</div>
<?php
}
?>

<form method="post" accept-charset="utf-8" action="<?=current_url()?>" class="uk-form-stacked">

<div class="uk-margin uk-child-width-1-2@s">
	<label class="uk-form-label" for="username"><?=$lang->line('username')?></label>
	<div class="uk-form-controls">
		<input type="text" name="username" id="username" value="<?=isset($item) ? $item['username'] : '';?>" class="uk-input <?=(form_error('username') ? 'uk-form-danger' : '');?>" />
		<?=form_error('username');?>
	</div>
</div>

<div class="uk-margin uk-child-width-1-2@s" >
	<label class="uk-form-label" for="email"><?=$lang->line('email')?></label>
	<div class="uk-form-controls">
		<input type="email" name="email" id="email" value="<?=isset($item) ? $item['email'] : '';?>" class="uk-input <?=(form_error('email') ? 'uk-form-danger' : '');?>" />
		<?=form_error('email');?>
	</div>
</div>

<div class="uk-margin ">
	<input type="hidden" name="user_id" value="<?=isset($item) ? $item['user_id'] : '';?>" />
	<input type="hidden" name="last_login" value="<?=isset($item) ? $item['created_at'] : '';?>" />
	<input type="hidden" name="created_at" value="<?=isset($item) ? $item['created_at'] : '';?>" />
	<button class="uk-button uk-button-primary" type="submit" name="submit" value="save"><?=$lang->line('save');?></button>
	<a class="uk-button" name="btn-back" href="<?=$link_back;?>"><?=$lang->line('back');?></a>
</div>

</form>
