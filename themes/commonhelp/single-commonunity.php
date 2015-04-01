<?php get_header('single'); ?>
<?php
  $query_options = array(
    'post_type' => 'commonunity'
  );
  \CpPressOnePage\CpOnePage::dispatch('index', 'single_blog', array('childView' => true, 'view' => 'single_commonunity', $query_options));
?>
<?php get_footer('single'); ?>
