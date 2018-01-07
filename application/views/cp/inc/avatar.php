<div class="uk-margin-small">
<div id="avatar-container" style="display: none;">
	<div id="avatar" class="media-full uk-margin-small uk-width-medium">
	</div>
	<button class="uk-button uk-button-small uk-button-danger" type="button" onclick="remove_avatar();"><?=$lang->line('remove')?></button>
</div>
<div id="non-avatar-container" style="display: none;" class="uk-margin-small uk-width-small">
	<div id="avatar-noimage" class="uk-margin-small">
	<div class="media uk-card uk-card-small uk-card-default uk-card-body">
		<div class="media-head">
			<a href="javascript:set_avatar();" data-type="post" title="<?=$lang->line('add')?>"><img class="card-img img-fluid" src="<?=base_url(F_PUB .F_CP .'img/noimage.jpg')?>"></a>
		</div>
	</div>
	</div>
</div>
<input type="hidden" name="avatar_id" value="<?=isset($item) ? $item['avatar_id'] : ''?>" />
<input type="hidden" name="avatar_url" value="<?=isset($item) ? $item['avatar_url'] : ''?>" />
<input type="hidden" name="avatar_type" value="<?=isset($item) ? $item['avatar_type'] : ''?>" />
<input type="hidden" name="avatar_file_ext" value="<?=isset($item) ? $item['avatar_file_ext'] : ''?>" />
</div>