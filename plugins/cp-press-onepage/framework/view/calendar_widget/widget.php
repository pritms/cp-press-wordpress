<div class="cp-widget cp-calendar row">
	<h3><?= $title ?></h3>
<? foreach($events as $event): ?>
	<div class="cp-calendar-icon col-xs-2">
		<time datetime="<?= $event['start_date']->format('Y-m-d H:i:s');?>" class="icon">
			<em><?= $weekday[$event['start_date']->format('w')]; ?></em>
			<strong><?= $month[$event['start_date']->format('n')]; ?></strong>
			<span><?= $event['start_date']->format('d') ?></span>
		</time>
	</div>
	<div class="cp-calendar-info col-xs-10">
		<h5><?= $event['title'] ?></h5>
		<p><?= $event['description'] ?></p>
	</div>
	<div style="clear: both;" />
<? endforeach; ?>
</div>

