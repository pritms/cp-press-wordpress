<section class="cp_content_type" id="cp-post-type-<?= $row ?>-<?= $col ?>">
	<header class="cp_content_column">
		<h3>Event display configuration</h3>
	</header>
	<p>
		<label>Filter to Calendar:</label>
		<select class="cp-row-form" data-row="<?= $row ?>" data-column="<?= $col ?>" multiple="multiple" name="cp-press-section-rowconfig[<?= $row ?>][<?=$col?>][content][calendars][]" style="width:100%;">
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
		<select class="cp-row-form" data-row="<?= $row ?>" data-column="<?= $col ?>" multiple="multiple" name="cp-press-section-rowconfig[<?= $row ?>][<?=$col?>][content][tags][]" style="width:100%;">
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
		<input class="cp-row-form" data-row="<?= $row ?>" data-column="<?= $col ?>" name="cp-press-section-rowconfig[<?= $row ?>][<?=$col?>][content][limit]" type="text" value="<? $content['limit'] != '' ? e($content['limit']) : e('0') ?>"/>
	</p>
	<p>
		<label>Offset (the number of posts to skip):</label>
		<input class="cp-row-form" data-row="<?= $row ?>" data-column="<?= $col ?>" name="cp-press-section-rowconfig[<?= $row ?>][<?=$col?>][content][offset]" type="text" value="<? $content['offset'] != '' ? e($content['offset']) : e('0') ?>"/>
	</p>
	<p>
		<label>View as:</label>
		<select class="cp-row-form cp-event-selectview" data-row="<?= $row ?>" data-column="<?= $col ?>" name="cp-press-section-rowconfig[<?= $row ?>][<?=$col?>][content][view]">
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
<? if(empty($content)): ?>
<div id="cp-tmp-form">
	<input type="hidden" data-row="<?= $row ?>" data-column="<?= $col ?>" name="cp-press-section-rowconfig[<?= $row ?>][<?= $col ?>][closure][ns]" value="<?= $ns ?>" />
	<input type="hidden" data-row="<?= $row ?>" data-column="<?= $col ?>" name="cp-press-section-rowconfig[<?= $row ?>][<?= $col ?>][closure][controller]" value="<?= $controller ?>" />
	<input type="hidden" data-row="<?= $row ?>" data-column="<?= $col ?>" name="cp-press-section-rowconfig[<?= $row ?>][<?= $col ?>][closure][action]" value="<?= $action ?>" />
	<input type="hidden" data-row="<?= $row ?>" data-column="<?= $col ?>" name="cp-press-section-rowconfig[<?= $row ?>][<?= $col ?>][closure][type]" value="<?= $type ?>" />
</div>
<? endif; ?>