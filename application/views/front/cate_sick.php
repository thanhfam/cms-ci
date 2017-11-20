<div class="body">
<?php if (isset($cate)): ?>
<div class="cate-list container">
<h2 class="cate-title"><?=$cate['title']?></h2>
<div class="post-list">
<?php
if (count($list_post) > 0):
foreach ($list_post as $post):
?>
<div class="post col">
	<div class="row">
		<?php if ($post['avatar_filename']): ?>
		<div class="col col-sm-2">
			<a href="<?=base_url($post['name'])?>"><img class="post-avatar img-fluid" src="<?=base_url(F_FILE .$post['avatar_filename'])?>" /></a>
		</div>
		<?php endif; ?>
		<div class="col">
			<h4 class="post-title"><a href="<?=base_url($post['name'])?>"><?=$post['title']?></a></h4>
			<p class="post-lead"><?=$post['lead']?></p>
		</div>
	</div>
</div>
<?php
endforeach;
else:
?>

<?php endif; ?>
</div>
<nav>
	<?=$pagy->create_links();?>
</nav>
</div>
<?php endif; ?>
</div>