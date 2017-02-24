<div class="uk-overflow-auto">
<table class="uk-table uk-table-small uk-table-hover uk-table-striped">
<thead>
<tr>
	<th data-field="id"><?=$lang->line('id');?></th>
	<th data-field="title"><?=$lang->line('title');?></th>
	<th data-field="type"><?=$lang->line('type');?></th>
	<th data-field="nation"><?=$lang->line('nation');?></th>
	<th data-field="command"><?=$lang->line('command');?></th>
</tr>
</thead>
<tbody>
<?php foreach ($list as $row) { ?>
<tr>
	<td><?=$row['id']?></td>
	<td><a href="<?=base_url('/city/edit/' . $row['id']);?>"><?=$row['title']?></a></td>
	<td><?=$row['type']?></td>
	<td><a href="<?=base_url('/city/list/?filter=' . $row['nation_title']);?>"><?=$row['nation_title']?></a></td>
	<td class="command">
		<ul class="uk-iconnav">
			<li><a href="<?=base_url('/district/list/?filter=' . $row['title']);?>" uk-icon="icon: menu" title="<?=$lang->line('list');?>"></a></li>
			<li><a href="<?=base_url('/city/edit/' . $row['id']);?>" uk-icon="icon: file-edit" title="<?=$lang->line('edit');?>"></a></li>
			<li><a href="<?=base_url('/city/remove/' . $row['id']);?>" uk-icon="icon: trash" title="<?=$lang->line('remove');?>"></a></li>
		</ul>
	</td>
</tr>
<?php } ?>
</tbody>
</table>
</div>