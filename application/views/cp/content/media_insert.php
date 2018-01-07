<script src="<?=base_url(F_PUB .F_CP .'js/mustache.min.js')?>"></script>

<div class="uk-overflow-auto">
<ul id="switcher" class="uk-subnav uk-subnav-pill" uk-switcher>
	<li><a href="#"><?=$lang->line('upload')?></a></li>
	<li class="uk-active"><a href="#"><?=$lang->line('list')?></a></li>
</ul>

<ul class="uk-switcher">
	<li>
		<div id="message-box" class="uk-margin-small" uk-alert hidden>
			<h3 id="message-title"></h3>
			<ul id="message-body" class="uk-text-small"></ul>
		</div>

		<div class="media-upload">
		<div class="js-upload uk-placeholder uk-text-center uk-height-medium">
			<span uk-icon="icon: cloud-upload"></span>
			<span class="uk-text-middle uk-text"><?=$lang->line('drop_file_to_upload')?></span>
			<div uk-form-custom>
				<input type="file" multiple>
				<span class="uk-link uk-text"><?=$lang->line('select_file_to_upload')?></span>
			</div>
		</div>
		</div>

		<progress id="js-progressbar" class="uk-progress" value="0" max="100" hidden></progress>
	</li>

	<li>
		<div uk-grid class="uk-grid-small">
			<div class="uk-width-expand@m">
				<nav class="uk-navbar-container uk-margin-small" uk-navbar>
					<div class="uk-navbar-left">
						<div class="uk-navbar-item">
							<form id="form_filter" method="get" accept-charset="UTF-8" action="<?=current_url()?>">
							<div class="uk-form-controls uk-inline">
								<span class="uk-form-icon" uk-icon="icon: search"></span>
								<input class="uk-input uk-form-small keyword" type="search" placeholder="<?=$lang->line('keyword')?>" name="keyword" value="<?=$filter['keyword']?>" />
							</div>

							<select class="uk-select uk-form-small uk-width-small" name="type">
								<option value="" disabled><?=$lang->line('select_one') .' ' .$lang->line('type')?></option>
								<option value="">-</option>
								<?php foreach ($list_type as $type): ?>
								<option value="<?=$type?>" <?=($type == $filter['type']) ? 'selected' : ''?>><?=$lang->line($type) ? $lang->line($type): $type?></option>
								<?php endforeach; ?>
							</select>

							<button id="btn_filter" class="uk-button-small uk-button uk-button-primary" type="submit"><?=$lang->line('filter')?></button>
							<button id="btn_unfilter" class="uk-button uk-button-small uk-button-secondary"><?=$lang->line('unfilter')?></button>
							</form>
						</div>
					</div>
					<div class="uk-navbar-right">
						<div class="uk-navbar-item">
							<div uk-spinner="ratio: 0.8"></div>
						</div>
					</div>
				</nav>

				<div id="list" uk-grid class="media-list uk-margin-small uk-grid-match uk-grid-small uk-text-center">
				</div>

				<nav class="uk-navbar-container uk-margin-small" uk-navbar>
					<div class="uk-navbar-center">
						<div id="pagy" class="uk-navbar-item">
						</div>
					</div>
				</nav>
			</div> <!-- end of col 1-->
			<div class="uk-width-medium">
				<nav class="uk-navbar-container uk-margin-small" uk-navbar>
					<div class="uk-navbar-left">
						<ul class="uk-navbar-nav">
							<li><a><?=$lang->line('selected_items')?></a></li>
						</ul>
					</div>
					<div class="uk-navbar-right">
						<div class="uk-navbar-item">
							<button id="btn_remove_all" class="uk-button-small uk-button" uk-icon="icon: trash" title="<?=$lang->line('remove')?> <?=$lang->line('all')?>" disabled></button>
							<button id="btn_use" class="uk-button-small uk-button uk-button-primary" disabled><?=$lang->line('use')?></button>
						</div>
					</div>
				</nav>
				<div id="selected" class="media-full uk-margin-small uk-text-center">
				</div>
			</div> <!-- end of col 2-->
		</div>
	</li>
</ul>

<!-- Upload Script - BEGIN -->
<script>
	$(document).on('beforeshow', $('#switcher'), function(event, active) {
	});

	var bar = document.getElementById('js-progressbar');
	var uploadSuccess;

	var msgBox = $('#message-box');
	var msgTitle = $('#message-title');
	var msgBody = $('#message-body');

	UIkit.upload('.js-upload', {

		url: '<?=base_url(F_CP ."media/upload")?>',
		multiple: true,
		params: {
			submit: 'save'
		},
		allow : '*.(<?=implode("|", $allowed_types)?>)',
		'data-type': 'json',
		'msg-invalid-mime': '<?=$lang->line("invalid_mime")?>',
		'msg-invalid-name': '<?=$lang->line("invalid_name")?>',

		beforeSend: function () {
			//console.log('beforeSend', arguments);
			uploadSuccess = true;
		},
		beforeAll: function () {
			//console.log('beforeAll', arguments);
		},
		load: function () {
			//console.log('load', arguments);
		},
		error: function () {
			//console.log('error', arguments);
			uploadSuccess = false;
		},
		complete: function (response) {
			console.warn('complete', arguments);

			try {
				if (response.responseJSON) {
					var message = response.responseJSON.message;
					var item = response.responseJSON.item;

					msg = '<li>';

					if (item) {
						msg += '[' + item.orig_name + '] - ';
					}

					if (message.type == 1) {
						msg += '<?=$lang->line("successfully")?>';
					}
					else {
						msg += '<?=$lang->line("failed")?> - ';
						msg += message.content;
						uploadSuccess = false;
					}
					msg += '</li>';
					msgBody.append(msg);
				}
				else {
					uploadSuccess = false;
				}
			}
			catch (e) {
				uploadSuccess = false;
			}
		},

		loadStart: function (e) {
			//console.log('loadStart', arguments);

			bar.removeAttribute('hidden');
			bar.max = e.total;
			bar.value = e.loaded;
		},

		progress: function (e) {
			//console.log('progress', arguments);

			bar.max = e.total;
			bar.value = e.loaded;
		},

		loadEnd: function (e) {
			//console.log('loadEnd', arguments);

			bar.max = e.total;
			bar.value = e.loaded;
		},

		completeAll: function () {
			//console.warn('completeAll', arguments);

			if (uploadSuccess) {
				load_media();
				UIkit.switcher('#switcher').show(1);

				msgTitle.text('<?=$lang->line("upload_successfully")?>');
				msgBox.addClass('uk-alert-success');
				msgBox.removeClass('uk-alert-danger');
			}
			else {
				msgTitle.text('<?=$lang->line("upload_failed")?>');
				msgBox.addClass('uk-alert-danger');
				msgBox.removeClass('uk-alert-success');
			}

			msgBox.removeAttr('hidden');

			setTimeout(function () {
				bar.setAttribute('hidden', 'hidden');
			}, 1000);
		}
	});
</script>
<!-- Upload Script - END -->

<!-- Library Script - BEGIN -->
<script id="list_items_template" type="x-tmpl-mustache">
{{#list}}
	<div class="uk-width-1-4@m uk-width-1-2@s">
	<div class="media uk-card uk-card-small uk-card-default uk-card-body uk-padding-small">
		<div class="media-head media-head-max-height">
			{{{presentation}}}
		</div>
		<ul class="uk-list media-meta">
			<li class="uk-text-small">#{{id}}</li>
			<li class="uk-text-small">{{orig_name}}</li>
			<li class="uk-text-small">{{file_size}} KB</li>
			<li class="command">
				<button class="uk-button uk-button-small uk-button-secondary"><?=$lang->line('select')?></button>
			</li>
		</ul>
	</div>
	</div>
{{/list}}
{{^list}}
	<div class="uk-text-small uk-text-center uk-width-expand@m"><?=$lang->line('no_row')?></div>
{{/list}}
</script>

<script id="selected_items_template" type="x-tmpl-mustache">
	<div class="media uk-card uk-card-small uk-card-default uk-card-body uk-padding-small">
		<div class="media-head media-head-max-height">
			{{{presentation}}}
		</div>
		<ul class="uk-list media-meta">
			<li class="command">
				<button class="uk-button uk-button-small uk-button-secondary"><?=$lang->line('remove')?></button>
			</li>
		</ul>
	</div>
</script>

<script>
var spinner = $('[uk-spinner]');
var pagy = $('#pagy');

var multi_select = <?=$multi_select?>;
var callback = '<?=$callback?>';

var list = $('#list');
var selected = $('#selected');

var btn_remove_all = $('#btn_remove_all');
var btn_use = $('#btn_use');

var form_filter = $('#form_filter');
var btn_filter = $('#btn_filter');
var btn_unfilter = $('#btn_unfilter');

form_filter.on('submit', function(e) {
	keyword = $(this).find('input.keyword').val();
	type = $(this).find('select').val();

	load_media(keyword, type);
	e.preventDefault();
});

btn_unfilter.on('click', function(e) {
	form_filter[0].reset();
	load_media();
});

var list_items_template = $('#list_items_template').html();
var selected_items_template = $('#selected_items_template').html();

var list_items = {
	presentation: function () {
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

var selected_items = [];

Mustache.parse(list_items_template);
Mustache.parse(selected_items_template);

var remove_all_items = function() {
	selected_items = [];
	selected.html('');

	btn_use.prop('disabled', true);
	btn_remove_all.prop('disabled', true);
}

var use = function() {
	if (window.self == window.top) {
		return;
	}

	if (window.parent && window.parent[callback]) {
		window.parent[callback]({list: selected_items});
	}
}

btn_use.on('click', use);
btn_remove_all.on('click', remove_all_items);

var add_item = function(index) {
	selected_item = list_items.list[index];

	for (var i = 0, len = selected_items.length; i < len; i++) {
		if (selected_item.id == selected_items[i].id) {
			return;
		}
	}

	selected_item.presentation = list_items.presentation;

	if (multi_select) {
		selected_items.push(selected_item);
		selected.append(Mustache.render(selected_items_template, selected_item));
	}
	else {
		selected_items[0] = selected_item;
		selected.html(Mustache.render(selected_items_template, selected_item));

		use();
	}

	selected.find('.media button').on('click', function() {
		remove_item(selected.find('.media').index($(this).parents('.media')));
		$(this).parents('.media').remove();
	});

	btn_use.prop('disabled', false);
	btn_remove_all.prop('disabled', false);
}

var remove_item = function(index) {
	selected_items.splice(index, 1);

	if (!selected_items.length) {
		btn_use.prop('disabled', true);
		btn_remove_all.prop('disabled', true);
	}
}

var load_media = function (keyword ='', type = '', url = '<?=base_url(F_CP ."media/list_all_json")?>') {
	$.ajax({
		url: url,
		data: {
			keyword: keyword,
			type: type,
			per_page: 8
		},
		dataType: 'json',
		beforeSend: function(jqXHR, settings) {
			spinner.show();
		},
		error: function(jqXHR, textStatus, errorThrown) {
		},
		success: function(data, textStatus, jqXHR) {
			list_items.list = data.list;

			list.html(Mustache.render(list_items_template, list_items));
			list.find('.media button').on('click', function() {
				add_item(list.find('.media').index($(this).parents('.media')));
			});

			pagy.html(data.pagy);
			pagy.find('a').on('click', function(e) {
				load_media('', '', this.href);
				e.preventDefault();
			});
		},
		complete: function(jqXHR, textStatus) {
			spinner.hide();
		}
	});
}

load_media();
</script>
<!-- Library Script - END -->
