<?php get_header('single'); ?>
<?php
  \CpPressOnePage\CpOnePage::dispatch('index', 'single_post', array('childView' => true, 'view' => 'single_post'));
?>
<?php get_footer('single'); ?>
