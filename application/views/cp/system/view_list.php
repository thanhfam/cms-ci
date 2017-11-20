<div class="uk-overflow-auto">
<table class="uk-table uk-table-small uk-table-hover uk-table-striped">
<thead>
<tr>
	<th><?=$lang->line('name');?></th>
	<th><?=$lang->line('size');?></th>
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
	<td class="uk-text-small"><a href="<?=base_url(F_CP .'view/edit/' . $row['name']);?>"><?=$row['name']?></a></td>
	<td class="uk-text-small"><?=$row['size']?></td>
	<td class="uk-text-small"><?=$row['date']?></td>
	<td class="command">
		<ul class="uk-iconnav">
			<li><a href="<?=base_url(F_CP .'view/edit/' . $row['name']);?>" uk-icon="icon: file-edit" title="<?=$lang->line('edit');?>"></a></li>
		</ul>
	</td>
</tr>
<?php
endforeach;
else:
?>
<tr>
	<td class="uk-text-small" colspan="7"><?=$lang->line('no_row')?></td>
</tr>
<?php
endif;
?>
</tbody>
</table>
</div>
