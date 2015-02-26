<td scope="row"><label for="tablecell"><?= $title ?></label></td>
<td>
	<? if($type != 'custom'): ?>
	<select name="slide_link" id="slide_link" class="select ui-widget-content ui-corner-all">
	<? foreach($posts as $id => $post): ?>
		<option value="<?= get_permalink($id); ?>"><?= $post  ?></option>
	<?	endforeach; ?>
	</select>
	<div class="cp-linker-permalink">
		<span class="description"><?= $first_link ?></span>
	</div>
	<? else: ?>
	<input name="slide_link" id="slide_link" type="text" value="http://" class="regular-text code ui-widget-content ui-corner-all" /> 
	<span class="description">Insert here a valid url for link</span>
	<? endif; ?>
</td>