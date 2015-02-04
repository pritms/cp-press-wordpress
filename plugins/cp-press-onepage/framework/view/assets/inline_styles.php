<style>
	<? if(isset($color['menu_background']['usecss']) && $color['menu_background']['usecss'] == 1): ?>
	.wpchop-menu-sticky{
		background-color: <?= $color['menu_background']['color'] ?>;
	}
	<? endif ?>
	<? if(isset($color['menu_text_color']['usecss']) && $color['menu_text_color']['usecss'] == 1): ?>
	.wpchop-menu > li > a{
		color: <?= $color['menu_text_color']['color'] ?>;
	}
	<? endif ?>
	<? if(isset($color['menu_hover_line_color']['usecss']) && $color['menu_hover_line_color']['usecss'] == 1): ?>
	.wpchop-menu a:hover{
		color: <?= $color['menu_hover_line_color']['color'] ?>;
	}
	.wpchop-menu > li:hover, .wpchop-menu > li.active, .wpchop-menu > li.current {
		border-bottom: 2px solid <?= $color['menu_hover_line_color']['color'] ?>;
	}
	<? endif; ?>
</style>