<?php get_header('single'); ?>
<?php
  $query_options = array(
    'post_child' => true,
    'post_type' => 'servizi'
  );
  \CpPressOnePage\CpOnePage::dispatch('index', 'single', array('childView' => true, 'view' => 'single-servizi', $query_options));
?>
<?php get_footer(); ?>
