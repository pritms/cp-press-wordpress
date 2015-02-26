<tr class='cp-slide'>
	<td colspan="3">
		<div id="cp_slide_<?= $slide_id ?>" class="cp-rows row cp-postbox">
			<div class="cp-row-icons cp-row-delete" id="cp-slide-delete-<?= $slide_id ?>" title="Delete Slide"></br></div>
			<div class="cp-row-icons cp-row-move" id="cp-slide-move-<?= $slide_id ?>" title="Sort Slide"></br></div>
			<h3 class="cp-row-handle">
				<? if($slide_title): ?>
				<span><?= $slide_title ?></span>
				<? else: ?>
				<span>&nbsp;</span>
				<? endif; ?>
			</h3>
			<div class="cp-inside">
				<div class="cp-col col-md-12">
					<input type="hidden" name="cp-press-slider[<?= $slide_id ?>][id]" value="<?= $slide_id ?>" />
					<input type="hidden" name="cp-press-slider[<?= $slide_id ?>][action]" value="add_parallax_slide" />
					<label for="cp-press-slider">Slide Text </label><input data-slide="<?= $slide_id ?>" type='text' name='cp-press-slider[<?= $slide_id ?>][title]' value='<?= $slide_title ?>'/>
				</div>
			</div>
		</div>
	</td>
</tr>