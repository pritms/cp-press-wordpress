<div class="wrap">
	<h2>CommonHelp Press Portfolio Options</h2>
	<form method="post" action="options.php">
		<?php settings_fields('chpress_portfolio_settings_groups'); ?>
		<table class="form-table">
			<thead>
				<tr>
					<th colspan="2"><h3>Main settings</h3></th>
				</tr>
			</thead>
			<tr valign="top">
				<th scope="row">Exclude Post Types</th>
				<td>
					<? foreach($post_types as $key => $post_type): ?>
					<p>
						<label class="input-checkbox"><?= $post_type ?>:</label>
						<input name="chpress_portfolio_settings[chpress_portfolio_settings][exclude][<?=$key?>]" type="checkbox" value="<?= $post_type ?>" <?php checked( $post_type, $chpress_portfolio_settings['chpress_portfolio_settings']['exclude'][$key] ); ?> />&nbsp;
					</p>
					<? endforeach ?>
				</td>
			</tr>
		</table>
		<table class="form-table">
			<thead>
				<tr>
					<th colspan="2"><h3>Box settings</h3></th>
				</tr>
			</thead>
			<tr valign="top">
				<th scope="row">Box Height (default is auto height)</th>
				<td>
					<input type="text" name="chpress_portfolio_settings[chpress_portfolio_settings][boxheight]"
						   value="<?php $chpress_portfolio_settings['chpress_portfolio_settings']['boxheight'] != '' ? e(esc_attr($chpress_portfolio_settings['chpress_portfolio_settings']['boxheight'])) : e('auto') ?>" />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">Box slide (how much box slide up? px)</th>
				<td>
					<input type="text" name="chpress_portfolio_settings[chpress_portfolio_settings][boxslide]"
							value="<?php $chpress_portfolio_settings['chpress_portfolio_settings']['boxslide'] != '' ? e(esc_attr($chpress_portfolio_settings['chpress_portfolio_settings']['boxslide'])) : e('155') ?>" />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">Hide information box (this options makes all box clickable)</th>
				<td>
					<input name="chpress_portfolio_settings[chpress_portfolio_settings][hideinfo]" type="checkbox" value="0" <?php checked( '0', $chpress_portfolio_settings['chpress_portfolio_settings']['hideinfo'] ); ?> />&nbsp;
				</td>
			</tr>
		</table>
		<p class="submit">
			<input type="submit" class="button-primary" value="Save" />
		</p>
	</form>
</div>
