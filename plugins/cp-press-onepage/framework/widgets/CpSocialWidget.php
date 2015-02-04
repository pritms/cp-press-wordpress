<?php 
/**
 * @package       WPChop.Widget
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
 * CpSocialWidget
 *
 * 
 *
 * @author Marco Trognoni, <mtrognon@commonhelp.it>
 */
namespace CpPressOnePage;
class CpSocialWidget extends \WP_Widget{
	
	public function __construct() {
		$opt = array(
			'classname'		=> 'cp_social_widget',
			'description'	=> 'A social media mashup widget'
		);
		$control_opt = array( 'width' => 300, 'height' => 350, 'id_base' => 'cp-social-widget' );
		parent::__construct('cp-social-widget', 'Cp Twitter', $opt);
	}
	
	public function form($instance) {
		CpOnePage::dispatch('SocialWidget', 'form', array($instance, $this));
	}
	
	public function update($new_instance, $old_instance) {
		
		$instance = $old_instance;
		$instance['title'] = trim(strip_tags($new_instance['title']));
		$instance['url'] = esc_url_raw(strip_tags($new_instance['url']));
		$instance['twidgetid'] = trim(strip_tags($new_instance['twidgetid']));

		return $instance;
	}
	
	public function widget($args, $instance) {
		CpOnePage::dispatch('SocialWidget', 'widget', array($args, $instance));
	}
}

?>