<?php
if (isset($item) && !empty($item['created'])) {
?>
<div class="uk-margin time">
	<div class="created"><?=$lang->line('created_at') . $item['created'];?></div>
	<div class="udpated"><?=$lang->line('updated_at') . $item['updated'];?></div>
</div>
<?php
}
?>

<form method="post" accept-charset="utf-8" action="<?=current_url()?>" class="uk-form-stacked">

<div class="uk-margin uk-child-width-1-2@s">
	<label class="uk-form-label" for="title"><?=$lang->line('title')?></label>
	<div class="uk-form-controls">
		<input type="text" name="title" id="title" value="<?=isset($item) ? $item['title'] : '';?>" class="uk-input <?=(form_error('title') ? 'uk-form-danger' : '');?>" />
		<?=form_error('title');?>
	</div>
</div>

<div class="uk-margin uk-child-width-1-2@s" >
	<label class="uk-form-label" for="code"><?=$lang->line('code')?></label>
	<div class="uk-form-controls">
		<input type="text" name="code" id="code" value="<?=isset($item) ? $item['code'] : '';?>" class="uk-input <?=(form_error('code') ? 'uk-form-danger' : '');?>" />
		<?=form_error('code');?>
	</div>
</div>

<div class="uk-margin uk-child-width-1-2@s">
	<label class="uk-form-label" for="type"><?=$lang->line('type')?></label>
	<div class="uk-form-controls">
		<input type="text" name="type" id="type" value="<?=isset($item) ? $item['type'] : '';?>" class="uk-input <?=(form_error('type') ? 'uk-form-danger' : '');?>" />
		<?=form_error('type');?>
	</div>
</div>

<div class="uk-margin uk-child-width-1-2@s">
	<label class="uk-form-label" for="nation_selector"><?=$lang->line('nation')?></label>
	<div class="uk-form-controls">
		<select class="uk-select" id="nation_selector" name="nation_id">
			<option value="" disabled><?=$lang->line('select_one')?></option>
			<?php foreach ($list_nation as $nation) { ?>
			<option value="<?=$nation['id'];?>" <?=(isset($item) && ($nation['id'] == $item['nation_id']) ? 'selected' : '')?>><?=$nation['title'];?></option>
			<?php } ?>
		</select>
		<?=form_error('nation_id');?>
	</div>
</div>

<div class="uk-margin ">
	<input type="hidden" name="id" value="<?=isset($item) ? $item['id'] : '';?>" />
	<input type="hidden" name="created" value="<?=isset($item) ? $item['created'] : '';?>" />
	<button class="uk-button uk-button-primary" type="submit" name="submit" value="save"><?=$lang->line('save');?></button>
	<a class="uk-button" name="btn-back" href="<?=$link_back;?>"><?=$lang->line('back');?></a>
</div>

</form>
