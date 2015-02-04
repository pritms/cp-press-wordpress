<? if($ajax): ?>
<section class="cp_content_type" data-column="<?= $col+1 ?>">
<? endif; ?>
<label>Column <?= $col+1 ?></label>
<select class="cp_press_content_types_select widefat">
	<option value="empty"></option>
<?php foreach($content_types as $key => $content_type): ?>
	<option value="<?= $key ?>_<?= $post_id ?>_<?= $col ?>" <? $key == $content['type'] ? e('selected') : e('') ?>><?= $content_type ?></option>
<?php endforeach; ?>
</select>
<? if($ajax): ?>
</section>
<? endif; ?>
