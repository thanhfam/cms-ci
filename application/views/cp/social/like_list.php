<div class="uk-overflow-auto">
<table class="uk-table uk-table-small uk-table-hover uk-table-striped">
<thead>
<tr>
	<th><?=$lang->line('id')?></th>
	<th><?=$lang->line('content')?></th>
	<th><?=$lang->line('content_type')?></th>
	<th><?=$lang->line('user')?></th>
	<th><?=$lang->line('created')?></th>
</tr>
</thead>
<tbody>
<?php
if (count($list) > 0):
foreach ($list as $row):
?>
<tr>
	<td class="uk-text-small">
		<?=$row['id']?>
	</td>
	<td class="uk-text-small">
		<?=$row['content_title']?> (<?=$row['content_id']?>)
	</td>
	<td class="uk-text-small">
		<?=$row['content_type']?>
	</td>
	<td class="uk-text-small">
		<?=$row['username']?> (<?=$row['user_id']?>)
	</td>
	<td class="uk-text-small">
		<?=$row['created']?>
	</td>
</tr>
<?php
endforeach;
else:
?>
<tr>
	<td colspan="6" class="uk-text-small"><?=$lang->line('no_row')?></td>
</tr>
<?php
endif;
?>
</tbody>
</table>
</div>
