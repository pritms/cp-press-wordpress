<div class="modal-dialog">
	<? if($link != ''): ?>
	<div style="width:99%; padding: 5px;" class="updated below-h2">
		<p>Selected link: <?= $link ?></p>
	</div>
	<? endif; ?>
	<? if($link == ''): ?>
	<table class="form-table" id="linker_table" data-slide="<?= $slide_id ?>">
	<? else: ?>
	<table class="form-table" id="linker_table" data-slide="<?= $slide_id ?>" style="display: none;">
	<? endif; ?>
		<tr valign="top">
			<td scope="row"><label for="tablecell">Select link type</label></td>
			<td>
				<select name="select_ctype" id="select_ctype" class="select widefat ui-widget-content ui-corner-all">
					<? foreach($post_types as $post_type): ?>
					<option value="<?= $post_type ?>"><?= ucfirst($post_type)  ?> Link</option>
					<?	endforeach; ?>
				</select>
			</td>
		</tr>
		<tr id="cp-linker-content">
			<?= $content ?>
		</tr>
	</table>
</div><!-- /.modal-dialog -->
