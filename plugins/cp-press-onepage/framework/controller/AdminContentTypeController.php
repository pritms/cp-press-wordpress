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

	protected $uses = array('Section', 'Post', 'Page', 'Settings', 'PostMeta', 'PostType');
	
	protected $baseTemplate = array('slidethumb');
	
	
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
	
	public function post_view($row='', $col='', $content=array()){
		$this->autoRender = false;
		$cp_post_options = get_post_meta($content['id'], 'cp-press-post-options', true);
		$this->assign('cp_post_options', $cp_post_options);
		if(isset($content['hidethumb']) && $content['hidethumb'])
			$this->assign('hide_thumb', true);
		else
			$this->assign('hide_thumb', false);
		if($content['id'] != 'extended')
			$this->assign('cp_post', $this->Post->find(array('p' => $content['id'], 'post_type' => 'post')));
		else{
			$options = $content['advanced'];
			$args = array(
				'post_type'			=> 'post',
				'posts_per_page'	=> $options['limit'],
				'category__in'		=> isset($options['categories']) ? $options['categories'] : array(),
				'tag__in'			=> isset($options['tags']) ? $options['tags'] : array(),
				'offset'			=> $options['offset'],
				'order'				=> $options['order'],
				'orderby'			=> $options['orderby'],
				/* Set it to false to allow WPML modifying the query. */
				'suppress_filters' => false
			);
			$this->assign('post_title', isset($options['title']) ? $options['title'] : '');
			$this->assign('cp_post', $this->Post->find($args));
		}
		return $this->render(array('controller' => 'Index'));
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
	
	public function simple_text_view($row='', $col='', $content=array()){
		$this->autoRender = false;
		$this->assign('content', $content);
		return $this->render(array('controller' => 'Index'));
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
	
	public function navigation_view($row='', $col='', $content=array()){
		$this->assign('menu', \CpPressOnePage\CpOnePage::dispatch_template('Menu', 'navbar', array($content['id'])));
	}

	public function page($row='', $col='', $content=array()){
		$this->assign('row', $row);
		$this->assign('col', $col);
		if(!empty($content)){
			$args = array(
				'p'			=> $content['id'],
				'post_type'	=> 'page'
			);
			$post = $this->PostType->findAll($args);
			$content['post'] = $post->posts[0];
		}
		$this->assign('content', $content);
		$this->assign('title', 'page');
		$this->assign('type', 'page');
		$this->assign('ns', '\CpPressOnePage\CpOnePage');
		$this->assign('controller', 'AdminContentType');
		$this->assign('action', 'page');
		$pages = $this->Page->findAll();
		$this->assign('items', \Set::combine($pages->posts, '{n}.ID', '{n}.post_title'));
	}
	
	public function page_view($row='', $col='', $content=array()){
		$this->autoRender = false;
		if(isset($content['hidethumb']) && $content['hidethumb'])
			$this->assign('hide_thumb', true);
		else
			$this->assign('hide_thumb', false);
		if(isset($content['hidetitle']) && $content['hidetitle'])
			$this->assign('hide_title', true);
		else
			$this->assign('hide_title', false);
		$page = $this->Post->find(array('p' => $content['id'], 'post_type' => 'page'));
		$pageTemplate = $this->PostMeta->find(array($page->posts[0]->ID, '_wp_page_template'));
		$pageTemplate = basename($pageTemplate, '.php');
		if($pageTemplate == 'default'){
			$pageTemplate = 'page';
		}else if(!in_array($pageTemplate, $this->baseTemplate)){
			$this->isChildView = true;
		}
		$this->assign('cp_page', $page);
		return $this->render(array('controller' => 'Index', 'action' => $pageTemplate.'_view'));
	}

	public function sidebar($row='', $col='', $content=array()){
		$this->assign('row', $row);
		$this->assign('col', $col);
		$this->assign('content', $content);
		$this->assign('title', 'sidebar');
		$this->assign('type', 'sidebar');
		$this->assign('ns', '\CpPressOnePage\CpOnePage');
		$this->assign('controller', 'AdminContentType');
		$this->assign('action', 'sidebar');
	}

	public function sidebar_view($row='', $col='', $content=array()){
		//global $wp_registered_sidebars;

		$this->autoRender = false;
		$this->assign('sidebar', $content);
		return $this->render(array('controller' => 'Index'));
	}
	
	public function type($row='', $col='', $content=array()){
		$this->assign('row', $row);
		$this->assign('col', $col);
		if(!empty($content)){
			$args = array(
				'p'			=> $content['id'],
				'post_type'	=> $content['type']
			);
			$post = $this->PostType->findAll($args);
			$content['post'] = $post->posts[0];
		}
		$this->assign('content', $content);
		$this->assign('title', 'type');
		$this->assign('type', 'type');
		$this->assign('ns', '\CpPressOnePage\CpOnePage');
		$this->assign('controller', 'AdminContentType');
		$this->assign('action', 'type');
	}
	
	public function type_view($row='', $col='', $content=array()){
		$this->autoRender = false;
		if(!empty($content)){
			$args = array(
				'p'			=> $content['id'],
				'post_type'	=> $content['type']
			);
			$post = $this->PostType->findAll($args);
			$content['post'] = $post;
		}
		$this->assign('content', $content);
		return $this->render(array('controller' => 'Index'));
	}
	
	public function type_modal(){
		$this->isAjax = true;
		$this->assign('row', $this->post['row']);
		$this->assign('col', $this->post['col']);
		$types = array();
		if($this->post['type'] == 'all'){
			$ptypes = get_post_types(array('_builtin' => false));
		}else{
			$ptypes = array($this->post['type']);
		}
		foreach($ptypes as $type){
			if(post_type_supports($type, 'editor')){
				$types[] = $type;
			}
		}
		$validPostTypesObj = array();
		foreach($types as $key => $postType){
			$obj  = get_post_type_object($postType);
			$posts = $this->PostType->findAll(array('post_type' => $postType));
			$validPostTypesObj[$key]['label'] = $obj->labels->singular_name;
			$validPostTypesObj[$key]['name'] = $obj->name;
			$validPostTypesObj[$key]['posts'] = \Set::combine($posts->posts, '{n}.ID', '{n}.post_title');
			$validPostTypesObj[$key]['contents'] = \Set::combine($posts->posts, '{n}.ID', '{n}.post_content');
		}
		
		$this->assign('types', $validPostTypesObj);
	}
	
	public function media($row='', $col='', $content=array()){
		$this->assign('row', $row);
		$this->assign('col', $col);
		if(!empty($content)){
			$this->assign('media_uri', reset(wp_get_attachment_image_src($content['id'], 'full')));
			$this->assign('media', wp_get_attachment_metadata( $content['id'], true));
		}
		$this->assign('content', $content);
		$this->assign('title', 'media');
		$this->assign('type', 'media');
		$this->assign('ns', '\CpPressOnePage\CpOnePage');
		$this->assign('controller', 'AdminContentType');
		$this->assign('action', 'media');
	}
	
	public function add_media_content(){
		$this->isAjax = true;
		$this->assign('row', $this->post['row']);
		$this->assign('col', $this->post['col']);
		$this->assign('media', $this->post['media']);
	}
	
	public function media_view($row='', $col='', $content=array()){
		$this->autoRender = false;
		$this->assign('content', $content);
		if(!empty($content)){
			$this->assign('media_uri', reset(wp_get_attachment_image_src($content['id'], 'full')));
			$media = wp_get_attachment_metadata( $content['id'], true);
			$this->assign('media', $media);
			$class = '';
			if($content['size'] == 'responsive'){
				$class .= 'img-responsive ';
				$content['size'] ==  'full';
			}
			switch($content['alignment']){
				case 'center':
					$class .= 'aligncenter';
					break;
				case 'left':
					$class .= 'alignleft';
					break;
				case 'right':
					$class .= 'alignright';
					break;
			}
			$this->assign('class', $class);
			if($content['size'] == 'full'){
				$this->assign('width', $media['width']);
				$this->assign('height', $media['height']);
			}else{
				$this->assign('width', $media['sizes'][$content['size']]['width']);
				$this->assign('height', $media['sizes'][$content['size']]['height']);
			}
		}
		return $this->render(array('controller' => 'Index'));
	}
	
	public function shortcode($attr=array(), $content=''){
		$defaults = array(
			'type' => 'post',
			'field' => 'post_title',
			'action' => 'link'
		);
		$options = shortcode_atts($defaults, $attr);
		$p = $this->Post->find(array('post_type' => $options['type']));
		$this->assign('posts', \Set::combine($p->posts, '{n}.ID', '{n}.'.$options['field']));
		$this->assign('action', $options['action']);
	}
}

?>
