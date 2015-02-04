<table class="widefat slider append-slide sortable" id="slider_<?=$slider_id?>">
	<thead>
	<tr>
		<th style="width: 100px;">
			<h3>Slides</h3>
		</th>
		<th>
			<a href='#' class='button alignright add-slide' data-editor='content' title='Add Slide'>
				<span class='wp-media-buttons-icon'></span> Add Slide
			</a>
		</th>

	</tr>
	</thead>

	<tbody>
		<?= $slides_body ?>
	</tbody>
</table>
<table class="widefat slider-settings sortable" id="slider_settings_<?=$slider_id?>">
	<thead>
	<tr>
		<th style="width: 100px;">
			<h3>Slider Settings</h3>
		</th>
	</tr>
	</thead>

	<tbody>
		<tr>
			<td>
				<p>
					<label class="input-checkbox">Display Title:</label>
					<input name="cp-press-slider[show_title]" type="checkbox" value="1" <?php checked( '1', $show_title ); ?> />&nbsp;
				</p>
				<p>
					<label class="input-checkbox">Display Content:</label>
					<input name="cp-press-slider[show_content]" type="checkbox" value="1" <?php checked( '1', $show_content ); ?> />&nbsp;
				</p>
				<p>
					<label class="input-checkbox">Display Splash Logo:</label>
					<input name="cp-press-slider[show_logo]" type="checkbox" value="1" <?php checked( '1', $show_logo ); ?> />&nbsp;
				</p>
			</td>
		</tr>
	</tbody>
</table>
