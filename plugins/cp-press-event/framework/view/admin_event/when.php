<div class="cpevent-form-when" id="cpevent-form-when">
	<p class="cpevent-date-range">
		From 				
		<input class="cpevent-date-input cpevent-date-start" type="text" name="cp-press-event[when][event_start_date]" value="<?= $when['event_start_date'] ?>" />
		To 
		<input class="cpevent-date-input cpevent-date-end" type="text" name="cp-press-event[when][event_end_date]" value="<?= $when['event_end_date'] ?>" />
	</p>
	<p class="cpevent-time-range">
		<span class="cpevent-event-text">Event starts at</span>
		<input id="start-time" class="cpevent-time-input cpevent-time-start" type="text" size="8" maxlength="8" name="cp-press-event[when][event_start_time]" value="<?= $when['event_start_time'] ?>" />
		to
		<input id="end-time" class="cpevent-time-input cpevent-time-end" type="text" size="8" maxlength="8" name="cp-press-event[when][event_end_time]" value="<?= $when['event_end_time'] ?>" />
		All day <input type="checkbox" class="cpevent-time-all-day" name="cp-press-event[when][event_all_day]" id="cpevent-time-all-day" value="1"  <?php checked( '1', $when['event_all_day'] ); ?>/>
	</p>
	<span id='event-date-explanation'>
	This event spans every day between the beginning and end date, with start/end times applying to each day.
	</span>
</div> 