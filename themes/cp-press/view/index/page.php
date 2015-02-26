<div class="static-container">
	<div class="cp_sidebar">
	<? dynamic_sidebar('home'); ?>
	</div>
	<div class="container-fluid">
		<h1 class="cp-static-title"><?= $page->post_title ?></h1>
		<? if($page->post_content != ''): ?>
		<div class="col-md-6 cp-columns">
			<? the_content() ?>
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