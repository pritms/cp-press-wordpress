<header class="cp_content_column">
	<h4>Portfolio View options</h4>
</header>
<div class="cpevent_slider_options">
	<p>
		<label class="input-checkbox">Show carousel:</label>
		<input name="cp-press-section-content[<?=$num_col?>][carousel]" type="checkbox" value="1" <?php checked( '1', $content['carousel'] ); ?> />&nbsp;
	</p>
	<p>
		<label class="input-checkbox">Paginate:</label>
		<input name="cp-press-section-content[<?=$num_col?>][paginate]" type="checkbox" value="1" <?php checked( '1', $content['paginate'] ); ?> />&nbsp;
	</p>
	<p>
		<label>Selected item thumb size:</label>
		<input name="cp-press-section-content[<?=$num_col?>][thumb][w]" type="text" value="<?= $content['thumb']['w']; ?>"/>&nbsp;x&nbsp;<input name="cp-press-section-content[<?=$num_col?>][thumb][h]" type="text" value="<?= $content['thumb']['h']; ?>"/>
	</p>
	<p>
		<label>Items per row:</label>
		<input name="cp-press-section-content[<?=$num_col?>][item_per_row]" type="text" value="<? $content['item_per_row'] == '' ? e('3') : e($content['item_per_row']); ?>"/>
	</p>
</div>