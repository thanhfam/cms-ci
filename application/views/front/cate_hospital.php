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
	<div class="post-list">
	<?php
	if (count($list_post) > 0):
	foreach ($list_post as $post):
	?>
	<div class="post col">
		<div class="row">
			<?php if ($post['avatar_url']): ?>
			<div class="col col-sm-2">
				<?php switch($post['avatar_type']):
					case MT_IMAGE: ?>
					<a href="<?=base_url($post['uri'])?>">
					<img class="post-avatar img-fluid" src="<?=$post['avatar_url']?>" />
					</a>
				<?php
					break;
					case MT_VIDEO:
				?>
					<video class="card-img img-fluid" controls>
						<source src="<?=$post['avatar_url']?>" type="video/mp4">
						Your browser does not support the video tag.
					</video>
				<?php
					break;
					case MT_AUDIO:
				?>
					<audio class="card-img img-fluid" controls>
						<source src="<?=$post['avatar_url']?>" type="audio/mpeg">
						Your browser does not support the audio tag.
					</audio>
				<?php
					break;
					endswitch;
				?>
			</div>
			<?php endif; ?>
			<div class="col">
				<h4 class="post-title"><a href="<?=base_url($post['uri'])?>"><?=$post['title']?></a></h4>
				<p class="post-lead"><?=$post['lead']?></p>
				<?php
				if (isset($post['tags'])):
				$tags = explode(',', $post['tags']);
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
	<?php
	endforeach;
	endif;
	?>
	</div>
	<nav>
		<?=$pagy->create_links();?>
	</nav>
</div>
<?php endif; ?>
</div>
