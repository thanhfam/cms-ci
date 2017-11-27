<div class="body">
<div class="page-title">
	<div class="page-title-bg">
	<div class="container">
		<h2><?=$cate['title']?></h2>
	</div>
	</div>
</div>
<?php if (isset($cate)): ?>
<div class="container">
<div class="post-list row">
<?php
if (count($list_post) > 0):
foreach ($list_post as $post):
?>
	<div class="col-sm-6 col-md-3 col-lg-2">
		<div class="post">
			<?php if ($post['avatar_filename']): ?>
			<a href="<?=base_url($post['uri'])?>"><img class="card-img img-fluid" src="<?=base_url(F_FILE .$post['avatar_filename'])?>"></a>
			<?php endif; ?>
			<h4 class="post-title"><a href="<?=base_url($post['uri'])?>"><?=$post['title']?></a></h4>
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