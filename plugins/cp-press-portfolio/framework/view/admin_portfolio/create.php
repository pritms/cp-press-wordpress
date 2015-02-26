<table class="widefat cp-portfolio append-portfolio sortable" id="portfolio_<?=$portfolio_id?>">
	<thead>
	<tr>
		<th style="width: 100px;">
			<h3>Items</h3>
		</th>
		<th>
			<a href='#' class='button alignright add-item' data-editor='content' title='Add Item'>
				<span class='wp-media-buttons-icon'></span> Add Item
			</a>
		</th>

	</tr>
	</thead>

	<tbody>
		<?= $portfolio_body ?>
	</tbody>
</table>
<table class="widefat portfolio-settings" id="portfolio_settings_<?=$slider_id?>">
	<thead>
	<tr>
		<th style="width: 100px;">
			<h3>Portfolio Settings</h3>
		</th>
	</tr>
	</thead>

	<tbody>
		<tr>
			<td>
				<p>
					<label>Title:</label>
					<input class="widefat" name="cp-press-portfolio[title]" type="text" value="<?= $title; ?>"/>
				</p>
				<p>
					<label>Selected item thumb size:</label>
					<input name="cp-press-portfolio[thumb][w]" type="text" value="<? isset($thumb['w']) ? e($thumb['w']) : 100 ?>"/>&nbsp;x&nbsp;<input name="cp-press-portfolio[thumb][h]" type="text" value="<? isset($thumb['h']) ? e($thumb['h']) : 100; ?>"/>
				</p>
				<p>
					<label>Items per row:</label>
					<input name="cp-press-portfolio[item_per_row]" type="text" value="<? $item_per_row == '' ? e('3') : e($item_per_row); ?>"/>
				</p>
				<p>
					<label class="input-checkbox">Show icons:</label>
					<input name="cp-press-portfolio[show_link]" type="checkbox" value="1" <?php checked( '1', $show_link ); ?> />&nbsp;
				</p>
				<p>
					<label class="input-checkbox">Hide information box (this options makes all box clickable)</label>
					<input name="cp-press-portfolio[hideinfo]" type="checkbox" value="1" <?php checked( '1', $hideinfo ); ?> />&nbsp;
				<p>
			</td>
		</tr>
	</tbody>
</table>
