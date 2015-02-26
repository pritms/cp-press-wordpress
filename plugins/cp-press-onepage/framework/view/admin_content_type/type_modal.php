<div class="modal-dialog">
	<div id="cp-accordion">
		<? foreach($types as $post_type): ?>
		<h3 class="cp-accordion-title"><?= $post_type['name'] ?></h3>
		<div class="cp-accordion-content">
			<ol class="cp-selectable">
				<? foreach($post_type['posts'] as $id => $post): ?>
				<? if(!isset($items[$id])): ?>
				<li class="ui-widget-content" data-type="<?= $post_type['name'] ?>" data-post="<?= $id ?>" data-col="<?= $col ?>" data-row="<?= $row ?>">
					<div class="cp-ctype-post-title"><?= $post ?></div>
					<div class="cp-ctype-post-content" style="display:none;">
						<? $content = get_extended($post_type['contents'][$id]); ?>
						<?= do_shortcode($content['main']); ?>
					</div>
				</li>
				<? endif; ?>
				<? endforeach; ?>
			</ol>
		</div>
		<? endforeach ?>
	</div>
</div><!-- /.modal-dialog -->
