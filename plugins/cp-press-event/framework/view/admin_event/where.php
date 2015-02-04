<?php if( true ): //set options event to require location for every event ?>
<div class="cpevent-location-data-nolocation">
	<p>
		<input type="checkbox" name="cp-press-event[where][no_location]" id="cpevent-no-location" value="1" <?php checked( '1', $where['no_location'] ); ?>>
		This event does not have a physical location.
	</p>
</div>
<?php endif; ?>
<div id="cpevent-location-data" class="cpevent-location-data">
	<div id="location_coordinates" style='display: none;'>
		<input id='location-latitude' name='cp-press-event[where][location_latitude]' type='text' value='<?= $where['location_latitude'] ?>' size='15' />
		<input id='location-longitude' name='cp-press-event[where][location_longitude]' type='text' value='<?= $where['location_longitude'] ?>' size='15' />
	</div>
	<table class="cpevent-location-data">
		<tr class="cpevent-location-data-name">
			<th>Location Name:</th>
			<td>
				<input id="location-name" type="text" name="cp-press-event[where][location_name]" value="<?= $where['location_name'] ?>" />											
				<br />
				<em id="cpevent-location-search-tip">Create a location or start typing to search a previously created location.</em>
				<em id="cpevent-location-reset" style="display:none;">You cannot edit saved locations here. <a href="#">Reset this form to create a location or search again.</a></em>
			</td>
 		</tr>
		<tr class="cpevent-location-data-address">
			<th>Address:&nbsp;</th>
			<td>
				<input id="location-address" type="text" name="cp-press-event[where][location_address]" value="<?= $where['location_address'] ?>" />
			</td>
		</tr>
		<tr class="cpevent-location-data-town">
			<th>City:&nbsp;</th>
			<td>
				<input id="location-town" type="text" name="cp-press-event[where][location_town]" value="<?= $where['location_town'] ?>" />
			</td>
		</tr>
	</table>
	<div class="cpevent-location-map-container">
		<div id='cpevent-map-404'  class="cpevent-location-map-404">
			<p><em>Location not found</em></p>
		</div>
		<div id='cpevent-map' class="cpevent-location-map-content" style='display: none;'></div>
	</div>
	<br style="clear:both;" />
</div>