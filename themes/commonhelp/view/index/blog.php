<?= $menu ?>
<section id="page-head-bg" style="background-image: url(<?= apply_filters( 'taxonomy-images-queried-term-image-url', '', array('image_size' => 'full') ); ?>)">
	<div class="container">
		<h1><?= get_query_var('blog'); ?></h1>
	</div>
</section>
<section id="blog-list" class="padding-80">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
			<?
				if(have_posts()):
					while(have_posts()) : the_post();
			?>
				<div class="blog-item-sec">
					<? if(has_post_thumbnail()): ?>
					<a href="<? the_permalink() ?>">
						<?	the_post_thumbnail('full', array( 'class' => 'img-responsive' ) ) ?>
					</a>
					<? endif; ?>
					<div class="blog-item-head">
						<h3><a href="<? the_permalink(); ?>"><? the_title() ?></a> </h3>
					</div><!--blog post item heading end-->
					<div class="blog-item-post-info">
						<span><? the_author_link() ?> | <? the_date() ?>  | <a href="<? comments_link(); ?>"><? comments_number( 'Nessun commento', '1 commento', '% commenti' ); ?></a> |  </span>
					</div><!--blog post item info end-->
					<div class="blog-item-post-desc">
						<? the_content(''); ?>
					</div><!--blog-item-post-desc end-->
					<div class="blog-more-desc">
						<div class="row">
							<div class="col-sm-7 col-xs-12">
								<ul class="list-inline social-colored">
									<li class="empty-text">Share:</li> 
									<li><a href="#"><i class="fa fa-facebook icon-fb" data-toggle="tooltip" title="" data-original-title="Facebook" data-placement="top"></i></a></li>
									<li><a href="#"><i class="fa fa-twitter icon-twit" data-toggle="tooltip" title="" data-original-title="Twitter" data-placement="top"></i></a></li>
									<li><a href="#"><i class="fa fa-google-plus icon-plus" data-toggle="tooltip" title="" data-original-title="Google pluse" data-placement="top"></i></a></li>
									<li><a href="#"><i class="fa fa-pinterest icon-pin" data-toggle="tooltip" title="" data-original-title="Linkedin" data-placement="top"></i></a></li>

								</ul> <!--colored social-->
							</div>
							<div class="col-sm-5 text-right col-xs-12">
								<a href="<? the_permalink(); ?>" class="btn btn-theme-color">Leggi tutto <i class="fa fa-angle-right"></i></a>
							</div>
						</div>
					</div><!--blog more desc end-->
				</div>  <!--blog-item section end-->
			<?
					endwhile;
				endif;
			?>
			</div>
			<?= $navpaged ?>
		</div>
	</div>
</section>