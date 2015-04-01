<?= $menu ?>
<section id="blog-post" class="padding-80">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="blog-item-sec" style="margin-bottom: 10px;">
					<?	the_post_thumbnail('full', array( 'class' => 'img-responsive' ) ) ?>
					<div class="blog-item-head">
						<h3><a href="<? the_permalink(); ?>"><? the_title() ?></a> </h3>
					</div><!--blog post item heading end-->
					<div class="blog-item-post-info">
						<span><? the_author_link() ?> | <? the_date() ?>  | <a href="<? comments_link(); ?>"><? comments_number( 'Nessun commento', '1 commento', '% commenti' ); ?></a> |  </span>
					</div><!--blog post item info end-->
					<div class="blog-item-post-desc">
						<? the_content(''); ?>
					</div><!--blog-item-post-desc end-->
				</div>
			</div>
		</div>
	</div>
</section>

