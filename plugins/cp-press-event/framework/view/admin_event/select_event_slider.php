<header class="cp_content_column">
	<h4>Slider View options</h4>
</header>
<div class="cpevent_slider_options">
	<p>
		<label class="input-checkbox">Show carousel:</label>
		<input name="cp-press-section-content[<?=$num_col?>][carousel]" type="checkbox" value="1" <?php checked( '1', $content['carousel'] ); ?> />&nbsp;
	</p>
	<p>
		<label>Scroll Time:</label>
		<input name="cp-press-section-content[<?=$num_col?>][scroll_time]" type="text" value="<? $content['scroll_time'] != '' ? e($content['scroll_time']) : e('5') ?>"/> Sec
	</p>
</div>