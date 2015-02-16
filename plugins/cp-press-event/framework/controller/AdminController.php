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
namespace CpPressEvent;
import('controller.AdminEventController');
class AdminController extends \CpPressOnePage\Controller{
	
	protected $uses = array('Settings');
	
	public function __construct() {
		parent::__construct();
		$this->autoRender = false;
		
	}
	
	public function install(){
		$sectionContentType = array(
			'section_content_type' => array(
				'event' => 'Event Layout'
			),
		);
		$this->Settings->save($sectionContentType);
		
	}
	
	public function admin_init(){
		register_setting('chpress_event_settings_groups', 'chpress_event_settings');
		add_action('wp_ajax_event', function(){
			CpEvent::dispatch('AdminEvent', 'select_event');
		});
		add_action('wp_ajax_select_event_portfolio', function(){
			CpEvent::dispatch('AdminEvent', 'select_event_portfolio', func_get_args());
		});
		add_action('wp_ajax_select_event_slider', function(){
			CpEvent::dispatch('AdminEvent', 'select_event_slider', func_get_args());
		});
		add_action('wp_ajax_select_event_calendar', function(){
			CpEvent::dispatch('AdminEvent', 'select_event_calendar', func_get_args());
		});
		add_action('calendar_edit_form_fields', function(){
			CpEvent::dispatch('AdminEvent', 'calendar_taxonomy_form', func_get_args());
		}, 10, 1);
		add_action('calendar_add_form_fields', function(){
			CpEvent::dispatch('AdminEvent', 'calendar_taxonomy_form', func_get_args());
		}, 10, 1);
		add_action('edited_calendar', function(){
			CpEvent::dispatch('AdminEvent', 'calendar_taxonomy_save', func_get_args());
		}, 10, 2);
		add_action('create_calendar', function(){
			CpEvent::dispatch('AdminEvent', 'calendar_taxonomy_save', func_get_args());
		}, 10, 2);
		add_action('delete_calendar', function(){
			CpEvent::dispatch('AdminEvent', 'calendar_taxonomy_delete', func_get_args());
		}, 10, 2);
	}
	
	public function admin_enqueue_scripts(){
		\CpPressOnePage\CpOnePage::dispatch('Admin', 'admin_enqueue_scripts');
		wp_enqueue_script('cp-press-event-admin');
		wp_enqueue_style( 'cp-press-event-admin' );
	}
	
	public function admin_menu(){
		add_submenu_page(
			'chpress_main_menu', 
			'Event settings', 
			'Event Settings',
			'manage_options', 
			'chpress_event_settings',
			function(){
				CpEvent::dispatch('EventSettings', 'settings');
			}
		);
	}
	
	public function add_meta_boxes(){
		add_meta_box(
			'cp-press-event-where', 
			'Where', 
			function($post, $box){
				CpEvent::dispatch('AdminEvent', 'where', array($post, $box));
			},
			'event', 
			'normal', 
			'high'
		);
		add_meta_box(
			'cp-press-event-when', 
			'When', 
			function($post, $box){
				CpEvent::dispatch('AdminEvent', 'when', array($post, $box));
			},
			'event', 
			'side', 
			'high'
		);
	}
	
	
	
	
	
	public function save_post($post_id, $post, $update){
		AdminEventController::save($post_id);
	}
	
	public function media_upload_image(){
		
	}
	
	public function media_upload_library(){
		
	}
	
}

?>