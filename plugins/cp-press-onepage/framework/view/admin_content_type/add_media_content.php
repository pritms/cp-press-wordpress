<div class="cp-rows-inside row cp-content-selected">
	<div class="cp-col-inside col-md-4">
		<div class='thumb'>
			<img src="<?= $media['sizes']['full']['url']; ?>" style="width: 98%; height: auto;" />
			<span class='media-details'>Image <?= $media['sizes']['full']['width'] ?> X <?= $media['sizes']['full']['height'] ?></span>
		</div>
	</div>
	<div class="cp-col-inside col-md-8">
		<p><label for="cp-press-rowmedia">Title </label><input type='text' class="cp-row-form widefat" data-row="<?= $row ?>" data-column="<?= $col ?>" name="cp-press-section-rowconfig[<?= $row ?>][<?= $col ?>][content][title]" value="<?= $media['title'] ?>"/></p>
		<p><label for="cp-press-rowmedia">Alternative </label><input type='text' class="cp-row-form widefat" data-row="<?= $row ?>" data-column="<?= $col ?>" name="cp-press-section-rowconfig[<?= $row ?>][<?= $col ?>][content][alt]" value="<?= $media['alt'] ?>"/></p>
		<p><label for="cp-press-rowmedia">Caption </label><input type='text' class="cp-row-form widefat" data-row="<?= $row ?>" data-column="<?= $col ?>" name="cp-press-section-rowconfig[<?= $row ?>][<?= $col ?>][content][caption]" value="<?= $media['caption'] ?>"/></p>
		<p>
			<label>Size:</label>
			<select class="cp-row-form widefat" data-row="<?= $row ?>" data-column="<?= $col ?>" name="cp-press-section-rowconfig[<?= $row ?>][<?=$col?>][content][size]">
				<option value="responsive">Full responsive</option>
				<? foreach($media['sizes'] as $name => $size): ?>
				<option value="<?= $name ?>"><?= ucfirst($name); ?> - <?= $size['width'] ?> X <?= $size['height'] ?></option>
				<? endforeach; ?>
			</select>
		</p>
		<p>
			<label>Alignment:</label>
			<select class="cp-row-form widefat" data-row="<?= $row ?>" data-column="<?= $col ?>" name="cp-press-section-rowconfig[<?= $row ?>][<?=$col?>][content][alignment]">
				<option value="none">None</option>
				<option value="center">Center</option>
				<option value="left">Left</option>
				<option value="right">Right</option>
			</select>
		</p>
		<p>
			<input class="cp-row-form" data-row="<?= $row ?>" data-column="<?= $col ?>" name="cp-press-section-rowconfig[<?= $row ?>][<?= $col ?>][content][bootstrapthumb]" type="checkbox" value="1" />&nbsp;
			<label class="input-checkbox">Bootstrap thumb</label>
			<input class="cp-row-form" data-row="<?= $row ?>" data-column="<?= $col ?>" name="cp-press-section-rowconfig[<?= $row ?>][<?= $col ?>][content][bootstraplighbox]" type="checkbox" value="1" />&nbsp;
			<label class="input-checkbox">Bootstrap lightbox</label>
		</p>
	</div>
</div>