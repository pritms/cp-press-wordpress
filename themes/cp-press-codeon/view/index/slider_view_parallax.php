<? 
	add_filter('cp-section-attributes', function($val, $post_name) use($sliders, $section_name){
		if(!isset($sliders['bg']))
			return '';
		if($post_name == $section_name){
			return 'data-stellar-background-ratio="0.5" style="background-image: url('.$sliders['bg']['media'][0].');"';
		}
	}, 9, 2);
	if(isset($sliders['bg']))
		unset($sliders['bg']);
?>
<? if($show_overlay): ?>
<div class="parallax-overlay"></div> 
<? endif; ?>
<div class="home-content text-center">
	<div class="container">
		<? if($show_title): ?>
		<h1 class=" slide-logo"><?php bloginfo('name') ?></h1>
		<? endif; ?>
		<div class="main-flex-slider">
			<ul class="slides">
				<? foreach($sliders as $slide_id => $slide): ?>
				<li id="slide_<?= $slide_id; ?>">
					<h1><?= $slide['title']; ?></h1>
				</li>
				<? endforeach; ?>
			</ul>
		</div> 
		<? if($sub_title != ''): ?>
		<h2 class="slide-btm-text"><?= $sub_title ?></h2>
		<? endif; ?>
		<div class="home-arrow-down text-center">
			<p class="scrollto"><a href="#<?= $next_section ?>" class="btn btn-lg btn-theme-color">Start</a></p>
		</div>
	</div>
</div>