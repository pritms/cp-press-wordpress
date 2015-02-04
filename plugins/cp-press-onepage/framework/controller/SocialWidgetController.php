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

class SocialWidgetController extends Controller{
	
	
	public function form($instance, \WP_Widget $widget){
		$defaults = array( 'title' => '', 'twidgetid' => '', 'url' => 'Insert here url for tweeter mashup');
		$instance = wp_parse_args( (array) $instance, $defaults );
		
		$this->assign('title', esc_attr($instance['title']));
		$this->assign('url', esc_attr($instance['url']));
		$this->assign('twidgetid', esc_attr($instance['twidgetid']));
	
		$this->assign('widget', $widget);
	}
	
	public function widget($args, $instance){
		$this->assign('instance', $instance);
	}

}

?>