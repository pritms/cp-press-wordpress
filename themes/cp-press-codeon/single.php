<?php get_header('single'); ?>
<?php 
	\CpPressOnePage\CpOnePage::dispatch('index', 'single');
?>
<?php get_footer(); ?>