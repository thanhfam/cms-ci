<?php
if (isset($item) && !empty($item['created'])) {
?>
<div class="uk-margin-small time">
	<div class="created"><?=$lang->line('created_at') . $item['created'];?></div>
	<div class="udpated"><?=$lang->line('updated_at') . $item['updated'];?></div>
</div>
<?php
}
?>

<form method="post" accept-charset="utf-8" action="<?=current_url()?>" class="uk-form-stacked">

<div class="uk-margin-small uk-width-large">
	<label class="uk-form-label" for="name"><?=$lang->line('name')?></label>
	<div class="uk-form-controls">
		<input type="text" name="name" id="name" value="<?=isset($item) ? $item['name'] : '';?>" class="uk-input uk-form-small <?=(form_error('name') ? 'uk-form-danger' : '');?>" />
		<?=form_error('name');?>
	</div>
</div>

<div class="uk-margin-small uk-width-large">
	<label class="uk-form-label" for="weight"><?=$lang->line('weight')?></label>
	<div class="uk-form-controls">
		<input type="text" name="weight" id="weight" value="<?=isset($item) ? $item['weight'] : '';?>" class="uk-input uk-form-small <?=(form_error('weight') ? 'uk-form-danger' : '');?>" />
		<?=form_error('weight');?>
	</div>
</div>

<div class="uk-margin-small">
	<input type="hidden" name="id" value="<?=isset($item) ? $item['id'] : '';?>" />
	<input type="hidden" name="created" value="<?=isset($item) ? $item['created'] : '';?>" />
	<button class="uk-button uk-button-small uk-button-primary" type="submit" name="submit" value="save"><?=$lang->line('save');?></button>
	<a class="uk-button uk-button-small" name="btn-back" href="<?=$link_back;?>"><?=$lang->line('back');?></a>
</div>

</form>
