<tr class='slide'>
	<td>
		<div class='thumb' style="background-image: url(<?= $slide_thumb[0]; ?>); width: <?= $slide_thumb[1] ?>px; height: <?= $slide_thumb[2] ?>px;">
			<a class='delete-slide' id="slide_<?= $slide_id ?>" href='#'>x</a>
			<span class='slide-details'>Image <?= $slide_full[1] ?> X <?= $slide_full[2] ?></span>
		</div>
	</td>
	<td>
		<input type="hidden" name="cp-press-slider[<?= $slide_id ?>][id]" value="<?= $slide_id ?>" />
		<label for="cp-press-slider">TITLE </label><input type='text' name='cp-press-slider[<?= $slide_id ?>][title]' value='<?= $slide_title ?>'/>
		<? wp_editor( $slide_content, 'slider_editor_'.$slide_id, array( 'textarea_name' => 'cp-press-slider['.$slide_id.'][content]', 'teeny' => false, 'media_buttons' => false ) ); ?>
	</td>
</tr>