<?php if (isset($message)): ?>
<div class="alert-dismissible fade show alert alert-<?=$message['status']?>" role="alert">
	<?php if (isset($message['title'])): ?>
	<h4 class="alert-heading"><?=$message['title'];?></h4>
	<?php endif; ?>

	<div><?=$message['content'];?></div>

	<button type="button" class="close" data-dismiss="alert" aria-label="Đóng">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
<?php endif; ?>
