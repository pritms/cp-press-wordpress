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
namespace CpPressSlider;
import('controller.AdminSliderController');
class AdminController extends \CpPressOnePage\Controller{
	protected $uses = array('Settings');
	
	public function __construct() {
		parent::__construct();
		$this->autoRender = false;
		
	}
	
	public function install(){
		$sectionContentType = array(
			'section_content_type' => array(
				'slider' => 'Slider Layout'
			),
		);
		$this->Settings->save($sectionContentType);
	}
	
	public function admin_init(){
		register_setting('chpress_slider_settings_groups', 'chpress_slider_settings');
		add_action('wp_ajax_slider', function(){
			CpSlider::dispatch('AdminSlider', 'select_slider');
		});
		add_action('wp_ajax_add_slide', function(){
			CpSlider::dispatch('AdminSlider', 'add_slide');
		});
		add_action('wp_ajax_delete_slide', function(){
			CpSlider::dispatch('AdminSlider', 'delete_slide');
		});
	}
	
	public function admin_enqueue_scripts(){
		\CpPressOnePage\CpOnePage::dispatch('Admin', 'admin_enqueue_scripts');
		wp_enqueue_script('cp-press-slider-admin');
		wp_enqueue_style( 'cp-press-slider-admin' );
	}
	
	public function admin_menu(){
		add_submenu_page(
			'chpress_main_menu', 
			'Slider settings', 
			'Slider Settings',
			'manage_options', 
			'chpress_slider_settings',
			function(){
				CpSlider::dispatch('SliderSettings', 'settings');
			}
		);
	}
	
	public function add_meta_boxes(){
		add_meta_box(
			'cp-press-slider-create', 
			'Create Slider', 
			function($post, $box){
				CpSlider::dispatch('AdminSlider', 'create', array($post, $box));
			},
			'slider', 
			'advanced', 
			'default'
		);
	}
	
	public function save_post($post_id, $post, $update){
		AdminSliderController::save($post_id);
	}
	
	public function media_upload_image(){
		
	}
	
	public function media_upload_library(){
		
	}
	
}

?>