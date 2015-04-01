<div <?= $containerClass ?>>
	<? if(isset($content['icon'])):?>
	<a href="<?= $content['category'] ?>">
		<div <?= $iconClass; ?> <?= $iconStyle; ?>>
			<i class="fa <?= $content['icon']; ?>"></i>
		</div>
	</a>
	<? endif; ?>
	<div <?= $textClass ?>>
		<? if(isset($content['title']) && $content['title'] != ''): ?>
		<?= apply_filters('cp-textbox-title', "<h4>".$content['title']."</h4>", $textClass, $content['section_name']); ?>
		<? endif; ?>
		<? if(!isset($content['doshortcode'])): ?>
		<?= $content['text']; ?>
		<? else: ?>
		<?= do_shortcode($content['text']); ?>
		<? endif; ?>
	</div>
</div>