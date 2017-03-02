<div class="<?=$message['cls']?> <?=isset($width) ? $width : '';?>" uk-alert>
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
