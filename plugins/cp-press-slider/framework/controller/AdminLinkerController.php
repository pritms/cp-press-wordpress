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
namespace CpPressSlider;
\import('util.Set');
class AdminLinkerController extends \CpPressOnePage\Controller{

	protected $uses = array('Slider', 'PostType', 'PostMeta');
	
	private $excludePostType = array('attachment', 'slider', 'section', 'portfolio');

	public function open(){
		$this->isAjax = true;
		$this->assign('slide_id', $this->post['slide_id']);
		$linkTypes = array_diff(get_post_types(array('public'   => true)), $this->excludePostType);
		$linkTypes['custom'] = 'custom';
		$this->assign('link', $this->post['link']);
		$this->assign('content', CpSlider::dispatch_template('AdminLinker', 'content', array(current($linkTypes))));
		$this->assign('post_types', $linkTypes);
	}
	
	public function content($type=''){
		if($type == ''){
			$this->isAjax = true;
			$type = $this->post['type'];
		}
		$this->assign('type', $type);
		if($type == 'custom'){
			$this->assign('title', 'Insert custom url:');
		}else{
			$this->assign('title', 'Select '.$type.' to link');
			$posts = $this->PostType->findAll(array('post_type' => $type));
			$posts = \Set::combine($posts->posts, '{n}.ID', '{n}.post_title');
			$this->assign('first_link', get_permalink(key($posts)));
			$this->assign('posts', $posts);
		}
	}
	
	public function delete(){
		$this->autoRender = false;
		$this->isAjax = true;
		$links = $this->PostMeta->find(array($this->post['slider_id'], 'cp-press-slider'));
		update_post_meta($this->post['slider_id'], 'cp-press-slider', \Set::remove($links, $this->post['slide_id'].'.link'));
		return json_encode(true);
	}

}

?>
