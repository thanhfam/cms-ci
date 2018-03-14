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
	<label class="uk-form-label" for="id"><?=$lang->line('id')?></label>
	<div class="uk-form-controls">
		<input disabled type="text" value="<?=$item['id']?>" class="uk-input uk-form-small" />
	</div>
</div>

<div class="uk-margin-small uk-width-large" >
	<label class="uk-form-label" for="title-selector"><?=$lang->line('name')?> (*)</label>
	<div class="uk-form-controls" uk-grid>
		<div class="uk-width-1-4@s">
			<select class="uk-select uk-form-small" id="title-selector" name="title">
				<?php foreach ($list_title as $title): ?>
				<option value="<?=$title['title']?>" <?=(isset($item) && ($title['title'] == $item['title']) ? 'selected' : '')?>><?=$title['title']?></option>
				<?php endforeach; ?>
			</select>
			<?=form_error('title')?>
		</div>
		<div class="uk-width-1-4@s">
			<input type="text" name="last_name" id="last_name" placeholder="<?=$lang->line('last_name')?>" value="<?=$item['last_name']?>" class="uk-input uk-form-small <?=(form_error('last_name') ? 'uk-form-danger' : '')?>" />
			<?=form_error('last_name')?>
		</div>
		<div class="uk-width-1-4@s">
			<input type="text" name="middle_name" id="middle_name" placeholder="<?=$lang->line('middle_name')?>" value="<?=$item['middle_name']?>" class="uk-input uk-form-small <?=(form_error('middle_name') ? 'uk-form-danger' : '')?>" />
			<?=form_error('middle_name')?>
		</div>
		<div class="uk-width-1-4@s">
			<input type="text" name="first_name" id="middle_name" placeholder="<?=$lang->line('first_name')?>" value="<?=$item['first_name']?>" class="uk-input uk-form-small <?=(form_error('first_name') ? 'uk-form-danger' : '')?>" />
			<?=form_error('first_name')?>
		</div>
	</div>
</div>

<div class="uk-margin-small uk-width-large" >
	<label class="uk-form-label" for="birthday"><?=$lang->line('birthday')?></label>
	<div class="uk-form-controls">
		<input type="text" name="birthday" id="birthday" value="<?=$item['birthday']?>" class="uk-input uk-form-small <?=(form_error('birthday') ? 'uk-form-danger' : '')?>" />
		<?=form_error('birthday')?>
	</div>
	<div class="uk-text-meta uk-margin-small">
		<p><?=$lang->line('date_format_description')?></p>
	</div>
</div>

<div class="uk-margin-small uk-width-large" >
	<label class="uk-form-label" for="email"><?=$lang->line('email')?></label>
	<div class="uk-form-controls">
		<input type="text" name="email" id="email" value="<?=$item['email']?>" class="uk-input uk-form-small <?=(form_error('email') ? 'uk-form-danger' : '')?>" />
		<?=form_error('email')?>
	</div>
</div>

<div class="uk-margin-small uk-width-large" >
	<label class="uk-form-label" for="phone"><?=$lang->line('phone')?></label>
	<div class="uk-form-controls">
		<input type="text" name="phone" id="phone" value="<?=$item['phone']?>" class="uk-input uk-form-small <?=(form_error('phone') ? 'uk-form-danger' : '')?>" />
		<?=form_error('phone')?>
	</div>
</div>

<div class="uk-margin-small uk-width-large" >
	<label class="uk-form-label" for="address"><?=$lang->line('address')?></label>
	<div class="uk-form-controls">
		<input type="text" name="address" id="address" value="<?=$item['address']?>" class="uk-input uk-form-small <?=(form_error('address') ? 'uk-form-danger' : '')?>" />
		<?=form_error('address')?>
	</div>
</div>

<div class="uk-margin-small uk-width-large">
	<div class="uk-form-controls" uk-grid>
		<div class="uk-width-1-3@s">
			<select class="uk-select uk-form-small" id="city-selector" name="city_id" onchange="get_district(this);">
				<option value="" disabled><?=$lang->line('city')?></option>
				<?php foreach ($list_city as $city) { ?>
				<option value="<?=$city['id'];?>" <?=(isset($item) && ($city['id'] == $item['city_id']) ? 'selected' : '')?>><?=$city['title'];?></option>
				<?php } ?>
			</select>
			<?=form_error('city_id');?>
		</div>
		<div class="uk-width-1-3@s">
			<select class="uk-select uk-form-small" id="district-selector" name="district_id" onchange="get_ward(this);">
				<option value="" disabled><?=$lang->line('district')?></option>
				<?php foreach ($list_district as $district) { ?>
				<option value="<?=$district['id'];?>" <?=(isset($item) && ($district['id'] == $item['district_id']) ? 'selected' : '')?>><?=$district['title'];?></option>
				<?php } ?>
			</select>
			<?=form_error('district_id');?>
		</div>
		<div class="uk-width-1-3@s">
			<select class="uk-select uk-form-small" id="ward-selector" name="ward_id">
				<option value="" disabled><?=$lang->line('ward')?></option>
				<?php foreach ($list_ward as $ward) { ?>
				<option value="<?=$ward['id'];?>" <?=(isset($item) && ($ward['id'] == $item['ward_id']) ? 'selected' : '')?>><?=$ward['title'];?></option>
				<?php } ?>
			</select>
			<?=form_error('ward_id');?>
		</div>
	</div>
</div>

<div class="uk-margin-small uk-width-medium">
	<label class="uk-form-label" for="group-selector"><?=$lang->line('group')?> (*)</label>
	<div class="uk-form-controls">
		<select class="uk-select uk-form-small" id="group-selector" name="group_name">
			<option value="" disabled><?=$lang->line('select_one')?></option>
			<?php foreach ($list_group as $group): ?>
			<option value="<?=$group['name']?>" <?=(isset($item) && ($group['name'] == $item['group_name']) ? 'selected' : (isset($group_name) && ($group_name == $group['name']) ? 'selected' : ''))?>><?=$group['title']?></option>
			<?php endforeach; ?>
		</select>
		<?=form_error('group_name')?>
	</div>
</div>

<div class="uk-margin-small uk-width-medium">
	<label class="uk-form-label" for="dad-selector"><?=$lang->line('dad')?></label>
	<div class="uk-form-controls">
		<select class="uk-select uk-form-small" id="dad-selector" name="dad_id">
			<option value="" disabled><?=$lang->line('select_one')?></option>
			<?php foreach ($list_relative as $relative): ?>
			<option value="<?=$relative['id']?>" <?=(isset($item) && ($relative['id'] == $item['dad_id']) ? 'selected' : '')?>><?=$relative['name']?></option>
			<?php endforeach; ?>
		</select>
		<?=form_error('dad_id')?>
	</div>
</div>

<div class="uk-margin-small uk-width-medium">
	<label class="uk-form-label" for="mom-selector"><?=$lang->line('mom')?></label>
	<div class="uk-form-controls">
		<select class="uk-select uk-form-small" id="mom-selector" name="mom_id">
			<option value="" disabled><?=$lang->line('select_one')?></option>
			<?php foreach ($list_relative as $relative): ?>
			<option value="<?=$relative['id']?>" <?=(isset($item) && ($relative['id'] == $item['mom_id']) ? 'selected' : '')?>><?=$relative['name']?></option>
			<?php endforeach; ?>
		</select>
		<?=form_error('mom_id')?>
	</div>
</div>

<div class="uk-margin-small uk-width-medium">
	<label class="uk-form-label" for="partner-selector"><?=$lang->line('wife_husband')?></label>
	<div class="uk-form-controls">
		<select class="uk-select uk-form-small" id="partner-selector" name="partner_id">
			<option value="" disabled><?=$lang->line('select_one')?></option>
			<?php foreach ($list_relative as $relative): ?>
			<option value="<?=$relative['id']?>" <?=(isset($item) && ($relative['id'] == $item['partner_id']) ? 'selected' : '')?>><?=$relative['name']?></option>
			<?php endforeach; ?>
		</select>
		<?=form_error('partner_id')?>
	</div>
</div>

<div class="uk-margin-small uk-width-large" >
	<label class="uk-form-label" for="note"><?=$lang->line('note')?></label>
	<div class="uk-form-controls">
		<textarea name="note" id="note" rows="3" class="uk-text-small uk-textarea <?=(form_error('note') ? 'uk-form-danger' : '')?>"><?=$item['note']?></textarea>
		<?=form_error('note')?>
	</div>
</div>

<div class="uk-margin-small">
	<input type="hidden" name="id" value="<?=isset($item) ? $item['id'] : ''?>" />
	<input type="hidden" name="group" value="<?=isset($group_name) ? $group_name : ''?>" />
	<input type="hidden" name="created" value="<?=isset($item) ? $item['created'] : ''?>" />
	<button class="uk-button uk-button-small uk-button-secondary" type="submit" name="submit" value="save_back"><?=$lang->line('save_back')?></button>
	<button class="uk-button uk-button-small uk-button-primary" type="submit" name="submit" value="save"><?=$lang->line('save')?></button>
	<a class="uk-button uk-button-small" name="btn-back" href="<?=$link_back?>"><?=$lang->line('back')?></a>
</div>

</form>
