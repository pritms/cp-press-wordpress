<figure class="cp-media-view">
	<img width="<?= $width ?>" height="<?= $height ?>" alt="<? $content['alt'] != '' ? e($content['alt']) : '' ?>" title="<? $content['title'] != '' ? e($content['title']) : '' ?>" class="<?= $class ?>" src="<?= $media_uri; ?>">
	<? if($content['caption']): ?>
	<figcaption><?= $content['caption'] ?></figcaption>
	<? endif; ?>
</figure>