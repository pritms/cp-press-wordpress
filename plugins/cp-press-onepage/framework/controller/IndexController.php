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
import('util.Set');
class IndexController extends Controller{

	protected $uses = array('Section', 'PostMeta', 'PostType');

	private $fluidGrid = array(
		'1' => '12',
		'2' => '6',
		'3' => '4',
		'4' => '3',
		'6' => '2'
	);

	public function onepage(){
		$args = array(
			'meta_key' => 'cp-press-section-order',
			'orderby' => 'meta_value_num',
			'order' => 'ASC'
		);
		$sections = $this->Section->findAll($args);
		$contentSections = array();
		foreach(\Set::combine($sections->posts, '{n}.ID', '{n}.post_name') as $post_id => $post_name){
			$section_content = $this->PostMeta->find(array($post_id, 'cp-press-section-rowconfig'));
			if(!empty($section_content)){
				foreach($section_content as $row => $section_content_cols){
					foreach($section_content_cols as $col => $content){
						if($content['type'] == 'Simple Text')
							$content['type'] = 'simple_text';
						$contentSections[$post_id][$row][$col]['content'] = $content['closure']['ns']::dispatch_template($content['closure']['controller'], strtolower($content['closure']['type']).'_view', array($row, $col, $content['content']));
						$contentSections[$post_id][$row][$col]['bootstrap'] = $content['bootstrap'];
					}
				}
			}
		}
		$this->assign('grid', $this->fluidGrid);
		$this->assign('content_sections', $contentSections);
		$this->assign('sections', $sections);
	}

	public function page(){
		global $post;
		$this->assign('gallery', CpOnePage::dispatch_template('Gallery', 'show', array($post), 'CpPressGallery'));
		$this->assign('thumb', wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full'));
		$this->assign('page', $post);
	}
	
	public function page_slidethumb(){
		global $post;
		$this->assign('thumb', wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full'));
		$this->assign('page', $post);
	}

	public function single($childView=false, $view=null, $options=array()){
		global $post;
		if($childView){
			$this->isChildView = true;
			if(!is_null($view))
				$this->template = $view;
		}
		if(!empty($options)){
			if(isset($options['post_child']) && isset($options['post_type'])){
				$args = array(
					'post_type'=> $options['post_type'],
					'post_parent' => $post->ID
				);
				$postChild = $this->PostType->findAll($args);
				$childThumbs = array();
				$childGalleries = array();
				foreach($postChild->posts as $child){
					$t = wp_get_attachment_image_src(get_post_thumbnail_id($child->ID), 'full');
					if($t)
						$childThumbs[$child->ID] = $t;
					$g = CpOnePage::dispatch_template('Gallery', 'show', array($child), 'CpPressGallery');
					if($g)
						$childGalleries[$child->ID] = $g;
				}
				$this->assign('child_thumbs', $childThumbs);
				$this->assign('child_galleries', $childGalleries);
				$this->assign('post_childs', $postChild->posts);
			}
		}
		$cp_post_options = get_post_meta($post->ID, 'cp-press-post-options', true);
		$this->assign('cp_post_options', $cp_post_options);
		$category = array_pop(get_the_category());
		$this->assign('category', $category);
		$this->assign('gallery', CpOnePage::dispatch_template('Gallery', 'show', array($post), 'CpPressGallery'));
		$this->assign('thumb', wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full'));
		$this->assign('post', $post);
	}

	public function single_product(){
		global $post;
		$this->assign('gallery', CpOnePage::dispatch_template('Gallery', 'show', array($post), 'CpPressGallery'));
		$this->assign('thumb', wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full'));
		$this->assign('post', $post);
	}

	public function under_construction(){
		global $post;
		$this->assign('post', $post);
	}

	public function single_gallery(){
		global $post;
		$this->assign('gallery', CpOnePage::dispatch_template('Gallery', 'show', array($post), 'CpPressGallery'));
		$this->assign('post', $post);
	}

	public function archive(){

	}

	public function tag(){

	}

}
?>
