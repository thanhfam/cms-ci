<script src="<?=base_url(F_PUB .F_CP .'ace/src-min/ace.js')?>"></script>

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

<form id="form-edit" method="post" accept-charset="utf-8" action="<?=current_url()?>" class="uk-form-stacked">

<div class="uk-margin-small uk-width-large">
	<label class="uk-form-label" for="name"><?=$lang->line('name')?> (*)</label>
	<div class="uk-form-controls">
		<input type="text" name="name" id="name" value="<?=isset($item) ? $item['name'] : '';?>" class="uk-input uk-form-small <?=(form_error('name') ? 'uk-form-danger' : '');?>" />
		<?=form_error('name');?>
	</div>
</div>

<div class="uk-margin-small" >
	<label class="uk-form-label" for="content"><?=$lang->line('content')?></label>
	<div class="uk-form-controls">
		<div id="content-editor"></div>
		<textarea type="text" name="content" id="content" rows="20" class="uk-hidden uk-text-small uk-textarea <?=(form_error('content') ? 'uk-form-danger' : '')?>"><?=isset($item) ? $item['content'] : ''?></textarea>
		<?=form_error('content')?>
	</div>
</div>

<script>
var textarea = $('#content');
var editor = ace.edit("content-editor");

	editor.setOptions({
		mode: 'ace/mode/php',
		theme: 'ace/theme/xcode',
		showInvisibles: true,
		printMarginColumn: 99,
		printMargin: true,
		useSoftTabs: false,
		tabSize: 4,
		showLineNumbers: true,
		showGutter: true,
		wrap: 99,
		displayIndentGuides: false,
		fontFamily: 'Consolas',
		fontSize: '0.9rem',
		minLines: 20,
		maxLines: 34,
		scrollPastEnd: true,
		highlightActiveLine: true,
		highlightSelectedWord: true
	});
	
	editor.getSession().setValue(textarea.val());
	editor.getSession().on('change', function () {
		textarea.val(editor.getSession().getValue());
	});

	editor.commands.addCommand({
		name: 'save',
		bindKey: {win: "Ctrl-S", "mac": "Cmd-S"},
		exec: function(editor) {
			document.getElementById('form-edit').submit();
		}
	})
</script>

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
	<input type="hidden" name="id" value="<?=isset($item) ? $item['id'] : '';?>" />
	<input type="hidden" name="created" value="<?=isset($item) ? $item['created'] : '';?>" />
	<button class="uk-button uk-button-small uk-button-primary" type="submit" name="btn_submit" value="save"><?=$lang->line('save');?></button>
	<button class="uk-button uk-button-small uk-button-secondary" type="submit" name="btn_submit" value="save_back"><?=$lang->line('save_back')?></button>
	<a class="uk-button uk-button-small" name="btn-back" href="<?=$link_back;?>"><?=$lang->line('back');?></a>
</div>

</form>

