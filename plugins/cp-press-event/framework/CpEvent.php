<?php
namespace CpPressEvent;
use CpPressOnePage\CpOnePage as CpOnePage;
class CpEvent extends CpOnePage{
	
	
	public static function install(){
		if(!file_exists(WPCHOP_BASE_FILE)){
			wp_die('CpEvent Plugin requires CPPress plugin installed and activated');
		}
		self::dispatch('Admin', 'install');
	}
	
	public static function start(){
		parent::$namespaces['CpPressEvent'] = 'cp-press-event/framework/';
		add_action('init', function(){
			CpEvent::setup();
		});
		add_action('admin_init', function(){
			CpEvent::dispatch('Admin', 'admin_init', func_get_args());
		});
		add_action('admin_menu', function(){
			CpEvent::dispatch('Admin', 'admin_menu', func_get_args());
		});
		add_action('add_meta_boxes', function(){
			CpEvent::dispatch('Admin', 'add_meta_boxes', func_get_args());
		});
		add_action('save_post', function(){
			CpEvent::dispatch('Admin', 'save_post', func_get_args());
		}, 10, 3);
		add_action('wp_enqueue_scripts', function(){
			CpEvent::enqueue_assets();
		});
		add_action('admin_enqueue_scripts', function(){
			CpEvent::dispatch('Admin', 'admin_enqueue_scripts', func_get_args());
		});
	}
	
	public static function setup(){
		$sliderArgs = array(
			'public'		=> true,
			'has_archive'	=> false,
			'taxonomies'	=> array(),
			'supports'		=> array('title', 'editor', 'thumbnail', 'excerpt'),
			'labels'		=> array(
				'name'					=> 'Events',
				'singular_name'			=> 'Event',
				'add_new'				=> 'Add New Event',
				'add_new_item'			=> 'Add New Event',
				'edit_item'				=> 'Edit Event',
				'new_item'				=> 'New Event',
				'all_item'				=> 'All Events',
				'view_item'				=> 'View Event',
				'search_item'			=> 'Search Event',
				'not_found'				=> 'No events found',
				'not_found_in_trash'	=> 'No events found in Trash',
				'parent_item_col'		=> '',
				'menu_name'				=> 'Events'
			)
		);
		register_post_type('event', $sliderArgs);
		register_taxonomy('calendar',array('event'),array( 
			'hierarchical' => true, 
			'public' => true,
			'show_ui' => true,
			'query_var' => true,
			'label' => 'Calendars',
			'singular_label' => 'Calendar',
			'labels' => array(
				'name'=> 'Calendars',
				'singular_name'=> 'Calendar',
				'search_items'=> 'Search Calendars',
				'popular_items'=> 'Popular Calendars',
				'all_items'=> 'All Calendars',
				'parent_items'=> 'Parent Calendars',
				'parent_item_colon'=> 'Parent Calendar:',
				'edit_item'=> 'Edit Calendar',
				'update_item'=> 'Update Calendar',
				'add_new_item'=> 'Add New Calendar', 
				'new_item_name'=> 'New Calendar Name',
				'seperate_items_with_commas'=> 'Seperate calendars with commas',
				'add_or_remove_items'=> 'Add or remove events',
				'choose_from_the_most_used'=> 'Choose from most used calendars',
			),
		));
		register_taxonomy('event-tags',array('event'),array( 
			'hierarchical' => false, 
			'public' => true,
			'show_ui' => true,
			'query_var' => true,
			'label' => 'Event Tags',
			'singular_label' => 'Event Tag',
			'labels' => array(
				'name'=> 'Event Tags',
				'singular_name'=> 'Event Tag',
				'search_items'=> 'Search Event Tags',
				'popular_items'=> 'Popular Event Tags',
				'all_items'=> 'All Event Tags',
				'parent_items'=> 'Parent Event Tags',
				'parent_item_colon'=> 'Parent Event Tag:',
				'edit_item'=> 'Edit Event Tag',
				'update_item'=> 'Update Event Tag',
				'add_new_item'=> 'Add New Event Tag',
				'new_item_name'=> 'New Event Tag Name',
				'seperate_items_with_commas'=> 'Seperate event tags with commas',
				'add_or_remove_items'=> 'Add or remove events',
				'choose_from_the_most_used'=> 'Choose from most used event tags',
			),
		));
		wp_register_style( 'cp-press-event', plugins_url('css/cp-press-event.css', __FILE__));
		wp_register_script( 'cp-press-event', plugins_url('js/cp-press-event.js', __FILE__));
		wp_register_script( 'cp-press-event-carousel', plugins_url('js/cp-press-event-carousel.js', __FILE__));
		if(is_admin()){
			wp_register_style( 'cp-press-event-admin', plugins_url('css/cp-press-event-admin.css', __FILE__));
			wp_register_script( 'cp-press-event-admin', plugins_url('js/cp-press-event-admin.js', __FILE__));
		}
	}
	
	public static function enqueue_assets() {
		self::dispatch('Assets', 'styles');
		self::dispatch('Assets', 'inline_styles');
		self::dispatch('Assets', 'javascripts');
	}
	
	public static function dispatch($app, $action='start', $params=array()){
		parent::dispatch($app, $action, $params, 'CpPressEvent');
	}
	
	public static function dispatch_template($app, $action, $params=array()){
		return parent::dispatch_template($app, $action, $params, 'CpPressEvent');
	}
	
	public static function import($libs){
		parent::addLibs($libs, __NAMESPACE__, WPCHOP_EVENT_RELATIVE);
	}
	
}
?>