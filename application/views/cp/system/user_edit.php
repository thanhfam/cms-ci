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
	<label class="uk-form-label" for="username"><?=$lang->line('username')?> (*)</label>
	<div class="uk-form-controls">
		<input type="text" name="username" id="name" value="<?=$item['username']?>" class="uk-input uk-form-small <?=(form_error('username') ? 'uk-form-danger' : '')?>" />
		<?=form_error('username')?>
	</div>
</div>

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
	<label class="uk-form-label" for="group-selector"><?=$lang->line('user_group')?> (*)</label>
	<div class="uk-form-controls">
		<select class="uk-select uk-form-small" id="group-selector" name="user_group_id">
			<option value="" disabled><?=$lang->line('select_one')?></option>
			<?php foreach ($list_group as $group) { ?>
			<option value="<?=$group['id']?>" <?=(isset($item) && ($group['id'] == $item['user_group_id']) ? 'selected' : '')?>><?=$group['title']?></option>
			<?php } ?>
		</select>
		<?=form_error('user_group_id')?>
	</div>
</div>

<div class="uk-margin-small uk-width-medium">
	<label class="uk-form-label" for="state-selector"><?=$lang->line('state')?> (*)</label>
	<div class="uk-form-controls">
		<select class="uk-select uk-form-small" id="state-selector" name="state_weight">
			<option value="" disabled><?=$lang->line('select_one')?></option>
			<?php foreach ($list_state as $state) { ?>
			<option value="<?=$state['weight']?>" <?=(isset($item) && ($state['weight'] == $item['state_weight']) ? 'selected' : '')?>><?=$lang->line($state['name']) ? $lang->line($state['name']) : $state['name']?> (<?=$state['weight']?>)</option>
			<?php } ?>
		</select>
		<?=form_error('state_weight')?>
	</div>
</div>

<div class="uk-margin-small">
	<input type="hidden" name="id" value="<?=$item['id']?>" />
	<input type="hidden" name="created" value="<?=$item['created']?>" />
	<button class="uk-button uk-button-small uk-button-primary" type="submit" name="submit" value="save"><?=$lang->line('save')?></button>
	<button class="uk-button uk-button-small uk-button-secondary" type="submit" name="submit" value="save_back"><?=$lang->line('save_back')?></button>
	<a class="uk-button uk-button-small" name="btn-back" href="<?=$link_back?>"><?=$lang->line('back')?></a>
</div>

</form>
