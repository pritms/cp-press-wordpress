<?php
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	add_image_size('commonunity-link', 64, 64);
	$itemsArgs = array(
		'public'		=> true,
		'has_archive'	=> false,
		'hierarchical' => false,
		'taxonomies' => array('filter'),
		'supports'		=> array('title', 'editor', 'thumbnail', 'excerpt', 'page-attributes'),
		'menu_icon'		=> 'dashicons-megaphone',
		'labels'		=> array(
			'name'					=> 'commonunity',
			'singular_name'			=> 'Commonunity',
			'add_new'				=> 'Aggiungi nuovo elemento commonunity',
			'add_new_item'			=> 'Aggiungi nuovo elemento commonunity',
			'edit_item'				=> 'Modifica elemento',
			'new_item'				=> 'Nuovo elemento commonunity',
			'all_item'				=> 'Tutti',
			'view_item'				=> 'Visualizza elementoo',
			'search_item'			=> 'Cerca commonunity',
			'not_found'				=> 'Nessun elemento commonunity trovato',
			'not_found_in_trash'	=> 'Nessun elemento commonunity trovato nel cestino',
			'parent_item_col'		=> '',
			'menu_name'				=> 'Commonunity'
		)
	);
	register_post_type('commonunity', $itemsArgs);
	if (class_exists('MultiPostThumbnails')) {
        new MultiPostThumbnails(
            array(
                'label' => 'Immagine',
                'id' => 'blog-image',
                'post_type' => 'commonunity'
            )
        );
    }
	add_action('init', function(){
		register_taxonomy_for_object_type('filter', 'commonunity');
	});
	add_action('init', function(){
		$blogLabels = array(
			'name'                       => 'Blog',
			'singular_name'              => 'Blog',
			'search_items'               => 'Search Blog' ,
			'popular_items'              => 'Popular Blogs',
			'all_items'                  => 'All Blogs',
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'edit_item'                  => 'Edit Blog',
			'update_item'                => 'Update Blog',
			'add_new_item'               => 'Add New Blog',
			'new_item_name'              => 'New Blog Name',
			'separate_items_with_commas' => 'Seaparate blogs with commas',
			'add_or_remove_items'        => 'Add or remove Blogs',
			'choose_from_most_used'      => 'Choose from the most used blogs',
			'not_found'                  => 'No blogs found',
			'menu_name'                  => 'Blogs',
		);

		$blogArgs = array(
			'hierarchical'          => true,
			'labels'                => $blogLabels,
			'show_ui'               => true,
			'show_admin_column'     => true,
			'query_var'             => true,
			'rewrite'               => array( 'slug' => 'blog' ),
		);
		register_taxonomy('blog', 'post', $blogArgs);
	});
	add_action('add_meta_boxes', function(){
		\CpPressOnePage\CpOnePage::dispatch('Admin', 'add_custom_link_meta', array('commonunity'));
		\CpPressOnePage\CpOnePage::dispatch('Admin', 'add_custom_subtitle', array('commonunity'));
	});
	add_filter('manage_posts_columns', function($columns){
		unset($columns['categories']);
		unset($columns['tags']);
		return $columns;
	});
	add_action('admin_menu', function(){
		remove_submenu_page('edit.php', 'edit-tags.php?taxonomy=category');
		remove_submenu_page('edit.php', 'edit-tags.php?taxonomy=post_tag');
		remove_meta_box( 'categorydiv','post','normal' ); // Categories Metabox
		remove_meta_box( 'tagsdiv-post_tag','post','normal' ); // Tags Metabox
	});
	add_action('cp-admin-text-extend', function($row, $col, $section, $content){
		if(strtolower($section) == 'servizi'){
			$c['taxonomy'] = 'blog';
			$c['label'] = 'Blog';
			$c['category'] = $content['category'];
			\CpPressOnePage\CpOnePage::dispatch('AdminContentType', 'category', array($row, $col, $c));
		}
	}, 10, 4);
	add_filter('cp-text-modify-view', function($val, $content){
		if(strtolower($content['section_name']) == 'servizi'){
			if($content['category']){
				return array(
					'isChild'	=> true,
					'view'		=> $content['section_name']
				);
			}
		}
		
		return null;
	}, 10, 2);
	
	add_action( 'pre_get_posts', function($query){
		if(is_tax()){
			$query->set('posts_per_page', 5);
		}
	});
	
?>
