<div class="static-container">
	<div class="container-fluid">
		<h1 class="cp-static-title"><?= $page->post_title ?></h1>
		<? if($page->post_content != ''): ?>
		<div class="row">
			<div class="col-md-12 cp-columns">
				<div class="thumbnail">
					<img src="<?= $thumb[0] ?>" alt="<?= $page->post_title ?>" />
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 cp-columns">
				<? the_content() ?>
			</div>
		</div>
		<? endif; ?>
	</div>
</div>