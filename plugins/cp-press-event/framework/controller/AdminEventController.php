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
\import('util.Set');
class AdminEventController extends \CpPressOnePage\Controller{
	
	protected $uses = array('Event', 'Section', 'PostMeta', 'CalendarTaxonomy');
	
	private $eventOptions = array();
	
	private $fluidGrid = array(
		'1' => '12',
		'2' => '6', 
		'3' => '4',
		'4' => '3',
		'6' => '2'
	);
	
	public function where($post, $box){
		$event = $this->PostMeta->find(array($post->ID, 'cp-press-event'));
		$this->assign('where', $event['where']);
	}
	
	public function when($post, $box){
		$event = $this->PostMeta->find(array($post->ID, 'cp-press-event'));
		
		$this->assign('when', $event['when']);
	}
	
	public function select_event($content= array(), $col=0){
		if(empty($content)){
			$this->isAjax = true;
			$content['view'] = 'portfolio';	
		}
		$action = 'select_event_'.$content['view'];
		$event_view = CpEvent::dispatch_template('AdminEvent', $action, array($content, $col));
		$this->assign('event_view', $event_view);
		$this->assign('content', $content);
		$this->assign('type', 'event');
		$this->assign('ns', '\CpPressEvent\CpEvent');
		$this->assign('controller', 'AdminEvent');
		$this->assign('action', 'select_event');
		if(isset($this->get['num_col']))
			$this->assign('num_col', $this->get['num_col']);
		else
			$this->assign('num_col', $col);
	}
	
	public function select_event_portfolio($content = array(), $col=0){
		if(empty($content))
			$this->isAjax = true;
		else
			$this->assign('content', $content);
		if(isset($this->get['num_col']))
			$this->assign('num_col', $this->get['num_col']);
		else
			$this->assign('num_col', $col);
	}
	
	public function select_event_slider($content = array(), $col=0){
		if(empty($content))
			$this->isAjax = true;
		else
			$this->assign('content', $content);
		
		if(isset($this->get['num_col']))
			$this->assign('num_col', $this->get['num_col']);
		else
			$this->assign('num_col', $col);
	}
	
	public function select_event_calendar($content = array(), $col=0){
		if(empty($content))
			$this->isAjax = true;
		else
			$this->assign('content', $content);
		if(isset($this->get['num_col']))
			$this->assign('num_col', $this->get['num_col']);
		else
			$this->assign('num_col', $col);
	}
	
	
	
	public function event_view($content=array(), $col=0){
		$this->autoRender = false;
		if(!empty($content) && isset($content['view']))
			$template = $content['view'];
		else
			$template = 'portfolio';
		$this->assign('content', $content);
		if($content['limit'] == 0){
			$limit = -1;
		}  else {
			$limit = $content['limit'];
		}
		$eventtags_taxonomy_query = array();
		if(isset($content['tags'])){
			$eventtags_taxonomy_query = array(
				'taxonomy' => 'event-tags',
				'field'    => 'term_id',
				'terms'    => $content['tags'],
			);
		}
		$eventcalendar_taxonomy_query = array();
		if(isset($content['calendar'])){
			$eventcalendar_taxonomy_query = array(
				'taxonomy' => 'calendar',
				'field'    => 'term_id',
				'terms'    => $content['calendar'],
			);
		}
		if(empty($eventcalendar_taxonomy_query) && empty($eventtags_taxonomy_query)){
			$events_taxonomy_query = array();
		}else if(!empty($eventcalendar_taxonomy_query)){
			$events_taxonomy_query = array($eventcalendar_taxonomy_query);
		}else if(!empty($eventtags_taxonomy_query)){
			$events_taxonomy_query = array($eventtags_taxonomy_query);
		}else{
			$events_taxonomy_query = array($eventcalendar_taxonomy_query, $eventtags_taxonomy_query);
		}
		$args = array(
			'posts_per_page'	=> $limit,
			'tax_query'			=> $events_taxonomy_query,
			'meta_key'			=> 'cp-press-event-start',
			'orderby'			=> 'meta_value_num',
			'order'				=> 'ASC',
			'offset'			=> $content['offset'],
			/* Set it to false to allow WPML modifying the query. */
			'suppress_filters'	=> false
		);
		if($content['carousel']){
			$this->assign('carousel', '');
		}else{
			$this->assign('carousel', 'style="display:none;"');
		}
		$events = $this->Event->find($args);
		$this->assign('events', $events);
		return $this->render(array('controller' => 'Index', 'action' => 'event_view_'.$template));
		//return $this->render(array('controller' => 'Index'));
	}
	
	public function calendar_taxonomy_form($tags){
		$calendar_color = '#FFFFFF';
		if(isset($tags->term_id)){
			$calendar_color = $this->CalendarTaxonomy->find('category_bgcolor_'.$tags->term_id);
		}
		$this->assign('calendar_color', $calendar_color);
	}
	
	
	
	public static function save($post_id){
		if(isset($_POST['cp-press-event'])){
			if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
				return;
			
			$startDateStr = $_POST['cp-press-event']['when']['event_start_date'].' '.$_POST['cp-press-event']['when']['event_start_time'];
			$dtStart = \DateTime::createFromFormat('d/m/Y G:i', $startDateStr);
			$endDateStr = $_POST['cp-press-event']['when']['event_end_date'].' '.$_POST['cp-press-event']['when']['event_end_time'];
			$dtEnd = \DateTime::createFromFormat('d/m/Y G:i', $endDateStr);
			update_post_meta($post_id, 'cp-press-event-start', $dtStart->getTimestamp());
			update_post_meta($post_id, 'cp-press-event-end', $dtEnd->getTimestamp());
			update_post_meta($post_id, 'cp-press-event', $_POST['cp-press-event']);
		}
	}
	
	public function calendar_taxonomy_save($term_id, $tt_id){
		$this->setAutoRender(false);
		if (!$term_id) return;
		if( !empty($this->post['category_bgcolor']) && preg_match('/^#[a-zA-Z0-9]{6}$/', $this->post['category_bgcolor']) ){
			$this->CalendarTaxonomy->save(array('category_bgcolor_'.$term_id => $this->post['category_bgcolor']));
		}
	}
	
	public function calendar_taxonomy_delete($term_id){
		$this->setAutoRender(false);
		$this->CalendarTaxonomy->delete('category_bgcolor_'.$term_id);
	}
	
}

?>