<? while($content['post']->have_posts()) : $content['post']->the_post(); ?>
	<? if(is_page()){
		global $more;
		$more = 0;
	} ?>
	<? the_title(); ?>
	<? the_content(); ?>
<? endwhile; ?>