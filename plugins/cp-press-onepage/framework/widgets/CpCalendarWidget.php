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
 * CpCalendarWidget
 *
 * 
 *
 * @author Marco Trognoni, <mtrognon@commonhelp.it>
 */

namespace CpPressOnePage;
class CpCalendarWidget extends \WP_Widget{
	
	
	public function __construct() {
		$opt = array(
			'classname'		=> 'cp_calendar_widget',
			'description'	=> 'An ical calendar aggregator'
		);
		$control_opt = array( 'width' => 300, 'height' => 350, 'id_base' => 'cp-calendar-widget' );
		parent::__construct('cp-calendar-widget', 'ICal Aggrgator', $opt, $control_opt);
	}
	
	public function form($instance) {
		
		CpOnePage::dispatch('CalendarWidget', 'form', array($instance, $this));
	}
	
	public function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = trim(strip_tags($new_instance['title']));
		$instance['url'] = esc_url_raw(strip_tags($new_instance['url']));
		$instance['maxresults'] = intval($new_instance['maxresults']);
		$instance['weekday'] = $new_instance['weekday'];
		$instance['month'] = $new_instance['month'];
		$instance['showfuture'] = $new_instance['showfuture'];
		return $instance;
	}
	
	public function widget($args, $instance) {
		CpOnePage::dispatch('CalendarWidget', 'widget', array($args, $instance));
	}
}
?>
