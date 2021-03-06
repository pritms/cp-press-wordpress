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
class AdminSliderController extends \CpPressOnePage\Controller{

	protected $uses = array('Slider', 'Section', 'PostMeta', 'SliderSettings');

	public static $sliderOptions = array('show_title', 'show_content', 'show_logo', 'run_effect', 'type', 'sub_title', 'show_overlay', 'next_section');

	public function create($post, $box){
		list($content, $sliders) = $this->createContent($post->ID);
		$this->assign('slides_body', $content);
		$this->assign('show_title', isset($sliders['show_title']) ? $sliders['show_title'] : '');
		$this->assign('show_content', isset($sliders['show_content']) ? $sliders['show_content'] : '');
		$this->assign('show_logo', isset($sliders['show_logo']) ? $sliders['show_logo'] : '');
		$this->assign('show_overlay', isset($sliders['show_overlay']) ? $sliders['show_overlay'] : '');
		$this->assign('slider_type', isset($sliders['type']) ? $sliders['type'] : 'cppress');
		$this->assign('sub_title', isset($sliders['sub_title']) ? $sliders['sub_title'] : '');
		$this->assign('next_section', isset($sliders['next_section']) ? $sliders['next_section'] : '');
		$this->assign('slides_body', $content);
		$this->assign('slider_id', $post->ID);
	}
	
	public function create_cppress(){
		$this->isAjax = true;
		list($content, $sliders) = $this->createContent($this->post['slider_id'], 'cppress');
		$this->assign('slides_body', $content);
		$this->assign('slider_id', $this->post['slider_id']);
	}
	
	public function create_parallax(){
		$this->isAjax = true;
		list($content, $sliders) = $this->createContent($this->post['slider_id'], 'parallax');
		$this->assign('slides_body', $content);
		$this->assign('slider_id', $this->post['slider_id']);
	}
	
	public function create_bootstrap(){
		$this->isAjax = true;
		list($content, $sliders) = $this->createContent($this->post['slider_id'], 'bootstrap');
		$this->assign('slides_body', $content);
		$this->assign('slider_id', $this->post['slider_id']);
	}

	public function select_slider($content=array(), $col=0){
		$this->autoRender = false;
		if(empty($content)){
			$this->isAjax = true;
			$this->assign('ajax', true);
		}else{
			$this->assign('ajax', false);
		}
		$this->assign('content', $content);
		$this->assign('title', 'slider');
		$this->assign('type', 'slider');
		$this->assign('ns', '\CpPressSlider\CpSlider');
		$this->assign('controller', 'AdminSlider');
		$this->assign('action', 'select_slider');
		$sliders = $this->Slider->findAll();
		$this->assign('items', \Set::combine($sliders->posts, '{n}.ID', '{n}.post_title'));
		$this->assign('section', $this->Section->find(array('p' => $this->get['section'])));
		if(isset($this->get['num_col']))
			$this->assign('num_col', $this->get['num_col']);
		else
			$this->assign('num_col', $col);

		return $this->render(array('controller' => 'AdminSection', 'action' => 'select_content', 'ns' => 'cp-press-onepage'));
	}

	public function add_slide($slide='', $title='', $content='', $link=''){
		if(!$slide){
			$this->isAjax = true;
			$slide_thumb = wp_get_attachment_image_src($this->post['slide_id'], array('150', '150'));
			$slide_full = wp_get_attachment_image_src($this->post['slide_id'], 'full');
			$slide_id = $this->post['slide_id'];
		}else{
			$this->isAjax = false;
			$slide_thumb = wp_get_attachment_image_src($slide, array('150', '150'));
			$slide_full = wp_get_attachment_image_src($slide, 'full');
			$slide_id = $slide;
		}
		$this->assign('slide_link', $link);
		$this->assign('slide_thumb', $slide_thumb);
		$this->assign('slide_full', $slide_full);
		$this->assign('slide_id', $slide_id);
		$this->assign('slide_title', $title);
		$this->assign('slide_content', $content);
	}
	
	public function add_parallax_slide($slide='', $title='', $num=''){
		if(!$slide){
			$this->isAjax = true;
			$slide_id = $this->post['slide_id'];
			$slide_num = $this->post['slide_num'];
		}else{
			$this->isAjax = false;
			$slide_id = $slide;
			$slide_num = $num;
		}
		$this->assign('slide_num', $slide_num);
		$this->assign('slide_id', $slide_id);
		$this->assign('slide_title', $title);
		$this->assign('slide_link', $link);
	}
	
	public function add_parallax_bg($slide=''){
		if(!$slide){
			$this->isAjax = true;
			$slide_thumb = wp_get_attachment_image_src($this->post['slide_id'], array('150', '150'));
			$slide_full = wp_get_attachment_image_src($this->post['slide_id'], 'full');
			$slide_id = $this->post['slide_id'];
		}else{
			$this->isAjax = false;
			$slide_thumb = wp_get_attachment_image_src($slide, array('150', '150'));
			$slide_full = wp_get_attachment_image_src($slide, 'full');
			$slide_id = $slide;
		}
		$this->assign('slide_thumb', $slide_thumb);
		$this->assign('slide_full', $slide_full);
		$this->assign('slide_id', $slide_id);
	}

	public function delete_slide(){
		$this->autoRender = false;
		$this->isAjax = true;
		$slides = $this->PostMeta->find(array($this->post['container_id'], 'cp-press-slider'));
		update_post_meta($this->post['container_id'], 'cp-press-slider', \Set::remove($slides, $this->post['id']));
		return json_encode(array('success' => true, 'id' => $this->post['id']));
	}

	public static function save($post_id){
		if(isset($_POST['cp-press-slider'])){
			if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
				return;
			update_post_meta($post_id, 'cp-press-slider', $_POST['cp-press-slider']);
		}
	}
	
	private function createContent($id, $type=''){
		$sliders = $this->PostMeta->find(array($id, 'cp-press-slider'));
		if($type != ''){
			$sliders['type'] = $type;
		}
		$content = '';
		if(!empty($sliders)){
			$num = 0;
			foreach($sliders as $key => $slide){
				if(!is_string($key)){
					if($type != ''){
						if($slide['action'] == 'add_parallax_bg' && $type != 'parallax'){
							continue;
						}
						if($type == 'cppress'){
							$slide['action'] = 'add_slide';
						}else if($slide['action'] != 'add_parallax_bg'){
							$slide['action'] = 'add_'.$type.'_slide';
						}
					}
					$params = array($slide['id']);
					if(isset($slide['title']))
						array_push($params, $slide['title']);
					if(isset($slide['content']))
						array_push ($params, $slide['content']);
					if(isset($slide['link']))
						array_push ($params, $slide['link']);
					if($slide['action'] == 'add_parallax_slide'){
						array_push($params, $num++);
					}
					$content .= CpSlider::dispatch_template('AdminSlider', $slide['action'], $params);
				}
			}
		}
		
		return array($content, $sliders);
	}

}

?>
