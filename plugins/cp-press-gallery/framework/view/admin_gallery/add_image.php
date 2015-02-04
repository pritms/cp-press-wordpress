<tr class='image'>
	<td>
		<div class='thumb' style="background-image: url(<?= $image_thumb[0]; ?>); width: <?= $image_thumb[1] ?>px; height: <?= $image_thumb[2] ?>px;">
			<a class='delete-image' id="image_<?= $image_id ?>" href='#'>x</a>
			<span class='image-details'>Image <?= $image_full[1] ?> X <?= $image_full[2] ?></span>
		</div>
	</td>
	<td>
		<input type="hidden" name="cp-press-gallery[<?= $image_id ?>][id]" value="<?= $image_id ?>" />
		<p>
			<label for="cp-press-gallery">Image Caption </label><input type='text' name='cp-press-gallery[<?= $image_id ?>][title]' value='<?= $image_title ?>'/>
		</p>
		<p>
			<label for="cp-press-gallery">Is Video </label>
			<input name="cp-press-gallery[<?= $image_id ?>][is_video]" class="cp-video-checkbox" id="video-check-<?= $image_id ?>" type="checkbox" value="1" <?php checked( '1', $is_video ); ?> />&nbsp;
		</p>
		<? if($is_video): ?>
		<p id="video-<?= $image_id ?>">
		<? else: ?>
		<p style="display: none;" id="video-<?= $image_id ?>">
		<? endif; ?>
			<label for="cp-press-gallery">Video URL: </label>
			<input type='text' name='cp-press-gallery[<?= $image_id ?>][video]' value='<?= $video ?>'/>
		</p>
	</td>
</tr>
