<div class="body">
<div class="page-title">
	<div class="page-title-bg">
	<div class="container">
		<h2><?=$post['title']?></h2>
	</div>
	</div>
</div>
<?php if (isset($post)): ?>
<div class="container">
	<div class="post-content"><?=$post['content']?></div>

	<?php
		if (isset($post['tags'])):
		$tags = explode(',', $post['tags']);
	?>
	<div class="post-tag">
	<?php
		foreach ($tags as $tag):
	?>
	<span class="badge badge-secondary"><?=$tag?></span>
	<?php
		endforeach;
		endif;
	?>
	</div>
</div>
</div>
<?php endif; ?>
</div>
