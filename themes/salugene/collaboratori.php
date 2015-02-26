<?php 
/*
 Template Name: Collaboratori
*/
?>
<?php get_header('single'); ?>
<?php 
  \CpPressOnePage\CpOnePage::dispatch('index', 'single', array('childView' => true, 'view' => 'collaboratori-link', $query_options));
?>
<?php get_footer(); ?>