<div class="wrap">
	<h2>CommonHelp Press Header Options</h2>
	<form method="post" action="options.php">
		<?php settings_fields('chpress_header_settings_groups'); ?>
		<table class="form-table">
			<thead>
				<tr>
					<th colspan="2"><h3>Javascript Settings</h3></th>
				</tr>
			</thead>
			<tr valign="top">
				<th scope="row">Menu slider offset (px)</th>
				<td>
					<input type="text" name="chpress_header_settings[chpress_header_settings][menu_slider_offset]" 
						   value="<?php $chpress_header_settings['chpress_header_settings']['menu_slider_offset'] != '' ? e(esc_attr($chpress_header_settings['chpress_header_settings']['menu_slider_offset'])) : e('100') ?>" />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">Scroll Adjust positions (px)</th>
				<td>
					<input type="text" name="chpress_header_settings[chpress_header_settings][scroll_top_offset][min]" 
						   value="<?php $chpress_header_settings['chpress_header_settings']['scroll_top_offset']['min'] != '' ? e(esc_attr($chpress_header_settings['chpress_header_settings']['scroll_top_offset']['min'])) : e('10') ?>" />
					to <input type="text" name="chpress_header_settings[chpress_header_settings][scroll_top_offset][max]" 
						   value="<?php $chpress_header_settings['chpress_header_settings']['scroll_top_offset']['max'] != '' ? e(esc_attr($chpress_header_settings['chpress_header_settings']['scroll_top_offset']['max'])) : e('100') ?>" />
				</td>
			</tr>
		</table>
		<table class="form-table">
			<thead>
				<tr>
					<th colspan="2"><h3>Style Settings</h3></th>
				</tr>
			</thead>
			<tr valign="top">
				<th scope="row">Menu Strip Background</th>
				<td>
					<input type="text" class="chpress_header_colorpick" name="chpress_header_settings[chpress_header_settings][color][menu_background][color]" 
						   value="<?php $chpress_header_settings['chpress_header_settings']['color']['menu_background']['color'] != '' ? e(esc_attr($chpress_header_settings['chpress_header_settings']['color']['menu_background']['color'])) : e('#000000') ?>" /><br /><br />
					Use inline style <input name="chpress_header_settings[chpress_header_settings][color][menu_background][usecss]" type="checkbox" value="1" <?php checked( '1', $chpress_header_settings['chpress_header_settings']['color']['menu_background']['usecss'] ); ?> />&nbsp;
					</td>
			</tr>
			<tr valign="top">
				<th scope="row">Menu Text Color</th>
				<td>
					<input type="text" class="chpress_header_colorpick" name="chpress_header_settings[chpress_header_settings][color][menu_text_color][color]" 
						   value="<?php $chpress_header_settings['chpress_header_settings']['color']['menu_text_color']['color'] != '' ? e(esc_attr($chpress_header_settings['chpress_header_settings']['color']['menu_text_color']['color'])) : e('#FFFFFF') ?>" /><br /><br />
					Use inline style <input name="chpress_header_settings[chpress_header_settings][color][menu_text_color][usecss]" type="checkbox" value="1" <?php checked( '1', $chpress_header_settings['chpress_header_settings']['color']['menu_text_color']['usecss'] ); ?> />&nbsp;
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">Menu Hover Line Color</th>
				<td>
					<input type="text" class="chpress_header_colorpick" name="chpress_header_settings[chpress_header_settings][color][menu_hover_line_color][color]" 
						   value="<?php $chpress_header_settings['chpress_header_settings']['color']['menu_hover_line_color']['color'] != '' ? e(esc_attr($chpress_header_settings['chpress_header_settings']['color']['menu_hover_line_color']['color'])) : e('#00b5a5') ?>" /><br /><br />
					Use inline style <input name="chpress_header_settings[chpress_header_settings][color][menu_hover_line_color][usecss]" type="checkbox" value="1" <?php checked( '1', $chpress_header_settings['chpress_header_settings']['color']['menu_hover_line_color']['usecss'] ); ?> />&nbsp;
					</td>
			</tr>
		</table>
		<table class="form-table">
			<thead>
				<tr>
					<th colspan="2"><h3>Misc Settings</h3></th>
				</tr>
			</thead>
			<tr valign="top">
				<th scope="row">Logo</th>
				<td><label for="cppress_logo">
					<?php
						$logoImgUri = $chpress_header_settings['chpress_header_settings']['cppress_logo'] != '' ? $chpress_header_settings['chpress_header_settings']['cppress_logo'] : plugins_url('img/chpress.png', WPCHOP_BASE_FILE);
					?>
					<img src="<?php e($logoImgUri) ?>" id="cppress_logo_img" />
					<input id="cppress_logo" type="hidden" name="chpress_header_settings[chpress_header_settings][cppress_logo]" value="<?php e(esc_attr($logoImgUri)); ?>" />
					<input id="cppress_logo_button" type="button" value="Upload" />
					<br />Upload an image for the banner.
					</label>
				</td>
			</tr>
		</table>
		<p class="submit">
			<input type="submit" class="button-primary" value="Save" />
		</p>
	</form>
</div>
