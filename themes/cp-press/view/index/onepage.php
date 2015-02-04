<? global $post; while($sections->have_posts()): $sections->the_post(); ?>
<section id="<?= $post->post_name ?>">
	<? if($post->post_name != 'home'): ?>
		<? the_title(); ?>
		<div class="container-fluid">
			<div class="row">
	<? endif; ?>
	<? 
	if(isset($content_sections[$post->ID]) && is_array($content_sections[$post->ID])):
		$span = $grid[count($content_sections[$post->ID])];
		foreach($content_sections[$post->ID] as $col => $content_section):
	?>
		<? if($post->post_name != 'home'): ?>
			<?=	apply_filters('cp-columns', '<div class="col-lg-'.$span.' cp-columns">', $span, $col, $post) ?>
			<?= apply_filters('cp-content-section', $content_section, $post) ?>
			</div>
		<? else: ?>
		<?= $content_section ?>
		<? endif; ?>
		<? endforeach; ?>
	<? endif; ?>
	<? if($post->post_name != 'home'): ?>
			</div>
		</div>
	<? endif; ?>
</section>
<? endwhile; ?>

