<table class="bordered striped highlight responsive-table">
<thead>
<tr>
	<th data-field="id"><?=$lang->line('id');?></th>
	<th data-field="title"><?=$lang->line('title');?></th>
	<th data-field="type"><?=$lang->line('type');?></th>
	<th data-field="district"><?=$lang->line('district');?></th>
	<th data-field="city"><?=$lang->line('city');?></th>
	<th data-field="command"><?=$lang->line('command');?></th>
</tr>
</thead>
<tbody>
<?php
if (count($list) > 0) {
foreach ($list as $row) {
?>
<tr>
	<td><?=$row['id']?></td>
	<td><a href="<?=base_url('/ward/edit/' . $row['id']);?>"><?=$row['title']?></a></td>
	<td><?=$row['type']?></td>
	<td><a href="<?=base_url('/ward/list/?filter=' . $row['district_title']);?>"><?=$row['district_title']?></a></td>
	<td><a href="<?=base_url('/district/list/?filter=' . $row['city_title']);?>"><?=$row['city_title']?></a></td>
	<td class="command">
		<ul class="icon-nav">
			<li><a href="<?=base_url('/ward/edit/' . $row['id']);?>" title="<?=$lang->line('edit');?>"> <i class="material-icons">edit</i></a></li>
			<li><a href="<?=base_url('/ward/remove/' . $row['id']);?>" title="<?=$lang->line('remove');?>"><i class="material-icons">delete</i></a></li>
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