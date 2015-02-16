<div class="modal-dialog">
	<table class="form-table">
		<tr valign="top">
			<td scope="row"><label for="tablecell">Number of column</label></td>
			<td>
				<select name="select_col" id="select_col" class="select widefat ui-widget-content ui-corner-all">
					<? foreach($grid as $col_num => $css_grid_value): ?>
						<option value="<?= $css_grid_value ?>"><?= $col_num  ?></option>
					<?	endforeach;?>
				</select>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<div id="cp-row-modal" class="row cp-rows">
					<div id="cp-col-0" class="cp-col col-md-12 cp-row-list">
						<div class="cp-row-droppable"></div>
					</div>
				</div>
			</td>
		</tr>
	</table>
	<form id="cp-row-config-form">
		<input type="hidden" name="col" id="col-0" value="12" />
	</form>
</div><!-- /.modal-dialog -->


