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
	
	public function select_gallery($content= array(), $col=0){
		$this->autoRender = false;
		if(empty($content)){
			$this->isAjax = true;
			$this->assign('ajax', true);
		}else{
			$this->assign('ajax', false);
		}
		$this->assign('content', $content);
		$this->assign('title', 'gallery');
		$this->assign('type', 'gallery');
		$this->assign('ns', '\CpPressGallery\CpGallery');
		$this->assign('controller', 'AdminGallery');
		$this->assign('action', 'select_gallery');
		$galleries = $this->Gallery->findAll();
		$this->assign('items', \Set::combine($galleries->posts, '{n}.ID', '{n}.post_title'));
		$this->assign('section', $this->Section->find(array('p' => $this->get['section'])));
		if(isset($this->get['num_col']))
			$this->assign('num_col', $this->get['num_col']);
		else
			$this->assign('num_col', $col);
		return $this->render(array('controller' => 'AdminSection', 'action' => 'select_content', 'ns' => 'cp-press-onepage'));
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
	
	public function gallery_view($content=array(), $col=0){
		$this->autoRender = false;
		$gallery = $this->Gallery->find(array('p' => $content['id']));
		$galleryPost = $gallery->posts[0];
		$galleryData = $this->PostMeta->find(array($galleryPost->ID, 'cp-press-gallery'));
		
		$this->assign('id', $galleryPost->ID);
		$images = array();
		if(isset($galleryData) && !empty($galleryData)){
			$i=0;
			foreach($galleryData as $id => $image){
				if(in_array($id, $this->galleryOptions))
					continue;
				if(!$image['is_video']){
					$images[$i]['img'] = wp_get_attachment_image_src($id, 'full');
					$images[$i]['id'] = $id;
					$images[$i]['is_video'] = false;
				}else{
					$thumbSize = getimagesize($image['video_thumbnail']);
					$images[$i]['img'][0] = $image['video_thumbnail'];
					$images[$i]['img'][1] = $thumbSize[0];
					$images[$i]['img'][2] = $thumbSize[1];
					$images[$i]['video'] = $image['video'];
					$images[$i]['is_video'] = true;
					$images[$i]['id'] = $id;
				}
				$images[$i]['caption'] = $image['title'];
				$i++;
			}
			$thumb = current($images);
			$this->assign('thumb', $thumb);
			$formatImages = array();
			$column =  ceil(count($images) / $galleryData['thumb_per_row']);
			$k = 0;
			for($i=0; $i<$column; $i++){
				for($j=0; $j<$galleryData['thumb_per_row']; $j++){
					if(isset($images[$k])){
						$formatImages[$i][$j] = $images[$k];
					}else{
						$formatImages[$i][$j] = null;
					}
					$k++;
				}
			}
			$template = $galleryData['template'];
			if($galleryData['template'] == ''){
				$template = 'carousel';
			}
			if((is_smartphone() || is_tablet()) && ($template == 'list')){
				$galleryData['mini_thumb']['w'] = '100%';
				$galleryData['mini_thumb']['h'] = 'auto';
			}else{
				$galleryData['mini_thumb']['w'] = '100%';
				$galleryData['mini_thumb']['h'] = 'auto';
			}
			if($galleryData['aspect_ratio']['x'] == '' || $galleryData['aspect_ratio']['y'] == ''){
				$galleryData['aspect_ratio']['x'] = 1;
				$galleryData['aspect_ratio']['y'] = 1;
			}
			
			if($column > 1)
				$this->assign('is_slide', true);
			else
				$this->assign('is_slide', false);
			$this->assign('col', $this->fluidGrid[$galleryData['thumb_per_row']]);
			$this->assign('mini_thumbs_col', $formatImages);
			$this->assign('title', $galleryData['title']);
			$this->assign('mini_thumb_size', $galleryData['mini_thumb']);
			$this->assign('thumb_per_row', $galleryData['thumb_per_row']);
			$this->assign('thumb_aspect_ratio', $galleryData['aspect_ratio']);


			
		}
		return $this->render(array('controller' => 'Index', 'action' => 'gallery_view_'.$template));
		//return $this->render(array('controller' => 'Index'));
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