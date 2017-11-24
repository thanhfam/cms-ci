<div class="uk-overflow-auto">
<table class="uk-table uk-table-small uk-table-hover uk-table-striped">
<thead>
<tr>
	<th><?=$lang->line('id')?></th>
	<th><?=$lang->line('title')?></th>
	<th><?=$lang->line('category')?></th>
	<!--
	<th><?=$lang->line('site')?></th>
	-->
	<th><?=$lang->line('state')?></th>
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
		<?=$row['title'] ? '<a target="_blank" href="'. $row['site_url'] .$row['uri'] .'">' .$row['title'] .'</a>' : ''?>
	</td>
	<td class="uk-text-small"><?=$row['parent_title']?></td>
	<!--
	<td class="uk-text-small"><?=$row['site_title']?></td>
	-->
	<td class="uk-text-small">
		<?=$lang->line($row['state_name']) ? $lang->line($row['state_name']) : $row['state_name']?> (<?=$row['state_weight']?>)
	</td>
	<td class="uk-text-small">
		<?=$row['updated']?>
	</td>
	<td class="command">
		<ul class="uk-iconnav">
			<li><a href="<?=base_url(F_CP .'post/list/?cate_id=' . $row['id']);?>" uk-icon="icon: list" title="<?=$lang->line('list')?>"></a></li>
			<li><a href="<?=base_url(F_CP .'category/edit/' . $row['id'])?>" uk-icon="icon: file-edit" title="<?=$lang->line('edit')?>"></a></li>
		</ul>
	</td>
</tr>
<?php
endforeach;
else:
?>
<tr>
	<td class="uk-text-small" colspan="6"><?=$lang->line('no_row')?></td>
</tr>
<?php
endif;
?>
</tbody>
</table>
</div>
