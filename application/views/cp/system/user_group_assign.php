<div class="uk-overflow-auto">

<form method="post" accept-charset="utf-8" action="<?=current_url()?>" class="uk-form-stacked">
<div uk-grid class="uk-grid-small">
<div class="uk-width-2-5@m">
	<table class="uk-table uk-table-small uk-table-hover uk-table-striped">
	<thead>
	<tr>
		<th><?=$lang->line('id')?></th>
		<th><?=$lang->line('other_right')?></th>
		<th><input class="uk-checkbox" type="checkbox" name="all_other_right" onclick="toggle_all_other_right(this);"></th>
	</tr>
	</thead>
	<tbody>
	<?php
	if (count($list_other_right) > 0):
	foreach ($list_other_right as $row):
	?>
	<tr>
		<td class="uk-text-small"><?=$row['id']?></td>
		<td class="uk-text-small">
			<a href="<?=base_url(F_CP .'right/edit/' . $row['id'])?>" title="<?=$lang->line('edit')?>"><?=$row['name']?></a>
		</td>
		<td class="command">
			<input class="uk-checkbox" type="checkbox" name="other_right[<?=$row['id']?>]">
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

<div class="uk-width-expand@m uk-flex uk-flex-middle">
	<button class="uk-button uk-button-small uk-form-width-small uk-button-primary uk-align-center" type="submit" name="submit" value="add"><?=$lang->line('add')?> &raquo;</button>
	<button class="uk-button uk-button-small uk-form-width-small uk-button-danger uk-align-center" type="submit" name="submit" value="remove">&laquo; <?=$lang->line('remove')?></button>
</div>

<div class="uk-width-2-5@m">
	<table class="uk-table uk-table-small uk-table-hover uk-table-striped">
	<thead>
	<tr>
		<th><?=$lang->line('id')?></th>
		<th><?=$lang->line('current_right')?></th>
		<th><input class="uk-checkbox" type="checkbox" name="all_current_right" onclick="toggle_all_current_right(this)"></th>
	</tr>
	</thead>
	<tbody>
	<?php
	if (count($list_current_right) > 0):
	foreach ($list_current_right as $row):
	?>
	<tr>
		<td class="uk-text-small"><?=$row['id']?></td>
		<td class="uk-text-small">
			<a href="<?=base_url(F_CP .'right/edit/' . $row['id'])?>" title="<?=$lang->line('edit')?>"><?=$row['name']?></a>
		</td>
		<td class="command">
			<input class="uk-checkbox" type="checkbox" name="current_right[<?=$row['id']?>]">
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
</form>

</div>

<script>
var toggle_all_other_right = function(e) {
	if ($(e).prop("checked") || $(e).is(":checked")) {
		$('input.uk-checkbox[name^=other_right]').prop('checked', true);
	}
	else {
		$('input.uk-checkbox[name^=other_right]').prop('checked', false);
	}
}

var toggle_all_current_right = function(e) {
	if ($(e).prop("checked") || $(e).is(":checked")) {
		$('input.uk-checkbox[name^=current_right]').prop('checked', true);
	}
	else {
		$('input.uk-checkbox[name^=current_right]').prop('checked', false);
	}
}
</script>
