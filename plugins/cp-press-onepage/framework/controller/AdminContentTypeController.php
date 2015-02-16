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

class AdminContentTypeController extends Controller{

	protected $uses = array('Section', 'Post', 'Page', 'Settings', 'PostMeta');
	
	
	public function post($row='', $col='', $content=array()){
		$this->assign('row', $row);
		$this->assign('col', $col);
		$this->assign('title', 'post');
		$this->assign('type', 'post');
		$this->assign('ns', '\CpPressOnePage\CpOnePage');
		$this->assign('controller', 'AdminContentType');
		$this->assign('action', 'post');
		$this->assign('content', $content);
		if(!empty($content) && ($content['id'] == 'extended' || $content['id'] == 'advanced'))
			$this->assign('advanced_options', CpOnePage::dispatch_template ('AdminContentType', 'postadvanced', array($row, $col, $content)));
		else
			$this->assign('advanced_options', '');
		$posts = $this->Post->findAll();
		$this->assign('items', \Set::combine($posts->posts, '{n}.ID', '{n}.post_title'));
	}

	public function postadvanced($row='', $col='', $content=array()){
		if($row==''){
			$this->isAjax = true;
			$this->assign('row', $this->post['row']);
			$this->assign('col', $this->post['col']);
		}else{
			$this->assign('row', $row);
			$this->assign('col', $col);
		}
		$this->assign('content', $content);
	}

	public function text($row='', $col='', $content=array()){
		$this->assign('row', $row);
		$this->assign('col', $col);
		if(isset($content['content']))
			$this->assign('content', $content['content']);
		else
			$this->assign('content', '');
		$this->assign('type', 'Simple Text');
		$this->assign('ns', '\CpPressOnePage\CpOnePage');
		$this->assign('controller', 'AdminContentType');
		$this->assign('action', 'text');
	}
	
	public function navigation($row='', $col='', $content=array()){
		$this->assign('row', $row);
		$this->assign('col', $col);
		$this->assign('type', 'Navigation');
		$this->assign('ns', '\CpPressOnePage\CpOnePage');
		$this->assign('controller', 'AdminContentType');
		$this->assign('action', 'navigation');
		$this->assign('content', $content);
		$this->assign('registered_menues', get_registered_nav_menus());
	}

	public function page($row='', $col=''){
		$this->assign('row', $row);
		$this->assign('col', $col);
		$this->assign('content', $content);
		$this->assign('title', 'page');
		$this->assign('type', 'page');
		$this->assign('ns', '\CpPressOnePage\CpOnePage');
		$this->assign('controller', 'AdminContentType');
		$this->assign('action', 'page');
		$pages = $this->Page->findAll();
		$this->assign('items', \Set::combine($pages->posts, '{n}.ID', '{n}.post_title'));
	}

	public function sidebar($row='', $col=''){
		$this->assign('row', $row);
		$this->assign('col', $col);
		$this->assign('content', $content);
		$this->assign('title', 'sidebar');
		$this->assign('type', 'sidebar');
		$this->assign('ns', '\CpPressOnePage\CpOnePage');
		$this->assign('controller', 'AdminContentType');
		$this->assign('action', 'sidebar');
	}
}

?>
