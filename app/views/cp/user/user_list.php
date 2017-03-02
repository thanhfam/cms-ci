<div class="uk-overflow-auto">
<table class="uk-table uk-table-small uk-table-hover uk-table-striped">
<thead>
<tr>
	<th><?=$lang->line('id');?></th>
	<th><?=$lang->line('username');?></th>
	<th><?=$lang->line('email');?></th>
	<th><?=$lang->line('group');?></th>
	<th><?=$lang->line('command');?></th>
</tr>
</thead>
<tbody>
<?php
if (count($list) > 0) {
foreach ($list as $row) {
?>
<tr>
	<td><?=$row['user_id']?></td>
	<td><a href="<?=base_url('/cp/user/edit/' . $row['user_id']);?>"><?=$row['username']?></a></td>
	<td><?=$row['email']?></td>
	<td><a href="<?=base_url('/user/list/?filter=' . $row['auth_level']);?>"><?=$row['auth_level']?></a></td>
	<td class="command">
		<ul class="uk-iconnav">
			<li><a href="<?=base_url('/cp/user/edit/' . $row['user_id']);?>" uk-icon="icon: file-edit" title="<?=$lang->line('edit');?>"></a></li>
			<li><a href="<?=base_url('/cp/user/change-password/' . $row['user_id']);?>" uk-icon="icon: file-edit" title="<?=$lang->line('change_password');?>"></a></li>
			<li><a href="<?=base_url('/cp/user/reset-password/' . $row['user_id']);?>" uk-icon="icon: file-edit" title="<?=$lang->line('reset_password');?>"></a></li>
			<li><a href="<?=base_url('/cp/user/remove/' . $row['user_id']);?>" uk-icon="icon: trash" title="<?=$lang->line('remove');?>"></a></li>
		</ul>
	</td>
</tr>
<?php
}
}
else {
?>
<tr>
	<td colspan="6"><?=$lang->line('no_row');?></td>
</tr>
<?php
}
?>
</tbody>
</table>
</div>
