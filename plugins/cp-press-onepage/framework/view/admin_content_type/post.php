<section class="cp_content_type" id="cp-post-type-<?= $row ?>-<?= $col ?>">
	<header class="cp_content_column">
		<h3>Post Configuration</h3>
	</header>
	<select class="cp-row-form cp-select-post" data-row="<?= $row ?>" data-column="<?= $col ?>" name="cp-press-section-rowconfig[<?= $row ?>][<?=$col?>][content][id]">
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
		<input class="cp-row-form" data-row="<?= $row ?>" data-column="<?= $col ?>" name="cp-press-section-rowconfig[<?= $row ?>][<?= $col ?>][content][hidethumb]" type="checkbox" value="1" <?php checked( '1', $content['hidethumb'] ); ?> />&nbsp;
	</p>
	<div id="cp-content-post-advanced-<?= $row ?>-<?= $col ?>">
	<? if($content['id'] == 'extended' || $content['id'] == 'advanced')
		e($advanced_options);
	?>
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