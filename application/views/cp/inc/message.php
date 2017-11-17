<?php
if ($message_show_type == 0):
?>
<div class="<?=$message['cls']?> uk-margin-small" uk-alert>
	<a class="uk-alert-close" uk-close></a>
	<?php
	if (isset($message['title'])) {
	?>
	<h3><?=$message['title'];?></h3>
	<?php
	}
	?>
	<p><?=$message['content'];?></p>
</div>
<?php
else:
?>
<script>
var notification = {
	message: "<?=$message['content'];?>",
	status: "<?=$message['status']?>",
	pos: 'top-center',
	timeout: 5000
};
</script>
<?php
endif;

if (isset($message['show_link_back'])):
?>
<div class="uk-margin-small">
	<a class="uk-button uk-button-small" name="btn-back" href="<?=$link_back;?>"><?=$lang->line('back');?></a>
</div>
<?php
endif;
