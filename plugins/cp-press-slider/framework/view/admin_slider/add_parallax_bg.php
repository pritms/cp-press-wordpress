<tr class='slide' id="parallax-background">
	<td>
		<a href='#' id="slide_<?= $slide_id ?>" class='button delete-slide' title='Delete Background'>
			<span class='wp-media-buttons-icon'></span> Delete Bg
		</a>
	</td>
	<td>
		<input type="hidden" name="cp-press-slider[<?= $slide_id ?>][id]" value="<?= $slide_id ?>" />
		<input type="hidden" name="cp-press-slider[<?= $slide_id ?>][action]" value="add_parallax_bg" />
		<div class='thumb' style="background-image: url(<?= $slide_thumb[0]; ?>); width: <?= $slide_thumb[1] ?>px; height: <?= $slide_thumb[2] ?>px;">
			<span class='slide-details'>Image <?= $slide_full[1] ?> X <?= $slide_full[2] ?></span>
		</div>
	</td>
</tr>