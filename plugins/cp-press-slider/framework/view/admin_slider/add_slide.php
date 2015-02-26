<tr class="cp-slide" data-slide="<?= $slide_id ?>">
	<td colspan="2">
		<div id="cp_slide_<?= $slide_id ?>" class="cp-rows row cp-postbox">
			<div class="cp-row-icons cp-row-delete" id="cp-slide-delete-<?= $slide_id ?>" title="Delete Slide"></br></div>
			<div class="cp-row-icons cp-row-move" id="cp-slide-move-<?= $slide_id ?>" title="Sort Slide"></br></div>
			<div class="cp-row-icons cp-row-link" id="cp-slide-link-<?= $slide_id ?>" title="Link Slide"></br></div>
			<h3 class="cp-row-handle">
				<? if($slide_title): ?>
				<span><?= $slide_title ?></span>
				<? else: ?>
				<span>&nbsp;</span>
				<? endif; ?>
			</h3>
			<div class="cp-inside">
				<div class="cp-col col-md-2">
					<div class='thumb' style="background-image: url(<?= $slide_thumb[0]; ?>); width: <?= $slide_thumb[1] ?>px; height: <?= $slide_thumb[2] ?>px;">
						<span class='slide-details'>Image <?= $slide_full[1] ?> X <?= $slide_full[2] ?></span>
					</div>
				</div>
				<div class="cp-col col-md-10">
					<input type="hidden" name="cp-press-slider[<?= $slide_id ?>][id]" value="<?= $slide_id ?>" />
					<input type="hidden" name="cp-press-slider[<?= $slide_id ?>][action]" value="add_slide" />
					<label for="cp-press-slider">TITLE </label><input type='text' data-slide="<?= $slide_id ?>" name='cp-press-slider[<?= $slide_id ?>][title]' value='<?= $slide_title ?>'/>
					<? if($slide_link != ''): ?>
					<label for="cp-press-slider">LINK </label><input type="text" readonly data-input="link" name="cp-press-slider[<?= $slide_id ?>][link]" value="<?= $slide_link ?>"/>
					<? endif ?>
					<? wp_editor( $slide_content, 'slider_editor_'.$slide_id, array( 'textarea_name' => 'cp-press-slider['.$slide_id.'][content]', 'teeny' => false, 'media_buttons' => false ) ); ?>
				</div>
			</div>
		</div>
	</td>
</tr>