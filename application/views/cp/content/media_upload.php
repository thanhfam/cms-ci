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

<div class="uk-margin-small">
	<a class="uk-button uk-button-small uk-button-default" name="btn-back" href="<?=$link_back?>"><?=$lang->line('back')?></a>
</div>

<progress id="js-progressbar" class="uk-progress" value="0" max="100" hidden></progress>
<script>

	var bar = document.getElementById('js-progressbar');
	var uploadSuccess;
	var msgBox = $('#message-box');
	var msgTitle = $('#message-title');
	var msgBody = $('#message-body');

	UIkit.upload('.js-upload', {

		url: '<?=current_url()?>',
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
				console.error(e);
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
