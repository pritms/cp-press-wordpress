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
						$content['content']['section_name'] = $post_name;
						if(isset($content['closure'])){
							$contentSections[$post_id][$row][$col]['content'] = $content['closure']['ns']::dispatch_template($content['closure']['controller'], strtolower($content['closure']['type']).'_view', array($row, $col, $content['content']));
						}else{
							$contentSections[$post_id][$row][$col]['content'] = '';
						}
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
	
	public function single_blog($childView=false, $view=null, $options=array()){
		global $post;
		if($childView){
			$this->isChildView = true;
			if(!is_null($view))
				$this->template = $view;
		}
		$this->assign('menu', \CpPressOnePage\CpOnePage::dispatch_template('Menu', 'navbar_single'));
		if (class_exists('MultiPostThumbnails')) {
			$thumbId = \MultiPostThumbnails::get_post_thumbnail_id(get_post_type(), 'blog-image', $post->ID);
			$headBgId = get_post_thumbnail_id($post->ID);
		}else{
			$thumbId = get_post_thumbnail_id($post->ID);
			$headBgId = $thumbId;
		}
		$othersQuery = $this->PostType->findAll(array(
			'post_type' => get_post_type(),
			'post__not_in' => array($post->ID)
		));
		$others = array();
		foreach($othersQuery->posts as $otherPost){
			$others[$otherPost->ID]['thumb'] = wp_get_attachment_image_src(get_post_thumbnail_id($otherPost->ID), 'full');
			$others[$otherPost->ID]['title'] = $otherPost->post_title;
			$others[$otherPost->ID]['content'] = $otherPost->post_excerpt;
			$others[$otherPost->ID]['permalink'] = get_permalink($otherPost->ID);
			$others[$otherPost->ID]['subtitle'] = get_post_meta($otherPost->ID, 'cp-press-section-subtitle', true);
		}
		$this->assign('others', $others);
		$this->assign('thumb', wp_get_attachment_image_src($thumbId, 'full'));
		$this->assign('head_bg', wp_get_attachment_image_src($headBgId, 'full'));
		$this->assign('post', $post);
	}
	
	public function single_post($childView=false, $view=null, $options=array()){
		global $post;
		if($childView){
			$this->isChildView = true;
			if(!is_null($view))
				$this->template = $view;
		}
		$this->assign('menu', \CpPressOnePage\CpOnePage::dispatch_template('Menu', 'navbar_single'));
	}
	
	public function taxonomy($childView=false, $view=null, $options=array()){
		global $wp_query;
		
		if($childView){
			$this->isChildView = true;
			if(!is_null($view))
				$this->template = $view;
		}
		$this->assign('menu', \CpPressOnePage\CpOnePage::dispatch_template('Menu', 'navbar_single'));
		$this->assign('navpaged', \CpPressOnePage\CpOnePage::dispatch_template('Index', 'post_numeric_nav', array($childView, $view)));
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
	
	public function post_numeric_nav($childView = false, $view=null){
		$this->autoRender = false;
		global $wp_query;
		//query_posts(array('posts_per_page' => 1));
		if($childView){
			$this->isChildView = true;
			if(!is_null($view))
				$this->template = $view."_numeric_nav";
		}
		
		if(is_singular()){
			return;
		}
		
		/** Stop execution if there's only 1 page */
		if( $wp_query->max_num_pages <= 1 ){
			return;
		}

		$paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
		$max   = intval( $wp_query->max_num_pages );
		/**	Add current page to the array */
		if ( $paged >= 1 )
			$links[] = $paged;

		/**	Add the pages around the current page to the array */
		if ( $paged >= 3 ) {
			$links[] = $paged - 1;
			$links[] = $paged - 2;
		}

		if ( ( $paged + 2 ) <= $max ) {
			$links[] = $paged + 2;
			$links[] = $paged + 1;
		}
		
		$this->assign('links', $links);
		$this->assign('max', $max);
		$this->assign('paged', $paged);
		
		return $this->render();
	}

}
?>
