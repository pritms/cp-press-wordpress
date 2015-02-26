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