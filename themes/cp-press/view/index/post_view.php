<? if($post_title != ''): ?>
<h3><?= $post_title ?></h3>
<? endif; ?>
<? while($cp_post->have_posts()) : $cp_post->the_post(); ?>
	<? if(is_page()){
		global $more;
		$more = 0;
	} ?>
	<? if(!$hide_thumb && has_post_thumbnail() && !isset($cp_post_options['hidethumbinhome'])): ?>
	<div class="post-thumbnail">
		<a href="<?= get_the_permalink() ?>"><? the_post_thumbnail('post-thumbnail', array('class' => 'img-responsive')); ?></a>
	</div>
	<? endif ?>
	<? if(!isset($cp_post_options['hidetitleinhome'])): ?>
		<? the_title(); ?>
	<? endif; ?>
	<? the_content(); ?>
<? endwhile; ?>
