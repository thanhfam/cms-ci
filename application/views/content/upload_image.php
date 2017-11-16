<div classs="uk-grid-small uk-child-width-expand@s uk-grid-divider" uk-grid>

	<?php if (isset($item['filename']) && ($item['filename'] != '')) { ?>
	<div>
		<img src="<?=base_url('/file/' .$item['filename']);?>" id="image-url" class="uk-height-small uk-margin-small" />
	</div>
	<?php } ?>
	<div>
	<form method="post" accept-charset="utf-8" action="<?=current_url()?>" class="uk-form-stacked" enctype="multipart/form-data">

		<div class="uk-margin-small uk-child-width-auto" >
			<label class="uk-form-label" for="image"><?=$lang->line('select_image')?></label>
			<div class="uk-form-controls">
				<input type="file" name="image" id="image" class="uk-input uk-form-small <?=(isset($file_error) ? 'uk-form-danger' : '');?>" />
				<?=isset($file_error) ? '<div class="input-field-invalid">' .$file_error .'</div>': '';?>
			</div>
		</div>

		<div class="uk-margin-small uk-child-width-auto" >
			<label class="uk-form-label" for="content"><?=$lang->line('content')?></label>
			<div class="uk-form-controls">
				<textarea type="text" name="content" id="content" class="uk-textarea uk-form-small <?=(form_error('content') ? 'uk-form-danger' : '');?>"><?=isset($item) ? $item['content'] : '';?></textarea>
				<?=form_error('content');?>
			</div>
		</div>

		<div class="uk-margin-small">
			<input type="hidden" id="image-id" name="id" value="<?=isset($item) ? $item['id'] : '';?>" />
			<input type="hidden" id="image-filename" name="filename" value="<?=isset($item) ? $item['filename'] : '';?>" />
			<input type="hidden" name="created" value="<?=isset($item) ? $item['created'] : '';?>" />
			<button class="uk-button uk-button-small uk-button-default" type="submit" name="submit" value="save"><?=$lang->line('upload');?></button>
			<button class="uk-button uk-button-small uk-button-primary" onclick="useImage(this);" type="button"><?=$lang->line('use');?></button>
		</div>

	</form>
	</div>
</div>

<script>
var useImage = function() {
	if (window.self == window.top) {
		return;
	}

	var img = {
		id: $('#image-id').val(),
		filename: $('#image-filename').val(),
		url: $('#image-url').attr('src')
	};

	if (img.id && img.url) {
		if (window.parent && window.parent.insertImage) {
			window.parent.insertImage(img);
		}
	}
}
</script>