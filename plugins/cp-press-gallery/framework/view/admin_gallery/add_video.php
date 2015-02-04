<tr class='image'>
	<td>
		<div class='thumb' style="background-image: url(<?= $video_thumb[0]; ?>); width: <?= $video_thumb[1] ?>px; height: <?= $video_thumb[2] ?>px;">
			<a class='delete-video' id="<?= $video_id ?>" href='#'>x</a>
			<span class='image-details'>Video <?= $video_full[1] ?> X <?= $video_full[2] ?></span>
		</div>
	</td>
	<td>
		<input type="hidden" name="cp-press-gallery[<?= $video_id ?>][id]" value="<?= $video_id ?>" />
		<input type="hidden" name="cp-press-gallery[<?= $video_id ?>][video_thumbnail]" value="<?= $video_thumb[0] ?>" />
		<p>
			<label for="cp-press-gallery">Video Caption </label><input type='text' name='cp-press-gallery[<?= $video_id ?>][title]' value='<?= $video_title ?>'/>
		</p>
		<p>
			<label for="cp-press-gallery">Is Video </label>
			<input name="cp-press-gallery[<?= $video_id ?>][is_video]" class="cp-video-checkbox" id="video-check-<?= $video_id ?>" type="checkbox" value="1" <?php checked( '1', $is_video ); ?> />&nbsp;
		</p>
		<? if($is_video): ?>
		<p id="video-<?= $image_id ?>">
		<? else: ?>
		<p style="display: none;" id="video-<?= $image_id ?>">
		<? endif; ?>
			<label for="cp-press-gallery">Video URL: </label>
			<input type='text' name='cp-press-gallery[<?= $video_id ?>][video]' value='<?= $video ?>'/>
		</p>
	</td>
</tr>