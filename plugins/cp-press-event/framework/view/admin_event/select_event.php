<section class="cp_content_type" id="col_<?= $num_col+1 ?>" data-column="<?= $num_col+1 ?>">
	<header class="cp_content_column">
		<h3>Column <?= $num_col+1 ?> -- <?= ucfirst($type) ?></h3>
	</header>
	<input type="hidden" name="cp-press-section-content[<?=$num_col?>][ns]" value="<?= $ns ?>" />
	<input type="hidden" name="cp-press-section-content[<?=$num_col?>][controller]" value="<?= $controller ?>" />
	<input type="hidden" name="cp-press-section-content[<?=$num_col?>][action]" value="<?= $action ?>" />
	<input type="hidden" name="cp-press-section-content[<?=$num_col?>][type]" value="<?= $type ?>" />
	<p>
		<label>Filter to Calendar:</label>
		<select class="widefat" multiple="multiple" name="cp-press-section-content[<?=$num_col?>][calendars][]" style="width:100%;">
			<optgroup label="Calendars">
				<?php $calendars = get_terms('calendar', array('hide_empty' => false)); ?>
				<?php foreach( $calendars as $calendar ) { ?>
					<option value="<?php echo $calendar->term_id; ?>" <?php if ( is_array( $content['calendars'] ) && in_array( $calendar->term_id, $content['calendars'] ) ) echo ' selected="selected"'; ?>><?php echo $calendar->name; ?></option>
				<?php } ?>
			</optgroup>
		</select>
	</p>
	<p>
		<label>Filter to Event Tag:</label>
		<select class="widefat" multiple="multiple" name="cp-press-section-content[<?=$num_col?>][tags][]" style="width:100%;">
			<optgroup label="Event Tags">
				<?php $tags = get_terms('event-tags', array('hide_empty' => false)); ?>
				<?php foreach( $tags as $event_tag ) { ?>
					<option value="<?php echo $event_tag->term_id; ?>" <?php if ( is_array( $content['tags'] ) && in_array( $event_tag->term_id, $content['tags'] ) ) echo ' selected="selected"'; ?>><?php echo $event_tag->name; ?></option>
				<?php } ?>
			</optgroup>
		</select>
	</p>
	<p>
		<label>Limit:</label>
		<input class="widefat" name="cp-press-section-content[<?=$num_col?>][limit]" type="text" value="<? $content['limit'] != '' ? e($content['limit']) : e('0') ?>"/>
	</p>
	<p>
		<label>Offset (the number of posts to skip):</label>
		<input class="widefat" name="cp-press-section-content[<?=$num_col?>][offset]" type="text" value="<? $content['offset'] != '' ? e($content['offset']) : e('0') ?>"/>
	</p>
	<p>
		<label>View as:</label>
		<select class="widefat cpevent-selectview" name="cp-press-section-content[<?=$num_col?>][view]" data-column="<?= $num_col ?>" style="width:100%;">
			<option value="portfolio" <?php selected( $content['view'], 'portfolio' ); ?>>Portfolio</option>
			<option value="slider" <?php selected( $content['view'], 'slider' ); ?>>Slider</option>
			<option value="calendar" <?php selected( $content['view'], 'calendar' ); ?>>Calendar</option>
		</select>
	</p>
	<div id="cpevent_view_<?= $num_col ?>">
	<? if($content['view'] == 'portfolio' || $content['view'] == 'slider' || $content['view'] == 'calendar')
		e($event_view);
	?>
	</div>
</section>