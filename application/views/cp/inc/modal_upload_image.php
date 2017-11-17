<div id="image-uploader" uk-modal>
	<div class="uk-modal-dialog uk-width-xlarge">
		<button class="uk-modal-close-default" type="button" uk-close></button>
		<div class="uk-modal-body uk-height-large">
			<iframe id="image-uploader-frame" width="100%" height="100%" src="<?=base_url('cp/upload/image');?>"></iframe>
		</div>
	</div>
</div>

<script>
if ($('#avatar-filename').val()) {
	$('#avatar-container').show();
}
else {
	$('#non-avatar-container').show();
}

var imageUploader = UIkit.modal('#image-uploader');

$('#image-uploader').on('show', function() {
});

$('#image-uploader').on('hide', function() {
	$('#image-uploader-frame').attr('src', $('#image-uploader-frame').attr('src'));
});

var changeAvatar = function() {
	imageUploader.show();
};

var addAvatar = function() {
	imageUploader.show();
};

var removeAvatar = function() {
	$('#avatar-img').removeAttr('src');
	$('#avatar-id').val('');
	$('#avatar-filename').val('');
	$('#avatar-container').hide();
	$('#non-avatar-container').show();
};

window.insertImage = function(img) {
	if (img.id && img.url) {
		$('#avatar-img').attr('src', img.url);
		$('#avatar-filename').val(img.filename);
		$('#avatar-id').val(img.id);
		$('#avatar-container').show();
		$('#non-avatar-container').hide();
	}

	imageUploader.hide();
};
</script>