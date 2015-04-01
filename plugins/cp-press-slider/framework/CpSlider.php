<?php
namespace CpPressSlider;
use CpPressOnePage\CpOnePage as CpOnePage;
class CpSlider extends CpOnePage{
	
	
	public static function install(){
		if(!file_exists(WPCHOP_BASE_FILE)){
			wp_die('CPSlider Plugin requires CPPress plugin installed and activated');
		}
		self::dispatch('Admin', 'install');
	}
	
	public static function start(){
		parent::$namespaces['CpPressSlider'] = 'cp-press-slider/framework/';
		//self::dispatch('Admin', 'install');
		add_action('init', function(){
			CpSlider::setup();
		});
		add_action('admin_init', function(){
			CpSlider::dispatch('Admin', 'admin_init', func_get_args());
		});
		add_action('admin_menu', function(){
			CpSlider::dispatch('Admin', 'admin_menu', func_get_args());
		});
		add_action('add_meta_boxes', function(){
			CpSlider::dispatch('Admin', 'add_meta_boxes', func_get_args());
		});
		add_action('save_post', function(){
			CpSlider::dispatch('Admin', 'save_post', func_get_args());
		}, 10, 3);
		add_action('wp_enqueue_scripts', function(){
			CpSlider::enqueue_assets();
		});
		add_action('admin_enqueue_scripts', function(){
			CpSlider::dispatch('Admin', 'admin_enqueue_scripts', func_get_args());
		});
	}
	
	public static function setup(){
		$sliderArgs = array(
			'public'		=> true,
			'has_archive'	=> false,
			'taxonomies'	=> array(),
			'supports'		=> array('title'),
			'menu_icon'		=> 'dashicons-media-interactive',
			'labels'		=> array(
				'name'					=> 'Sliders',
				'singular_name'			=> 'Slider',
				'add_new'				=> 'Add New Slider',
				'add_new_item'			=> 'Add New Slider',
				'edit_item'				=> 'Edit Slider',
				'new_item'				=> 'New Slider',
				'all_item'				=> 'All Sliders',
				'view_item'				=> 'View Slider',
				'search_item'			=> 'Search Slider',
				'not_found'				=> 'No sliders found',
				'not_found_in_trash'	=> 'No sliders found in Trash',
				'parent_item_col'		=> '',
				'menu_name'				=> 'Sliders'
			)
		);
		register_post_type('slider', $sliderArgs);
		wp_register_style( 'cp-press-slider', plugins_url('css/cp-press-slider.css', __FILE__));
		wp_register_script( 'cp-press-slider', plugins_url('js/cp-press-slider.js', __FILE__));
		if(is_admin()){
			wp_register_style( 'cp-press-slider-admin', plugins_url('css/cp-press-slider-admin.css', __FILE__));
			wp_register_script( 'cp-press-slider-admin', plugins_url('js/cp-press-slider-admin.js', __FILE__));
		}
	}
	
	public static function enqueue_assets() {
		self::dispatch('Assets', 'styles');
		self::dispatch('Assets', 'inline_styles');
		self::dispatch('Assets', 'javascripts');
	}
	
	public static function dispatch($app, $action='start', $params=array()){
		parent::dispatch($app, $action, $params, 'CpPressSlider');
	}
	
	public static function dispatch_template($app, $action, $params=array()){
		return parent::dispatch_template($app, $action, $params, 'CpPressSlider');
	}
	
	public static function import($libs){
		parent::addLibs($libs, __NAMESPACE__, WPCHOP_SLIDER_RELATIVE);
	}
	
}
?>