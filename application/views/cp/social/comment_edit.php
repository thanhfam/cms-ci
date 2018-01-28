<?php
if (isset($item) && !empty($item['created'])):
?>
<div class="uk-margin-small time">
	<div class="created"><?=$lang->line('created_at') . $item['created'];?></div>
	<div class="udpated"><?=$lang->line('updated_at') . $item['updated'];?></div>
</div>
<?php
endif;
?>

<form method="post" accept-charset="utf-8" action="<?=current_url()?>" class="uk-form-stacked">
<div class="uk-margin-small uk-width-large" >
	<label class="uk-form-label" for="comment"><?=$lang->line('comment')?> (*)</label>
	<div class="uk-form-controls">
		<textarea type="text" name="comment" id="comment" rows="3" class="uk-text-small uk-textarea <?=(form_error('comment') ? 'uk-form-danger' : '')?>"><?=isset($item) ? $item['comment'] : ''?></textarea>
		<?=form_error('comment')?>
	</div>
</div>

<div class="uk-margin-small uk-width-large" >
	<label class="uk-form-label" for="user"><?=$lang->line('user')?></label>
	<div class="uk-form-controls">
		<input type="text" value="<?=$item['username']?> (<?=$item['user_id']?>)" class="uk-input uk-form-small uk-form-blank" readonly="readonly" />
		<input type="hidden" name="username" value="<?=$item['username']?>" />
		<input type="hidden" name="user_id" value="<?=$item['user_id']?>" />
	</div>
</div>

<div class="uk-margin-small uk-width-large" >
	<label class="uk-form-label" for="content"><?=$lang->line('content')?></label>
	<div class="uk-form-controls">
		<input type="text" value="<?=$item['content_title']?> (<?=$item['content_id']?>)" class="uk-input uk-form-small uk-form-blank" readonly="readonly" />
		<input type="hidden" name="content_title" value="<?=$item['content_title']?>" />
		<input type="hidden" name="content_id" value="<?=$item['content_id']?>" />
	</div>
</div>

<div class="uk-margin-small uk-width-large" >
	<label class="uk-form-label" for="content_type"><?=$lang->line('content_type')?></label>
	<div class="uk-form-controls">
		<input type="text" name="content_type" id="content_type" value="<?=$item['content_type']?>" class="uk-input uk-form-small uk-form-blank" readonly="readonly" />
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
		<input type="hidden" name="old_state_weight" value="<?=$item['old_state_weight']?>" />
	</div>
</div>

<div class="uk-margin-small">
	<input type="hidden" name="id" value="<?=$item['id']?>" />
	<input type="hidden" name="created" value="<?=$item['created']?>" />
	<input type="hidden" name="link_back" value="<?=$link_back?>" />
	<button class="uk-button uk-button-small uk-button-danger" type="submit" name="submit" value="activate_back"><?=$lang->line('activate_back')?></button>
	<button class="uk-button uk-button-small uk-button-primary" type="submit" name="submit" value="save"><?=$lang->line('save')?></button>
	<button class="uk-button uk-button-small uk-button-secondary" type="submit" name="submit" value="save_back"><?=$lang->line('save_back')?></button>
	<a class="uk-button uk-button-small" name="btn-back" href="<?=$link_back?>"><?=$lang->line('back')?></a>
</div>

</form>
