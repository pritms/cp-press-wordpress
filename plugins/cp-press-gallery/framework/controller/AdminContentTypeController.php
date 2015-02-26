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

class AdminContentTypeController extends \CpPressOnePage\Controller{

	protected $uses = array('Gallery', 'Section', 'PostMeta');
	
	public function gallery($row='', $col='', $content=array()){
		$this->assign('row', $row);
		$this->assign('col', $col);
		$this->assign('content', $content);
		$this->assign('title', 'gallery');
		$this->assign('type', 'gallery');
		$this->assign('ns', '\CpPressGallery\CpGallery');
		$this->assign('controller', 'AdminContentType');
		$this->assign('action', 'gallery');
		$galleries = $this->Gallery->findAll();
		$this->assign('items', \Set::combine($galleries->posts, '{n}.ID', '{n}.post_title'));
	}
	
	public function gallery_view($row='', $col='', $content=array()){
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
	}
}

?>
