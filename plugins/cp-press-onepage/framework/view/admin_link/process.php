<tr class="cp-link" data-item="<?= md5($uri); ?>">
	<td colspan="2">
		<div id="cp_link_<?= md5($uri); ?>" class="cp-rows row cp-postbox">
			<div class="cp-row-icons cp-row-delete" id="cp-link-delete-<?= md5($uri); ?>" title="Delete Link"></br></div>
			<div class="cp-row-icons cp-row-move" id="cp-link-move-<?= md5($uri); ?>" title="Sort Link"></br></div>
			<div class="cp-row-icons cp-row-image" id="cp-link-image-<?= md5($uri); ?>" title="Change image"></br></div>
			<h3 class="cp-row-handle">
				<? if(isset($meta_uri['title'])): ?>
				<span><?= $meta_uri['title'] ?></span>
				<? else: ?>
				<span>&nbsp;</span>
				<? endif; ?>
			</h3>
			<div class="cp-inside">
				<div class="cp-col col-md-2">
					<img src="<?= $image ?>" class="cp-link-image" style="width: 64px; height: auto;">
				</div>
				<div class="cp-col col-md-10">
					<input type="hidden" name="cp-press-link[<?= md5($uri); ?>][uri]" value="<?= $uri ?>" />
					<input type="hidden" name="cp-press-link[<?= md5($uri); ?>][image]" value="<?= $image ?>" />
					<label for="cp-press-link">Title </label><input type='text' name="cp-press-link[<?= md5($uri); ?>][title]" value="<? isset($meta_uri['title']) ? e($meta_uri['title']) : e('') ?>"/>
					<label for="cp-press-link">Description </label><textarea name="cp-press-link[<?= md5($uri); ?>][description]"><? isset($meta_uri['description']) ? e($meta_uri['description']) : e(''); ?></textarea>
				</div>
			</div>
		</div>
	</td>
</tr>