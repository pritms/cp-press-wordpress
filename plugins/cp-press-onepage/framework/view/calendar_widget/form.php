<p>
	<label for="<?= $widget->get_field_id( 'title' ); ?>">Calendar Title:</label>
	<input class="widefat" id="<?= $widget->get_field_id( 'title' ); ?>" name="<?= $widget->get_field_name( 'title' ); ?>" type="text" value="<?= $title ?>">
</p>
<p>
	<label for="<?= $widget->get_field_id( 'url' ); ?>">Calendar URI:</label>
	<input class="widefat" id="<?= $widget->get_field_id( 'url' ); ?>" name="<?= $widget->get_field_name( 'url' ); ?>" type="text" value="<?= $url ?>">
</p>
<p>
	<label for="<?= $widget->get_field_id( 'maxresults' ); ?>">Calendar Max Results:</label>
	<input class="widefat" id="<?= $widget->get_field_id( 'maxresults' ); ?>" name="<?= $widget->get_field_name( 'maxresults' ); ?>" type="text" value="<?= $maxresults ?>">
</p>
<p>
	<label class="input-checkbox" for="<?= $widget->get_field_id('weekday'); ?>">Display short weekday:</label>
	<input id="<?= $widget->get_field_id('weekday'); ?>" name="<?= $widget->get_field_name( 'weekday' ); ?>" type="checkbox" value="1" <?php checked( '1', $weekday ); ?> />&nbsp;
</p>
<p>
	<label class="input-checkbox" for="<?= $widget->get_field_id('month'); ?>">Display short month name:</label>
	<input id="<?= $widget->get_field_id('month'); ?>" name="<?= $widget->get_field_name( 'month' ); ?>" type="checkbox" value="1" <?php checked( '1', $month ); ?> />&nbsp;
</p>
<p>
	<label class="input-checkbox" for="<?= $widget->get_field_id('showfuture'); ?>">Show only next event:</label>
	<input id="<?= $widget->get_field_id('showfuture'); ?>" name="<?= $widget->get_field_name( 'showfuture' ); ?>" type="checkbox" value="1" <?php checked( '1', $showfuture ); ?> />&nbsp;
</p>
