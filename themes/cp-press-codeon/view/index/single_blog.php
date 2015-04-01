<?= $menu ?>
<section id="page-head-bg" style="background-image: url(<?= $head_bg[0] ?>);">
	<div class="container">
		<h1><?= $post->post_title ?></h1>
	</div>
</section>
<section id="blog-post" class="padding-80">
	<div class="container">
		<div class="row">
			<div class="col-md-9">
				<div class="blog-item-sec">
					<img src="<?= $thumb[0] ?>" class="img-responsive" alt="">
					<div class="blog-item-head">
						<h3><?= get_post_meta(get_the_ID(), 'cp-press-section-subtitle', true) ?></h3>
					</div>
					<div class="blog-item-post-desc">
						<? the_content() ?>
					</div>
				</div>
				<div class="comment-wrapper">
					<h4>Links</h4>
					<div class="comment-box"></div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="sidebar-box">
					<h4>Commonunities</h4>
					<? foreach($others as $id => $other): ?>
					<div class="popu-post-item">
						<img src="<?= $other['thumb'][0]; ?>" class="img-responsive" alt="">
						<h5><a href="<?= $other['permalink']; ?>"><?= $other['title']; ?></a></h5>
						<span><?= $other['subtitle']; ?></span>
						<p>
							<?= $other['content']; ?>
						</p>
					</div>
					<? endforeach; ?>
				</div>
			</div>
		</div>
	</div>
</section>

