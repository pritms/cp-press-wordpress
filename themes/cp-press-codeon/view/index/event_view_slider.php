<div class="cp-events cp-events-slider">
    <div class="cp-events-carousel-box cp-carousel-box">
        <div class="cp-events-carousel-mask cp-carousel-mask">
            <div class="cp-events-carousel-container cp-carousel-container">
				<? $i = 0; ?>
                <? while($events->have_posts()) : $events->the_post(); ?>
                <? $event_data = get_post_meta(get_the_ID(), 'cp-press-event', true); ?>
                <? $calendar = array_pop(get_the_terms(get_the_Id(), 'calendar')); ?>
                <? 
                   $calendar_color = '#FFFFFF';
                   foreach(get_option('calendar_taxonomy') as $calendar_colors){
                       foreach($calendar_colors as $key => $color){
                           if($key == 'category_bgcolor_'.$calendar->term_id){
                               $calendar_color = $color;
                               break;
                           }
                       }
                   }
                ?>
                <div class="cp-events-row row slide" id="row-<?= $i ?>" style="border: 1px solid <?= $calendar_color; ?>;">
                        <div class="cp-events-post-thumbnail col-md-3">
                                <a href="<?= get_the_permalink() ?>"><? the_post_thumbnail('medium', array('class' => 'img-responsive thumbnail')); ?></a>
                        </div>
                        <div class="cp-events-content col-md-8">
                                <? the_title() ?>	
                                <h4 class="cpevents-info">
                                    <?= $calendar->name ?> - <?= $event_data['when']['event_start_date'] ?> ore <?= $event_data['when']['event_start_time'] ?> @ <?= $event_data['where']['location_name'] ?> 
                                </h4>
                                <? the_content() ?>
                        </div>
                </div>
				<? $i++ ?>
                <? endwhile ?>						
            </div>
        </div>
    </div>
    <div class="cp-events-carousel cp-carousel" data-column="0" data-count="<?= $events->post_count ?>" <?= $carousel ?>>
        <div class="cp-arrow cp-arrow-next">
                <a herf="#"><i class="icon-right-open"></i></a>
        </div>
        <div class="cp-arrow cp-arrow-prev">
                <a herf="#"><i class="icon-left-open"></i></a>
        </div>
		<? for($i=0; $i<$events->post_count; $i++): ?>
		<? if($i > 0): ?>
        <a href="#" class="dot" data-column="<?= $i ?>"><span class="icon-dot"></span></a>
		<? else: ?>
		<a href="#" class="dot" data-column="<?= $i ?>"><span class="icon-dot current-slide"></span></a>
		<? endif; ?>
		<? endfor; ?>
    </div>
</div>
<script type="text/javascript">
	var event_view_settings = {
		scroll_time: <?= $content['scroll_time']; ?>
	};
</script>