<script src="<?=base_url('pub/ckeditor/ckeditor.js')?>"></script>

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

<div class="uk-margin-small uk-width-large">
	<label class="uk-form-label" for="title"><?=$lang->line('title')?> (*)</label>
	<div class="uk-form-controls">
		<input type="text" name="title" id="title" value="<?=isset($item) ? $item['title'] : ''?>" class="uk-input uk-form-small <?=(form_error('title') ? 'uk-form-danger' : '')?>" />
		<?=form_error('title')?>
	</div>
</div>

<div class="uk-margin-small uk-width-large">
	<label class="uk-form-label" for="url"><?=$lang->line('url')?> (*)</label>
	<div class="uk-form-controls">
		<input type="text" name="url" id="url" value="<?=isset($item) ? $item['url'] : ''?>" class="uk-input uk-form-small <?=(form_error('url') ? 'uk-form-danger' : '')?>" />
		<?=form_error('url')?>
	</div>
</div>

<div class="uk-margin-small uk-width-large">
	<label class="uk-form-label" for="target"><?=$lang->line('target')?></label>
	<div class="uk-form-controls">
		<input type="text" name="target" id="target" value="<?=isset($item) ? $item['target'] : ''?>" class="uk-input uk-form-small <?=(form_error('target') ? 'uk-form-danger' : '')?>" />
		<?=form_error('target')?>
	</div>
</div>

<div class="uk-margin-small uk-width-medium">
	<label class="uk-form-label" for="menu-selector"><?=$lang->line('menu')?> (*)</label>
	<div class="uk-form-controls">
		<select class="uk-select uk-form-small" id="menu-selector" name="menu_id">
			<option value="" disabled><?=$lang->line('select_one')?></option>
			<?php foreach ($list_menu as $menu) { ?>
			<option value="<?=$menu['id']?>" <?=(isset($item) && ($menu['id'] == $item['menu_id']) ? 'selected' : '')?>><?=$menu['title']?></option>
			<?php } ?>
		</select>
		<?=form_error('menu_id')?>
	</div>
</div>

<div class="uk-margin-small uk-width-medium">
	<label class="uk-form-label" for="parent-selector"><?=$lang->line('parent')?> (*)</label>
	<div class="uk-form-controls">
		<select class="uk-select uk-form-small" id="parent-selector" name="menu_item_id">
			<option value="" disabled><?=$lang->line('select_one')?></option>
			<?php foreach ($list_menu_item as $menu_item) { ?>
			<option value="<?=$menu_item['id']?>" <?=(isset($item) && ($menu_item['id'] == $item['menu_item_id']) ? 'selected' : '')?>><?=$menu_item['title']?></option>
			<?php } ?>
		</select>
		<?=form_error('menu_item_id')?>
	</div>
</div>

<div class="uk-margin-small uk-width-large">
	<label class="uk-form-label" for="position"><?=$lang->line('position')?> (*)</label>
	<div class="uk-form-controls">
		<input type="text" name="position" id="position" value="<?=isset($item) ? $item['position'] : ''?>" class="uk-input uk-form-small <?=(form_error('position') ? 'uk-form-danger' : '')?>" />
		<?=form_error('position')?>
	</div>
</div>

<div class="uk-margin-small ">
	<input type="hidden" name="id" value="<?=isset($item) ? $item['id'] : ''?>" />
	<input type="hidden" name="created" value="<?=isset($item) ? $item['created'] : ''?>" />
	<button class="uk-button uk-button-small uk-button-secondary" type="submit" name="submit" value="save_back"><?=$lang->line('save_back')?></button>
	<button class="uk-button uk-button-small uk-button-primary" type="submit" name="submit" value="save"><?=$lang->line('save')?></button>
	<a class="uk-button uk-button-small" name="btn-back" href="<?=$link_back?>"><?=$lang->line('back')?></a>
</div>

</form>
