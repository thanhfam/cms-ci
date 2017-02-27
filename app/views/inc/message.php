<?php
if (isset($content)) {
?>
<div class="<?=$cls?>" uk-alert>
	<a class="uk-alert-close" uk-close></a>
	<?php
	if ($title) {
	?>
	<h3><?=$title?></h3>
	<?php
	}
	?>
	<p><?=$content?></p>
</div>
<?php
}
?>
