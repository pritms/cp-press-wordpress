<section class="cp_content_type" id="cp-post-type-<?= $row ?>-<?= $col ?>">
	<header class="cp_content_column">
		<h3>Add Text Box</h3>
	</header>
	<div class="cp-content-select" data-row="<?= $row ?>" data-col="<?= $col ?>">
		<div class="cp-row-icons cp-row-faicon" title="Select Icon"></br></div>
		<? if(!isset($content['icon'])): ?>
		<h3 class="cp-faicon-title">Select Icon</h3>
		<? else: ?>
		<h3 class="cp-faicon-title">Icon <?= $content['icon']; ?> - <span style="color: #aaa; font-size: 20px;" class="fa <?= $content['icon'] ?>"></span></h3>
		<? endif; ?>
		
		<? if(!empty($content)): ?>
		<h3>Title: 
			<span class="cp-title-reactable cp-reactable"><?= $content['title'] ?></span>
			<input class="cp-row-form widefat cp-reactable-form" style="display:none;" data-row="<?= $row ?>" data-column="<?= $col ?>" name="cp-press-section-rowconfig[<?= $row ?>][<?= $col ?>][content][title]" value="<?= $content['title']; ?>"/>
		</h3>
		<? else: ?>
		<h3>Title: 
			<input class="cp-row-form widefat" data-row="<?= $row ?>" data-column="<?= $col ?>" name="cp-press-section-rowconfig[<?= $row ?>][<?= $col ?>][content][title]" value=""/>
		</h3>
		
		<? endif; ?>
		<h3>Content:</h3>
		<? if(!empty($content)): ?>
		<div class="cp-content-selected">
			<div class="cp-content-selected-reactable cp-reactable">
				<? if(!isset($content['doshortcode'])): ?>
				<?= $content['text'] ?>
				<? else: ?>
				<?= do_shortcode($content['text']); ?>
				<? endif; ?>
			</div>
			<textarea class="cp-row-form large-text cp-reactable-form" style="display:none" rows="15" data-row="<?= $row ?>" data-column="<?= $col ?>" name="cp-press-section-rowconfig[<?= $row ?>][<?=$col?>][content][text]"><?= $content['text']?></textarea>
		</div>
		<? else: ?>
		<textarea class="cp-row-form large-text" rows="15" data-row="<?= $row ?>" data-column="<?= $col ?>" name="cp-press-section-rowconfig[<?= $row ?>][<?=$col?>][content][text]"></textarea>
		<? endif; ?>
		<? if(!empty($content) && isset($content['icon'])): ?>
		<input type="hidden" class="cp-row-form cp-input-faicon" data-row="<?= $row ?>" data-column="<?= $col ?>" name="cp-press-section-rowconfig[<?= $row ?>][<?= $col ?>][content][icon]" value="<?= $content['icon'] ?>" />
		<? endif; ?>
	</div>
	<div class="cp-content-options">
		<? if(!empty($content) && isset($content['icon'])): ?>
		<div class="cp-content-icon-options">
		<? else: ?>
		<div class="cp-content-icon-options" style="display:none">
		<? endif; ?>
			<p>
				<label>Icon container class:</label>
				<input class="cp-row-form" data-row="<?= $row ?>" data-column="<?= $col ?>" name="cp-press-section-rowconfig[<?= $row ?>][<?= $col ?>][content][iconclass]" value="<? !empty($content) ? e($content['iconclass']) : e(''); ?>"/>
			</p>
			<p>
				<label class="cp-color-picker-label">Icon color:</label>
				<input class="cp-row-form cp-color-picker" data-row="<?= $row ?>" data-column="<?= $col ?>" name="cp-press-section-rowconfig[<?= $row ?>][<?= $col ?>][content][iconcolor]" value="<? !empty($content) ? e($content['iconcolor']) : e(''); ?>"/>
			</p>
		</div>
		<p>
			<label>Text container class:</label>
			<input class="cp-row-form" data-row="<?= $row ?>" data-column="<?= $col ?>" name="cp-press-section-rowconfig[<?= $row ?>][<?= $col ?>][content][containerclass]" value="<? !empty($content) ? e($content['containerclass']) : e(''); ?>"/>
		</p>
		<p>
			<label>Apply shortcode:</label>
			<input class="cp-row-form" data-row="<?= $row ?>" data-column="<?= $col ?>" name="cp-press-section-rowconfig[<?= $row ?>][<?= $col ?>][content][doshortcode]" type="checkbox" value="1" <?php checked( '1', $content['doshortcode'] ); ?> />&nbsp;
		</p>
		<? do_action('cp-admin-text-extend', $row, $col, $content['section'], $content); ?>
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
