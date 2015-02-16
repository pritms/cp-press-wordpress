<?php get_header(); ?>
<?php 
	\CpPressOnePage\CpOnePage::dispatch('index', 'tag');
?>
<?php get_footer(); ?>