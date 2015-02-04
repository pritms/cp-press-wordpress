<?php get_header('single'); ?>
<?php 
	\CpPressOnePage\CpOnePage::dispatch('index', 'single_product');
?>
<?php get_footer(); ?>
