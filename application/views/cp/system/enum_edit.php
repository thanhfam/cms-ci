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

<div class="uk-margin-small uk-width-large" >
	<label class="uk-form-label" for="title"><?=$lang->line('title')?> (*)</label>
	<div class="uk-form-controls">
		<input type="text" name="title" id="name" value="<?=$item['title']?>" class="uk-input uk-form-small <?=(form_error('title') ? 'uk-form-danger' : '')?>" />
		<?=form_error('title')?>
	</div>
</div>

<div class="uk-margin-small uk-width-large" >
	<label class="uk-form-label" for="name"><?=$lang->line('name')?></label>
	<div class="uk-form-controls">
		<input type="text" name="name" id="name" value="<?=$item['name']?>" class="uk-input uk-form-small <?=(form_error('name') ? 'uk-form-danger' : '')?>" />
		<?=form_error('name')?>
	</div>
</div>

<div class="uk-margin-small uk-width-medium">
	<label class="uk-form-label" for="parent-selector"><?=$lang->line('parent')?></label>
	<div class="uk-form-controls">
		<select class="uk-select uk-form-small" id="parent-selector" name="parent_id">
			<option value="" disabled><?=$lang->line('select_one')?></option>
			<?php foreach ($list_parent as $parent): ?>
			<option value="<?=$parent['id']?>" <?=(isset($item) && ($parent['id'] == $item['parent_id']) ? 'selected' : '')?>><?=$parent['title']?></option>
			<?php endforeach; ?>
		</select>
		<?=form_error('parent_weight')?>
	</div>
</div>

<div class="uk-margin-small uk-width-large" >
	<label class="uk-form-label" for="language"><?=$lang->line('language')?></label>
	<div class="uk-form-controls">
		<input type="text" name="lang" id="name" value="<?=$item['lang']?>" class="uk-input uk-form-small <?=(form_error('lang') ? 'uk-form-danger' : '')?>" />
		<?=form_error('lang')?>
	</div>
</div>

<div class="uk-margin-small uk-width-large" >
	<label class="uk-form-label" for="weight"><?=($type && $type == 'tvn_service') ? $lang->line('price') : $lang->line('weight')?></label>
	<div class="uk-form-controls">
		<input type="text" name="weight" id="name" value="<?=$item['weight']?>" class="uk-input uk-form-small <?=(form_error('weight') ? 'uk-form-danger' : '')?>" />
		<?=form_error('weight')?>
	</div>
</div>

<div class="uk-margin-small uk-width-large" >
	<label class="uk-form-label" for="type"><?=$lang->line('type')?></label>
	<div class="uk-form-controls">
		<input type="text" name="type" id="name" value="<?=$item['type']?>" class="uk-input uk-form-small <?=(form_error('type') ? 'uk-form-danger' : '')?>" />
		<?=form_error('type')?>
	</div>
</div>

<div class="uk-margin-small">
	<input type="hidden" name="id" value="<?=isset($item) ? $item['id'] : ''?>" />
	<input type="hidden" name="type_name" value="<?=isset($type) ? $type : ''?>" />
	<input type="hidden" name="created" value="<?=isset($item) ? $item['created'] : ''?>" />
	<button class="uk-button uk-button-small uk-button-secondary" type="submit" name="submit" value="save_back"><?=$lang->line('save_back')?></button>
	<button class="uk-button uk-button-small uk-button-primary" type="submit" name="submit" value="save"><?=$lang->line('save')?></button>
	<a class="uk-button uk-button-small" name="btn-back" href="<?=$link_back?>"><?=$lang->line('back')?></a>
</div>

</form>
