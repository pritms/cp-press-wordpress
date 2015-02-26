<? while($cp_page->have_posts()) : $cp_page->the_post(); ?>
	<? if(is_page()){
		global $more;
		$more = 0;
	} ?>
	<? if(!$hide_thumb && has_post_thumbnail()): ?>
	<div class="post-thumbnail">
		<a href="<?= get_the_permalink() ?>"><? the_post_thumbnail('post-thumbnail', array('class' => 'img-responsive')); ?></a>
	</div>
	<? endif ?>
	<? if(!$hide_title): ?>
		<? the_title(); ?>
	<? endif; ?>
	<? the_content(); ?>
<? endwhile; ?>
