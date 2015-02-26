<section class="cp_content_type" id="cp-post-type-<?= $row ?>-<?= $col ?>">
	<header class="cp_content_column">
		<h3>Media Layout</h3>
	</header>
	<div class="cp-content-select" data-row="<?= $row ?>" data-col="<?= $col ?>">
		<div class="cp-row-icons cp-row-media" title="Select Media to Show"></br></div>
		<? if(empty($content)): ?>
		<h3>Select Media</h3>
		<? else: ?>
		<h3><? $content['title'] == '' ? e($media['file']) : e($content['title']) ?> - <span style="color: #aaa;">Media</span></h3>
		<? endif; ?>
		<? if(!empty($content)): ?>
		<div class="cp-rows-inside row cp-content-selected">
			<div class="cp-col-inside col-md-4">
				<div class='thumb'>
					<img src="<?= $media_uri; ?>" style="width: 98%; height: auto;" />
					<span class='media-details'>Image <?= $media['width'] ?> X <?= $media['height'] ?></span>
				</div>
			</div>
			<div class="cp-col-inside col-md-8">
				<input type="hidden" class="cp-row-form" data-row="<?= $row ?>" data-column="<?= $col ?>" name="cp-press-section-rowconfig[<?= $row ?>][<?= $col ?>][content][id]" value="<?= $content['id'] ?>" />
				<p><label for="cp-press-rowmedia">Title </label><input type='text' class="cp-row-form widefat" data-row="<?= $row ?>" data-column="<?= $col ?>" name="cp-press-section-rowconfig[<?= $row ?>][<?= $col ?>][content][title]" value="<?= $content['title'] ?>"/></p>
				<p><label for="cp-press-rowmedia">Alternative </label><input type='text' class="cp-row-form widefat" data-row="<?= $row ?>" data-column="<?= $col ?>" name="cp-press-section-rowconfig[<?= $row ?>][<?= $col ?>][content][alt]" value="<?= $content['alt'] ?>"/></p>
				<p><label for="cp-press-rowmedia">Caption </label><input type='text' class="cp-row-form widefat" data-row="<?= $row ?>" data-column="<?= $col ?>" name="cp-press-section-rowconfig[<?= $row ?>][<?= $col ?>][content][caption]" value="<?= $content['caption'] ?>"/></p>
				<p>
					<label>Size:</label>
					<select class="cp-row-form widefat" data-row="<?= $row ?>" data-column="<?= $col ?>" name="cp-press-section-rowconfig[<?= $row ?>][<?=$col?>][content][size]">
						<option value="responsive" <?php selected( $content['size'], 'responsive' ); ?>>Full responsive</option>
						<? foreach($media['sizes'] as $name => $size): ?>
						<option value="<?= $name ?>" <?php selected( $content['size'], $name ); ?>><?= ucfirst($name); ?> - <?= $size['width'] ?> X <?= $size['height'] ?></option>
						<? endforeach; ?>
						<option value="full" <?php selected( $content['size'], 'full' ); ?>>Full - <?= $media['width'] ?> X <?= $media['height'] ?></option>
					</select>
				</p>
				<p>
					<label>Alignment:</label>
					<select class="cp-row-form widefat" data-row="<?= $row ?>" data-column="<?= $col ?>" name="cp-press-section-rowconfig[<?= $row ?>][<?=$col?>][content][alignment]">
						<option value="none" <?php selected( $content['alignment'], 'none' ); ?>>None</option>
						<option value="center" <?php selected( $content['alignment'], 'center' ); ?>>Center</option>
						<option value="left" <?php selected( $content['alignment'], 'left' ); ?>>Left</option>
						<option value="right" <?php selected( $content['alignment'], 'right' ); ?>>Right</option>
					</select>
				</p>
				<p>
					<input class="cp-row-form" data-row="<?= $row ?>" data-column="<?= $col ?>" name="cp-press-section-rowconfig[<?= $row ?>][<?= $col ?>][content][bootstrapthumb]" type="checkbox" value="1" <?php checked( '1', $content['bootstrapthumb'] ); ?>/>&nbsp;
					<label class="input-checkbox">Bootstrap thumb</label>
					<input class="cp-row-form" data-row="<?= $row ?>" data-column="<?= $col ?>" name="cp-press-section-rowconfig[<?= $row ?>][<?= $col ?>][content][bootstraplighbox]" type="checkbox" value="1" <?php checked( '1', $content['bootstraplighbox'] ); ?>/>&nbsp;
					<label class="input-checkbox">Bootstrap lightbox</label>
				</p>
			</div>
		</div>
		<? endif; ?>
	</div>
	<div class="cp-content-options">
		
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

