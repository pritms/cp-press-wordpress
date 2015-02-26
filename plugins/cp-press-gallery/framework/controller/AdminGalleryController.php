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
namespace CpPressGallery;
\import('util.Set');
class AdminGalleryController extends \CpPressOnePage\Controller{
	
	protected $uses = array('Gallery', 'Section', 'PostMeta');
	
	private $galleryOptions = array('title', 'aspect_ratio', 'thumb_per_row', 'template');
	
	private $fluidGrid = array(
		'1' => '12',
		'2' => '6', 
		'3' => '4',
		'4' => '3',
		'6' => '2'
	);
	
	public function create($post, $box){
		$images = $this->PostMeta->find(array($post->ID, 'cp-press-gallery'));
		$content = '';
		if(!empty($images)){
			foreach($images as $key => $image){
				if(!in_array($key, $this->galleryOptions)){
					if($image['is_video'])
						$content .= CpGallery::dispatch_template('AdminGallery', 'add_video', array($image));
					else
						$content .= CpGallery::dispatch_template('AdminGallery', 'add_image', array($image['id'], $image['title']));
				}
			}
		}
		$this->assign('grid', $this->fluidGrid);
		$this->assign('title', $images['title']);
		$this->assign('aspect_ratio', $images['aspect_ratio']);
		if($images['thumb_per_row'] != '')
			$this->assign('thumb_per_row', $images['thumb_per_row']);
		else
			$this->assign('thumb_per_row', 3); //TODO add settings for default
		
		if($images['template'] != '')
			$this->assign('template', $images['template']);
		else
			$this->assign('template', 'carousel');
		$this->assign('gallery_body', $content);
		$this->assign('gallery_id', $post->ID);
	}
	
	public function select_gallery_box($post, $box){
		$gallerySelected = $this->PostMeta->find(array($post->ID, 'cp-press-gallery-select'));
		if($gallerySelected == '')
			$gallerySelected = 0;
		$this->assign('g_selected', $gallerySelected);
		$this->assign('galleries', \Set::combine($this->Gallery->findAll()->posts, '{n}.ID', '{n}.post_title'));
	}
	
	public function add_image($image='', $title=''){
		if(!$image){
			$this->isAjax = true;
			$image_thumb = wp_get_attachment_image_src($this->post['image_id'], array('150', '150'));
			$image_full = wp_get_attachment_image_src($this->post['image_id'], 'full');
			$image_id = $this->post['image_id'];
		}else{
			$this->isAjax = false;
			$image_thumb = wp_get_attachment_image_src($image, array('150', '150'));
			$image_full = wp_get_attachment_image_src($image, 'full');
			$image_id = $image;
		}
		$this->assign('image_thumb', $image_thumb);
		$this->assign('image_full', $image_full);
		$this->assign('image_id', $image_id);
		$this->assign('image_title', $title);
	}
	
	public function add_video($video=''){
		if(!$video){
			$this->isAjax = true;
			$thumbSize = getimagesize($this->post['video_thumbnail']);
			$video_thumb[0] = $this->post['video_thumbnail'];
			$video_full[0] = $this->post['video_thumbnail'];
			$video_id = $this->post['video_id'];
			$title = $this->post['video_title'];
			$video_url = $this->post['video_url'];
		}else{
			$this->isAjax = false;
			$video_id = $video['id'];
			$thumbSize = getimagesize($video['video_thumbnail']);
			$video_thumb[0] = $video['video_thumbnail'];
			$video_full[0] = $video['video_thumbnail'];
			$title = $video['title'];
			$video_url = $video['video'];
		}
		$video_thumb[1] = 150;
		$video_thumb[2] = 150;
		$video_full[1] = $thumbSize[0];
		$video_full[2] = $thumbSize[1];
		$this->assign('is_video', true);
		$this->assign('video_thumb', $video_thumb);
		$this->assign('video_full', $video_full);
		$this->assign('video_id', $video_id);
		$this->assign('video_title', $title);
		$this->assign('video', $video_url);
	}
	
	public function add_video_modal(){
		$this->isAjax = true;
	}
	
	public function delete_image(){
		$this->autoRender = false;
		$this->isAjax = true;
		$gallery = $this->PostMeta->find(array($this->post['gallery_id'], 'cp-press-gallery'));
		update_post_meta($this->post['gallery_id'], 'cp-press-gallery', \Set::remove($gallery, $this->post['image_id']));
		return json_encode(true);
	}
	
	public function delete_video(){
		$this->autoRender = false;
		$this->isAjax = true;
		$gallery = $this->PostMeta->find(array($this->post['gallery_id'], 'cp-press-gallery'));
		update_post_meta($this->post['gallery_id'], 'cp-press-gallery', \Set::remove($gallery, $this->post['video_id']));
		return json_encode(true);
	}
	
	public static function save($post_id){
		if(isset($_POST['cp-press-gallery-select'])){
			if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
				return;
			
			update_post_meta($post_id, 'cp-press-gallery-select', $_POST['cp-press-gallery-select']);
		}
		if(isset($_POST['cp-press-gallery'])){
			if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
				return;
			
			update_post_meta($post_id, 'cp-press-gallery', $_POST['cp-press-gallery']);
		}
	}
	
}

?>