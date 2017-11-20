<div class="uk-overflow-auto">
<table class="uk-table uk-table-small uk-table-hover uk-table-striped">
<thead>
<tr>
	<th><?=$lang->line('id')?></th>
	<th><?=$lang->line('name')?></th>
	<th><?=$lang->line('email')?></th>
	<th><?=$lang->line('phone')?></th>
	<th><?=$lang->line('time')?></th>
	<th><?=$lang->line('summary')?></th>
	<th><?=$lang->line('state')?></th>
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
	<td class="uk-text-small"><?=$row['id']?></td>
	<td class="uk-text-small"><?=$row['name']?></td>
	<td class="uk-text-small"><?=$row['email']?></td>
	<td class="uk-text-small"><?=$row['phone']?></td>
	<td class="uk-text-small"><?=$row['time']?></td>
	<td class="uk-text-small"><?=$row['summary'] ? $row['summary'] : '-'?></td>
	<td class="uk-text-small"><?=$lang->line($row['state_name']) ? $lang->line($row['state_name']) : $row['state_name']?> (<?=$row['state_weight']?>)</td>
	<td class="uk-text-small"><?=$row['updated']?></td>
	<td class="command">
		<ul class="uk-iconnav">
			<li><a href="<?=base_url(F_CP .'appointment/edit/' . $row['id'])?>" uk-icon="icon: file-edit" title="<?=$lang->line('edit')?>"></a></li>
		</ul>
	</td>
</tr>
<?php
endforeach;
else:
?>
<tr>
	<td class="uk-text-small" colspan="10"><?=$lang->line('no_row')?></td>
</tr>
<?php
endif;
?>
</tbody>
</table>
</div>
