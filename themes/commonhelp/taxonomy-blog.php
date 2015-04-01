<?php get_header('single'); ?>
<?php
 
  \CpPressOnePage\CpOnePage::dispatch('index', 'taxonomy', array('childView' => true, 'view' => 'blog'));
?>
<?php get_footer('single'); ?>