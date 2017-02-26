<?php
if (isset($content)) {
?>
<div class="<?=$cls?>" uk-alert>
	<a class="uk-alert-close" uk-close></a>
	<h3><?=$title?></h3>
	<p><?=$content?></p>
</div>
<?php
}
?>
