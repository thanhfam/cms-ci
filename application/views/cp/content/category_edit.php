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

<div uk-grid>
<div class="uk-width-2-3@m">
<div class="container uk-padding-small uk-background-muted">
	<div class="uk-margin-small">
		<label class="uk-form-label" for="subtitle"><?=$lang->line('subtitle')?></label>
		<div class="uk-form-controls">
			<input type="text" name="subtitle" id="subtitle" value="<?=isset($item) ? $item['subtitle'] : ''?>" class="uk-input uk-form-small <?=(form_error('subtitle') ? 'uk-form-danger' : '')?>" />
			<?=form_error('subtitle')?>
		</div>
	</div>

	<div class="uk-margin-small">
		<label class="uk-form-label" for="title"><?=$lang->line('title')?> (*)</label>
		<div class="uk-form-controls">
			<input type="text" name="title" id="title" value="<?=isset($item) ? $item['title'] : ''?>" class="uk-input uk-form-small <?=(form_error('title') ? 'uk-form-danger' : '')?>" />
			<?=form_error('title')?>
		</div>
	</div>

	<div class="uk-margin-small" >
		<label class="uk-form-label" for="name"><?=$lang->line('name')?></label>
		<div class="uk-form-controls">
			<input type="text" name="name" id="name" value="<?=isset($item) ? $item['name'] : ''?>" class="uk-input uk-form-small <?=(form_error('name') ? 'uk-form-danger' : '')?>" />
			<?=form_error('name')?>
		</div>
	</div>

	<div class="uk-margin-small">
		<label class="uk-form-label" for="uri"><?=$lang->line('uri')?></label>
		<div class="uk-form-controls">
			<input type="text" name="uri" id="uri" value="<?=isset($item) ? $item['uri'] : ''?>" class="uk-input uk-form-small <?=(form_error('uri') ? 'uk-form-danger' : '')?>" />
			<?=form_error('uri')?>
		</div>
	</div>

	<div class="uk-margin-small" >
		<label class="uk-form-label" for="lead"><?=$lang->line('lead')?></label>
		<div class="uk-form-controls">
			<textarea type="text" name="lead" id="lead" rows="3" class="uk-text-small uk-textarea <?=(form_error('lead') ? 'uk-form-danger' : '')?>"><?=isset($item) ? $item['lead'] : ''?></textarea>
			<?=form_error('lead')?>
		</div>
	</div>

	<div class="uk-margin-small" >
		<label class="uk-form-label" for="content"><?=$lang->line('content')?></label>
		<div class="uk-form-controls">
			<textarea type="text" name="content" id="content" rows="10" class="uk-text-small uk-textarea <?=(form_error('content') ? 'uk-form-danger' : '')?>"><?=isset($item) ? $item['content'] : ''?></textarea>
			<?=form_error('content')?>
		</div>
	</div>

	<script>
		//AlloyEditor.editable('content');
	</script>

	<div class="uk-margin-small">
		<label class="uk-form-label" for="cate-selector"><?=$lang->line('category')?></label>
		<div class="uk-form-controls">
			<select class="uk-select uk-form-small uk-form-width-medium" id="cate-selector" name="cate_id">
				<option value="" disabled><?=$lang->line('select_one')?></option>
				<?php foreach ($list_category as $category) { ?>
				<option value="<?=$category['id']?>" <?=(isset($item) && ($category['id'] == $item['cate_id']) ? 'selected' : '')?>><?=$category['title']?></option>
				<?php } ?>
			</select>
			<?=form_error('cate_id')?>
		</div>
	</div>

	<div class="uk-margin-small">
		<label class="uk-form-label" for="state-selector"><?=$lang->line('state')?></label>
		<div class="uk-form-controls">
			<select class="uk-select uk-form-small uk-form-width-medium" id="state-selector" name="state_weight">
				<option value="" disabled><?=$lang->line('select_one')?></option>
				<?php foreach ($list_state as $state) { ?>
				<option value="<?=$state['weight']?>" <?=(isset($item) && ($state['weight'] == $item['state_weight']) ? 'selected' : '')?>><?=$lang->line($state['name']) ? $lang->line($state['name']) : $state['name']?> (<?=$state['weight']?>)</option>
				<?php } ?>
			</select>
			<?=form_error('state_weight')?>
		</div>
	</div>

	<div class="uk-margin-small ">
		<input type="hidden" name="id" value="<?=isset($item) ? $item['id'] : ''?>" />
		<input type="hidden" name="created" value="<?=isset($item) ? $item['created'] : ''?>" />
		<button class="uk-button uk-button-small uk-button-primary" type="submit" name="submit" value="save"><?=$lang->line('save')?></button>
		<button class="uk-button uk-button-small uk-button-secondary" type="submit" name="submit" value="save_back"><?=$lang->line('save_back')?></button>
		<a class="uk-button uk-button-small" name="btn-back" href="<?=$link_back?>"><?=$lang->line('back')?></a>
	</div>
</div>
</div>

<div class="uk-width-1-3@m">
<div class="container uk-padding-small uk-background-muted">
	<div class="uk-margin-small">
		<label class="uk-form-label" for="type"><?=$lang->line('type')?></label>
		<div class="uk-form-controls">
			<input type="text" name="type" id="type" value="<?=isset($item) ? $item['type'] : ''?>" class="uk-input uk-form-small <?=(form_error('type') ? 'uk-form-danger' : '')?>" />
			<?=form_error('type')?>
		</div>
	</div>

	<div class="uk-margin-small" >
		<label class="uk-form-label" for="description"><?=$lang->line('description')?></label>
		<div class="uk-form-controls">
			<textarea type="text" name="description" id="description" rows="2" class="uk-text-small uk-textarea <?=(form_error('description') ? 'uk-form-danger' : '')?>"><?=isset($item) ? $item['description'] : ''?></textarea>
			<?=form_error('description')?>
		</div>
	</div>

	<div class="uk-margin-small" >
		<label class="uk-form-label" for="keywords"><?=$lang->line('keywords')?></label>
		<div class="uk-form-controls">
			<textarea type="text" name="keywords" id="keywords" rows="2" class="uk-text-small uk-textarea <?=(form_error('keywords') ? 'uk-form-danger' : '')?>"><?=isset($item) ? $item['keywords'] : ''?></textarea>
			<?=form_error('keywords')?>
		</div>
	</div>

	<div class="uk-margin-small">
		<label class="uk-form-label" for="cate-layout-selector"><?=$lang->line('cate_layout')?></label>
		<div class="uk-form-controls">
			<select class="uk-select uk-form-small uk-form-width-medium" id="cate-layout-selector" name="cate_layout_id">
				<option value="" disabled><?=$lang->line('select_one')?></option>
				<?php foreach ($list_layout as $layout) { ?>
				<option value="<?=$layout['id']?>" <?=(isset($item) && ($layout['id'] == $item['cate_layout_id']) ? 'selected' : '')?>><?=$layout['name']?></option>
				<?php } ?>
			</select>
			<?=form_error('cate_layout_id')?>
		</div>
	</div>

	<div class="uk-margin-small">
		<label class="uk-form-label" for="post-layout-selector"><?=$lang->line('post_layout')?></label>
		<div class="uk-form-controls">
			<select class="uk-select uk-form-small uk-form-width-medium" id="post-layout-selector" name="post_layout_id">
				<option value="" disabled><?=$lang->line('select_one')?></option>
				<?php foreach ($list_layout as $layout) { ?>
				<option value="<?=$layout['id']?>" <?=(isset($item) && ($layout['id'] == $item['post_layout_id']) ? 'selected' : '')?>><?=$layout['name']?></option>
				<?php } ?>
			</select>
			<?=form_error('cate_layout_id')?>
		</div>
	</div>
</div>
</div>



</div>
</form>
