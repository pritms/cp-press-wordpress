<? global $post; while($sections->have_posts()): $sections->the_post(); ?>
<section id="<?= $post->post_name ?>" <?= apply_filters('cp-section-attributes', '', $post->post_name) ?>>
	<?= apply_filters('cp-div-section-open', ' <div class="'.$post->post_name.'-section">', $post->post_name); ?>
	<?= apply_filters('cp-section-title-filter', '', $post->post_name, $post->post_title, get_post_meta(get_the_ID(), 'cp-press-section-subtitle', true), $post->ID); ?>


	<? 
	if(isset($content_sections[$post->ID]) && is_array($content_sections[$post->ID])):
		$span = $grid[count($content_sections[$post->ID])];
		foreach($content_sections[$post->ID] as $col => $content_section):
	?>
		<?= apply_filters('cp-section-filter', '<div class="col-lg-'.$span.'">', $span, $col, $post, $content_section); ?>
		<? endforeach; ?>
	<? endif; ?>
	<? if($post->post_name != 'home'): ?>
	<? endif; ?>
	<?= apply_filters('cp-div-section-open', ' <div class="'.$post->post_name.'-section">', $post->post_name); ?>
</section>
<? endwhile; ?>

