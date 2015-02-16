<div class="static-container">
	<div class="container-fluid">
		<h1><?= $post->post_title ?></h1>
		<? if($post->post_content != ''): ?>
		<div class="col-md-6 cp-columns">
			<? if($gallery): ?>
			<div class="thumbnail pull-left">
				<img src="<?= $thumb[0] ?>" alt="<?= $page->post_title ?>" />
			</div>
			<? endif; ?>
			<? the_content(); ?>
		</div>
		<div class="col-md-6 cp-columns">
			<? if($gallery): ?>
			<?= $gallery ?>
			<? else: ?>
			<div class="thumbnail">
				<img src="<?= $thumb[0] ?>" alt="<?= $page->post_title ?>" />
			</div>
			<? endif; ?>
		</div>
		<? endif; ?>
	</div>
</div>