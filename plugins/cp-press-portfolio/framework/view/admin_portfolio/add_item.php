<tr class="cp-item" data-item="<?= $item_id ?>">
	<td colspan="2">
		<div id="cp_item_<?= $item_id ?>" class="cp-rows row cp-postbox">
			<div class="cp-row-icons cp-row-delete" id="cp-item-delete-<?= $item_id ?>" title="Delete Item"></br></div>
			<div class="cp-row-icons cp-row-move" id="cp-item-move-<?= $item_id ?>" title="Sort Item"></br></div>
			<div class="cp-row-icons cp-row-image" id="cp-item-icon-<?= $item_id ?>" title="Add icon"></br></div>
			<h3 class="cp-row-handle">
				<? if($item_title): ?>
				<span><?= $item_title ?></span>
				<? else: ?>
				<span>&nbsp;</span>
				<? endif; ?>
			</h3>
			<div class="cp-inside">
				<div class="cp-col col-md-2">
					<div class='thumb' style="background-image: url(<?= $item_img_thumb[0]; ?>); width: <?= $item_img_thumb[1] ?>px; height: <?= $item_img_thumb[2] ?>px;">
						<span class='cp-item-details'>Image <?= $item_img_full[1] ?> X <?= $item_img_full[2] ?></span>
					</div>
				</div>
				<div class="cp-col col-md-10">
					<input type="hidden" name="cp-press-portfolio[<?= $item_id ?>][id]" value="<?= $item_id ?>" />
					<input type="hidden" name="cp-press-portfolio[<?= $item_id ?>][type]" value="<?= $item_type ?>" />
					<label for="cp-press-portfolio">Title </label><input type='text' disabled="disabled" value='<?= $item_title ?>'/>
					<? if($item_content): ?>
					<label for="cp-press-portfolio">Content </label><textarea disabled="disabled"><?= $item_content ?></textarea>
					<? endif; ?>
					<p>
						<label class="input-checkbox">Enable link:</label>
						<input style="width: auto;" name="cp-press-portfolio[<?= $item_id ?>][enable_link]" type="checkbox" value="1" <?php checked( '1', $item_enable_link ); ?> />&nbsp;
					</p>
					<p>
						<label>Link:</label>
						<input disabled="disable" type="text" value="<?= $item_link ?>"/>
					</p>
				</div>
			</div>
		</div>
	</td>
</tr>