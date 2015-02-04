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

class AdminSectionController extends Controller{

	protected $uses = array('Section', 'Post', 'Page', 'Settings', 'PostMeta');

	public function order_box($post, $box){
		$order_box_value = get_post_meta($post->ID, 'cp-press-section-order', true);
		$this->assign('order_box_value', $order_box_value != '' ? $order_box_value : $this->Section->count('publish'));
	}

	public function single_box($post, $box){
		$cp_post_options = get_post_meta($post->ID, 'cp-press-post-options', true);
		$this->assign('cp_post_options', $cp_post_options);
	}

	public function content($post, $box){
		global $wp_registered_sidebars;
		$content_cols = $this->PostMeta->find(array($post->ID, 'cp-press-section-content'));
		$cols = array();
		$content_body = '';
		if(isset($content_cols) && !empty($content_cols)){
			foreach($content_cols as $col => $content){
				$t_content = $content;
				$t_content['post_id'] = $post->ID;
				$class = $content['ns'];
				$content_body .= $class::dispatch_template($content['controller'], $content['action'], array($content, $col));
				$this->assign('content_body', $content_body);
				$cols[$col] = CpOnePage::dispatch_template('AdminSection', 'select_content_type', array($t_content, $col));
			}
			$this->assign('cols', $cols);
		}else{
			$t_content = array('post_id' => $post->ID);
			$cols[0] = CpOnePage::dispatch_template('AdminSection', 'select_content_type', array($t_content, 0));;
			$this->assign('cols', $cols);
		}
		$this->assign('is_sidebar_active', true);
		if(empty($wp_registered_sidebars))
			$this->assign('is_sidebar_active', false);
		$this->assign('post_id', $post->ID);
		$this->assign('content', $content);
	}

	public function select_content_type($content=array(), $col=0){
		global $wp_registered_sidebars;
		if(empty($content)){
			$this->isAjax = true;
			$this->assign('ajax', true);
		}else{
			if($content['type'] == 'Simple Text')
				$content['type'] = 'text';
			$this->assign('ajax', false);
		}
		if(!isset($this->get['num_col']))
			$this->assign('col', $col);
		else
			$this->assign('col', $this->get['num_col']);
		$this->assign('content', $content);
		if(!isset($this->get['post']))
			$this->assign('post_id', $content['post_id']);
		else
			$this->assign('post_id', $this->get['post']);
		if(!empty($wp_registered_sidebars))
			$this->assign('content_types', $this->Settings->find('section_content_type'));
		else{
			$content_types = \Set::remove($this->Settings->find('section_content_type'), 'sidebar');
			$this->assign('content_types', $content_types);
		}
	}

	public function select_post($content = array(), $col=0){
		if(empty($content)){
			$this->isAjax = true;
			$this->assign('ajax', true);
		}else{
			$this->assign('ajax', false);
		}
		$this->assign('title', 'post');
		$this->assign('type', 'post');
		$this->assign('ns', '\CpPressOnePage\CpOnePage');
		$this->assign('controller', 'AdminSection');
		$this->assign('action', 'select_post');
		$this->assign('content', $content);
		if(!empty($content) && ($content['id'] == 'extended' || $content['id'] == 'advanced'))
			$this->assign('advanced_options', CpOnePage::dispatch_template ('AdminSection', 'select_post_advanced', array($content, $col)));
		else
			$this->assign('advanced_options', '');
		$posts = $this->Post->findAll();
		$this->assign('items', \Set::combine($posts->posts, '{n}.ID', '{n}.post_title'));
		$this->assign('section', $this->Section->find(array('p' => $this->get['section'])));
		if(isset($this->get['num_col']))
			$this->assign('num_col', $this->get['num_col']);
		else
			$this->assign('num_col', $col);
	}

	public function select_post_advanced($content = array(), $col=0){
		if(empty($content))
			$this->isAjax = true;
		$this->assign('content', $content);
		if(isset($this->get['num_col']))
			$this->assign('num_col', $this->get['num_col']);
		else
			$this->assign('num_col', $col);

	}

	public function select_simple_text($content = array(), $col=0){
		if(empty($content))
			$this->isAjax = true;
		if(isset($content['content']))
			$this->assign('content', $content['content']);
		else
			$this->assign('content', '');
		$this->assign('type', 'Simple Text');
		$this->assign('ns', '\CpPressOnePage\CpOnePage');
		$this->assign('controller', 'AdminSection');
		$this->assign('action', 'select_simple_text');
		if(isset($this->get['num_col']))
			$this->assign('num_col', $this->get['num_col']);
		else
			$this->assign('num_col', $col);
	}

	public function select_page($content = array(), $col=0){
		$this->autoRender = false;
		if(empty($content)){
			$this->isAjax = true;
			$this->assign('ajax', true);
		}else{
			$this->assign('ajax', false);
		}
		$this->assign('content', $content);
		$this->assign('title', 'page');
		$this->assign('type', 'page');
		$this->assign('ns', '\CpPressOnePage\CpOnePage');
		$this->assign('controller', 'AdminSection');
		$this->assign('action', 'select_page');
		$pages = $this->Page->findAll();
		$this->assign('items', \Set::combine($pages->posts, '{n}.ID', '{n}.post_title'));
		$this->assign('section', $this->Section->find(array('p' => $this->get['section'])));
		if(isset($this->get['num_col']))
			$this->assign('num_col', $this->get['num_col']);
		else
			$this->assign('num_col', $col);
		return $this->render(array('controller' => 'AdminSection', 'action' => 'select_content', 'ns' => 'cp-press-onepage'));
	}

	public function select_sidebar($content = array(), $col=0){
		if(empty($content)){
			$this->isAjax = true;
			$this->assign('ajax', true);
		}else{
			$this->assign('ajax', false);
		}
		$this->assign('content', $content);
		$this->assign('title', 'sidebar');
		$this->assign('type', 'sidebar');
		$this->assign('ns', '\CpPressOnePage\CpOnePage');
		$this->assign('controller', 'AdminSection');
		$this->assign('action', 'select_sidebar');
		$this->assign('section', $this->Section->find(array('p' => $this->get['section'])));
		if(isset($this->get['num_col']))
			$this->assign('num_col', $this->get['num_col']);
		else
			$this->assign('num_col', $col);
	}

	public function section_columns($cols){
		$this->autoRender = false;
		$cols['content_type'] = 'Content Layout';
		return $cols;
	}

	public function section_custom_column($col, $post){
		$this->autoRender = false;
		$content_cols = $this->PostMeta->find(array($post, 'cp-press-section-content'));
		if($content_cols){
			switch($col){
				case 'content_type':
					$content_types = $this->Settings->find('section_content_type');
					$toEcho = '';
					foreach($content_cols as $content){
						$toEcho .= $content_types[$content['type']].', ';
					}
					$toEcho = substr($toEcho, 0, strlen($toEcho) - 2);
					e($toEcho);
			}
		}else{
			e('N/A');
		}
	}

	public function order_section(\WP_Query $query){
		$this->autoRender = false;
		if(is_admin() && (isset($this->get['post_type']) && $this->get['post_type'] == 'section')){
			$query->set('orderby', 'meta_value_num');
			$query->set('meta_key', 'cp-press-section-order');
			$query->set('order', 'ASC');
		}
	}

	public function page_view($content=array(), $col=0){
		$this->autoRender = false;

		return $this->render(array('controller' => 'Index'));
	}

	public function simple_text_view($content=array(), $col=0){
		$this->autoRender = false;
		$this->assign('content', $content);
		return $this->render(array('controller' => 'Index'));
	}

	public function post_view($content=array(), $col=0){
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

	public function sidebar_view($content=array(), $col=0){
		//global $wp_registered_sidebars;

		$this->autoRender = false;
		$this->assign('sidebar', $content);
		return $this->render(array('controller' => 'Index'));
	}

	public static function save($post_id){
		if(isset($_POST['cp-press-section-order'])){
			if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
				return;

			update_post_meta($post_id, 'cp-press-section-order', sanitize_text_field($_POST['cp-press-section-order']));
		}
		if(isset($_POST['cp-press-section-content'])){
			if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
				return;

			update_post_meta($post_id, 'cp-press-section-content', $_POST['cp-press-section-content']);
		}
		if(isset($_POST['cp-press-post-options'])){
			if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
				return;

			update_post_meta($post_id, 'cp-press-post-options', $_POST['cp-press-post-options']);
		}
	}

}

?>