<?php 
/*
 Template Name: SlideThumb
*/
?>
<?php get_header('single'); ?>
<?php 
  \CpPressOnePage\CpOnePage::dispatch('index', 'page_slidethumb');
?>
<?php get_footer(); ?>