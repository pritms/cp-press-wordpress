<div class="cp-gallery cp-gallery-viewcarousel" data-aspect-ratio-x="<?= $thumb_aspect_ratio['x'] ?>" data-aspect-ratio-y="<?= $thumb_aspect_ratio['y'] ?>" id="cp-gallery-<?= $id ?>" style="max-width: <?= $thumb_size['w'] ?>;">
	<? if($title != ''): ?>
	<h3><?= $title ?></h3>
	<? endif; ?>
	<? if(!$thumb_only): ?>
	<? if($thumb['is_video']): ?>
	<div class="cp-gallery-image" style="display: none;">
	<? else: ?>
	<div class="cp-gallery-image cp-thumbnail">
	<? endif ?>
		<img src="<?= $thumb['img'][0] ?>" class="img-responsive" alt="<?= $thumb['caption'] ?>" />
	</div>
	<? if(!$thumb['is_video']): ?>
	<div class="cp-gallery-video" style="display:none;">
	<? else: ?>
	<div class="cp-gallery-video">
	<? endif; ?>
		<iframe src="http://www.youtube.com/embed/<?= $thumb['id'] ?>" width="<?= $thumb_size['w'] ?>" height="<?= $thumb_size['h'] ?>" frameborder="0" allowfullscreen></iframe>
	</div>	
	<? endif; ?>
	<div class="cp-gallery-thumbs">
		<div class="cp-gallery-carousel-box cp-carousel-box">
			<div class="cp-gallery-carousel-mask cp-carousel-mask">
				<div class="cp-gallery-carousel-container cp-carousel-container">
				<? foreach($mini_thumbs_col as $column => $mini_thumbs ): ?>
				<? if($column > 0): ?>
				<div class="row slide" id="row-<?=$column?>">
				<? else: ?>
				<div class="row slide" id="row-<?=$column?>">
				<? endif; ?>
				<?	foreach($mini_thumbs as $row => $mini_thumb): ?>
					<div class="col-md-<?=$col?> col-xs-<?=$col?> cp-gallery-minithumb">
						<? if(!is_null($mini_thumb)): ?>
						<div class="cp-gallery-image-wrapper <? $mini_thumb['is_video'] ? e('cp-video') : e(''); ?>">
							<? if(!$mini_thumb['is_video']): ?>
							<img src="<?= $mini_thumb['img'][0] ?>" data-src="<?= $mini_thumb['img'][0] ?>" data-original-width="<?= $mini_thumb['img'][1]; ?>" data-original-height="<?= $mini_thumb['img'][2]; ?>" class="thumbnail" alt="<?= $mini_thumb['caption'] ?>" />
							<? else: ?>
							<img src="<?= $mini_thumb['img'][0] ?>" data-src="http://www.youtube.com/embed/<?= $mini_thumb['id'] ?>" data-original-width="<?= $mini_thumb['img'][1]; ?>" data-original-height="<?= $mini_thumb['img'][2]; ?>" class="thumbnail" alt="<?= $mini_thumb['caption'] ?>" />
							<? endif; ?>
						</div>
						<? endif; ?>
					</div>
				<?	endforeach; ?>
				</div>
				<? endforeach; ?>
				</div>
			</div>
		</div>
		<div class="cp-gallery-carousel cp-carousel" data-column="0" data-count="<?= count($mini_thumbs_col); ?>">
			<div class="cp-arrow cp-arrow-next">
				<a herf="#"><i class="icon-right-open"></i></a>
			</div>
			<div class="cp-arrow cp-arrow-prev">
				<a herf="#"><i class="icon-left-open"></i></a>
			</div>
			<? if($is_slide): ?>
			<? foreach($mini_thumbs_col as $column => $none): ?>
			<? if($column > 0): ?>
			<a href="#" class="dot" data-column="<?= $column ?>"><span class="icon-dot"></span></a>
			<? else: ?>
			<a href="#" class="dot" data-column="<?= $column ?>"><span class="icon-dot current-slide"></span></a>
			<? endif; ?>
			<? endforeach ?>
			<? endif; ?>
		</div>
	</div>
</div>
