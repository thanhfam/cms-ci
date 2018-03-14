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

<div class="media-full uk-margin-small uk-width-large uk-text-center">
<div class="media uk-card uk-card-small uk-card-default uk-card-body uk-padding-small">
	<div class="media-head media-head-max-height">
		<?php switch($item['type']):
			case MT_IMAGE: ?>
			<a href="<?=$item['url']?>" title="<?=$item['content']?>">
				<img src="<?=$item['url']?>">
			</a>
		<?php
			break;
			case MT_VIDEO:
		?>
			<video controls>
				<source src="<?=$item['url_ori']?>" type="video/mp4">
				Your browser does not support the video tag.
			</video>
		<?php
			break;
			case MT_AUDIO:
		?>
			<audio controls>
				<source src="<?=$item['url']?>" type="audio/mpeg">
				Your browser does not support the audio tag.
			</audio>
		<?php
			break;
			case MT_FLASH:
		?>
			<a href="<?=$item['url']?>" title="<?=$item['content']?>">
				<i class="fa fa-bolt" aria-hidden="true"></i>
			</a>
		<?php
			break;
			case MT_ATTACH:
				switch($item['file_ext']):
				case 'xls':
				case 'xlsx':
		?>
			<a href="<?=$item['url']?>" title="<?=$item['content']?>">
				<i class="fa fa-file-excel-o" aria-hidden="true"></i>
			</a>
		<?php
			break;
			case 'doc':
			case 'docx':
		?>
			<a href="<?=$item['url']?>" title="<?=$item['content']?>">
				<i class="fa fa-file-word-o" aria-hidden="true"></i>
			</a>
		<?php
			break;
			case 'ppt':
			case 'pptx':
		?>
			<a href="<?=$item['url']?>" title="<?=$item['content']?>">
				<i class="fa fa-file-powerpoint-o" aria-hidden="true"></i>
			</a>
		<?php
			break;
			case 'pdf':
		?>
			<a href="<?=$item['url']?>" title="<?=$item['content']?>">
				<i class="fa fa-file-pdf-o" aria-hidden="true"></i>
			</a>
		<?php
			break;
			case 'zip':
		?>
			<a href="<?=$item['url']?>" title="<?=$item['content']?>">
				<i class="fa fa-file-archive-o" aria-hidden="true"></i>
			</a>
		<?php
			break;
			endswitch;
			break;
			endswitch;
		?>
	</div>
	<ul class="uk-list media-meta">
		<li class="uk-text-small">#<?=$item['id']?></li>
		<?php if ($item['orig_name']): ?>
		<li class="uk-text-small">
			<a href="<?=$item['url_ori']?>" title="<?=$item['content']?>"><?=$item['orig_name']?></a>
		</li>
		<?php endif; ?>
		<?php if ($item['file_size']): ?>
		<li class="uk-text-small"><?=$item['file_size']?> KB</li>
		<?php endif; ?>
		<li class="command">
			<ul class="uk-iconnav">
				<li><a href="<?=base_url(F_CP .'media/download/' . $item['id']);?>" uk-icon="icon: download" title="<?=$lang->line('download')?>"></a></li>
				<li><a href="<?=base_url(F_CP .'media/edit/' . $item['id']);?>" uk-icon="icon: file-edit" title="<?=$lang->line('edit')?>"></a></li>
				<li><a href="<?=base_url(F_CP .'media/remove/' . $item['id']);?>" uk-icon="icon: trash" data-msg="<?=$lang->line('sure_to_remove');?>" title="<?=$lang->line('remove');?>" class="btn-remove"></a></li>
			</ul>
		</li>
	</ul>
</div>
</div>

<form method="post" accept-charset="utf-8" action="<?=current_url()?>" class="uk-form-stacked">

<div class="uk-margin-small uk-width-large">
	<label class="uk-form-label" for="content"><?=$lang->line('content')?></label>
	<div class="uk-form-controls">
		<textarea type="text" name="content" id="content" rows="5" class="uk-text-small uk-textarea <?=(form_error('content') ? 'uk-form-danger' : '')?>"><?=isset($item) ? $item['content'] : ''?></textarea>
		<?=form_error('content')?>
	</div>
</div>

<div class="uk-margin-small">
	<input type="hidden" name="id" value="<?=$item['id']?>" />
	<input type="hidden" name="created" value="<?=$item['created']?>" />
	<input type="hidden" name="filename" value="<?=$item['file_name']?>" />
	<input type="hidden" name="oriname" value="<?=$item['orig_name']?>" />
	<input type="hidden" name="size" value="<?=$item['file_size']?>" />
	<input type="hidden" name="type" value="<?=$item['type']?>" />
	<input type="hidden" name="filetype" value="<?=$item['file_type']?>" />
	<button class="uk-button uk-button-small uk-button-primary" type="submit" name="submit" value="save"><?=$lang->line('save')?></button>
	<button class="uk-button uk-button-small uk-button-secondary" type="submit" name="submit" value="save_back"><?=$lang->line('save_back')?></button>
	<a class="uk-button uk-button-small" name="btn-back" href="<?=$link_back?>"><?=$lang->line('back')?></a>
</div>

</form>

