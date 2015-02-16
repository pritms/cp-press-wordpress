<div class="static-container">
	<div class="container-fluid">
		<h1 class="cp-static-title">multimedia</h1>
		<div class="cp-gallery-title" style="padding: 0;">
			<h3><?= $post->post_title ?></h3>
			<? the_excerpt(); ?>
		</div>
		<div style="padding: 0;">
			<?= $gallery ?>
		</div>
	</div>
</div>