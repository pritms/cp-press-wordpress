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
namespace CpPressGallery;
import('controller.AdminGalleryController');
class AdminController extends \CpPressOnePage\Controller{
	
	protected $uses = array('Settings');
	
	public function __construct() {
		parent::__construct();
		$this->autoRender = false;
		
	}
	
	public function install(){
		$sectionContentType = array(
			'section_content_type' => array(
				'gallery' => 'Gallery Layout'
			),
		);
		$this->Settings->save($sectionContentType);
	}
	
	public function admin_init(){
		register_setting('chpress_gallery_settings_groups', 'chpress_gallery_settings');
		add_action('wp_ajax_gallery', function(){
			CpGallery::dispatch('AdminGallery', 'select_gallery');
		});
		add_action('wp_ajax_add_image', function(){
			CpGallery::dispatch('AdminGallery', 'add_image');
		});
		add_action('wp_ajax_delete_image', function(){
			CpGallery::dispatch('AdminGallery', 'delete_image');
		});
		add_action('wp_ajax_delete_video', function(){
			CpGallery::dispatch('AdminGallery', 'delete_video');
		});
		add_action('wp_ajax_add_video_modal', function(){
			CpGallery::dispatch('AdminGallery', 'add_video_modal');
		});
		add_action('wp_ajax_add_video', function(){
			CpGallery::dispatch('AdminGallery', 'add_video');
		});
	}
	
	public function admin_enqueue_scripts(){
		\CpPressOnePage\CpOnePage::dispatch('Admin', 'admin_enqueue_scripts');
		wp_enqueue_script('cp-press-gallery-admin');
		wp_enqueue_style( 'cp-press-gallery-admin' );
	}
	
	public function admin_menu(){
		add_submenu_page(
			'chpress_main_menu', 
			'Gallery settings', 
			'Gallery Settings',
			'manage_options', 
			'chpress_gallery_settings',
			function(){
				CpGallery::dispatch('GallerySettings', 'settings');
			}
		);
	}
	
	public function add_meta_boxes(){
		add_meta_box(
			'cp-press-gallery-create', 
			'Create Gallery', 
			function($post, $box){
				CpGallery::dispatch('AdminGallery', 'create', array($post, $box));
			},
			'gallery', 
			'advanced', 
			'default'
		);
		$this->add_meta_boxes_per_post_type('post');
		$this->add_meta_boxes_per_post_type('page');
		$this->add_meta_boxes_per_post_type('event');
	}
	
	public function add_meta_boxes_per_post_type($post_type){
		if(post_type_exists($post_type)){
			add_meta_box(
				'cp-press-gallery-select-product', 
				'Select Gallery', 
				function($post, $box){
					CpGallery::dispatch('AdminGallery', 'select_gallery_box', array($post, $box));
				},
				$post_type, 
				'side', 
				'default'
			);
		}
	}
	
	public function save_post($post_id, $post, $update){
		AdminGalleryController::save($post_id);
	}
	
	public function media_upload_image(){
		
	}
	
	public function media_upload_library(){
		
	}
	
}

?>