<ol class="cp-content-type-list">
<? foreach($posts as $id => $post_field): ?>
	<? if($action == 'link'): ?>
	<li><a href="<?= get_permalink($id)?>"><?= $post_field ?></a></li>
	<? else: ?>
	<li><?= $post_field ?></li>
	<? endif; ?>
<? endforeach; ?>
</ol>
