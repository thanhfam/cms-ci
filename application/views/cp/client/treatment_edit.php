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

<div class="uk-margin-small uk-width-medium" >
	<label class="uk-form-label" for="date_consult"><?=$lang->line('date_consult')?></label>
	<div class="uk-form-controls">
		<input type="text" name="date_consult" id="date_consult" value="<?=$item['date_consult']?>" class="uk-input uk-form-small <?=(form_error('date_consult') ? 'uk-form-danger' : '')?>" />
		<?=form_error('date_consult')?>
	</div>
	<div class="uk-text-meta uk-margin-small">
		<p><?=$lang->line('date_format_description')?></p>
	</div>
</div>

<div class="uk-margin-small uk-width-medium" >
	<label class="uk-form-label" for="date_exam"><?=$lang->line('date_exam')?></label>
	<div class="uk-form-controls">
		<input type="text" name="date_exam" id="date_exam" value="<?=$item['date_exam']?>" class="uk-input uk-form-small <?=(form_error('date_exam') ? 'uk-form-danger' : '')?>" />
		<?=form_error('date_exam')?>
	</div>
	<div class="uk-text-meta uk-margin-small">
		<p><?=$lang->line('date_format_description')?></p>
	</div>
</div>

<div class="uk-margin-small uk-width-medium" >
	<label class="uk-form-label" for="code"><?=$lang->line('code')?></label>
	<div class="uk-form-controls">
		<input type="text" name="code" id="code" value="<?=$item['code']?>" class="uk-input uk-form-small <?=(form_error('code') ? 'uk-form-danger' : '')?>" />
		<?=form_error('code')?>
	</div>
</div>

<div class="uk-margin-small uk-width-medium">
	<label class="uk-form-label" for="customer-1-selector"><?=$lang->line('customer')?> 1</label>
	<div class="uk-form-controls">
		<select class="uk-select uk-form-small" id="customer-1-selector" name="customer_1_id">
			<option value="" disabled><?=$lang->line('select_one')?></option>
			<?php foreach ($list_customer as $customer): ?>
			<option value="<?=$customer['id']?>" <?=(isset($item) && ($customer['id'] == $item['customer_1_id']) ? 'selected' : '')?>><?=$customer['name']?></option>
			<?php endforeach; ?>
		</select>
		<?=form_error('customer_1_id')?>
	</div>
</div>

<div class="uk-margin-small uk-width-medium">
	<label class="uk-form-label" for="customer-2-selector"><?=$lang->line('customer')?> 2</label>
	<div class="uk-form-controls">
		<select class="uk-select uk-form-small" id="customer-2-selector" name="customer_2_id">
			<option value="" disabled><?=$lang->line('select_one')?></option>
			<?php foreach ($list_customer as $customer): ?>
			<option value="<?=$customer['id']?>" <?=(isset($item) && ($customer['id'] == $item['customer_2_id']) ? 'selected' : '')?>><?=$customer['name']?></option>
			<?php endforeach; ?>
		</select>
		<?=form_error('customer_2_id')?>
	</div>
</div>

<div class="uk-margin-small uk-width-medium">
	<label class="uk-form-label" for="hospital-selector"><?=$lang->line('hospital')?></label>
	<div class="uk-form-controls">
		<select class="uk-select uk-form-small" id="hospital-selector" name="hospital_id">
			<option value="" disabled><?=$lang->line('select_one')?></option>
			<?php foreach ($list_hospital as $hospital): ?>
			<option value="<?=$hospital['id']?>" <?=(isset($item) && ($hospital['id'] == $item['hospital_id']) ? 'selected' : '')?>><?=$hospital['display_title']?></option>
			<?php endforeach; ?>
		</select>
		<?=form_error('hospital_id')?>
	</div>
</div>

<div class="uk-margin-small uk-width-medium">
	<label class="uk-form-label" for="service-selector"><?=$lang->line('service')?></label>
	<div class="uk-form-controls">
		<select class="uk-select uk-form-small" id="service-selector" name="service_id" onchange="extract_service(this);">
			<option value="" disabled><?=$lang->line('select_one')?></option>
			<?php foreach ($list_service as $service): ?>
			<option value="<?=$service['id']?>" <?=(isset($item) && ($service['id'] == $item['service_id']) ? 'selected' : '')?> data-title="<?=$service['title']?>" data-price="<?=$service['weight']?>" data-name="<?=$service['name']?>"><?=$service['display_title']?></option>
			<?php endforeach; ?>
		</select>
		<?=form_error('service_id')?>
	</div>
</div>

<div class="uk-margin-small uk-width-medium" >
	<label class="uk-form-label" for="service-title"><?=$lang->line('service_name')?></label>
	<div class="uk-form-controls">
		<input type="text" name="service_title" id="service-title" value="<?=$item['service_title']?>" class="uk-input uk-form-small <?=(form_error('service_title') ? 'uk-form-danger' : '')?>" />
		<?=form_error('service_title')?>
	</div>
</div>

<div class="uk-margin-small uk-width-medium" >
	<label class="uk-form-label" for="service-price"><?=$lang->line('price')?></label>
	<div class="uk-form-controls">
		<input type="text" name="service_price" id="service-price" value="<?=$item['service_price']?>" class="uk-input uk-form-small <?=(form_error('service_price') ? 'uk-form-danger' : '')?>" />
		<?=form_error('service_price')?>
	</div>
</div>

<div class="uk-margin-small uk-width-medium">
	<label class="uk-form-label" for="agency-selector"><?=$lang->line('agency')?></label>
	<div class="uk-form-controls">
		<select class="uk-select uk-form-small" id="agency-selector" name="agency_id">
			<option value="" disabled><?=$lang->line('select_one')?></option>
			<?php foreach ($list_agency as $agency): ?>
			<option value="<?=$agency['id']?>" <?=(isset($item) && ($agency['id'] == $item['agency_id']) ? 'selected' : '')?>><?=$agency['name']?></option>
			<?php endforeach; ?>
		</select>
		<?=form_error('agency_id')?>
	</div>
</div>

<div class="uk-margin-small uk-width-medium">
	<label class="uk-form-label" for="staff-selector"><?=$lang->line('staff')?></label>
	<div class="uk-form-controls">
		<select class="uk-select uk-form-small" id="staff-selector" name="staff_id">
			<option value="" disabled><?=$lang->line('select_one')?></option>
			<?php foreach ($list_staff as $staff): ?>
			<option value="<?=$staff['id']?>" <?=(isset($item) && ($staff['id'] == $item['staff_id']) ? 'selected' : '')?>><?=$staff['name']?></option>
			<?php endforeach; ?>
		</select>
		<?=form_error('staff_id')?>
	</div>
</div>

<div class="uk-margin-small">
	<input type="hidden" name="id" value="<?=isset($item) ? $item['id'] : ''?>" />
	<input type="hidden" name="created" value="<?=isset($item) ? $item['created'] : ''?>" />
	<button class="uk-button uk-button-small uk-button-secondary" type="submit" name="submit" value="save_back"><?=$lang->line('save_back')?></button>
	<button class="uk-button uk-button-small uk-button-primary" type="submit" name="submit" value="save"><?=$lang->line('save')?></button>
	<a class="uk-button uk-button-small" name="btn-back" href="<?=$link_back?>"><?=$lang->line('back')?></a>
</div>

</form>

<script>
var extract_service = function(e) {
	var f_service_title = $('#service-title');
	var f_service_price = $('#service-price');

	var o_service = (e.options[e.selectedIndex]);

	if (!o_service) {
		return false;
	}

	var service_title = o_service.getAttribute('data-title');
	var service_price = o_service.getAttribute('data-price');

	f_service_title.val(service_title);
	f_service_price.val(service_price);
};
</script>