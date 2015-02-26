<?php
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	$itemsArgs = array(
		'public'		=> true,
		'has_archive'	=> false,
		'hierarchical' => true,
		'supports'		=> array('title', 'editor', 'thumbnail', 'excerpt', 'page-attributes'),
		'labels'		=> array(
			'name'					=> 'servizi',
			'singular_name'			=> 'Servizio',
			'add_new'				=> 'Aggiungi nuovo servizio',
			'add_new_item'			=> 'Aggiungi nuovo servizio',
			'edit_item'				=> 'Modifica servizio',
			'new_item'				=> 'Nuovo servizio',
			'all_item'				=> 'Tutti',
			'view_item'				=> 'Visualizza servizio',
			'search_item'			=> 'Cerca servizio',
			'not_found'				=> 'Nessun servizio trovato',
			'not_found_in_trash'	=> 'Nessun servizio trovato nel cestino',
			'parent_item_col'		=> '',
			'menu_name'				=> 'Servizi'
		)
	);
	register_post_type('servizi', $itemsArgs);
	$itemsArgs = array(
		'public'		=> true,
		'has_archive'	=> false,
		'supports'		=> array('title', 'editor', 'thumbnail', 'excerpt'),
		'labels'		=> array(
			'name'					=> 'collaboratori',
			'singular_name'			=> 'Collaboratore',
			'add_new'				=> 'Aggiungi nuovo collaboratore',
			'add_new_item'			=> 'Aggiungi nuovo collaboratore',
			'edit_item'				=> 'Modifica collaboratore',
			'new_item'				=> 'Nuovo collaboratore',
			'all_item'				=> 'Tutti',
			'view_item'				=> 'Visualizza collaboratore',
			'search_item'			=> 'Cerca collaboratore',
			'not_found'				=> 'Nessun collaboratore trovato',
			'not_found_in_trash'	=> 'Nessun collaboratore trovato nel cestino',
			'parent_item_col'		=> '',
			'menu_name'				=> 'Collaboratori'
		)
	);
	register_post_type('collaboratori', $itemsArgs);
	if(is_plugin_active('cp-press-gallery'.DIRECTORY_SEPARATOR.'cp-press-gallery.php')){
		add_action('add_meta_boxes', function(){
			\CpPressGallery\CpGallery::dispatch('Admin', 'add_meta_boxes_per_post_type', array('project'));
		});
	}
	register_sidebar(array(
			'name' => 'societa',
			'before_widget' => '<div class="cp-widget cp-societa">',
			'after_widget'  => '</div>',
		)
	);
	register_sidebar(array(
			'name' => 'sede',
			'before_widget' => '<div class="cp-widget cp-sede">',
			'after_widget'  => '</div>',
		)
	);
	register_sidebar(array(
			'name' => 'servizi',
			'before_widget' => '<div class="cp-widget cp-splash-menu">',
			'after_widget'  => '</div>',
		)
	);
	register_sidebar(array(
			'name' => 'collaboratori',
			'before_widget' => '<div class="cp-widget cp-splash-menu">',
			'after_widget'  => '</div>',
		)
	);
	register_sidebar(array(
			'name' => 'mappa',
			'before_widget' => '<div class="cp-widget cp-splash-menu">',
			'after_widget'  => '</div>',
		)
	);

?>
