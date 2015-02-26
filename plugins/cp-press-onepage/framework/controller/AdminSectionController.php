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
	
	private $pluginContentTypes = array(
		'gallery',
		'slider',
		'portfolio',
		'event'
	);

	public function order_box($post, $box){
		$order_box_value = get_post_meta($post->ID, 'cp-press-section-order', true);
		$this->assign('order_box_value', $order_box_value != '' ? $order_box_value : $this->Section->count('publish'));
	}
	
	public function sub_title($post, $box){
		$sub_title_value = get_post_meta($post->ID, 'cp-press-section-subtitle', true);
		$this->assign('sub_title_value', $sub_title_value);
	}
	
	public function content_type_box($post, $box){
		global $wp_registered_sidebars;
		$this->assign('post_id', $post->ID);
		if(!empty($wp_registered_sidebars))
			$this->assign('content_types', $this->Settings->find('section_content_type'));
		else{
			$content_types = \Set::remove($this->Settings->find('section_content_type'), 'sidebar');
			$this->assign('content_types', $content_types);
		}
	}

	public function single_box($post, $box){
		$cp_post_options = get_post_meta($post->ID, 'cp-press-post-options', true);
		$this->assign('cp_post_options', $cp_post_options);
	}
	
	public function content($post, $box){
		global $wp_registered_sidebars;
		$contents = $this->PostMeta->find(array($post->ID, 'cp-press-section-content'));
		$rowsDb = $this->PostMeta->find(array($post->ID, 'cp-press-section-rowconfig'));
		if($rowsDb == '')
			$rowsDb = array();
		ksort($rowsDb);
		$rows = array();
		foreach($rowsDb as $row => $colsDb){
			foreach($colsDb as $col => $data){
				$rows[$row][$col]['bootstrap'] = $data['bootstrap'];
				if(isset($data['content'])){
					$rows[$row][$col]['content'] = 
							$data['closure']['ns']::dispatch_template(
									$data['closure']['controller'], 
									$data['closure']['action'], 
									array($row, $col, $data['content'])
							);
					$rows[$row][$col]['closure'] = $data['closure'];
				}else{
					$rows[$row][$col]['content'] = null;
					$rows[$row][$col]['closure'] = null;
				}
			}
		}
		$this->assign('is_sidebar_active', true);
		if(empty($wp_registered_sidebars))
			$this->assign('is_sidebar_active', false);
		$this->assign('rows', $rows);
		$this->assign('post_id', $post->ID);
		$this->assign('content', $content);
	}
	
	public function add_row_modal(){
		$this->isAjax = true;
		$fluidGrid = array(
			'1' => '12',
			'2' => '6',
			'3' => '4',
			'4' => '3',
			'6' => '2'
		);
		$this->assign('grid', $fluidGrid);
	}
	
	public function set_content_type($action='', $row='', $col=''){
		if($action == ''){
			$this->isAjax = true;
			$action = $this->post['content_type'];
			$col = $this->post['col'];
			$row = $this->post['row'];
		}
		if(!in_array($action, $this->pluginContentTypes)){
			$this->assign('content_type', CpOnePage::dispatch_template ('AdminContentType', $action, array($row, $col)));
		}else{
			$ns = '\CpPress'.ucfirst($action).'\Cp'.ucfirst($action);
			$this->assign('content_type', $ns::dispatch_template ('AdminContentType', $action, array($row, $col)));
		}
	}

	public function section_columns($cols){
		$this->autoRender = false;
		//$cols['content_type'] = 'Content Layout';
		return $cols;
	}

	public function section_custom_column($col, $post){
		$this->autoRender = false;
	
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
	
	public function navigation_view($content=array(), $col=0){
		$this->assign('menu', \CpPressOnePage\CpOnePage::dispatch_template('Menu', 'navbar', array($content['id'])));
	}

	public static function save($post_id){
		if(isset($_POST['cp-press-section-order'])){
			if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
				return;

			update_post_meta($post_id, 'cp-press-section-order', sanitize_text_field($_POST['cp-press-section-order']));
		}
		if(isset($_POST['cp-press-section-subtitle'])){
			if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
				return;

			update_post_meta($post_id, 'cp-press-section-subtitle', sanitize_text_field($_POST['cp-press-section-subtitle']));
		}
		if(isset($_POST['cp-press-section-content'])){
			if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
				return;

			update_post_meta($post_id, 'cp-press-section-content', $_POST['cp-press-section-content']);
		}
		if(isset($_POST['cp-press-section-rowconfig'])){
			if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
				return;

			update_post_meta($post_id, 'cp-press-section-rowconfig', $_POST['cp-press-section-rowconfig']);
		}
		if(isset($_POST['cp-press-post-options'])){
			if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
				return;

			update_post_meta($post_id, 'cp-press-post-options', $_POST['cp-press-post-options']);
		}
	}

}

?>
