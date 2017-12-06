<div id="avatar-container" style="display: none;">
	<div id="avatar" class="media-full uk-margin-small uk-width-large uk-text-center">
	</div>

	<button class="uk-button uk-button-small uk-button-primary" type="button" data-type="post" onclick="set_avatar();"><?=$lang->line('change')?></button>
	<button class="uk-button uk-button-small uk-button-danger" type="button" onclick="remove_avatar();"><?=$lang->line('remove')?></button>
</div>
<div id="non-avatar-container" style="display: none;">
	<button class="uk-button uk-button-small uk-button-primary" type="button" data-type="post" onclick="set_avatar();"><?=$lang->line('add')?></button>
</div>
<input type="hidden" name="avatar_id" value="<?=isset($item) ? $item['avatar_id'] : ''?>" />
<input type="hidden" name="avatar_url" value="<?=isset($item) ? $item['avatar_url'] : ''?>" />
<input type="hidden" name="avatar_type" value="<?=isset($item) ? $item['avatar_type'] : ''?>" />
<input type="hidden" name="avatar_file_ext" value="<?=isset($item) ? $item['avatar_file_ext'] : ''?>" />