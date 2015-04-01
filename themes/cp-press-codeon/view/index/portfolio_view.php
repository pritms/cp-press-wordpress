<!-- <ul class="portfolio-filters text-center">
	<li class="filter active" data-filter="all">all</li>
	<li class="filter" data-filter="design">design</li>
	<li class="filter" data-filter="html">HTML5</li>
	<li class="filter" data-filter="wordpress">Wordpress</li>
	<li class="filter" data-filter="seo">Seo</li>
</ul> -->
<? if(!empty($filters)): ?>
<ul class="portfolio-filters text-center">
	<li class="filter active" data-filter="all">all</li>
<? foreach($filters as $filter): ?>
	<li class="filter" data-filter="<?= strtolower($filter); ?>"><?= $filter ?></li>
<? endforeach ?>
</ul>	
<? endif; ?>
<div class="cp-mixitup">
<? foreach($items as $columnItems): ?>
<div class="row">
<? foreach($columnItems as $item): ?>
<?
	$filterClass = '';
	if(isset($item['filters']) && !empty($item['filters'])){
		foreach($item['filters'] as $filter){
			$filterClass .= strtolower($filter).' ';
		}
	}
?>
<? if(isset($item['id'])): ?>
    <div class="mix col-md-<?=$col?> col-sm-<?=($col*2 % 12)?> <?= $filterClass ?> margin-btm-20 mix_all">
        <a href="<?= $item['link']; ?>">
            <div class="image-wrapper">
                <img src="<?= $item['image'][0] ?>" width="<?= $thumb_size['w'] ?>"  height="<?= $thumb_size['h'] ?>" class="img-responsive" alt="<?= $item['title'] ?>">
                <div class="image-overlay">
                    <p class="cp-item-link">
                      	<span class="fa fa-search-plus"></span>
                    </p>
                </div><!--.image-overlay-->
            </div><!--.image-wrapper-->                                      
        </a>
        <div class="work-sesc">

            <p>
               <?= $item['title']; ?>
            </p>
        </div><!--.work-desc-->
    </div><!--work item-->
<? endif; ?>
<? endforeach; ?>
</div>
<? endforeach; ?>
</div>