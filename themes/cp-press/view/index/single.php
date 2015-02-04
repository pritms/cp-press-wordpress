 <div class="static-container">
	<div class="container-fluid">
		<? if(isset($cp_post_options['showtitlecategory'])): ?>
		<h1 class="cp-static-title"><?= $category->name; ?></h1>
		<? else: ?>
		<h1 class="cp-static-title"><?= $post->post_title ?></h1>
		<? endif; ?>
		<? if($post->post_content != ''): ?>
		<div class="col-md-6 cp-columns">
			<? if(isset($cp_post_options['showtitlecategory'])): ?>
			<h3><?= $post->post_title ?></h3>
			<? endif; ?>
			<? if($gallery && isset($thumb[0])): ?>
			<div class="thumbnail pull-left">
				<img src="<?= $thumb[0] ?>" alt="<?= $page->post_title ?>" />
			</div>
			<? endif; ?>
			<? the_content(); ?>
		</div>
		<div class="col-md-6 cp-columns">
			<? if($gallery): ?>
			<?= $gallery ?>
			<? else: ?>
			<div class="thumbnail">
				<img src="<?= $thumb[0] ?>" alt="<?= $page->post_title ?>" />
			</div>
			<? endif; ?>
			<? if($category->slug != 'uncategorized'): ?>
			<? if($category->slug == 'news'): ?>
			<? dynamic_sidebar('article-news'); ?>
			<? elseif($category->slug == 'appuntamenti'): ?>
			<? dynamic_sidebar('article-events'); ?>
			<? endif; ?>
			<? endif; ?>
		</div>
		<? endif; ?>
	</div>
</div>