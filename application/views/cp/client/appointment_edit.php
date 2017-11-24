<link rel="stylesheet" href="<?=base_url(F_PUB .F_CP .'datetimepicker/jquery.datetimepicker.min.css')?>"/>
<script src="<?=base_url(F_PUB .F_CP .'datetimepicker/jquery.datetimepicker.full.min.js')?>"></script>

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

<div class="uk-margin-small uk-width-large" >
	<label class="uk-form-label" for="name"><?=$lang->line('name')?> (*)</label>
	<div class="uk-form-controls">
		<input type="text" name="name" id="name" value="<?=isset($item) ? $item['name'] : ''?>" class="uk-input uk-form-small <?=(form_error('name') ? 'uk-form-danger' : '')?>" />
		<?=form_error('name')?>
	</div>
</div>

<div class="uk-margin-small uk-width-large" >
	<label class="uk-form-label" for="email"><?=$lang->line('email')?> (*)</label>
	<div class="uk-form-controls">
		<input type="text" name="email" id="email" value="<?=isset($item) ? $item['email'] : ''?>" class="uk-input uk-form-small <?=(form_error('email') ? 'uk-form-danger' : '')?>" />
		<?=form_error('email')?>
	</div>
</div>

<div class="uk-margin-small uk-width-large" >
	<label class="uk-form-label" for="phone"><?=$lang->line('phone')?> (*)</label>
	<div class="uk-form-controls">
		<input type="text" name="phone" id="phone" value="<?=isset($item) ? $item['phone'] : ''?>" class="uk-input uk-form-small <?=(form_error('name') ? 'uk-form-danger' : '')?>" />
		<?=form_error('phone')?>
	</div>
</div>

<div class="uk-margin-small uk-width-large" >
	<label class="uk-form-label" for="address"><?=$lang->line('address')?> (*)</label>
	<div class="uk-form-controls">
		<input type="text" name="address" id="address" value="<?=isset($item) ? $item['address'] : ''?>" class="uk-input uk-form-small <?=(form_error('name') ? 'uk-form-danger' : '')?>" />
		<?=form_error('address')?>
	</div>
</div>

<div class="uk-margin-small uk-width-large" >
	<label class="uk-form-label" for="time"><?=$lang->line('time')?> (*)</label>
	<div class="uk-form-controls">
		<input type="text" name="time" id="time" value="<?=isset($item) ? $item['time'] : ''?>" class="uk-input uk-form-small <?=(form_error('time') ? 'uk-form-danger' : '')?>" />
		<?=form_error('time')?>
	</div>
</div>

<script>
$('#time').datetimepicker({
	inline: true,
	defaultSelect: false
});
</script>

<div class="uk-margin-small uk-width-large" >
	<label class="uk-form-label" for="summary"><?=$lang->line('summary')?></label>
	<div class="uk-form-controls">
		<input type="text" name="summary" id="summary" value="<?=isset($item) ? $item['summary'] : ''?>" class="uk-input uk-form-small <?=(form_error('summary') ? 'uk-form-danger' : '')?>" />
		<?=form_error('summary')?>
	</div>
</div>

<div class="uk-margin-small uk-width-xlarge">
	<label class="uk-form-label" for="content"><?=$lang->line('content')?> (*)</label>
	<div class="uk-form-controls">
		<textarea type="text" name="content" id="content" rows="5" class="uk-text-small uk-textarea <?=(form_error('content') ? 'uk-form-danger' : '')?>"><?=isset($item) ? $item['content'] : ''?></textarea>
		<?=form_error('content')?>
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

<script>
	AlloyEditor.editable('content');
</script>

<div class="uk-margin-small">
	<input type="hidden" name="id" value="<?=isset($item) ? $item['id'] : ''?>" />
	<input type="hidden" name="created" value="<?=isset($item) ? $item['created'] : ''?>" />
	<button class="uk-button uk-button-small uk-button-primary" type="submit" name="submit" value="save"><?=$lang->line('save')?></button>
	<button class="uk-button uk-button-small uk-button-secondary" type="submit" name="submit" value="save_back"><?=$lang->line('save_back')?></button>
	<a class="uk-button uk-button-small" name="btn-back" href="<?=$link_back?>"><?=$lang->line('back')?></a>
</div>

</form>
