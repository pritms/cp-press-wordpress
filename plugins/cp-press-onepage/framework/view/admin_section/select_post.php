<section class="cp_content_type" id="col_<?= $num_col+1 ?>" data-column="<?= $num_col+1 ?>">
	<header class="cp_content_column">
		<h3>Column <?= $num_col+1 ?> -- <?= ucfirst($type) ?></h3>
	</header>
	<input type="hidden" name="cp-press-section-content[<?=$num_col?>][ns]" value="<?= $ns ?>" />
	<input type="hidden" name="cp-press-section-content[<?=$num_col?>][controller]" value="<?= $controller ?>" />
	<input type="hidden" name="cp-press-section-content[<?=$num_col?>][action]" value="<?= $action ?>" />
	<input type="hidden" name="cp-press-section-content[<?=$num_col?>][type]" value="<?= $type ?>" />
	<select class="widefat cp_select_post_select" data-column="<?= $num_col ?>" name="cp-press-section-content[<?=$num_col?>][id]">
		<option value="">Select Post or Advanced Options</option>
		<? foreach($items as $id => $title): ?>
		<? if(isset($content) && !empty($content)): ?>
			<option value="<?= $id ?>" <? $id == $content['id'] ? e('selected') : e('') ?>><?= ucfirst($type) ?> --> <?= $title ?></option>
		<? else: ?>
			<option value="<?= $id ?>"><?= ucfirst($type) ?> --> <?= $title ?></option>
		<? endif; ?>
		<? endforeach; ?>
		<? if(isset($content) && !empty($content)): ?>	
			<option value="extended" <? $content['id'] == 'extended' ? e('selected') : e('') ?>>Advanced Options</option>
		<? else: ?>
			<option value="extended">Advanced Options</option>
		<? endif; ?>
	</select>
	<p>
		<label class="input-checkbox">Hide home page thumbnail:</label>
		<input name="cp-press-section-content[<?=$num_col?>][hidethumb]" type="checkbox" value="1" <?php checked( '1', $content['hidethumb'] ); ?> />&nbsp;
	</p>
	<div id="cp_content_post_advanced_<?= $num_col ?>">
	<? if($content['id'] == 'extended' || $content['id'] == 'advanced')
		e($advanced_options);
	?>
	</div>
</section>
