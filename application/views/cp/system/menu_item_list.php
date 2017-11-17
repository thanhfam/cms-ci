<div class="uk-overflow-auto">
<table class="uk-table uk-table-small uk-table-hover uk-table-striped">
<thead>
<tr>
	<th><?=$lang->line('id');?></th>
	<th><?=$lang->line('title');?></th>
	<th><?=$lang->line('url');?></th>
	<th><?=$lang->line('parent');?></th>
	<th><?=$lang->line('menu');?></th>
	<th><?=$lang->line('position');?></th>
	<th><?=$lang->line('updated');?></th>
	<th><?=$lang->line('command');?></th>
</tr>
</thead>
<tbody>
<?php
if (count($list) > 0):
foreach ($list as $row):
?>
<tr>
	<td><?=$row['id']?></td>
	<td><?=$row['title']?></td>
	<td><?=$row['url']?></td>
	<td><?=$row['parent_title']?></td>
	<td><?=$row['menu_name']?></td>
	<td><?=$row['position']?></td>
	<td><?=$row['updated']?></td>
	<td class="command">
		<ul class="uk-iconnav">
			<li><a href="<?=base_url('cp/menu_item/edit/' . $row['menu_id'] . '/' . $row['id']);?>" uk-icon="icon: file-edit" title="<?=$lang->line('edit');?>"></a></li>
			<li><a href="<?=base_url('cp/menu_item/remove/' . $row['menu_id'] . '/' . $row['id']);?>" uk-icon="icon: trash" data-msg="<?=$lang->line('sure_to_remove');?>" title="<?=$lang->line('remove');?>" class="btn-remove"></a></li>
		</ul>
	</td>
</tr>
<?php
endforeach;
else:
?>
<tr>
	<td colspan="8"><?=$lang->line('no_row');?></td>
</tr>
<?php
endif;
?>
</tbody>
</table>
</div>
