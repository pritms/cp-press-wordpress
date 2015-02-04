<tr class='item'>
	<td>
		<div class='thumb' style="background-image: url(<?= $item_img_thumb[0]; ?>); width: <?= $item_img_thumb[1] ?>px; height: <?= $item_img_thumb[2] ?>px;">
			<a class='delete-item' id="item_<?= $item_id ?>" href='#'>x</a>
				<span class='item-details'>Image <?= $item_img_full[1] ?> X <?= $item_img_full[2] ?></span>
		</div>
	</td>
	<td>
		<input type="hidden" name="cp-press-portfolio[<?= $item_id ?>][id]" value="<?= $item_id ?>" />
		<input type="hidden" name="cp-press-portfolio[<?= $item_id ?>][type]" value="<?= $item_type ?>" />
		<label for="cp-press-portfolio">Title </label><input type='text' disabled="disabled" value='<?= $item_title ?>'/>
		
		<label for="cp-press-portfolio">Content </label><textarea disabled="disabled"><?= $item_content ?></textarea>
		<p>
			<label class="input-checkbox">Enable link:</label>
			<input style="width: auto;" name="cp-press-portfolio[<?= $item_id ?>][enable_link]" type="checkbox" value="1" <?php checked( '1', $item_enable_link ); ?> />&nbsp;
		</p>
		<p>
			<label>Link:</label>
			<input disabled="disable" type="text" value="<?= $item_link ?>"/>
		</p>
	</td>
</tr>
