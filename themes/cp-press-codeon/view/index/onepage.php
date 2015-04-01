<? global $post; while($sections->have_posts()): $sections->the_post(); ?>
<section id="<?= $post->post_name ?>" <?= apply_filters('cp-section-attributes', '', $post->post_name) ?>>
	<?= apply_filters('cp-section-title', '', $post->post_name, $post->post_title, get_post_meta(get_the_ID(), 'cp-press-section-subtitle', true), $post->ID); ?>

	<? if(isset($content_sections[$post->ID]) && is_array($content_sections[$post->ID])):?>
	<?= apply_filters('cp-container-open', '<div class="container">', $post->post_name); ?>
	<?	foreach($content_sections[$post->ID] as $row => $col_content_section): ?>
		<?=	apply_filters('cp-row-open', '<div class="row" data-row="'.$row.'">', $post->post_name); ?>
	<? foreach($col_content_section as $col => $content): ?>
		<?= apply_filters('cp-col-open', '<div class="col-md-'.$content['bootstrap'].'">', $post->post_name); ?>
		<?= $content['content'] ?>
		<?= apply_filters('cp-col-close', '</div>', $post->post_name); ?>
	<? endforeach; ?>
		<?=	apply_filters('cp-row-close', '</div>', $post->post_name); ?>
	<? endforeach; ?>
	<?= apply_filters('cp-container-close', '</div>', $post->post_name); ?>
	<? endif; ?>
</section>
<? endwhile; ?>

