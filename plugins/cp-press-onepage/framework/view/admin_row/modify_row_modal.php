<div id="cp-row-modal" class="cp-rows row">
	<? for($i=0; $i<$columns; $i++): ?>
	<div id="cp-col-<?= $i ?>" class="cp-col col-md-<?= $bootstrap; ?> cp-row-list">
		<div class="cp-col-config">
			<? if(!is_null($colconfig)): ?>
			<select name="select_col_config" id="cp-select-col-config-<?= $i ?>" class="select ui-widget-content ui-corner-all">
				<? foreach($colconfig as $css_col_value): ?>
					<option value="<?=  $css_col_value[$i] ?>" <? $css_col_value[$i] == $bootstrap ? e('selected') : e('') ?>>Bootstrap grid <?=  $css_col_value[$i]  ?></option>
				<?	endforeach;?>
			</select>
			<? endif; ?>
		</div>
		<div class="cp-row-droppable"></div>
	</div>
	<? endfor; ?>
</div>