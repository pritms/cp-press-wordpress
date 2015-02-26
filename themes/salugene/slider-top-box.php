<? if(!is_smartphone()): ?>
<div class="salugene-top">
  <img src="<?= dirname(get_stylesheet_uri()).'/top-wave.png'?>" class="salugene-bg" />
  <nav class="wpchop-menu-main wpchop-menu-main-dynamic salugene-top-menu">
    <?php
      \CpPressOnePage\CpOnePage::dispatch('menu', 'main');
    ?>
  </nav>
  <img src="<?= dirname(get_stylesheet_uri()).'/logo-sw.png'?>" class="salugene-logo"/>
</div>
<? endif; ?>
