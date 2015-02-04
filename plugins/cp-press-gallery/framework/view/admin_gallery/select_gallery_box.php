<p>Gallery:
	<select class="widefat" name="cp-press-gallery-select">
		<option value="0"></option>
		<? foreach($galleries as $id => $gallery): ?>
		<option value="<?= $id ?>" <? selected($g_selected, $id); ?>><?= $gallery ?></option>
		<? endforeach; ?>
	</select>
</p>
