<div class="uk-overflow-auto">
<table class="uk-table uk-table-small uk-table-hover uk-table-striped">
<thead>
<tr>
	<th><?=$lang->line('id');?></th>
	<th><?=$lang->line('title');?></th>
	<th><?=$lang->line('category');?></th>
	<th><?=$lang->line('state');?></th>
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
	<td>
		<?=$row['subtitle'] ? '<span class="uk-text-meta">' .$row['subtitle'] .'</span>' : ''?>
		<?=$row['title'] ? '<a href="'. $row['site_url'] .$row['name'] .'">' .$row['title'] .'</a>' : ''?>
	</td>
	<td><?=$row['cate_title']?> (<?=$row['cate_id']?>)</td>
	<td>
		<?=$lang->line($row['state_name']) ? $lang->line($row['state_name']) : $row['state_name'];?> (<?=$row['state_weight']?>)
	</td>
	<td><?=$row['created']?></td>
	<td class="command">
		<ul class="uk-iconnav">
			<li><a href="<?=base_url('cp/post/edit/' . $row['id']);?>" uk-icon="icon: file-edit" title="<?=$lang->line('edit');?>"></a></li>
		</ul>
	</td>
</tr>
<?php
endforeach;
else:
?>
<tr>
	<td colspan="6"><?=$lang->line('no_row');?></td>
</tr>
<?php
endif;
?>
</tbody>
</table>
</div>