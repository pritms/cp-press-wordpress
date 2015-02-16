<tr class='slide'>
	<td>
		<a href='#' id="slide_<?= $slide_id ?>" class='button delete-slide' title='Delete Slide'>
			<span class='wp-media-buttons-icon'></span> Delete Slide
		</a>
	</td>
	<td>
		<input type="hidden" name="cp-press-slider[<?= $slide_id ?>][id]" value="<?= $slide_id ?>" />
		<input type="hidden" name="cp-press-slider[<?= $slide_id ?>][action]" value="add_parallax_slide" />
		<label for="cp-press-slider">Slide Text </label><input type='text' name='cp-press-slider[<?= $slide_id ?>][title]' value='<?= $slide_title ?>'/>
	</td>
</tr>