<?php 
/**
 * @package       WPChop.Controller
 * @subpackage Controller
 * @copyright    Copyright (C) Copyright (c) 2007 Marco Trognoni. All rights reserved.
 * @license        GNU/GPLv3, see LICENSE
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 */


/**
 * Controller
 *
 * Controller defines the inerface to access MVC Controller
 *
 * @author Marco Trognoni, <mtrognon@commonhelp.it>
 */
namespace CpPressOnePage;
import('controller.AdminSectionController');
class AdminController extends Controller{
	
	protected $uses = array('Settings', 'HeaderSettings');
	private $icons = array();
	
	public function __construct() {
		parent::__construct();
		$this->autoRender = false;
		$this->icons['logo'] = plugins_url('img/chpress.png', WPCHOP_BASE_FILE);
	}
	
	public function install(){
		$sectionContentType = array(
			'section_content_type' => array(
				'post' => 'Post Layout',
				'page' => 'Page Layout',
				'sidebar' => 'Sidebar Layout',
				'text'	=> 'Simple Text Layout'
			),
		);
		$this->Settings->delete();
		$this->Settings->save($sectionContentType);
		
	}
	
	public function admin_init(){
		register_setting('chpress_header_settings_groups', 'chpress_header_settings');
		register_setting('chpress_settings_groups', 'chpress_settings');
		add_action('wp_ajax_select_content_type', function(){
			CpOnePage::dispatch('AdminSection', 'select_content_type');
		});
		add_action('wp_ajax_post', function(){
			CpOnePage::dispatch('AdminSection', 'select_post');
		});
		add_action('wp_ajax_page', function(){
			CpOnePage::dispatch('AdminSection', 'select_page');
		});
		add_action('wp_ajax_sidebar', function(){
			CpOnePage::dispatch('AdminSection', 'select_sidebar');
		});
		add_action('wp_ajax_select_post_advanced', function(){
			CpOnePage::dispatch('AdminSection', 'select_post_advanced');
		});
		add_action('wp_ajax_text', function(){
			CpOnePage::dispatch('AdminSection', 'select_simple_text');
		});
		add_filter('manage_section_posts_columns' , function(){
			return CpOnePage::dispatch_method('AdminSection', 'section_columns', func_get_args());
		});
		add_action('manage_section_posts_custom_column' , function(){
			return CpOnePage::dispatch_method('AdminSection',  'section_custom_column', func_get_args());
		}, 10, 2 );
		add_filter('pre_get_posts', function(){
			CpOnePage::dispatch_method('AdminSection', 'order_section', func_get_args());
		});
		
		
	}
	
	public function admin_enqueue_scripts(){
		wp_enqueue_media();
		wp_enqueue_script('editor');
		wp_enqueue_script('tiny_mce');
		wp_enqueue_script('editor-functions');
		wp_enqueue_script('utils');
		wp_enqueue_script('quicktags');
		wp_enqueue_script('wp-color-picker');
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script('cp-press');
		wp_enqueue_script('media-upload');
		wp_enqueue_script('thickbox');
		wp_enqueue_style('thickbox');
		wp_enqueue_script('form-validator');
		wp_enqueue_script('jquery-ui');
		wp_enqueue_style('jquery-ui');
		wp_enqueue_style('entypo-icon');
		wp_enqueue_style('cp-press-admin');
		add_thickbox();
		
	}
	
	public function admin_menu(){
		add_menu_page(
			'CommonHelp Press', 
			'Commonhelp Press',
			'manage_options', 
			'chpress_main_menu', 
			function(){
				CpOnePage::dispatch('AdminSettings', 'main_page');
			},
			$this->icons['logo']
		);
		add_submenu_page(
			'chpress_main_menu', 
			'Header settings', 
			'Header Settings',
			'manage_options', 
			'chpress_header_settings',
			function(){
				CpOnePage::dispatch('AdminSettings', 'header_settings');
			}
		);
	}
	
	public function add_meta_boxes(){
		add_meta_box(
			'cp-press-section-order', 
			'Section order', 
			function($post, $box){
				CpOnePage::dispatch('AdminSection', 'order_box', array($post, $box));
			},
			'section', 
			'side', 
			'default'
		);
		add_meta_box(
			'cp-press-section-content', 
			'Content', 
			function($post, $box){
				CpOnePage::dispatch('AdminSection', 'content', array($post, $box));
			},
			'section', 
			'advanced'
		);
		add_meta_box(
			'cp-press-post-settings', 
			'View options', 
			function($post, $box){
				CpOnePage::dispatch('AdminSection', 'single_box', array($post, $box));
			},
			'post',
			'side', 
			'default'
		);
	}
	
	public function save_post($post_id, $post, $update){
		AdminSectionController::save($post_id);
	}
	
	public function media_upload_image(){
		
	}
	
	public function media_upload_library(){
		
	}
	
}

?>