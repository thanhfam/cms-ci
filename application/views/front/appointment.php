<link rel="stylesheet" type="text/css" href="<?=base_url(F_PUB .F_FRONT .'datetimepicker/jquery.datetimepicker.min.css')?>"/>
<script src="<?=base_url(F_PUB .F_FRONT .'datetimepicker/jquery.datetimepicker.full.min.js')?>"></script>
<script src='https://www.google.com/recaptcha/api.js'></script>

<div class="body">
<div id="appointment" class="container">
<h2 class="page-title"><?=$cate['title']?></h2>
<p class="cate-lead"><?=$cate['lead']?></h2>

<?php
	$this->load->view(F_FRONT .'message');
?>

<?php if (!isset($hide_form)): ?>
<form id="form-appointment" method="post" accept-charset="utf-8" action="<?=current_url()?>">

<div class="form-group row col-sm-12 col-md-6">
	<label class="col-sm-3 col-form-label" for="name"><?=$lang->line('name')?> (*)</label>
	<div class="col-sm-9">
		<input type="text" name="name" id="name" value="<?=isset($item) ? $item['name'] : ''?>" class="form-control form-control-sm" />
		<?=form_error('name')?>
	</div>
</div>

<div class="form-group row col-sm-12 col-md-6">
	<label class="col-sm-3 col-form-label" for="email"><?=$lang->line('email')?> (*)</label>
	<div class="col-sm-9">
		<input type="text" name="email" id="email" value="<?=isset($item) ? $item['email'] : ''?>" class="form-control form-control-sm" />
		<?=form_error('email')?>
	</div>
</div>

<div class="form-group row col-sm-12 col-md-6">
	<label class="col-sm-3 col-form-label" for="phone"><?=$lang->line('phone')?> (*)</label>
	<div class="col-sm-9">
		<input type="text" name="phone" id="phone" value="<?=isset($item) ? $item['phone'] : ''?>" class="form-control form-control-sm" />
		<?=form_error('phone')?>
	</div>
</div>

<div class="form-group row col-sm-12 col-md-6">
	<label class="col-sm-3 col-form-label" for="address"><?=$lang->line('address')?> (*)</label>
	<div class="col-sm-9">
		<input type="text" name="address" id="address" value="<?=isset($item) ? $item['address'] : ''?>" class="form-control form-control-sm" />
		<?=form_error('address')?>
	</div>
</div>

<div class="form-group row col-sm-12 col-md-6">
	<label class="col-sm-3 col-form-label" for="time"><?=$lang->line('time')?></label>
	<div class="col-sm-9">
		<input type="text" name="time" id="time" value="<?=isset($item) ? $item['time'] : ''?>" class="form-control form-control-sm" />
		<?=form_error('time')?>
	</div>
</div>

<div class="form-group row col-sm-12 col-md-6">
	<label class="col-sm-3 col-form-label" for="content"><?=$lang->line('content')?></label>
	<div class="col-sm-9">
		<textarea type="text" name="content" id="content" rows="6" class="form-control form-control-sm"><?=isset($item) ? $item['content'] : ''?></textarea>
		<?=form_error('content')?>
	</div>
</div>

<div class="form-group row col-sm-12 col-md-6">
	<div class="col-sm-9 offset-sm-3">
		<div class="g-recaptcha" data-sitekey="6LcIjjkUAAAAAD73RIFklLVO2CZ0op5WdZRK-YTP"></div>
	</div>
</div>

<div class="form-group row col-sm-12 col-md-6">
	<div class="col-sm-9 offset-sm-3">
		<input type="hidden" name="id" value="<?=isset($item) ? $item['id'] : ''?>" />
		<button class="btn btn-secondary" type="submit" name="submit" value="save"><?=$lang->line('send')?></button>
	</div>
</div>

</form>
</div>
</div>

<script>
$('#time').datetimepicker({
	inline: true,
	defaultSelect: false
});
</script>

<?php endif; ?>
