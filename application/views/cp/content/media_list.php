<nav class="uk-navbar-container uk-margin-small" uk-navbar>
	<div class="uk-navbar-left">
		<div class="uk-navbar-item">
			<form method="get" accept-charset="UTF-8" action="<?=current_url()?>">
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

			<button class="uk-button-small uk-button uk-button-primary" type="submit"><?=$lang->line('filter')?></button>
			<a class="uk-button uk-button-small uk-button-secondary" href="<?=current_url()?>"><?=$lang->line('unfilter')?></a>
			</form>
		</div>
	</div>
	<div class="uk-navbar-right">
		<div class="uk-navbar-item">
		<?php
			if ($link_create) {
		?>
			<a class="uk-button-small uk-button uk-button-primary" href="<?=$link_create?>"><?=$lang->line('upload')?></a>
		<?php
			}
		?>
		</div>
	</div>
</nav>

<div class="uk-overflow-auto">
<div uk-grid class="uk-margin-small uk-grid-match uk-grid-small uk-text-center">
<?php
if (count($list) > 0):
foreach ($list as $item):
?>
<div class="media-list uk-width-1-4@m uk-width-1-2@s">
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
				<source src="<?=$item['url']?>" type="video/mp4">
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
		<li class="uk-text-small"><a href="<?=$item['url']?>" title="<?=$item['content']?>"><?=$item['orig_name']?></a></li>
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
<?php
endforeach;
else:
?>
<div class="uk-text-small uk-text-center uk-width-expand@m"><?=$lang->line('no_row')?></div>
<?php endif; ?>
</div>
</div>
