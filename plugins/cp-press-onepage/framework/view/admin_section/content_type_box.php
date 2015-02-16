<? foreach($content_types as $id => $content_type): ?>
<ul class="cp-ctype">
	<li id="content_<?= $id ?>" class="cp-content-type-button button cp-draggable">
		<span class='dashicons-before dashicons-admin-appearance'></span> <?= $content_type ?>
	</li>
</ul>
<? endforeach; ?>


