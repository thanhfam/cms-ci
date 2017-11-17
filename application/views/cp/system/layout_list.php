<div class="uk-overflow-auto">
<table class="uk-table uk-table-small uk-table-hover uk-table-striped">
<thead>
<tr>
	<th><?=$lang->line('id');?></th>
	<th><?=$lang->line('name');?></th>
	<th><?=$lang->line('site');?></th>
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
	<td><a href="<?=base_url('cp/layout/edit/' . $row['id']);?>"><?=$row['name']?></a></td>
	<td><?=$row['site_title']?> (<?=$row['site_id']?>)</td>
	<td><?=$row['updated']?></td>
	<td class="command">
		<ul class="uk-iconnav">
			<li><a href="<?=base_url('cp/layout/edit/' . $row['id']);?>" uk-icon="icon: file-edit" title="<?=$lang->line('edit');?>"></a></li>
		</ul>
	</td>
</tr>
<?php
endforeach;
else:
?>
<tr>
	<td colspan="5"><?=$lang->line('no_row');?></td>
</tr>
<?php
endif;
?>
</tbody>
</table>
</div>