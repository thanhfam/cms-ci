<form method="post" accept-charset="utf-8" action="<?=base_url('ward/edit')?>" class="col s12">

<div class="row">
	<div class="input-field col m6 s12">
		<label for="id"><?=$lang->line('id')?></label>
		<input type="text" name="id" id="id" value="<?=$item['id']?>" class="validate <?=(form_error('id')?'invalid':'"');?>" />
		<?=form_error('id');?>
	</div>
</div>

<div class="row">
	<div class="input-field col m6 s12">
		<label for="title"><?=$lang->line('title')?></label>
		<input type="text" name="title" id="title" value="<?=$item['title']?>" class="validate <?=(form_error('title')?'invalid':'"');?>" />
		<?=form_error('title');?>
	</div>
</div>

<div class="row">
	<div class="input-field col m6 s12">
		<label for="type"><?=$lang->line('type')?></label>
		<input type="text" name="type" id="type" value="<?=$item['type']?>" class="validate <?=(form_error('type')?'invalid':'"');?>" />
		<?=form_error('type');?>
	</div>
</div>

<div class="row">
	<div class="input-field col m6 s12">
		<select class="validate <?=(form_error('district_id')?'invalid':'"');?>">
			<option value="" disabled><?=$lang->line('select_one')?></option>
			<?php foreach ($list_district as $district) { ?>
			<option value="<?=$district['id'];?>" <?=(($district['id'] == $item['district_id']) ? 'selected' : '')?>><?=$district['title'];?></option>
			<?php } ?>
		</select>
		<label for="district_id"><?=$lang->line('district')?></label>
		<?=form_error('district_id');?>
	</div>
</div>

<div class="row">
	<button class="btn waves-effect waves-light" type="submit" name="action"><i class="material-icons left">send</i><?=$lang->line('save');?></button>
	<button class="btn waves-effect waves-light teal lighten-5" name="back"><i class="material-icons left">replay</i><?=$lang->line('back');?></button>
</div>
</div>
</form>