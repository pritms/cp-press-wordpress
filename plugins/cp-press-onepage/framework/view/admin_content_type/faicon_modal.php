<div class="modal-dialog">
	<header>
		<div class="cp-filter-box">
			<div class="cp-filter-container">
				<span class="cp-filter-icon"><i class="fa fa-search"></i></span>
				<input type="search" class="cp-filter" placeholder="Filter icon..." />
			</div>
		</div>
	</header>
	<ol class="cp-selectable cp-faicon-modal">
		<? foreach($fontawesome as $class => $icon): ?>
		<li class="ui-widget-content" data-icon="<?= $class ?>" data-col="<?= $col ?>" data-row="<?= $row ?>">
			<div class="cp-box-faicon">
				<i class="fa <?= $class ?>"></i>
				<label><?= $class ?></label>
			</div>
		</li>
		<? endforeach; ?>
	</ol>
</div><!-- /.modal-dialog -->


