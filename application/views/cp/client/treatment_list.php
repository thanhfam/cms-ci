<nav class="uk-navbar-container uk-margin-small" uk-navbar>
	<div class="uk-navbar-left">
		<div class="uk-navbar-item">
			<form method="get" accept-charset="utf-8" action="<?=current_url()?>">
			<div class="uk-form-controls uk-inline">
				<span class="uk-form-icon" uk-icon="icon: search"></span>
				<input class="uk-input uk-form-small keyword" type="search" placeholder="<?=$lang->line('keyword')?>" name="filter" value="<?=$filter?>" />
			</div>
			<button class="uk-button-small uk-button uk-button-primary filter" type="submit"><?=$lang->line('filter')?></button>
			<button class="uk-button-small uk-button unfilter" type="submit"><?=$lang->line('unfilter')?></button>
			</form>
		</div>
	</div>
	<div class="uk-navbar-right">
		<div class="uk-navbar-item">
		<?php if (isset($link_back)): ?>
			<a class="uk-button-small uk-button uk-button-primary" href="<?=$link_back?>"><?=$lang->line('back')?></a>
		<?php endif; ?>
		<?php if (isset($link_create)): ?>
			<a class="uk-button-small uk-button uk-button-primary" href="<?=$link_create?>"><?=$lang->line('create')?></a>
		<?php endif; ?>
		</div>
	</div>
</nav>

<div class="uk-overflow-auto">
<table class="uk-table uk-table-small uk-table-hover uk-table-striped">
<thead>
<tr>
	<th><?=$lang->line('id')?></th>
	<th><?=$lang->line('customer')?></th>
	<th><?=$lang->line('hospital')?></th>
	<th><?=$lang->line('service')?></th>
	<th><?=$lang->line('price')?></th>
	<th><?=$lang->line('agency')?></th>
	<th><?=$lang->line('staff')?></th>
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
	<td class="uk-text-small">
		<?php if ($row['c1_id']): ?>
		<?=$row['c1_last_name']?> <?=$row['c1_middle_name']?> <?=$row['c1_first_name']?> (<?=$row['c1_id']?>)
		<?php endif; ?>
		<?php if ($row['c2_id']): ?>
		<br/>
		<?=$row['c2_last_name']?> <?=$row['c2_middle_name']?> <?=$row['c2_first_name']?> (<?=$row['c2_id']?>)
		<?php endif; ?>
	</td>
	<td class="uk-text-small">
		<?=$row['h_title']?>
	</td>
	<td class="uk-text-small">
		<?=$row['service_title'] ? $row['service_title'] : $row['sv_title']?> (<?=number_format($row['sv_price'], 0, ',', '.')?>)
	</td>
	<td class="uk-text-small">
		<?=number_format($row['service_price'], 0, ',', '.')?>
	</td>
	<td class="uk-text-small">
		<?=$row['a_last_name']?> <?=$row['a_middle_name']?> <?=$row['a_first_name']?> (<?=$row['a_id']?>)
	</td>
	<td class="uk-text-small">
		<?=$row['st_last_name']?> <?=$row['st_middle_name']?> <?=$row['st_first_name']?> (<?=$row['st_id']?>)
	</td>
	<td class="uk-text-small">
		<?=$row['updated']?>
	</td>
	<td class="command">
		<ul class="uk-iconnav">
			<li><a href="<?=base_url(F_CP .'treatment/edit/' .$row['id'])?>" uk-icon="icon: file-edit" title="<?=$lang->line('edit')?>"></a></li>
			<li><a href="<?=base_url(F_CP .'treatment/remove/' .$row['id'])?>" uk-icon="icon: trash" data-msg="<?=$lang->line('sure_to_remove')?>" title="<?=$lang->line('remove')?>" class="btn-remove"></a></li>
		</ul>
	</td>
</tr>
<?php
endforeach;
else:
?>
<tr>
	<td class="uk-text-small" colspan="8"><?=$lang->line('no_row')?></td>
</tr>
<?php
endif;
?>
</tbody>
</table>
</div>
