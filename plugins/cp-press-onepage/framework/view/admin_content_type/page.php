<section class="cp_content_type" id="cp-post-type-<?= $row ?>-<?= $col ?>">
	<header class="cp_content_column">
		<h3>Select Single Page</h3>
	</header>
	<div class="cp-content-select" data-row="<?= $row ?>" data-col="<?= $col ?>">
		<div class="cp-row-icons cp-row-page" title="Select Page To Show"></br></div>
		<? if(empty($content)): ?>
		<h3>Select content type</h3>
		<? else: ?>
		<h3><?= $content['post']->post_title ?> - <span style="color: #aaa;">Page</span></h3>
		<? endif; ?>
		<? if(!empty($content)): ?>
		<? $c = get_extended($content['post']->post_content); ?>
		<div class="cp-content-selected"><?= do_shortcode($c['main']) ?></div>
		<input type="hidden" class="cp-row-form" data-row="<?= $row ?>" data-column="<?= $col ?>" name="cp-press-section-rowconfig[<?= $row ?>][<?= $col ?>][content][id]" value="<?= $content['post']->ID ?>" />
		<? endif; ?>
	</div>
	<div class="cp-content-options">
		<p>
			<input class="cp-row-form" data-row="<?= $row ?>" data-column="<?= $col ?>" name="cp-press-section-rowconfig[<?= $row ?>][<?= $col ?>][content][hidethumb]" type="checkbox" value="1" <?php checked( '1', $content['hidethumb'] ); ?> />
			<label class="input-checkbox">Hide home page thumbnail</label>
		</p>
		<p>
			<input class="cp-row-form" data-row="<?= $row ?>" data-column="<?= $col ?>" name="cp-press-section-rowconfig[<?= $row ?>][<?= $col ?>][content][hidetitle]" type="checkbox" value="1" <?php checked( '1', $content['hidetitle'] ); ?> />
			<label class="input-checkbox">Hide home page title</label>
		</p>
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