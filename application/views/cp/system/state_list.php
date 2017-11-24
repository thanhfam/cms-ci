<div class="uk-overflow-auto">
<table class="uk-table uk-table-small uk-table-hover uk-table-striped">
<thead>
<tr>
	<th><?=$lang->line('id');?></th>
	<th><?=$lang->line('name');?></th>
	<th><?=$lang->line('weight');?></th>
	<th><?=$lang->line('type');?></th>
	<th><?=$lang->line('updated');?></th>
	<th><?=$lang->line('command');?></th>
</tr>
</thead>
<tbody>
<?php
if (count($list) > 0) {
foreach ($list as $row) {
?>
<tr>
	<td class="uk-text-small"><?=$row['id']?></td>
	<td class="uk-text-small"><a href="<?=base_url('cp/state/edit/' . $row['id']);?>"><?=$row['name']?></a></td>
	<td class="uk-text-small"><?=$row['weight']?></td>
	<td class="uk-text-small"><?=$row['type']?></td>
	<td class="uk-text-small"><?=$row['updated']?></td>
	<td class="command">
		<ul class="uk-iconnav">
			<li><a href="<?=base_url('cp/state/edit/' . $row['id']);?>" uk-icon="icon: file-edit" title="<?=$lang->line('edit');?>"></a></li>
		</ul>
	</td>
</tr>
<?php
}
}
else {
?>
<tr>
	<td class="uk-text-small" colspan="7"><?=$lang->line('no_row')?></td>
</tr>
<?php
}
?>
</tbody>
</table>
</div>
