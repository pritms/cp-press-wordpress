<p>
	<label><?= $label ?>:</label>
	<select class="cp-row-form cp-select-category" data-row="<?= $row ?>" data-column="<?= $col ?>" name="cp-press-section-rowconfig[<?= $row ?>][<?=$col?>][content][category]">
		<option value=""></option>
		<? foreach($categories as $category): ?>
		<option value="<?= get_term_link($category) ?>" <? $set == get_term_link($category) ? e('selected') : e('') ?>><?= $category->cat_name ?></option>
		<? endforeach; ?>
	</select>
</p>
