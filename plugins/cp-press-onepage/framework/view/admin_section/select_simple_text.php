<section class="cp_content_type" id="col_<?= $num_col+1 ?>" data-column="<?= $num_col+1 ?>">
	<header class="cp_content_column">
		<h3>Column <?= $num_col+1 ?> -- <?= ucfirst($type) ?></h3>
	</header>
	<input type="hidden" name="cp-press-section-content[<?=$num_col?>][ns]" value="<?= $ns ?>" />
	<input type="hidden" name="cp-press-section-content[<?=$num_col?>][controller]" value="<?= $controller ?>" />
	<input type="hidden" name="cp-press-section-content[<?=$num_col?>][action]" value="<?= $action ?>" />
	<input type="hidden" name="cp-press-section-content[<?=$num_col?>][type]" value="<?= $type ?>" />
	<textarea class="widefat cp_select_post_select" name="cp-press-section-content[<?=$num_col?>][content]"><?= $content ?></textarea>
</section>
