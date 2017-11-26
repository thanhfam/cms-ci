<nav class="uk-navbar-container uk-margin-small" uk-navbar>
	<div class="uk-navbar-left">
		<div class="uk-navbar-item">
			<form method="get" accept-charset="UTF-8" action="<?=current_url()?>">
			<div class="uk-form-controls uk-inline">
				<span class="uk-form-icon" uk-icon="icon: search"></span>
				<input class="uk-input uk-form-small keyword" type="search" placeholder="<?=$lang->line('keyword')?>" name="keyword" value="<?=$filter['keyword']?>" />
			</div>

			<select class="uk-select uk-form-small uk-width-small" id="state-selector" name="state_weight">
				<option value="" disabled><?=$lang->line('select_one') .' ' .$lang->line('state')?></option>
				<?php foreach ($list_state as $state): ?>
				<option value="<?=$state['weight']?>" <?=($state['weight'] == $filter['state_weight']) ? 'selected' : ''?>><?=$lang->line($state['name']) ? $lang->line($state['name']) .' (' .$state['weight'] .')': $state['name']?></option>
				<?php endforeach; ?>
			</select>

			<button class="uk-button-small uk-button uk-button-primary" type="submit"><?=$lang->line('filter')?></button>
			<a class="uk-button uk-button-small uk-button-secondary" href="<?=current_url()?>"><?=$lang->line('unfilter')?></a>
			</form>
		</div>
	</div>
	<div class="uk-navbar-right">
		<div class="uk-navbar-item">
		<?php
			if ($link_create) {
		?>
			<a class="uk-button-small uk-button uk-button-primary" href="<?=$link_create?>"><?=$lang->line('create')?></a>
		<?php
			}
		?>
		</div>
	</div>
</nav>

<div class="uk-overflow-auto">
<table class="uk-table uk-table-small uk-table-hover uk-table-striped">
<thead>
<tr>
	<th><?=$lang->line('id')?></th>
	<th><?=$lang->line('title')?></th>
	<th><?=$lang->line('category')?></th>
	<!--
	<th><?=$lang->line('site')?></th>
	-->
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
	<td class="uk-text-small">
		<?=$row['title'] ? '<a target="_blank" href="'. $row['site_url'] .$row['uri'] .'">' .$row['title'] .'</a>' : ''?>
	</td>
	<td class="uk-text-small"><?=$row['parent_title']?></td>
	<!--
	<td class="uk-text-small"><?=$row['site_title']?></td>
	-->
	<td class="uk-text-small">
		<?=$lang->line($row['state_name']) ? $lang->line($row['state_name']) : $row['state_name']?> (<?=$row['state_weight']?>)
	</td>
	<td class="uk-text-small">
		<?=$row['updated']?>
	</td>
	<td class="command">
		<ul class="uk-iconnav">
			<li><a href="<?=base_url(F_CP .'post/list/?cate_id=' . $row['id']);?>" uk-icon="icon: list" title="<?=$lang->line('list')?>"></a></li>
			<li><a href="<?=base_url(F_CP .'category/edit/' . $row['id'])?>" uk-icon="icon: file-edit" title="<?=$lang->line('edit')?>"></a></li>
		</ul>
	</td>
</tr>
<?php
endforeach;
else:
?>
<tr>
	<td class="uk-text-small" colspan="6"><?=$lang->line('no_row')?></td>
</tr>
<?php
endif;
?>
</tbody>
</table>
</div>
