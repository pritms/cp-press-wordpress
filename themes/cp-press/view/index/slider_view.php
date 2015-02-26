<div class="cp-slider wrapper">
<? get_template_part('slider-top-box'); ?>
<? if(!is_smartphone()): ?>
	<? foreach($sliders as $id => $slider): ?>
	<? if(is_null($slider['link'])): ?>
	<div class="cp-slider-image image">
	<? else: ?>
	<div class="cp-slider-image image" data-link="<?= $slider['link'] ?>">	
	<? endif; ?>
		<img class="lazy" data-original="<?= $slider['media'][0] ?>" width="<?= $slider['media'][1] ?>" height="<?= $slider['media'][2] ?>" style="opacity: 0;"/>
		<? if($show_title || $show_content || $show_logo): ?>
		<div class="cp-slider-info">
			<? if($show_logo): ?>
			<div class="cp-slider-logo">
				<img src="<?=  $logo_slider_img_uri ?>" />
			</div>
			<? endif; ?>
			<? if($show_title): ?>
			<div class="cp-slider-title">
				<h1><?= $slider['title'] ?></h1>
			</div>
			<? endif; ?>
			<? if($show_content): ?>
			<div class="cp-slider-content">
				<p><?= wpautop($slider['content']) ?></p>
			</div>
			<? endif; ?>
		</div>
		<? endif; ?>
	</div>
	<? endforeach; ?>
<? endif; ?>
<? get_template_part('slider-bottom-box'); ?>
</div>
