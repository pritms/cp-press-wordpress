<section class="cp_content_type" id="cp-post-type-<?= $row ?>-<?= $col ?>">
	<header class="cp_content_column">
		<h3>Add Simple Text</h3>
	</header>
	<textarea class="cp-row-form large-text" rows="15" data-row="<?= $row ?>" data-column="<?= $col ?>" name="cp-press-section-rowconfig[<?= $row ?>][<?=$col?>][content]"><?= $content ?></textarea>
</section>
<div id="cp-tmp-form">
	<input type="hidden" data-row="<?= $row ?>" data-column="<?= $col ?>" name="cp-press-section-rowconfig[<?= $row ?>][<?= $col ?>][closure][ns]" value="<?= $ns ?>" />
	<input type="hidden" data-row="<?= $row ?>" data-column="<?= $col ?>" name="cp-press-section-rowconfig[<?= $row ?>][<?= $col ?>][closure][controller]" value="<?= $controller ?>" />
	<input type="hidden" data-row="<?= $row ?>" data-column="<?= $col ?>" name="cp-press-section-rowconfig[<?= $row ?>][<?= $col ?>][closure][action]" value="<?= $action ?>" />
	<input type="hidden" data-row="<?= $row ?>" data-column="<?= $col ?>" name="cp-press-section-rowconfig[<?= $row ?>][<?= $col ?>][closure][type]" value="<?= $type ?>" />
</div>
