<header class="cp_content_column">
	<h4>Advanced Options</h4>
</header>
<div class="cp_select_post_advanced_options">
	<p>
		<label>Title:</label>
		<input class="cp-row-form widefat" data-row="<?= $row ?>" data-column="<?= $col ?>" name="cp-press-section-rowconfig[<?= $row ?>][<?=$col?>][content][advanced][title]" type="text" value="<?= $content['advanced']['title']; ?>"/>
	</p>
	<p>
		<label>Limit:</label>
		<input class="cp-row-form widefat" data-row="<?= $row ?>" data-column="<?= $col ?>" name="cp-press-section-rowconfig[<?= $row ?>][<?=$col?>][content][advanced][limit]" type="text" value="<? $content['advanced']['limit'] != '' ? e($content['advanced']['limit']) : e('1') ?>"/>
	</p>
	<p>
		<label>Offset (the number of posts to skip):</label>
		<input class="cp-row-form widefat" data-row="<?= $row ?>" data-column="<?= $col ?>" name="cp-press-section-rowconfig[<?= $row ?>][<?=$col?>][content][advanced][offset]" type="text" value="<? $content['advanced']['offset'] != '' ? e($content['advanced']['offset']) : e('0') ?>"/>
	</p>
	<p>
		<label>Order:</label>
		<select class="cp-row-form widefat" data-row="<?= $row ?>" data-column="<?= $col ?>" name="cp-press-section-rowconfig[<?= $row ?>][<?=$col?>][content][advanced][order]" style="width:100%;">
			<option value="DESC" <?php selected( $content['advanced']['order'], 'DESC' ); ?>>DESC</option>
			<option value="ASC" <?php selected( $content['advanced']['order'], 'ASC' ); ?>>ASC</option>
		</select>
	</p>
	<p>
		<label>Orderby:</label>
		<select class="cp-row-form widefat" data-row="<?= $row ?>" data-column="<?= $col ?>" name="cp-press-section-rowconfig[<?= $row ?>][<?=$col?>][content][advanced][orderby]" style="width:100%;">
			<option value="ID" <?php selected( $content['advanced']['orderby'], 'ID' ); ?>>ID</option>
			<option value="author" <?php selected( $content['advanced']['orderby'], 'author' ); ?>>Author</option>
			<option value="title" <?php selected( $content['advanced']['orderby'], 'title' ); ?>>Title</option>
			<option value="date" <?php selected( $content['advanced']['orderby'], 'date' ); ?>>Date</option>
			<option value="modified" <?php selected( $content['advanced']['orderby'], 'modified' ); ?>>Modified</option>
			<option value="rand" <?php selected( $content['advanced']['orderby'], 'rand' ); ?>>Random</option>
			<option value="comment_count" <?php selected( $content['advanced']['orderby'], 'comment_count' ); ?>>Comment Count</option>
			<option value="menu_order" <?php selected( $content['advanced']['orderby'], 'menu_order' ); ?>>Menu Order</option>
		</select>
	</p>
	<p>
		<label>Filter to Category:</label>
		<select class="cp-row-form widefat" data-row="<?= $row ?>" data-column="<?= $col ?>" multiple="multiple" name="cp-press-section-rowconfig[<?= $row ?>][<?=$col?>][content][advanced][categories][]" style="width:100%;">
			<optgroup label="Categories">
				<?php $categories = get_terms('category', array('hide_empty' => false)); ?>
				<?php foreach( $categories as $category ) { ?>
					<option value="<?php echo $category->term_id; ?>" <?php if ( is_array( $content['advanced']['categories'] ) && in_array( $category->term_id, $content['advanced']['categories'] ) ) echo ' selected="selected"'; ?>><?php echo $category->name; ?></option>
				<?php } ?>
			</optgroup>
		</select>
	</p>
	<p>
		<label>Filter to Tag:</label>
		<select class="cp-row-form widefat" data-row="<?= $row ?>" data-column="<?= $col ?>" multiple="multiple" name="cp-press-section-rowconfig[<?= $row ?>][<?=$col?>][content][advanced][tags][]" style="width:100%;">
			<optgroup label="Tags">
				<?php $tags = get_terms('post_tag', array('hide_empty' => false)); ?>
				<?php foreach( $tags as $post_tag ) { ?>
					<option value="<?php echo $post_tag->term_id; ?>" <?php if ( is_array( $content['advanced']['tags'] ) && in_array( $post_tag->term_id, $content['advanced']['tags'] ) ) echo ' selected="selected"'; ?>><?php echo $post_tag->name; ?></option>
				<?php } ?>
			</optgroup>
		</select>
	</p>
</div>