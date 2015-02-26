<div class="static-container">
 <div class="cp_sidebar">
  <? dynamic_sidebar('servizi'); ?>
</div>
 <div class="container-fluid"  role="tabpanel">
	 <h1 class="cp-static-title"><?= $post->post_title ?></h1>
  <? if(!empty($post_childs)): ?>
  <div class="cp-tabs-container">
    <ul class="nav nav-tabs nav-justified cp-tabs" role="tablist">
      <li role="presentation" class="active"><a href="#" data-target="#cp-tab-<?= $post->post_name ?>" role="tab" data-toggle="tab"><?= $post->post_title ?></a></li>
      <? foreach($post_childs as $child): ?>
      <li role="presentation"><a href="#" data-target="#cp-tab-<?= $child->post_name ?>" role="tab" data-toggle="tab"><?= $child->post_title ?></a></li>
      <? endforeach; ?>
    </ul>
  </div>
  <? endif; ?>
  <div class="tab-content">
    <div id="cp-tab-<?= $post->post_name ?>" role="tabpanel" class="tab-pane fade in active">
     <? if($post->post_content != ''): ?>
     <div class="col-md-6 cp-columns">
       <? if(isset($cp_post_options['showtitlecategory'])): ?>
       <h3><?= $post->post_title ?></h3>
       <? endif; ?>
       <? if($gallery && isset($thumb[0])): ?>
       <div class="thumbnail pull-left">
         <img src="<?= $thumb[0] ?>" alt="<?= $post->post_title ?>" />
       </div>
       <? endif; ?>
       <? the_content(); ?>
     </div>
     <div class="col-md-6 cp-columns">
       <? if($gallery): ?>
       <?= $gallery ?>
       <? else: ?>
       <div class="thumbnail">
         <img src="<?= $thumb[0] ?>" alt="<?= $post->post_title ?>" />
       </div>
       <? endif; ?>
     </div>
    </div>
    <? foreach($post_childs as $child): ?>
    <div id="cp-tab-<?= $child->post_name ?>" role="tabpanel" class="tab-pane fade">
      <div class="col-md-6 cp-columns">
        <? echo apply_filters('the_content', $child->post_content);  ?>
      </div>
      <div class="col-md-6 cp-columns">
        <? if(isset($child_galleries[$child->ID])): ?>
          <?= $child_galleries[$child->ID]; ?>
        <? elseif(isset($child_thumbs[$child->ID])): ?>
        <div class="thumbnail">
          <img src="<?= $child_thumbs[$child->ID][0]; ?>" alt="<?= $child->post_title ?>" />
        </div>
        <? else: ?>
        <div class="thumbnail">
          <img src="<?= $thumb[0] ?>" alt="<?= $page->post_title ?>" />
        </div>
        <? endif; ?>
      </div>
    </div>
    <? endforeach; ?>
  </div>
   <? endif; ?>
 </div>
</div>
