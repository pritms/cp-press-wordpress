<?php
namespace CpPressPortfolio;
use CpPressOnePage\CpOnePage as CpOnePage;
class CpPortfolio extends CpOnePage{
	
	
	public static function install(){
		if(!file_exists(WPCHOP_BASE_FILE)){
			wp_die('CPPortfolio Plugin requires CPPress plugin installed and activated');
		}
		self::dispatch('Admin', 'install');
	}
	
	public static function start(){
		//self::dispatch('Admin', 'install');
		parent::$namespaces['CpPressPortfolio'] = 'cp-press-portfolio/framework/';
		add_action('init', function(){
			CpPortfolio::setup();
		});
		add_action('admin_init', function(){
			CpPortfolio::dispatch('Admin', 'admin_init', func_get_args());
		});
		add_action('admin_menu', function(){
			CpPortfolio::dispatch('Admin', 'admin_menu', func_get_args());
		});
		add_action('add_meta_boxes', function(){
			CpPortfolio::dispatch('Admin', 'add_meta_boxes', func_get_args());
		});
		add_action('save_post', function(){
			CpPortfolio::dispatch('Admin', 'save_post', func_get_args());
		}, 10, 3);
		add_action('wp_enqueue_scripts', function(){
			CpPortfolio::enqueue_assets();
		});
		add_action('admin_enqueue_scripts', function(){
			CpPortfolio::dispatch('Admin', 'admin_enqueue_scripts', func_get_args());
		});
	}
	
	public static function setup(){
		$portfolioArgs = array(
			'public'		=> true,
			'has_archive'	=> false,
			'taxonomies'	=> array(),
			'supports'		=> array('title'),
			'labels'		=> array(
				'name'					=> 'Portfolios',
				'singular_name'			=> 'Portfolio',
				'add_new'				=> 'Add New Portfolio',
				'add_new_item'			=> 'Add New Portfolio',
				'edit_item'				=> 'Edit Portfolio',
				'new_item'				=> 'New Portfolio',
				'all_item'				=> 'All Portfolios',
				'view_item'				=> 'View Portfolio',
				'search_item'			=> 'Search Portfolio',
				'not_found'				=> 'No portfolios found',
				'not_found_in_trash'	=> 'No portfolios found in Trash',
				'parent_item_col'		=> '',
				'menu_name'				=> 'Portfolio'
			)
		);
		
		register_post_type('portfolio', $portfolioArgs);
		wp_register_style( 'cp-press-portfolio', plugins_url('css/cp-press-portfolio.css', __FILE__));
		wp_register_script( 'cp-press-portfolio', plugins_url('js/cp-press-portfolio.js', __FILE__));
		if(is_admin()){
			wp_register_style( 'cp-press-portfolio-admin', plugins_url('css/cp-press-portfolio-admin.css', __FILE__));
			wp_register_script( 'cp-press-portfolio-admin', plugins_url('js/cp-press-portfolio-admin.js', __FILE__));
		}
	}
	
	public static function enqueue_assets() {
		self::dispatch('Assets', 'styles');
		self::dispatch('Assets', 'inline_styles');
		self::dispatch('Assets', 'javascripts');
	}
	
	public static function dispatch($app, $action='start', $params=array()){
		parent::dispatch($app, $action, $params, 'CpPressPortfolio');
	}
	
	public static function dispatch_template($app, $action, $params=array()){
		return parent::dispatch_template($app, $action, $params, 'CpPressPortfolio');
	}
	
	public static function import($libs){
		parent::addLibs($libs, __NAMESPACE__, WPCHOP_PORTFOLIO_RELATIVE);
	}
	
}
?>