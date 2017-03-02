<form method="post" accept-charset="utf-8" action="<?=current_url()?>" class="uk-form-stacked">

<div class="uk-margin-small">
	<label class="uk-form-label" for="username"><?=$lang->line('username')?></label>
	<div class="uk-form-controls uk-inline">
		<span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: user"></span>
		<input type="text" name="username" id="username" value="<?=$item['username'];?>" class="uk-input uk-form-width-medium uk-form-small" maxlength="255" required />
	</div>
</div>

<div class="uk-margin-small">
	<label class="uk-form-label" for="password"><?=$lang->line('password')?></label>
	<div class="uk-form-controls uk-inline">
		<span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: lock"></span>
		<input type="password" name="password" id="password" value="<?=$item['password'];?>" class="uk-input uk-form-width-medium uk-form-small" maxlength="255" required />
	</div>
</div>

<div class="uk-margin-small">
	<div class="uk-form-controls">
		<label class="uk-form-label" for="remember_me">
			<input class="uk-checkbox uk-form-width-medium uk-form-small" type="checkbox" name="remember_me" id="remember_me" value="1" <?=$item['remember_me'] ? ' checked' : '';?>/>
			<?=$lang->line('remember_me')?>
		</label>
	</div>
</div>

<div class="uk-margin-small">
	<div class="uk-form-controls">
		<button class="uk-button uk-button-primary uk-form-width-medium uk-form-small" type="submit" name="submit" value="login"><?=$lang->line('login');?></button>
	</div>
</div>

<div class="uk-margin-small">
	<div class="uk-form-controls">
		<button class="uk-button uk-form-width-medium uk-form-small" type="button"><?=$lang->line('password_recovery');?></button>
	</div>
</div>

</form>
