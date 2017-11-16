<div class="uk-overflow-auto">
<table class="uk-table uk-table-small uk-table-hover uk-table-striped">
<thead>
<tr>
	<th><?=$lang->line('id');?></th>
	<th><?=$lang->line('title');?></th>
	<th><?=$lang->line('name');?></th>
	<th><?=$lang->line('url');?></th>
	<th><?=$lang->line('language');?></th>
	<th><?=$lang->line('command');?></th>
</tr>
</thead>
<tbody>
<?php
if (count($list) > 0) {
foreach ($list as $row) {
?>
<tr>
	<td><?=$row['id']?></td>
	<td><a href="<?=base_url('/site/edit/' . $row['id']);?>"><?=$row['title']?></a></td>
	<td><?=$row['name']?></td>
	<td><?=$row['url']?></td>
	<td><?=$row['language']?></td>
	<td class="command">
		<ul class="uk-iconnav">
			<li><a href="<?=base_url('/site/edit/' . $row['id']);?>" uk-icon="icon: file-edit" title="<?=$lang->line('edit');?>"></a></li>
		</ul>
	</td>
</tr>
<?php
}
}
else {
?>
<tr>
	<td colspan="5"><?=$lang->line('no_row');?></td>
</tr>
<?php
}
?>
</tbody>
</table>
</div>
