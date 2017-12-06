<script src="<?=base_url(F_PUB .F_CP .'js/mustache.min.js')?>"></script>

<div id="media-insert" class="uk-modal-full" uk-modal>
	<div class="uk-modal-dialog uk-overflow-auto uk-height-viewport">
		<button class="uk-modal-close-full uk-close-large" type="button" uk-close></button>
		<iframe id="media-insert-frame" class="uk-height-viewport uk-padding" width="100%" src=""></iframe>
	</div>
</div>

<script id="avatar_template" type="x-tmpl-mustache">
	<div class="media uk-card uk-card-small uk-card-default uk-card-body uk-padding-small">
		<div class="media-head media-head-max-height">
			{{{avatar}}}
		</div>
	</div>
</script>

<script>
var avatar_template = $('#avatar_template').html();
Mustache.parse(avatar_template);

var avatar = $('#avatar');

var avatar_media = {
	id: <?=isset($item) ? $item["avatar_id"] : ""?>,
	url: '<?=isset($item) ? $item["avatar_url"] : ""?>',
	type: '<?=isset($item) ? $item["avatar_type"] : ""?>',
	file_ext: '<?=isset($item) ? $item["avatar_file_ext"] : ""?>'
};

if (avatar_media.id) {
	$('#avatar-container').show();
}
else {
	$('#non-avatar-container').show();
}

var set_avatar = function() {
	if (media_insert_frame.attr('src') != '<?=base_url(F_CP ."media/insert?multi_select=0&callback=insert_avatar")?>') {
		media_insert_frame.attr('src', '<?=base_url(F_CP ."media/insert?multi_select=0&callback=insert_avatar")?>');
	}

	media_inserter.show();
};

var remove_avatar = function() {
	avatar.html('');

	$('input[name=avatar_id]').val('');
	$('input[name=avatar_url]').val('');
	$('input[name=avatar_type]').val('');
	$('input[name=avatar_file_ext]').val('');

	$('#avatar-container').hide();
	$('#non-avatar-container').show();
};

var avatar_generate = function() {
	var avatar;
	switch (this.type) {
		case '<?=MT_IMAGE?>':
			avatar = '<img src="' + this.url + '">';
		break;
		case '<?=MT_VIDEO?>':
			avatar = '<video controls><source src="' + this.url + '" type="video/mp4">Your browser does not support the video tag.</video>';
		break;
		case '<?=MT_AUDIO?>':
			avatar = '<audio controls><source src="' + this.url + '" type="audio/mpeg">Your browser does not support the audio tag.</audio>';
		break;
		case '<?=MT_FLASH?>':
			avatar = '<i class="fa fa-bolt" aria-hidden="true"></i>';
		break;
		case '<?=MT_ATTACH?>':
			switch (this.file_ext) {
				case 'xls':
				case 'xlsx':
					avatar = '<a href="javascript:void(0);"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>';
				break;
				case 'doc':
				case 'docx':
					avatar = '<a href="javascript:void(0);"><i class="fa fa-file-word-o" aria-hidden="true"></i></a>';
				break;
				case 'ppt':
				case 'pptx':
					avatar = '<a href="javascript:void(0);"><i class="fa fa-file-powerpoint-o" aria-hidden="true"></i></a>';
				break;
				case 'pdf':
					avatar = '<a href="javascript:void(0);"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>';
				break;
				case 'zip':
					avatar = '<a href="javascript:void(0);"><i class="fa fa-file-archive-o" aria-hidden="true"></i></a>';
				break;
			}
		break;
	}
	return avatar;
}

var show_avatar = function(media) {
	if (!media.id) {
		return;
	}

	media.avatar = avatar_generate;
	avatar.html(Mustache.render(avatar_template, media));

	$('input[name=avatar_id]').val(media.id);
	$('input[name=avatar_url]').val(media.url);
	$('input[name=avatar_type]').val(media.type);
	$('input[name=avatar_file_ext]').val(media.file_ext);

	$('#avatar-container').show();
	$('#non-avatar-container').hide();
}

show_avatar(avatar_media);

var media_inserter = UIkit.modal('#media-insert');
var media_insert_frame = $('#media-insert-frame');

$('#media-insert').on('show', function() {
});

$('#media-insert').on('hide', function() {
	media_insert_frame.attr('src', media_insert_frame.attr('src'));
});

window.insert_avatar = function(media_list) {
	var media = media_list[0];

	if (media.id && media.url) {
		show_avatar(media);
	}

	media_inserter.hide();
};
</script>