<div class="cp-gallery cp-gallery-viewlist" id="cp-gallery-<?= $id ?>">
	<? if($title != ''): ?>
	<h3><?= $title ?></h3>
	<? endif; ?>
	<? if(!$thumb_only): ?>
	<div class="cp-gallery-thumbs">
		<? foreach($mini_thumbs_col as $column => $mini_thumbs ): ?>
		<div class="row">
		<?	foreach($mini_thumbs as $row => $mini_thumb): ?>
			<div class="col-lg-<?=$col?> cp-gallery-minithumb">
				<? if(!is_null($mini_thumb)): ?>
				<div class="cp-gallery-image-wrapper <? $mini_thumb['is_video'] ? e('cp-video') : e(''); ?>">
					<? if(!is_smartphone() && !is_tablet()): ?>
					<a data-toggle="lightbox" href="#cp-gallery-lightbox-<?= $id ?>">
					<? endif ?>
						<? if(!$mini_thumb['is_video']): ?>
						<img src="<?= $mini_thumb['img'][0] ?>" data-src="<?= $mini_thumb['img'][0] ?>" data-original-width="<?= $mini_thumb['img'][1]; ?>" width="<?= $mini_thumb_size['w'] ?>" data-original-height="<?= $mini_thumb['img'][2]; ?>" height="<?= $mini_thumb_size['h'] ?>" class="thumbnail" style="width: <?= $mini_thumb_size['w'] ?>; height: <?= $mini_thumb_size['h'] ?>;" alt="<?= $mini_thumb['caption'] ?>" />
						<? else: ?>
						<? if(!!is_smartphone() && !is_tablet()): ?>
						<img src="<?= $mini_thumb['img'][0] ?>" data-src="http://www.youtube.com/embed/<?= $mini_thumb['id'] ?>" data-original-width="<?= $mini_thumb['img'][1]; ?>" width="<?= $mini_thumb_size['w'] ?>" data-original-height="<?= $mini_thumb['img'][2]; ?>" height="<?= $mini_thumb_size['h'] ?>" class="thumbnail" style="width: <?= $mini_thumb_size['w'] ?>px; height: <?= $mini_thumb_size['h'] ?>px;" alt="<?= $mini_thumb['caption'] ?>" />
						<? else: ?>
						<div class="cp-gallery-video">
							<iframe src="http://www.youtube.com/embed/<?= $mini_thumb['id'] ?>" style="width: <?= $mini_thumb_size['w'] ?> height: <?= $mini_thumb_size['h'] ?>" frameborder="0" allowfullscreen></iframe>
						</div>
						<? endif; ?>
						<? endif; ?>
					<? if(!is_smartphone() && !is_tablet()): ?>
					</a>
					<? endif; ?>
				</div>
				<? endif; ?>
			</div>
		<?	endforeach; ?>
		</div>
		<? endforeach; ?>
	</div>
	<? endif; ?>
	<? if(!is_smartphone() && !is_tablet()): ?>
	<div id="cp-gallery-lightbox-<?= $id ?>" class="lightbox fade"  tabindex="-1" role="dialog" aria-hidden="true">
		<div class="lightbox-modal">
			<div class="lightbox-content">
				<div class="cp-arrow cp-arrow-next">
					<a herf="#"><i class="icon-right-open"></i></a>
				</div>
				<div class="cp-arrow cp-arrow-prev">
					<a herf="#"><i class="icon-left-open"></i></a>
				</div>
				<? if($thumb['is_video']): ?>
				<div class="lightbox-image" style="display: none;">
				<? else: ?>
				<div class="lightbox-image">
				<? endif ?>
					<img src="" width="<?= $thumb['img'][1] ?>" height="<?= $thumb['img'][2] ?>" alt="<?= $thumb['caption'] ?>">
					<? if($thumb['caption'] != ''): ?>
					<div class="cp-lightbox-caption"><p><?= $thumb['caption'] ?></p></div>
					<? endif; ?>
				</div>
				<? if($thumb['is_video']): ?>
				<div class="lightbox-video" >
				<? else: ?>
				<div class="lightbox-video" style="display: none;">
				<? endif ?>
					<iframe src="" width="<?= $thumb['img'][1] ?>" height="<?= $thumb['img'][2] ?>" frameborder="0" allowfullscreen></iframe>
					<? if($thumb['caption'] != ''): ?>
					<div class="cp-lightbox-caption"><p><?= $thumb['caption'] ?></p></div>
					<? endif; ?>
				</div>
				<div class="hide lightbox-image-container">
					<? foreach($mini_thumbs_col as $column => $mini_thumbs ): ?>
					<?	foreach($mini_thumbs as $row => $thumb): ?>
					<? if($thumb): ?>
					<? if(!$thumb['is_video']): ?>
					<img src="<?= $thumb['img'][0] ?>" width="<?= $thumb['img'][1] ?>" height="<?= $thumb['img'][2] ?>" alt="<?= $thumb['caption'] ?>">
					<? else: ?>
					<img src="<?= $thumb['img'][0] ?>" data-src="http://www.youtube.com/embed/<?= $thumb['id'] ?>" class="cp-video" width="<?= $thumb['img'][1] ?>" height="<?= $thumb['img'][2] ?>" alt="<?= $thumb['caption'] ?>">
					<? endif; ?>
					<? endif; ?>
					<? endforeach; ?>
					<? endforeach; ?>
				</div>
			</div>
		</div>
	</div>
	<? endif; ?>
</div>
