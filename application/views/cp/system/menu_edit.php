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

<div class="uk-margin-small uk-width-medium">
	<label class="uk-form-label" for="site_selector"><?=$lang->line('site')?> (*)</label>
	<div class="uk-form-controls">
		<select class="uk-select uk-form-small" id="site-selector" name="site_id">
			<option value="" disabled><?=$lang->line('select_one')?></option>
			<?php foreach ($list_site as $site) { ?>
			<option value="<?=$site['id']?>" <?=(isset($item) && ($site['id'] == $item['site_id']) ? 'selected' : '')?>><?=$site['title']?></option>
			<?php } ?>
		</select>
		<?=form_error('site_id')?>
	</div>
</div>

<div class="uk-margin-small">
	<input type="hidden" name="id" value="<?=isset($item) ? $item['id'] : ''?>" />
	<input type="hidden" name="created" value="<?=isset($item) ? $item['created'] : ''?>" />
	<button class="uk-button uk-button-small uk-button-primary" type="submit" name="submit" value="save"><?=$lang->line('save')?></button>
	<button class="uk-button uk-button-small uk-button-secondary" type="submit" name="submit" value="save_back"><?=$lang->line('save_back')?></button>
	<a class="uk-button uk-button-small" name="btn-back" href="<?=$link_back?>"><?=$lang->line('back')?></a>
</div>

</form>
