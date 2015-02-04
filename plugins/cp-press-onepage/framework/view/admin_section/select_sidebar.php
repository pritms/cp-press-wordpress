<?
global $wp_registered_sidebars;
?>
<section class="cp_content_type" id="col_<?= $num_col+1 ?>" data-column="<?= $num_col+1 ?>">
	<header class="cp_content_column">
		<h3>Column <?= $num_col+1 ?> -- <?= ucfirst($type) ?></h3>
	</header>
	<input type="hidden" name="cp-press-section-content[<?=$num_col?>][ns]" value="<?= $ns ?>" />
	<input type="hidden" name="cp-press-section-content[<?=$num_col?>][controller]" value="<?= $controller ?>" />
	<input type="hidden" name="cp-press-section-content[<?=$num_col?>][action]" value="<?= $action ?>" />
	<input type="hidden" name="cp-press-section-content[<?=$num_col?>][type]" value="<?= $type ?>" />
	<select class="widefat" name="cp-press-section-content[<?=$num_col?>][id]">
		<? foreach($wp_registered_sidebars as $id => $sidebar): ?>
		<? if(isset($content) && !empty($content)): ?>
			<option value="<?= $id ?>" <? $id == $content['id'] ? e('selected') : e('') ?>><?= ucfirst($type) ?> --> <?= $sidebar['name'] ?></option>
		<? else: ?>
			<option value="<?= $id ?>"><?= ucfirst($type) ?> --> <?= $sidebar['name'] ?></option>
		<? endif; ?>
		<? endforeach; ?>
	</select>
</section>
