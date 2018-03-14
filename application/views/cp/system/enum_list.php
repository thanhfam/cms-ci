<nav class="uk-navbar-container uk-margin-small" uk-navbar>
	<div class="uk-navbar-left">
		<div class="uk-navbar-item">
			<form method="get" accept-charset="utf-8" action="<?=current_url()?>">
			<div class="uk-form-controls uk-inline">
				<span class="uk-form-icon" uk-icon="icon: search"></span>
				<input class="uk-input uk-form-small keyword" type="search" placeholder="<?=$lang->line('keyword')?>" name="filter" value="<?=$filter?>" />
			</div>
			<input type="hidden" name="type" value="<?=$type ? $type : ''?>" />
			<button class="uk-button-small uk-button uk-button-primary filter" type="submit"><?=$lang->line('filter')?></button>
			<button class="uk-button-small uk-button unfilter" type="submit"><?=$lang->line('unfilter')?></button>
			</form>
		</div>
	</div>
	<div class="uk-navbar-right">
		<div class="uk-navbar-item">
		<?php if (isset($link_back)): ?>
			<a class="uk-button-small uk-button uk-button-primary" href="<?=$link_back?>"><?=$lang->line('back')?></a>
		<?php endif; ?>
		<?php if (isset($link_create)): ?>
			<a class="uk-button-small uk-button uk-button-primary" href="<?=$link_create?>"><?=$lang->line('create')?></a>
		<?php endif; ?>
		</div>
	</div>
</nav>

<div class="uk-overflow-auto">
<table class="uk-table uk-table-small uk-table-hover uk-table-striped">
<thead>
<tr>
	<th><?=$lang->line('id')?></th>
	<th><?=$lang->line('title')?></th>
	<th><?=$lang->line('parent')?></th>
	<th><?=$lang->line('language')?></th>
	<th>
		<?=($type && $type == 'tvn_service') ? $lang->line('price') : $lang->line('weight')?>
	</th>
	<?php if (!$type):?>
	<th><?=$lang->line('type')?></th>
	<?php endif;?>
	<th><?=$lang->line('updated')?></th>
	<th><?=$lang->line('command')?></th>
</tr>
</thead>
<tbody>
<?php
if (count($list) > 0):
foreach ($list as $row):
?>
<tr>
	<td class="uk-text-small"><?=$row['id']?></td>
	<td class="uk-text-small">
		<dl>
			<dt>
			<a href="<?=base_url(F_CP .'enum/edit/' . $row['id'] .($type ? '?type=' .$type : ''))?>" title="<?=$lang->line('edit')?>">
				<?=$row['title']?>
			</a>
			</dt>
			<dd class="uk-text-meta"><?=$row['name']?></dd>
		</dl>
	</td>
	<td class="uk-text-small">
		<dl>
			<dt><?=$row['parent_title']?></dt>
			<dd class="uk-text-meta"><?=$row['parent_name']?></dd>
		</dl>
	</td>
	<td class="uk-text-small">
		<?=$row['lang']?>
	</td>
	<td class="uk-text-small">
		<?=number_format($row['weight'], 0, ',', '.')?>
	</td>
	<?php if (!$type):?>
	<td class="uk-text-small">
		<?=$row['type']?>
	</td>
	<?php endif;?>
	<td class="uk-text-small">
		<?=$row['updated']?>
	</td>
	<td class="command">
		<ul class="uk-iconnav">
			<li><a href="<?=base_url(F_CP .'enum/edit/' .$row['id'] .($type ? '?type=' .$type : ''))?>" uk-icon="icon: file-edit" title="<?=$lang->line('edit')?>"></a></li>
			<li><a href="<?=base_url(F_CP .'enum/remove/' .$row['id'] .($type ? '?type=' .$type : ''))?>" uk-icon="icon: trash" data-msg="<?=$lang->line('sure_to_remove')?>" title="<?=$lang->line('remove')?>" class="btn-remove"></a></li>
		</ul>
	</td>
</tr>
<?php
endforeach;
else:
?>
<tr>
	<td class="uk-text-small" colspan="7"><?=$lang->line('no_row')?></td>
</tr>
<?php
endif;
?>
</tbody>
</table>
</div>
