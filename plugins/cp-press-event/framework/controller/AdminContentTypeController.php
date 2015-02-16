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

class AdminContentTypeController extends \CpPressOnePage\Controller{

	protected $uses = array('Section', 'PostMeta');
	
	public function event($row='', $col='', $content=array()){
		$this->assign('row', $row);
		$this->assign('col', $col);
		$action = 'event_'.$content['view'];
		$event_view = CpEvent::dispatch_template('AdminContenType', $action, array($row, $col, $content));
		$this->assign('event_view', $event_view);
		$this->assign('content', $content);
		$this->assign('type', 'event');
		$this->assign('ns', '\CpPressEvent\CpEvent');
		$this->assign('controller', 'AdminContentType');
		$this->assign('action', 'event');
	}
	
	public function event_portfolio($row='', $col='', $content=array()){
		$this->event_view_assign($row, $col, $content);
	}
	
	public function event_slider($row='', $col='', $content=array()){
		$this->event_view_assign($row, $col, $content);
	}
	
	public function event_calendar($row='', $col='', $content=array()){
		$this->event_view_assign($row, $col, $content);
	}
	
	private function event_view_assign($row='', $col='', $content=array()){
		if(empty($content)){
			$this->isAjax = true;
			$this->assign('row', $this->post['row']);
			$this->assign('col', $this->post['col']);
		}else{
			$this->assign('content', $content);
			$this->assign('row', $row);
			$this->assign('col', $col);
		}
	}
}

?>
