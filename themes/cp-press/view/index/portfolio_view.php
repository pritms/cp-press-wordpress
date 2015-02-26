<div class="cp-portfolio wpchop-block wpchop-view-layout-block wpchop-view-layout-block-6  wpchop-view-layout-class-staff" id="filter-attach">
	<div id="filter-items">
	<? foreach($items as $columnItems): ?>
	<div class="row">
	<? foreach($columnItems as $item): ?>
	<? 
		$toFilter = array();
		foreach(get_the_category($staff->ID) as $category){
			if($category->parent == $this->filterCategoryParent){
				$toFilter[] = $category->slug;
			}
		}
		$filter = array_pop($toFilter);
	?>
	<? if(isset($item['id'])): ?>
	<div class="col-md-<?=$col?> filtrable cp-portfolio-hover" id="<? e($filter.'-'.$item['id']); ?>'" data-category="<?= $filter ?>"  data-animation="fadeInUp" style="-webkit-animation: 0s;">
		<? if(!$hideinfo): ?>
		<div class="cp-portfolio-item" style="overflow: hidden; height: auto;">
		<? else: ?>
		<div class="cp-portfolio-item" style="overflow: hidden; height: auto;" data-hide="true" <? $item['link'] != '' ? e('data-link="'.$item['link'].'"') : e('') ?>>
		<? endif; ?>
			<img class="lazy" src="<?= $item['image'][0] ?>" width="<?= $thumb_size['w'] ?>"  height="<?= $thumb_size['h'] ?>" alt="<?= $item['title'] ?>" style="opacity: 1;">
			<div class="details">
				<span class="arrow"></span>
				<div class="title-wrap">
					<h4><?= $item['title'] ?></h4>
				</div>
				<? if(!$hideinfo): ?>
				<? if(!is_ipad() && !is_mobile()): ?>
				<div class="info-wrap">
				<? else: ?>
				<div class="info-wrap" style="height: 221px;">
				<? endif; ?>
					<p><?= $item['caption'] ?></p>
					<? if($item['link']): ?>
					<div class="social-media-wrap">
						<div>
							<? if($item['type'] != 'gallery'): ?>
							<a href="<?= $item['link'] ?>" data-rel="tooltip" data-position="top" data-original-title=""><i class="icon-eye"></i></a>
							<? else: ?>
							<a href="<?= $item['link'] ?>" data-rel="tooltip" data-position="top" data-original-title=""><i class="icon-camera"></i></a>
							<? endif; ?>
						</div>
					</div>
					<? endif; ?>
				</div>
				<? endif; ?>
			</div>
		</div>
	</div>
	<? endif; ?>
	<? endforeach; ?>
	</div>
	<? endforeach; ?>
	</div>
</div>