<link href="<?=base_url(F_PUB .F_CP .'alloy-editor/assets/alloy-editor-ocean-min.css')?>" rel="stylesheet">
<script src="<?=base_url(F_PUB .F_CP .'alloy-editor/alloy-editor-all-min.js')?>"></script>

<?php
if (isset($item) && !empty($item['created'])):
?>
<div class="uk-margin-small time">
	<div class="created"><?=$lang->line('created_at') . $item['created']?></div>
	<div class="udpated"><?=$lang->line('updated_at') . $item['updated']?></div>
</div>
<?php
endif;
?>

<form method="post" accept-charset="utf-8" action="<?=current_url()?>" class="uk-form-stacked">

<div class="uk-margin-small uk-width-xlarge">
	<label class="uk-form-label" for="subtitle"><?=$lang->line('subtitle')?></label>
	<div class="uk-form-controls">
		<input type="text" name="subtitle" id="subtitle" value="<?=isset($item) ? $item['subtitle'] : ''?>" class="uk-form-small uk-input <?=(form_error('subtitle') ? 'uk-form-danger' : '')?>" />
		<?=form_error('subtitle')?>
	</div>
</div>

<div class="uk-margin-small uk-width-xlarge">
	<label class="uk-form-label" for="title"><?=$lang->line('title')?> (*)</label>
	<div class="uk-form-controls">
		<input type="text" name="title" id="title" value="<?=isset($item) ? $item['title'] : ''?>" class="uk-form-small uk-input <?=(form_error('title') ? 'uk-form-danger' : '')?>" />
		<?=form_error('title')?>
	</div>
</div>

<div class="uk-margin-small uk-width-xlarge">
	<label class="uk-form-label" for="uri"><?=$lang->line('uri')?></label>
	<div class="uk-form-controls">
		<input type="text" name="uri" id="uri" value="<?=isset($item) ? $item['uri'] : ''?>" class="uk-form-small uk-input <?=(form_error('uri') ? 'uk-form-danger' : '')?>" />
		<?=form_error('uri')?>
	</div>
</div>

<div class="uk-margin-small uk-width-xlarge">
	<label class="uk-form-label" for="avatar"><?=$lang->line('avatar')?></label>
	<div class="uk-form-controls">
		<div id="avatar-container" style="display: none;">
			<img class="uk-height-small" id="avatar-img" src="<?=(isset($item) && $item['avatar_filename'] != '') ? base_url('/file/' .$item['avatar_filename']) : ''?>" />
			<button class="uk-button uk-button-small uk-button-primary" type="button" data-type="post" onclick="changeAvatar(this);"><?=$lang->line('change')?></button>
			<button class="uk-button uk-button-small uk-button-danger" type="button" onclick="removeAvatar(this);"><?=$lang->line('remove')?></button>
		</div>
		<div id="non-avatar-container" style="display: none;">
			<button class="uk-button uk-button-small uk-button-primary" type="button" data-type="post" onclick="addAvatar(this);"><?=$lang->line('add')?></button>
		</div>
		<input type="hidden" name="avatar_id" id="avatar-id" value="<?=isset($item) ? $item['avatar_id'] : ''?>" />
		<input type="hidden" name="avatar_filename" id="avatar-filename" value="<?=isset($item) ? $item['avatar_filename'] : ''?>" />
	</div>
</div>

<div class="uk-margin-small uk-width-xlarge">
	<label class="uk-form-label" for="lead"><?=$lang->line('lead')?></label>
	<div class="uk-form-controls">
		<textarea type="text" name="lead" id="lead" rows="5" class="uk-text-small uk-textarea <?=(form_error('lead') ? 'uk-form-danger' : '')?>"><?=isset($item) ? $item['lead'] : ''?></textarea>
		<?=form_error('lead')?>
	</div>
</div>

<div class="uk-margin-small uk-width-xxlarge">
	<label class="uk-form-label" for="content"><?=$lang->line('content')?></label>
	<div class="uk-form-controls">
		<textarea type="text" name="content" id="content" rows="5" class="uk-text-small uk-textarea <?=(form_error('content') ? 'uk-form-danger' : '')?>"><?=isset($item) ? $item['content'] : ''?></textarea>
		<?=form_error('content')?>
	</div>
</div>

<script>
	AlloyEditor.editable('content');
</script>

<div class="uk-margin-small uk-width-xlarge">
	<label class="uk-form-label" for="tags"><?=$lang->line('tags')?></label>
	<span class="uk-text-meta">(tag 1, tag 2, tag 3...)</span>
	<div class="uk-form-controls">
		<input type="text" name="tags" id="tags" value="<?=isset($item) ? $item['tags'] : ''?>" class="uk-form-small uk-input <?=(form_error('tags') ? 'uk-form-danger' : '')?>" />
		<?=form_error('tags')?>
	</div>
</div>

<div class="uk-margin-small uk-width-medium">
	<label class="uk-form-label" for="category-selector"><?=$lang->line('category')?></label>
	<div class="uk-form-controls">
		<select class="uk-select uk-form-small" id="category-selector" name="cate_id">
			<option value="" disabled><?=$lang->line('select_one')?></option>
			<?php foreach ($list_category as $category) { ?>
			<option value="<?=$category['id']?>" <?=(isset($item) && ($category['id'] == $item['cate_id']) ? 'selected' : '')?>><?=$category['title']?></option>
			<?php } ?>
		</select>
		<?=form_error('cate_id')?>
	</div>
</div>

<div class="uk-margin-small uk-width-medium">
	<label class="uk-form-label" for="state-selector"><?=$lang->line('state')?></label>
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
	<input type="hidden" name="id" value="<?=isset($item) ? $item['id'] : ''?>" />
	<input type="hidden" name="created" value="<?=isset($item) ? $item['created'] : ''?>" />
	<button class="uk-button uk-button-small uk-button-primary" type="submit" name="submit" value="save"><?=$lang->line('save')?></button>
	<button class="uk-button uk-button-small uk-button-secondary" type="submit" name="submit" value="save_back"><?=$lang->line('save_back')?></button>
	<a class="uk-button uk-button-small" name="btn-back" href="<?=$link_back?>"><?=$lang->line('back')?></a>
</div>

</form>

<?php
	$this->load->view('cp/inc/modal_upload_image');
