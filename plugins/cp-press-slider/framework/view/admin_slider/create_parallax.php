<div id="parallax-slider" class="hideable">
	<table class="widefat cp-slider parallax-append-slide sortable" id="slider_<?=$slider_id?>">
		<thead>
			<tr>
				<th style="width: 100px;">
					<h3>Parallax</h3>
				</th>
				<th>
					<a href='#' id="parallax-slider-add" class='button alignright add-slide' data-editor='content' title='Add Slide'>
						<span class='wp-media-buttons-icon'></span> Add Slide
					</a>
					<a href='#' id="parallax-slider-background" class='button alignright add-slide' data-editor='content' title='Add Slide'>
						<span class='wp-media-buttons-icon'></span> Add Background
					</a>
				</th>
			</tr>
		</thead>

		<tbody>
			<?= $slides_body ?>
		</tbody>
	</table>
	<table class="widefat cp-slider-settings sortable" id="slider_cppress_settings_<?=$slider_id?>">
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
						<label for="cp-press-slider">Sub Title </label>
						<input type='text' name='cp-press-slider[sub_title]' value='<?= $sub_title ?>'/>
					</p>
					<p>
						<label class="input-checkbox">Display Splash Logo:</label>
						<input name="cp-press-slider[show_logo]" type="checkbox" value="1" <?php checked( '1', $show_logo ); ?> />&nbsp;
					</p>
					<p>
						<label class="input-checkbox">Display Overlay:</label>
						<input name="cp-press-slider[show_overlay]" type="checkbox" value="1" <?php checked( '1', $show_overlay ); ?> />&nbsp;
					</p>
					<p>
						<label for="cp-press-slider">Next Section </label>
						<input type='text' name='cp-press-slider[next_section]' value='<?= $next_section ?>'/>
					</p>
				</td>
			</tr>
		</tbody>
	</table>
</div>