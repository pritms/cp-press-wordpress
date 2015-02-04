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
\import('util.Set');
\import('util.ICal');
class CalendarWidgetController extends Controller{
	
	private $longWeekDay = array(
		'Domenica','Lunedì','Martedì','Marcoledì','Giovedì','Venerdì','Sabato'
	);
	
	private $shortWeekDay = array(
		'Dom','Lun','Mar','Mer','Gio','Ven','Sab'
	);
	
	private $longMonth = array(
		'','Gennaio','Febbraio','Marzo','Aprile','Maggio','Giugno','Luglio','Agosto','Settembre'
		,'Novembre','Dicembre'
	);
	
	private $shortMonth = array(
		'','Gen','Feb','Mar','Arp','Mag','Giu','Lug','Ago','Set','Ott','Nov','Dic'
	);
	
	
	
	public function form($instance, \WP_Widget $widget){
		$defaults = array( 'title' => '', 'url' => '', 'maxresults' => 5, 'weekday' => true, 'month' => true, 'showfuture' => true);
		
		$instance = wp_parse_args( (array) $instance, $defaults );
		$this->assign('title', esc_attr($instance['title']));
		$this->assign('url', esc_attr($instance['url']));
		$this->assign('maxresults', intval($instance['maxresults']));
		$this->assign('weekday', $instance['weekday']);
		$this->assign('month', $instance['month']);
		$this->assign('showfuture', $instance['showfuture']);
		$this->assign('widget', $widget);
	}
	
	public function widget($args, $instance){
		$iCal = new \ICal($instance['url']);
		$count = 1;
		$events = array();
		$testDate = new \DateTime("now");
		foreach($iCal->events() as $key => $event){
			$start_date = new \DateTime($event['DTSTART']);
			if($instance['showfuture'] && ($start_date < $testDate))
				continue;
			$events[$key]['sort'] = \ICal::iCalDateToUnixTimestamp($event['DTSTART']);
			$events[$key]['start_date'] = $start_date;
			
			$events[$key]['end_date'] = new \DateTime($event['DTEND']);
			$events[$key]['title'] = $event['SUMMARY'];
			$events[$key]['description'] = $event['DESCRIPTION'];
			$count++;
		}
		usort($events, function($a, $b){
			return $a['sort'] > $b['sort'];
		});
		array_splice($events, $instance['maxresults']);
		$this->assign('events', $events);
		$this->assign('title', $instance['title']);
		if($instance['weekday'])
			$this->assign('weekday', $this->shortWeekDay);
		else
			$this->assign('weekday', $this->longWeekDay);
		
		if($instance['month'])
			$this->assign('month', $this->shortMonth);
		else
			$this->assign('month', $this->longMonth);
	}

}

?>