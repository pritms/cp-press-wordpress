<? global $post; while($sections->have_posts()): $sections->the_post(); ?>
<section id="<?= $post->post_name ?>">
	<? if($post->post_name != 'home'): ?>
		<? the_title(); ?>
		<div class="container-fluid">
	<? endif; ?>
	<? if(isset($content_sections[$post->ID]) && is_array($content_sections[$post->ID])):
		$span = $grid[count($content_sections[$post->ID])];
	?>
	<?	foreach($content_sections[$post->ID] as $row => $col_content_section): ?>
	<?	if($post->post_name != 'home'): ?>
		<div class="row" data-row="<?= $row ?>">
	<? endif; ?>
	<? foreach($col_content_section as $col => $content): ?>
		<? if($post->post_name != 'home'): ?>
		<?=	apply_filters('cp-columns', '<div class="col-lg-'.$content['bootstrap'].' cp-columns" data-column="'.$col.'">', $span, $col, $post) ?>
		<?= apply_filters('cp-content-section', $content['content'], $post) ?>
		<?=	apply_filters('cp-columns-close', '</div>', $span, $col, $post) ?>
		<? else: ?>
		<?= $content['content'] ?>
		<? endif; ?>
	<? endforeach; ?>
	<?	if($post->post_name != 'home'): ?>
		</div>
	<? endif; ?>
	<? endforeach; ?>
	<? endif; ?>
	<? if($post->post_name != 'home'): ?>
		</div>
	<? endif; ?>
</section>
<? endwhile; ?>



