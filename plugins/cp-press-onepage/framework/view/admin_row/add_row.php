<div id="cp_row_<?= $row_number ?>" class="cp-rows row cp-postbox">
	<div class="cp-row-icons cp-row-delete" id="cp-row-delete-<?= $row_number ?>" title="Delete Row"></br></div>
	<div class="cp-row-icons cp-row-move" id="cp-row-move-<?= $row_number ?>" title="Sort Row"></br></div>
	<h3 class="cp-row-handle"><span>Row: <?= $row_number ?></span></h3>
	<div class="cp-inside">
		<? foreach($columns as $col => $bootstrap): ?>
		<div id="cp-col-<?= $col; ?>" class="cp-col col-md-<?= $bootstrap['value'] ?> cp-row-list" data-row="<?= $row_number; ?>" data-column="<?= $col ?>">
			<div class="cp-row-droppable"></div>
		</div>
		<? endforeach; ?>
	</div>
</div>
