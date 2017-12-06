<?php
if (isset($item) && !empty($item['created'])) {
?>
<div class="uk-margin-small time">
	<div class="created"><?=$lang->line('created_at') . $item['created']?></div>
	<div class="udpated"><?=$lang->line('updated_at') . $item['updated']?></div>
</div>
<?php
}
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
	<label class="uk-form-label" for="subtitle"><?=$lang->line('subtitle')?></label>
	<div class="uk-form-controls">
		<input type="text" name="subtitle" id="subtitle" value="<?=isset($item) ? $item['subtitle'] : ''?>" class="uk-input uk-form-small <?=(form_error('subtitle') ? 'uk-form-danger' : '')?>" />
		<?=form_error('subtitle')?>
	</div>
</div>

<div class="uk-margin-small uk-width-large">
	<label class="uk-form-label" for="name"><?=$lang->line('name')?></label>
	<div class="uk-form-controls">
		<input type="text" name="name" id="name" value="<?=isset($item) ? $item['name'] : ''?>" class="uk-input uk-form-small <?=(form_error('name') ? 'uk-form-danger' : '')?>" />
		<?=form_error('name')?>
	</div>
</div>

<div class="uk-margin-small uk-width-large">
	<label class="uk-form-label" for="url"><?=$lang->line('url')?></label>
	<div class="uk-form-controls">
		<input type="text" name="url" id="url" value="<?=isset($item) ? $item['url'] : ''?>" class="uk-input uk-form-small <?=(form_error('url') ? 'uk-form-danger' : '')?>" />
		<?=form_error('url')?>
	</div>
</div>

<div class="uk-margin-small uk-width-xlarge">
	<label class="uk-form-label" for="avatar"><?=$lang->line('avatar')?></label>
	<div class="uk-form-controls">
		<?php
			$this->load->view(F_CP .'inc/avatar');
		?>
	</div>
</div>

<div class="uk-margin-small uk-width-large">
	<label class="uk-form-label" for="language"><?=$lang->line('language')?></label>
	<div class="uk-form-controls">
		<input type="text" name="language" id="language" value="<?=isset($item) ? $item['language'] : ''?>" class="uk-input uk-form-small <?=(form_error('language') ? 'uk-form-danger' : '')?>" />
		<?=form_error('language')?>
	</div>
</div>

<div class="uk-margin-small uk-width-large">
	<label class="uk-form-label" for="facebook"><?=$lang->line('facebook')?></label>
	<div class="uk-form-controls">
		<input type="text" name="facebook" id="facebook" value="<?=isset($item) ? $item['facebook'] : ''?>" class="uk-input uk-form-small <?=(form_error('facebook') ? 'uk-form-danger' : '')?>" />
		<?=form_error('facebook')?>
	</div>
</div>

<div class="uk-margin-small uk-width-large">
	<label class="uk-form-label" for="twitter"><?=$lang->line('twitter')?></label>
	<div class="uk-form-controls">
		<input type="text" name="twitter" id="twitter" value="<?=isset($item) ? $item['twitter'] : ''?>" class="uk-input uk-form-small <?=(form_error('twitter') ? 'uk-form-danger' : '')?>" />
		<?=form_error('twitter')?>
	</div>
</div>

<div class="uk-margin-small uk-width-large">
	<label class="uk-form-label" for="pinterest"><?=$lang->line('pinterest')?></label>
	<div class="uk-form-controls">
		<input type="text" name="pinterest" id="pinterest" value="<?=isset($item) ? $item['pinterest'] : ''?>" class="uk-input uk-form-small <?=(form_error('pinterest') ? 'uk-form-danger' : '')?>" />
		<?=form_error('pinterest')?>
	</div>
</div>

<div class="uk-margin-small uk-width-large">
	<label class="uk-form-label" for="gplus"><?=$lang->line('gplus')?></label>
	<div class="uk-form-controls">
		<input type="text" name="gplus" id="gplus" value="<?=isset($item) ? $item['gplus'] : ''?>" class="uk-input uk-form-small <?=(form_error('gplus') ? 'uk-form-danger' : '')?>" />
		<?=form_error('gplus')?>
	</div>
</div>

<div class="uk-margin-small uk-width-large">
	<label class="uk-form-label" for="linkedin"><?=$lang->line('linkedin')?></label>
	<div class="uk-form-controls">
		<input type="text" name="linkedin" id="linkedin" value="<?=isset($item) ? $item['linkedin'] : ''?>" class="uk-input uk-form-small <?=(form_error('linkedin') ? 'uk-form-danger' : '')?>" />
		<?=form_error('linkedin')?>
	</div>
</div>

<div class="uk-margin-small">
	<input type="hidden" name="id" value="<?=isset($item) ? $item['id'] : ''?>" />
	<input type="hidden" name="created" value="<?=isset($item) ? $item['created'] : ''?>" />
	<button class="uk-button uk-button-small uk-button-primary" type="submit" name="submit" value="save"><?=$lang->line('save')?></button>
	<a class="uk-button uk-button-small" name="btn-back" href="<?=$link_back?>"><?=$lang->line('back')?></a>
</div>

</form>

<?php
	$this->load->view(F_CP .'inc/modal_media');
