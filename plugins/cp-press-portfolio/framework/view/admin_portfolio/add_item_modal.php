<div class="modal-dialog">
	<p class="validateTips">Select item to insert in this portfolio.</p>
	<div id="cp-accordion">
		<? foreach($post_types as $post_type): ?>
		<h3 class="cp-accordion-title"><?= $post_type['name'] ?></h3>
		<div class="cp-accordion-content">
			<ol class="cp-selectable">
				<? foreach($post_type['posts'] as $id => $post): ?>
				<? if(!isset($items[$id])): ?>
				<li class="ui-widget-content" data-item="<?= $post_type['name'].'-'.$id; ?>"><?= $post ?></li>
				<? endif; ?>
				<? endforeach; ?>
			</ol>
		</div>
		<? endforeach ?>
	</div>
</div><!-- /.modal-dialog -->
