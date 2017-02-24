<form method="post" accept-charset="utf-8" action="<?=base_url('ward/edit')?>" class="uk-form-stacked">

<div class="uk-margin uk-child-width-1-2@s" >
	<label class="uk-form-label" for="id"><?=$lang->line('id')?></label>
	<div class="uk-form-controls">
		<input type="text" name="id" id="id" value="<?=$item['id']?>" class="uk-input <?=(form_error('id') ? 'uk-form-danger' : '');?>" />
		<?=form_error('id');?>
	</div>
</div>

<div class="uk-margin uk-child-width-1-2@s">
	<label class="uk-form-label" for="title"><?=$lang->line('title')?></label>
	<div class="uk-form-controls">
		<input type="text" name="title" id="title" value="<?=$item['title']?>" class="uk-input <?=(form_error('title') ? 'uk-form-danger' : '');?>" />
		<?=form_error('title');?>
	</div>
</div>

<div class="uk-margin uk-child-width-1-2@s">
	<label class="uk-form-label" for="type"><?=$lang->line('type')?></label>
	<div class="uk-form-controls">
		<input type="text" name="type" id="type" value="<?=$item['type']?>" class="uk-input <?=(form_error('type') ? 'uk-form-danger' : '');?>" />
		<?=form_error('type');?>
	</div>
</div>

<div class="uk-margin uk-child-width-1-2@s">
	<label class="uk-form-label" for="district_id"><?=$lang->line('district')?></label>
	<div class="uk-form-controls">
		<select class="uk-select">
			<option value="" disabled><?=$lang->line('select_one')?></option>
			<?php foreach ($list_district as $district) { ?>
			<option value="<?=$district['id'];?>" <?=(($district['id'] == $item['district_id']) ? 'selected' : '')?>><?=$district['title'];?></option>
			<?php } ?>
		</select>
		<?=form_error('district_id');?>
	</div>
</div>

<div class="uk-margin ">
	<button class="uk-button uk-button-primary" type="submit" name="action"><?=$lang->line('save');?></button>
</div>

</form>