<?php get_header('single'); ?>
<?php 
	\CpPressOnePage\CpOnePage::dispatch('index', 'single_gallery');
?>
<?php get_footer(); ?>