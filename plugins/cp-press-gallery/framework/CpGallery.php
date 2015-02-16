<?php
namespace CpPressGallery;
use CpPressOnePage\CpOnePage as CpOnePage;
class CpGallery extends CpOnePage{
	
	
	public static function install(){
		if(!file_exists(WPCHOP_BASE_FILE)){
			wp_die('CPGallery Plugin requires CPPress plugin installed and activated');
		}
		self::dispatch('Admin', 'install');
	}
	
	public static function start(){
		parent::$namespaces['CpPressGallery'] = 'cp-press-gallery/framework/';
		add_action('init', function(){
			CpGallery::setup();
		});
		add_action('admin_init', function(){
			CpGallery::dispatch('Admin', 'admin_init', func_get_args());
		});
		add_action('admin_menu', function(){
			CpGallery::dispatch('Admin', 'admin_menu', func_get_args());
		});
		add_action('add_meta_boxes', function(){
			CpGallery::dispatch('Admin', 'add_meta_boxes', func_get_args());
		});
		add_action('save_post', function(){
			CpGallery::dispatch('Admin', 'save_post', func_get_args());
		}, 10, 3);
		add_action('wp_enqueue_scripts', function(){
			CpGallery::enqueue_assets();
		});
		add_action('admin_enqueue_scripts', function(){
			CpGallery::dispatch('Admin', 'admin_enqueue_scripts', func_get_args());
		});
	}
	
	public static function setup(){
		$sliderArgs = array(
			'public'		=> true,
			'has_archive'	=> false,
			'taxonomies'	=> array(),
			'supports'		=> array('title', 'thumbnail', 'excerpt'),
			'labels'		=> array(
				'name'					=> 'Galleries',
				'singular_name'			=> 'Gallery',
				'add_new'				=> 'Add New Gallery',
				'add_new_item'			=> 'Add New Gallery',
				'edit_item'				=> 'Edit Gallery',
				'new_item'				=> 'New Gallery',
				'all_item'				=> 'All Galleries',
				'view_item'				=> 'View Gallery',
				'search_item'			=> 'Search Gallery',
				'not_found'				=> 'No galleries found',
				'not_found_in_trash'	=> 'No galleris found in Trash',
				'parent_item_col'		=> '',
				'menu_name'				=> 'Gallery'
			)
		);
		register_post_type('gallery', $sliderArgs);
		wp_register_style( 'cp-press-gallery', plugins_url('css/cp-press-gallery.css', __FILE__));
		wp_register_script( 'carousel', plugins_url('js/cp-press-gallery-carousel.js', __FILE__));
		wp_register_script( 'cp-press-gallery', plugins_url('js/cp-press-gallery.js', __FILE__));
		wp_register_style( 'bootstrap-lightbox', plugins_url('css/bootstrap-lightbox.css', __FILE__));
		wp_register_script( 'bootstrap-lightbox', plugins_url('js/bootstrap-lightbox.js', __FILE__));
		if(is_admin()){
			wp_register_style( 'cp-press-gallery-admin', plugins_url('css/cp-press-gallery-admin.css', __FILE__));
			wp_register_script( 'cp-press-gallery-admin', plugins_url('js/cp-press-gallery-admin.js', __FILE__));
		}
	}
	
	public static function enqueue_assets() {
		self::dispatch('Assets', 'styles');
		self::dispatch('Assets', 'inline_styles');
		self::dispatch('Assets', 'javascripts');
	}
	
	public static function dispatch($app, $action='start', $params=array()){
		parent::dispatch($app, $action, $params, 'CpPressGallery');
	}
	
	public static function dispatch_template($app, $action, $params=array()){
		return parent::dispatch_template($app, $action, $params, 'CpPressGallery');
	}
	
	public static function import($libs){
		parent::addLibs($libs, __NAMESPACE__, WPCHOP_GALLERY_RELATIVE);
	}
	
}
?>