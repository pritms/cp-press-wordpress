<section class="cp_content_type" id="cp-post-type-<?= $row ?>-<?= $col ?>">
	<header class="cp_content_column">
		<h3>Select a navigation menu</h3>
	</header>
	<select class="cp-row-form" data-row="<?= $row ?>" data-column="<?= $col ?>" name="cp-press-section-rowconfig[<?= $row ?>][<?=$col?>][content][id]">
		<? foreach($registered_menues as $id => $menu): ?>
		<? if(isset($content) && !empty($content)): ?>
			<option value="<?= $id ?>" <? $id == $content['id'] ? e('selected') : e('') ?>><?= ucfirst($type) ?> --> <?= $menu ?></option>
		<? else: ?>
			<option value="<?= $id ?>"><?= ucfirst($type) ?> --> <?= $menu ?></option>
		<? endif; ?>
		<? endforeach; ?>
	</select>
</section>
<div id="cp-tmp-form">
	<input type="hidden" data-row="<?= $row ?>" data-column="<?= $col ?>" name="cp-press-section-rowconfig[<?= $row ?>][<?= $col ?>][closure][ns]" value="<?= $ns ?>" />
	<input type="hidden" data-row="<?= $row ?>" data-column="<?= $col ?>" name="cp-press-section-rowconfig[<?= $row ?>][<?= $col ?>][closure][controller]" value="<?= $controller ?>" />
	<input type="hidden" data-row="<?= $row ?>" data-column="<?= $col ?>" name="cp-press-section-rowconfig[<?= $row ?>][<?= $col ?>][closure][action]" value="<?= $action ?>" />
	<input type="hidden" data-row="<?= $row ?>" data-column="<?= $col ?>" name="cp-press-section-rowconfig[<?= $row ?>][<?= $col ?>][closure][type]" value="<?= $type ?>" />
</div>