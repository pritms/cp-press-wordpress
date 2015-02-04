<div class="wrap">
	<h2>CommonHelp Press Slider Options</h2>
	<form method="post" action="options.php">
		<?php settings_fields('chpress_slider_settings_groups'); ?>
		<table class="form-table">
			<tr valign="top">
				<th scope="row">Center Logo</th>
				<td>
					<input name="chpress_slider_settings[center_logo]" type="checkbox" value="1" <?php checked( '1', $chpress_slider_settings['center_logo'] ); ?> />&nbsp;
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">Logo position top</th>
				<td>
						<input name="chpress_slider_settings[logo_ptop]" type="checkbox" value="1" <?php checked( '1', $chpress_slider_settings['logo_ptop'] ); ?> />&nbsp;
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">Logo position bottom</th>
				<td>
					<input name="chpress_slider_settings[logo_pbottom]" type="checkbox" value="1" <?php checked( '1', $chpress_slider_settings['logo_pbottom'] ); ?> />&nbsp;
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">Image width</th>
				<td>
					<input type="text" name="chpress_slider_settings[imgwidth]" 
						   value="<?php $chpress_slider_settings['imgwidth'] != '' ? e(esc_attr($chpress_slider_settings['imgwidth'])) : e('1920') ?>" />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">Image height</th>
				<td>
					<input type="text" name="chpress_slider_settings[imgheight]" 
						   value="<?php $chpress_slider_settings['imgheight'] != '' ? e(esc_attr($chpress_slider_settings['imgheight'])) : e('900') ?>" />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">Translate time (in ms)</th>
				<td>
					<input type="text" name="chpress_slider_settings[translatetime]" 
						   value="<?php $chpress_slider_settings['translatetime'] != '' ? e(esc_attr($chpress_slider_settings['translatetime'])) : e('5000') ?>" />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">Show time (in ms)</th>
				<td>
					<input type="text" name="chpress_slider_settings[showtime]" 
						   value="<?php $chpress_slider_settings['showtime'] != '' ? e(esc_attr($chpress_slider_settings['showtime'])) : e('1000') ?>" />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">Slider Logo</th>
				<td><label for="cppress_slider_logo">
					<?php
						$logoImgUri = $chpress_slider_settings['cppress_slider_logo'] != '' ? $chpress_slider_settings['cppress_slider_logo'] : get_template_directory_uri().'/img/logo_slide.png';
					?>
					<img src="<?php e($logoImgUri) ?>" id="cppress_slider_logo_img" />
					<input id="cppress_slider_logo" type="hidden" name="chpress_slider_settings[cppress_slider_logo]" value="<?php e(esc_attr($logoImgUri)); ?>" />
					<input id="cppress_slider_logo_button" type="button" value="Upload" />
					</label>
				</td>
			</tr>
		</table>
		<p class="submit">
			<input type="submit" class="button-primary" value="Save" />
		</p>
	</form>
</div>

