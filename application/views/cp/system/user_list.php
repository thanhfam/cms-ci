<div class="uk-overflow-auto">
<table class="uk-table uk-table-hover uk-table-striped">
<thead>
<tr>
	<th><?=$lang->line('id');?></th>
	<th><?=$lang->line('username');?></th>
	<th><?=$lang->line('email');?></th>
	<th><?=$lang->line('group');?></th>
	<th><?=$lang->line('state');?></th>
	<th><?=$lang->line('last_login');?></th>
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
	<td class="uk-text-small">
		<a href="<?=base_url(F_CP .'user/edit/' . $row['id']);?>"><?=$row['username']?></a>
	</td>
	<td class="uk-text-small"><?=mailto($row['email'])?></td>
	<td class="uk-text-small">
		<a href="<?=base_url(F_CP .'user/list/?filter=' . $row['user_group_title']);?>"><?=$row['user_group_title']?></a>
	</td>
	<td class="uk-text-small">
		<?=$lang->line($row['state_name']) ? $lang->line($row['state_name']) : $row['state_name']?> (<?=$row['state_weight']?>)
	</td>
	<td class="uk-text-small"><?=$row['last_login']?></td>
	<td class="command">
		<ul class="uk-iconnav">
			<li><a href="<?=base_url(F_CP .'user/edit/' . $row['id']);?>" uk-icon="icon: file-edit" title="<?=$lang->line('edit');?>"></a></li>
			<li><a href="<?=base_url(F_CP .'user/reset-password/' . $row['id']);?>" uk-icon="icon: cog" title="<?=$lang->line('reset_password');?>"></a></li>
			<li><a href="<?=base_url(F_CP .'user/remove/' . $row['id']);?>" uk-icon="icon: trash" data-msg="<?=$lang->line('sure_to_remove');?>" title="<?=$lang->line('remove');?>" class="btn-remove"></a></li>
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
