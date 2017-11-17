<div class="uk-height-viewport uk-flex uk-flex-middle user-login-background">
<div id="user-login" class="uk-form-width-medium uk-box-shadow-bottom uk-box-shadow-small">
<div class="uk-background-default uk-padding-small">

<form method="post" accept-charset="utf-8" action="<?=current_url()?>" class="uk-form-stacked">

<div class="uk-margin-small">
	<h3 class="uk-text-primary"><?=$title?></h3>
</div>

<div class="uk-margin-small">
	<label class="uk-form-label" for="username"><?=$lang->line('username')?></label>
	<div class="uk-form-controls uk-inline">
		<span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: user"></span>
		<input minlength="3" type="text" name="username" id="username" value="<?=$item['username'];?>" class="uk-input uk-form-small" maxlength="255" required />
	</div>
</div>

<div class="uk-margin-small">
	<label class="uk-form-label" for="password"><?=$lang->line('password')?></label>
	<div class="uk-form-controls uk-inline">
		<span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: lock"></span>
		<input minlength="8" type="password" name="password" id="password" value="<?=$item['password'];?>" class="uk-input uk-form-small" maxlength="255" required />
	</div>
</div>

<div class="uk-margin-small">
	<div class="uk-form-controls">
		<button class="uk-button uk-button-small uk-button-primary" type="submit" name="submit" value="login"><?=$lang->line('login');?></button>
	</div>
</div>

</form>
</div>
</div>
</div>
