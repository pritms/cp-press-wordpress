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
class AssetsController extends Controller{
	
	private $javascriptOptions = array();
	
	public function __construct(){
		parent::__construct();
		$this->autoRender = false;
		$this->javascriptOptions['header'] = get_option('chpress_header_settings');
	}
	
	public function styles(){
		wp_enqueue_style('bootstrap');
		wp_enqueue_style('bootstrap-responsive');
		wp_enqueue_style('entypo-icon');
		wp_enqueue_style('cp-press');
	}
	
	public function inline_styles(){
		//dump($this->javascriptOptions['header']['chpress_header_settings']['color']);
		$this->assign('color', $this->javascriptOptions['header']['chpress_header_settings']['color']);
		return $this->render();
	}
	
	public function javascripts(){
		wp_enqueue_script('jquery');
		wp_enqueue_script('browser');
		wp_enqueue_script('mobile');
		wp_enqueue_script('bootstrap');
		wp_enqueue_script('transit');
		wp_enqueue_script('lazyload');
		wp_enqueue_script('scrollto');
		wp_enqueue_script('nav');
		wp_enqueue_script('cp-press');
		wp_enqueue_script('cp-press-carousel');
		wp_localize_script('cp-press', 'cpPressOptions', $this->javascriptOptions);
	}
}

?>