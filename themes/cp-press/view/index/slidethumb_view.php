<? while($cp_page->have_posts()) : $cp_page->the_post(); ?>
	<? if(is_page()){
		global $more;
		$more = 0;
	} ?>
	<? the_content(); ?>
<? endwhile; ?>
