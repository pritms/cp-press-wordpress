<div class="cp_press_select_content_type" id="cp_press_select_content_type">
	<div id="cp_press_rows_head">
		<div id="cp_add_row" data-row="<?= count($rows) ?>" data-post="<?= $post_id ?>" class='button add-row' title='Add Row'>
			Add Row
		</div>
	</div>
	<div id="cp_press_rows_container" data-post="<?= $post_id; ?>">
		<? if(!empty($rows)): ?>
		<? foreach($rows as $row => $cols): ?>
		<div id="cp_row_<?= $row ?>" class="cp-rows row cp-postbox">
			<div class="cp-row-icons cp-row-delete" id="cp-row-delete-<?= $row ?>" title="Delete Row"></br></div>
			<div class="cp-row-icons cp-row-move" id="cp-row-move-<?= $row ?>" title="Sort Row"></br></div>
			<h3 class="cp-row-handle"><span>Row: <?= $row ?></span></h3>
			<div class="cp-inside">
				<? foreach($cols as $col => $value): ?>
					<div id="cp-col-<?= $col; ?>" class="cp-col col-md-<?= $value['bootstrap'] ?> cp-row-list" data-row="<?= $row; ?>" data-column="<?= $col ?>">
						<? if(is_null($value['content'])): ?>
						<div class="cp-row-droppable"></div>
						<? else: ?>
						<?= $value['content']; ?>
						<? endif; ?>
					</div>
				<? endforeach; ?>
			</div>
		</div>
		<? endforeach; ?>
		<? endif; ?>
	</div>
	<div id="notifications">
	<? if(!$is_sidebar_active): ?>
		<div style="width:99%; padding: 5px;" class="error form-invalid below-h2">None sidebar register on this theme!! To apply a Sidebar Layout you have to support sidebar on your theme</div>
	<? endif ?>
	</div>
	<div id="cp-row-form">
	<? if(!empty($rows)): ?>
	<? foreach($rows as $row => $cols): ?>
		<? foreach($cols as $col => $value): ?>
		<input type="hidden" data-row="<?= $row ?>" data-column="<?= $col ?>" name="cp-press-section-rowconfig[<?= $row ?>][<?= $col ?>][bootstrap]" value="<?= $value['bootstrap'] ?>" />
		<? if(!is_null($value['closure'])):
			foreach($value['closure'] as $key => $val):
		?>
		<input type="hidden" data-row="<?= $row ?>" data-column="<?= $col ?>" name="cp-press-section-rowconfig[<?= $row ?>][<?= $col ?>][closure][<?= $key ?>]" value="<?= $val ?>" />
		<?	endforeach;
		endif;?>
		<? endforeach; ?>
	<? endforeach; ?>
	<? endif; ?>
	</div>
</div>