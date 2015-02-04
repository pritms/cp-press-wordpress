<table class="widefat gallery append-gallery sortable" id="gallery_<?=$gallery_id?>">
	<thead>
	<tr>
		<th style="width: 100px;">
			<h3>Images</h3>
		</th>
		<th>
			<a href='#' class='button alignright add-image' data-editor='content' title='Add Image' style="margin-left: 15px;">
				<span class='wp-media-buttons-icon'></span> Add Image
			</a>
			<a href='#' class='button alignright add-video' data-editor='content' title='Add Video'>
				<span class='wp-media-buttons-icon'></span> Add Video
			</a>
		</th>
	</tr>
	</thead>

	<tbody>
		<?= $gallery_body ?>
	</tbody>
</table>
<table class="widefat gallery-settings" id="gallery_settings_<?=$slider_id?>">
	<thead>
	<tr>
		<th style="width: 100px;">
			<h3>Gallery Settings</h3>
		</th>
	</tr>
	</thead>

	<tbody>
		<tr>
			<td>
				<p>
					<label>Title:</label>
					<input class="widefat" name="cp-press-gallery[title]" type="text" value="<?= $title; ?>"/>
				</p>
				<p>
					<label>Gallery template (default Carousel):</label>
					<select class="widefat" name="cp-press-gallery[template]">
						<option value="carousel" <? selected( $template, 'carousel' ); ?>>Carousel</option>
						<option value="list" <? selected( $template, 'list' ); ?>>List</option>
					</select>
				</p>
				<p>
					<label>Images aspect ratio:</label><br />
					<input name="cp-press-gallery[aspect_ratio][x]" type="text" value="<?= $aspect_ratio['x']; ?>"/>&nbsp;x&nbsp;<input name="cp-press-gallery[aspect_ratio][y]" type="text" value="<?= $aspect_ratio['y']; ?>"/>
				</p>
				<p>
					<label>Thumb per row:</label><br />
					<select name="cp-press-gallery[thumb_per_row]">
						<? foreach($grid as $key => $val): ?>
						<option value="<?= $key ?>" <? selected($thumb_per_row, $key) ?>><?= $key ?></option>
						<? endforeach; ?>
					</select>
				</p>
			</td>
		</tr>
	</tbody>
</table>
