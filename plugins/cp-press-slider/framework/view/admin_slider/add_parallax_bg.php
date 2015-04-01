<tr class="cp-slide" id="parallax-background" data-slide="<?= $slide_id ?>">
	<td colspan="3">
		<div id="cp_slide_<?= $slide_id ?>" class="cp-rows row cp-postbox">
			<div class="cp-row-icons cp-row-delete" id="cp-slide-delete-<?= $slide_id ?>" title="Delete Background"></br></div>
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
					<input type="hidden" name="cp-press-slider[<?= $slide_id ?>][action]" value="add_parallax_bg" />
					<div class='thumb' style="background-image: url(<?= $slide_thumb[0]; ?>); width: <?= $slide_thumb[1] ?>px; height: <?= $slide_thumb[2] ?>px;">
						<span class='slide-details'>Image <?= $slide_full[1] ?> X <?= $slide_full[2] ?></span>
					</div>
				</div>
			</div>
		</div>
		</div>
	</td>
</tr>