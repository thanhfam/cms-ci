<form method="post" accept-charset="utf-8" action="<?=isset($item) ? base_url('ward/edit') : base_url('ward/create');?>" class="col s12">

<div class="row">
	<div class="input-field col m6 s12">
		<label for="id"><?=$lang->line('id')?></label>
		<input type="text" name="id" id="id" value="<?=isset($item) ? $item['id'] : set_value('id');?>" class="validate <?=(form_error('id')?'invalid':'"');?>" />
		<?=form_error('id');?>
	</div>
</div>

<div class="row">
	<div class="input-field col m6 s12">
		<label for="title"><?=$lang->line('title')?></label>
		<input type="text" name="title" id="title" value="<?=isset($item) ? $item['title'] : set_value('title');?>" class="validate <?=(form_error('title')?'invalid':'"');?>" />
		<?=form_error('title');?>
	</div>
</div>

<div class="row">
	<div class="input-field col m6 s12">
		<label for="type"><?=$lang->line('type')?></label>
		<input type="text" name="type" id="type" value="<?=isset($item) ? $item['type'] : set_value('type');?>" class="validate <?=(form_error('type')?'invalid':'"');?>" />
		<?=form_error('type');?>
	</div>
</div>

<div class="row">
	<div class="input-field col m6 s12">
		<select id="city-selector" name="city_id" onchange="get_district(this);">
			<option disabled><?=$lang->line('select_one')?></option>
			<?php foreach ($list_city as $city) { ?>
			<option value="<?=$city['id'];?>" <?=(isset($item) && ($city['id'] == $item['city_id']) ? 'selected' : '')?>><?=$city['title'];?></option>
			<?php } ?>
		</select>
		<label for="city-selector"><?=$lang->line('city')?></label>
		<?=form_error('city_id');?>
	</div>
</div>

<div class="row">
	<div class="input-field col m6 s12">
		<select id="district-selector" name="district_id">
			<option disabled><?=$lang->line('select_one')?></option>
			<?php foreach ($list_district as $district) { ?>
			<option value="<?=$district['id'];?>" <?=(isset($item) && ($district['id'] == $item['district_id']) ? 'selected' : '')?>><?=$district['title'];?></option>
			<?php } ?>
		</select>
		<label for="district-selector"><?=$lang->line('district')?></label>
		<?=form_error('district_id');?>
	</div>
</div>

<div class="row">
	<button class="btn waves-effect waves-light" type="submit"><i class="material-icons left">send</i><?=$lang->line('save');?></button>
	<button class="btn waves-effect waves-light orange darken-4" name="btn-back"><i class="material-icons left">replay</i><?=$lang->line('back');?></button>
</div>
</div>
</form>
