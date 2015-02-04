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
class HeaderController extends Controller{

	protected $uses = array('HeaderSettings', 'Section');

	public function __construct(){
		parent::__construct();
		$this->autoRender = false;
	}

	public function main(){
		$this->assign('favicon', dirname(get_stylesheet_uri()).'/favicon.png');
		return $this->render();
	}

	public function logo(){
		$this->assign('logo_img_uri', dirname(get_stylesheet_uri()).'/logo.png');

		$args = array(
			'meta_key' => 'cp-press-section-order',
			'orderby' => 'meta_value_num',
			'order' => 'ASC',
			'posts_per_page' => 1
		);
		$home_section = $this->Section->find($args);
		$this->assign('home_slug', $home_section->posts[0]->post_name);
		return $this->render();
	}

	public function single(){
		$this->assign('favicon', dirname(get_stylesheet_uri()).'/favicon.png');
		return $this->render();
	}

}
?>
