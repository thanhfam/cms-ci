<div class="uk-overflow-auto">
<table class="uk-table uk-table-small uk-table-hover uk-table-striped">
<thead>
<tr>
	<th><?=$lang->line('id')?></th>
	<th><?=$lang->line('title')?></th>
	<th><?=$lang->line('name')?></th>
	<th><?=$lang->line('updated')?></th>
	<th><?=$lang->line('command')?></th>
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
		<a href="<?=base_url(F_CP .'user_group/edit/' . $row['id'])?>" title="<?=$lang->line('edit')?>"><?=$row['title']?></a>
	</td>
	<td><?=$row['name']?></td>
	<td><?=$row['updated']?></td>
	<td class="command">
		<ul class="uk-iconnav">
			<li><a href="<?=base_url(F_CP .'user_group/edit/' . $row['id'])?>" uk-icon="icon: file-edit" title="<?=$lang->line('edit')?>"></a></li>
		</ul>
	</td>
</tr>
<?php
endforeach;
else:
?>
<tr>
	<td colspan="6"><?=$lang->line('no_row')?></td>
</tr>
<?php
endif;
?>
</tbody>
</table>
</div>
