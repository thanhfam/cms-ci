<script src="<?=base_url(F_PUB .F_CP .'js/mustache.min.js')?>"></script>

<div id="media-insert" class="uk-modal-full" uk-modal>
	<div class="uk-modal-dialog uk-overflow-auto uk-height-viewport">
		<button class="uk-modal-close-full uk-close-large" type="button" uk-close></button>
		<iframe id="media-insert-frame" class="uk-height-viewport uk-padding" width="100%" src=""></iframe>
	</div>
</div>

<script id="no_media_template" type="x-tmpl-mustache">
<li>
<div class="media uk-card uk-card-small uk-card-default uk-card-body uk-text-center">
	<div class="media-head">
		<button class="uk-button uk-button-small uk-button-primary" type="button" onclick="add_media(this);"><?=$lang->line('add')?></button>
	</div>
</div>
</li>
</script>

<script id="media_template" type="x-tmpl-mustache">
{{#list}}
	<li>
	<div class="media uk-card uk-card-small uk-card-default uk-card-body uk-text-center">
		<div class="media-head uk-margin-small">
			{{{presentation}}}
		</div>
		<button class="uk-button uk-button-small uk-button-danger" type="button" onclick="remove_media(this);"><?=$lang->line('remove')?></button>
	</div>
	<input type="hidden" name="{{name}}_id[]" value="{{id}}" />
	<input type="hidden" name="{{name}}_type[]" value="{{type}}" />
	<input type="hidden" name="{{name}}_file_ext[]" value="{{file_ext}}" />
	<input type="hidden" name="{{name}}_url[]" value="{{url}}" />
	<input type="hidden" name="{{name}}_url_opt[]" value="{{url}}" />
	<input type="hidden" name="{{name}}_url_ori[]" value="{{url}}" />
	</li>
{{/list}}
</script>

<script>
var media_template = $('#media_template').html();
Mustache.parse(media_template);

var no_media_template = $('#no_media_template').html();
Mustache.parse(no_media_template);

var remove_media = function(e) {
	var container = $(e).closest('.media-container');

	var media = $(e).closest('li');
	media.remove();

	if (!container.children().length) {
		show_no_media(container);
	}
}

var add_media = function(e, select_mode) {
	var container = $(e).closest('.media-container')

	if (container.length) {
		window.container = container;
	}
	else {
		console.error("You have to specify a .media-container");
		exit();
	}

	select_mode = container.attr('data-select-mode');

	if (parseInt(select_mode)) {
		select_mode = 1;
	}
	else {
		select_mode = 0;
	}

	var frame_url = '<?=base_url(F_CP ."media/insert?multi_select=' + select_mode + '&callback=insert_media")?>';

	if (media_insert_frame.attr('src') != frame_url) {
		media_insert_frame.attr('src', frame_url);
	}

	media_inserter.show();
};

var media_inserter = UIkit.modal('#media-insert');
var media_insert_frame = $('#media-insert-frame');

$('#media-insert').on('show', function() {
});

$('#media-insert').on('hide', function() {
	media_insert_frame.attr('src', media_insert_frame.attr('src'));
});

var show_media = function(media_list, container) {
	if (typeof(container) == 'string') {
		container = $(container);
	}

	if (!media_list.presentation) {
		media_list.presentation = function () {
			var media;
			switch (this.type) {
				case '<?=MT_IMAGE?>':
					media = '<img src="' + this.url + '" alt="' + this.content  + '">';
				break;
				case '<?=MT_VIDEO?>':
					media = '<video controls><source src="' + this.url + '" type="video/mp4">Your browser does not support the video tag.</video>';
				break;
				case '<?=MT_AUDIO?>':
					media = '<audio controls><source src="' + this.url + '" type="audio/mpeg">Your browser does not support the audio tag.</audio>';
				break;
				case '<?=MT_FLASH?>':
					media = '<i class="fa fa-bolt" aria-hidden="true"></i>';
				break;
				case '<?=MT_ATTACH?>':
					switch (this.file_ext) {
						case 'xls':
						case 'xlsx':
							media = '<a href="javascript:void(0);" title="' + this.content + '"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>';
						break;
						case 'doc':
						case 'docx':
							media = '<a href="javascript:void(0);" title="' + this.content + '"><i class="fa fa-file-word-o" aria-hidden="true"></i></a>';
						break;
						case 'ppt':
						case 'pptx':
							media = '<a href="javascript:void(0);" title="' + this.content + '"><i class="fa fa-file-powerpoint-o" aria-hidden="true"></i></a>';
						break;
						case 'pdf':
							media = '<a href="javascript:void(0);" title="' + this.content + '"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>';
						break;
						case 'zip':
							media = '<a href="javascript:void(0);" title="' + this.content + '"><i class="fa fa-file-archive-o" aria-hidden="true"></i></a>';
						break;
					}
				break;
			}
			return media;
		}
	}

	if (container) {
		select_mode = container.attr('data-select-mode');
		name = container.attr('data-name');

		if (media_list.list) {
			media_list.list.forEach(function(item) {
				item.name = name;
			});
		}

		if (parseInt(select_mode)) {
			container.prepend(Mustache.render(media_template, media_list));
		}
		else {
			container.html(Mustache.render(media_template, media_list));
		}
	}
};

var show_no_media = function(container) {
	if (typeof(container) == 'string') {
		container = $(container);
	}

	select_mode = container.attr('data-select-mode');

	if (parseInt(select_mode)) {
		select_mode = 1;
	}
	else {
		select_mode = 0;
	}

	container.html(Mustache.render(no_media_template, {select_mode: select_mode}));
};

window.insert_media = function(media_list) {
	if (window.container) {
		if (media_list.list.length) {
			show_media(media_list, window.container);
		}
		else {
			show_no_media(window.container);
		}

		delete(window.container);
	}

	media_inserter.hide();
};

</script>
