<div class="cp_press_select_content_type" id="cp_press_select_content_type">
	<header><h3>Select content Type:</h3></header>
	<div id="cp_press_rows">
		<? if(count($cols) > 0): ?>
		<? foreach($cols as $col => $t_col): ?>
			<section class="cp_content_type" data-column="<?= $col+1 ?>">
				<?= $t_col ?>
			</section>
		<? endforeach; ?>
		<? else: ?>
		<section class="cp_content_type" data-column="1">
			<?= $cols[0] ?>
		</section>
		<? endif; ?>
	</div>
	<? if(count($cols) > 0): ?>
		<a href="#" id="cp_add_col" data-column="<?= count($cols) ?>" data-post="<?= $post_id ?>">Add Column</a>
	<? endif; ?>
	<? if(!$is_sidebar_active): ?>
		<p style="color: red">None sidebar register on this theme!! To apply a Sidebar Layout you have to support sidebar on your theme</p>
	<? endif ?>
</div>
<div id="cp_press_content_type" class="cp_press_content">
	<? if(isset($content) && !empty($content)): ?>
	<header>
		<h2>Selected Content</h2>
	</header>
	<?= $content_body ?>
	<? endif; ?>
</div>