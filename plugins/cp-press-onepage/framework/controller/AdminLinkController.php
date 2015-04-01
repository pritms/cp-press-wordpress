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
import('controller.AdminSectionController');
class AdminLinkController extends Controller{
	protected $uses = array('PostMeta', 'PostType', 'Post');
	
	public function create($post, $box){
		$links = $this->PostMeta->find(array($post->ID, 'cp-press-link'));
		foreach($links as $link){
			$content .= CpOnePage::dispatch_template('AdminLink', 'process', array($link));
		}
		$this->assign('link_body', $content);
		$this->assign('content_id', $post->ID);
	}
	
	public function modal(){
		$this->isAjax = true;
		
	}
	
	public function process($link=array()){
		if(empty($link)){
			$this->isAjax = true;
			$image = $this->guessLogo($this->post['uri']);
			$this->assign('image', $image);
			$this->assign('uri', $this->post['uri']);
			$this->assign('meta_uri', get_meta_tags($this->post['uri']));
		}else{
			$meta_uri['title'] = $link['title'];
			$meta_uri['description'] = $link['description'];
			$this->assign('uri', $link['uri']);
			$this->assign('image', $link['image']);
			$this->assign('meta_uri', $meta_uri);
		}
		
	}
	
	public function delete(){
		$this->autoRender = false;
		$this->isAjax = true;
		$items = $this->PostMeta->find(array($this->post['container_id'], 'cp-press-link'));
		update_post_meta($this->post['container_id'], 'cp-press-link', \Set::remove($items, $this->post['id']));
		return json_encode(array('success' => true, 'id' => $this->post['id']));
	}
	
	public static function save($post_id){
		if(isset($_POST['cp-press-link'])){
			if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
				return;

			update_post_meta($post_id, 'cp-press-link', $_POST['cp-press-link']);
		}
	}
	
	protected function guessLogo($uri){
		$content = file_get_contents($uri);
		preg_match('/<\s*meta\s+property="(og:image)"\s+content="([^"]*)/i', $content, $og);
		preg_match('/<\s*link\s+rel="image_src"\s+href="([^"]*)/i', $content, $image_src);
		if(!empty($og) && isset($og[2])){
			return $og[2];
		
		}else if(!empty($image_src) && isset($images_src[1])){
			return $image_src[1];
		}else{
			preg_match_all('/<img[^>]+>/i', $content, $images); 
			if(count($images[0]) > 20){
				$minIndex = rand(0, count($images[0])-19);
				$maxIndex = $minIndex+19;
				$images_set = array_slice($images[0], $minIndex, $maxIndex);
			}else{
				$images_set = $images[0];
			}
			$selectedImages = array();
			foreach($images_set as $image){
				preg_match('/src="([^"]*)/i', $image, $image_uri);
				list($w, $h) = @getimagesize($image_uri[1]);
				if($h > 0){		
					if($w/$h < 4 && $w >= 200 && $h >= 200){
						$selectedImages[] = $image_uri[1];
					}
				}
			}
			
			return $selectedImages[rand(0, count($selectedImages))];
		}
			
	}
	
}

?>