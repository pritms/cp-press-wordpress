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
namespace CpPressPortfolio;
import('controller.AdminPortfolioController');
class AdminController extends \CpPressOnePage\Controller{
	protected $uses = array('Settings', 'PortfolioSettings');
	
	public function __construct() {
		parent::__construct();
		$this->autoRender = false;
		
	}
	
	public function install(){
		$sectionContentType = array(
			'section_content_type' => array(
				'portfolio' => 'Portfolio Layout'
			),
		);
		$this->Settings->save($sectionContentType);
		$portfolioSettings = array(
			'boxheight' => 'auto',
			'boxslide' => '55',
			'hideinfo' => '1'
		);
		$this->PortfolioSettings->delete();
		$this->PortfolioSettings->save($portfolioSettings);
	}
	
	public function admin_init(){
		register_setting('chpress_portfolio_settings_groups', 'chpress_portfolio_settings');
		add_action('wp_ajax_portfolio', function(){
			CpPortfolio::dispatch('AdminPortfolio', 'select_portfolio');
		});
		add_action('wp_ajax_add_item', function(){
			CpPortfolio::dispatch('AdminPortfolio', 'add_item');
		});
		add_action('wp_ajax_add_item_modal', function(){
			CpPortfolio::dispatch('AdminPortfolio', 'add_item_modal');
		});
		add_action('wp_ajax_delete_item', function(){
			CpPortfolio::dispatch('AdminPortfolio', 'delete_item');
		});
	}
	
	public function admin_enqueue_scripts(){
		\CpPressOnePage\CpOnePage::dispatch('Admin', 'admin_enqueue_scripts');
		wp_enqueue_script('cp-press-portfolio-admin');
		wp_enqueue_style( 'cp-press-portfolio-admin' );
	}
	
	public function admin_menu(){
		add_submenu_page(
			'chpress_main_menu', 
			'Portfolio settings', 
			'Portfolio Settings',
			'manage_options', 
			'chpress_portfolio_settings',
			function(){
				CpPortfolio::dispatch('PortfolioSettings', 'settings');
			}
		);
	}
	
	public function add_meta_boxes(){
		add_meta_box(
			'cp-press-portfolio-create', 
			'Create Portfolio', 
			function($post, $box){
				CpPortfolio::dispatch('AdminPortfolio', 'create', array($post, $box));
			},
			'portfolio', 
			'advanced', 
			'default'
		);
	}
	
	public function save_post($post_id, $post, $update){
		AdminPortfolioController::save($post_id);
	}
	
	public function media_upload_image(){
		
	}
	
	public function media_upload_library(){
		
	}
	
}

?>