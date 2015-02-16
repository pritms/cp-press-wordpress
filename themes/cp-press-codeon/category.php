<?php get_header(); ?>
<?php 
	\CpPressOnePage\CpOnePage::dispatch('index', 'category');
?>
<?php get_footer(); ?>