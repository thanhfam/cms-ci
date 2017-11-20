<div class="uk-overflow-auto">
<table class="uk-table uk-table-small uk-table-hover uk-table-striped">
<thead>
<tr>
	<th><?=$lang->line('id');?></th>
	<th><?=$lang->line('title');?></th>
	<th><?=$lang->line('code');?></th>
	<th><?=$lang->line('type');?></th>
	<th><?=$lang->line('city');?></th>
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
	<td class="uk-text-small"><a href="<?=base_url('/district/edit/' . $row['id']);?>"><?=$row['title']?></a></td>
	<td class="uk-text-small"><?=$row['code']?></td>
	<td class="uk-text-small"><?=$row['type']?></td>
	<td class="uk-text-small"><a href="<?=base_url('/district/list/?filter=' . $row['city_title']);?>"><?=$row['city_title']?></a></td>
	<td class="command">
		<ul class="uk-iconnav">
			<li><a href="<?=base_url('/ward/list/?filter=' . $row['title']);?>" uk-icon="icon: menu" title="<?=$lang->line('list');?>"></a></li>
			<li><a href="<?=base_url('/district/edit/' . $row['id']);?>" uk-icon="icon: file-edit" title="<?=$lang->line('edit');?>"></a></li>
			<li><a href="<?=base_url('/district/remove/' . $row['id']);?>" uk-icon="icon: trash" title="<?=$lang->line('remove');?>"></a></li>
		</ul>
	</td>
</tr>
<?php
}
}
else {
?>
<tr>
	<td class="uk-text-small" colspan="6"><?=$lang->line('no_row')?></td>
</tr>
<?php
}
?>
</tbody>
</table>
</div>
