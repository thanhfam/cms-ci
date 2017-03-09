<?php
if ($message_show_type == 0) {
?>
<div class="<?=$message['cls']?>" uk-alert>
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
}
else {
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
}
