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
class MenuController extends Controller{
	private $defaults;

	public $menu = "header-menu";

	public $active = -1;

	public function __construct(){
		parent::__construct();
		$this->autoRender = false;

		$this->defaults = array(
			'theme_location'  => "",
			'menu'            => "",
			'container'       => "",
			'container_class' => "",
			'container_id'    => "",
			'menu_class'      => null,
			'menu_id'         => null,
			'echo'            => true,
			'before'          => "",
			'after'           => "",
			'link_before'     => "",
			'link_after'      => "",
			'items_wrap'      => apply_filters("wpchop_theme_menu_items_wrap",'<ul id="navigation" class="wpchop-menu">%3$s</ul>'),
			'walker'		  => new WalkerNavMenuCPPress(),
			'depth'           => 0,
			'pe_type'		  => "default"
		);
	}

	public function main(){
		$this->defaults['theme_location'] = $this->menu;
		$this->defaults['walker']->setActive($this->active);
		$this->defaults['walker']->object = 'section';
		$this->assign('menu_options', $this->defaults);
		return $this->render();
	}
	
	public function navbar($id){
		$walker = new WalkerNavMenuCPPress($this->active, $id);
		$walker->object = 'section';
		$this->assign('walker', $walker);
		$this->assign('menu', $id);
		return $this->render();
	}
	
	public function navbar_single(){
		$walker = new WalkerNavMenuCPPress();
		$this->assign('walker', $walker);
		$walker->object = 'section';
		$this->assign('menu', 'header-menu');
		return $this->render(array('action' => 'navbar'));
	}

}

class WalkerNavMenuCPPress extends \Walker_Nav_Menu {

	private $active;
	private $menu;
	public $filter = array();
	public $object = 'custom';

	public function __construct($active = -1, $menu='header-menu'){
		$this->active = $active;
		$this->menu = $menu;
	}

	public function setActive($active){
		$this->active = $active;
	}

	public function setMenu($menu){
		$this->menu = $menu;
	}

	public function start_lvl(&$output, $depth = 0, $args = Array()) {
		parent::start_lvl($output, $depth, $args);
	}

	public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		if(!empty($this->filter) && in_array($item->post_title, $this->filter)) return;
		if($item->object == $this->object && $args->theme_location == $this->menu){
			switch($this->object){
				case 'section':
					$item->url = '#'.$item->title;
				default:
					$item->url = get_bloginfo('url').DS.$item->url;
			}
		}
		if($item->object != $this->object){
			$item->classes[] = 'noonepage';
		}
		if($this->active > 0 && $this->active == $item->ID){
			$item->classes[] = 'active';
			$item->classes[] = 'current';
		}
		parent::start_el($output, $item, $depth, $args, $id);
	}

	public function end_el(&$output, $object, $depth = 0, $args = Array()) {
		parent::end_el($output, $object, $depth, $args);
	}


}
?>
