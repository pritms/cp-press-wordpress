<?php get_header('single'); ?>
<?php 
	\CpPressOnePage\CpOnePage::dispatch('index', 'page');
?>
<?php get_footer(); ?>