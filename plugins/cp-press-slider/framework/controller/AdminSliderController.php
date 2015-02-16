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

	private $sliderOptions = array('show_title', 'show_content', 'show_logo', 'run_effect', 'type', 'sub_title', 'show_overlay', 'next_section');

	public function create($post, $box){
		$sliders = $this->PostMeta->find(array($post->ID, 'cp-press-slider'));
		$content = '';
		if(!empty($sliders)){
			foreach($sliders as $key => $slide){
				if(!in_array($key, $this->sliderOptions)){
					$params = array($slide['id']);
					if(isset($slide['title']))
						array_push($params, $slide['title']);
					if(isset($slide['content']))
						array_push ($params, $slide['content']);
					$content .= CpSlider::dispatch_template('AdminSlider', $slide['action'], array($slide['id'], $slide['title'], $slide['content']));
				}
			}
		}
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

	public function add_slide($slide='', $title='', $content=''){
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
		$this->assign('slide_title', $title);
		$this->assign('slide_content', $content);
	}
	
	public function add_parallax_slide($slide='', $title=''){
		if(!$slide){
			$this->isAjax = true;
			$slide_id = $this->post['slide_id'];
		}else{
			$this->isAjax = false;
			$slide_id = $slide;
		}
		$this->assign('slide_id', $slide_id);
		$this->assign('slide_title', $title);
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
		$slides = $this->PostMeta->find(array($this->post['slider_id'], 'cp-press-slider'));
		update_post_meta($this->post['slider_id'], 'cp-press-slider', \Set::remove($slides, $this->post['slide_id']));
		return json_encode(true);
	}

	public function slider_view($content=array(), $col=0){
		$this->autoRender = false;
		$slide = $this->Slider->find(array('p' => $content['id']));
		$slidePost = $slide->posts[0];
		$slidersData = $this->PostMeta->find(array($slidePost->ID, 'cp-press-slider'));
		$view = 'slider_view';
		if($slidersData['type'] == 'cppress'){
			$sliders = $this->cppressSlider($slidersData);
			$this->assign('show_title', isset($slidersData['show_title']) ? true : false);
			$this->assign('show_content', isset($slidersData['show_content']) ? true : false);
			
		}else if($slidersData['type'] == 'parallax'){
			$sliders = $this->parallaxSlider($slidersData);
			$this->assign('show_title', isset($slidersData['show_title']) ? true : false);
			$this->assign('show_overlay', isset($slidersData['show_overlay']) ? true : false);
			$this->assign('sub_title', isset($slidersData['sub_title']) ? $slidersData['sub_title'] : '');
			$this->assign('next_section', isset($slidersData['next_section']) ? $slidersData['next_section'] : '');
			$view = 'slider_view_parallax';
		}else if($slidersData['bootstrap']){
			$sliders = $this->bootstrapSlider($slidersData);
			$this->assign('show_title', isset($slidersData['show_title']) ? true : false);
			$this->assign('show_content', isset($slidersData['show_content']) ? true : false);
		}
		$this->assign('section_name', $content['section_name']);
		$this->assign('show_logo', isset($slidersData['show_logo']) ? true : false);
		$this->assign('sliders', $sliders);
		$this->assign('slide', $slidePost);
		$logo_slider = !is_null($this->SliderSettings->find('cppress_slider_logo')) ? $this->SliderSettings->find('cppress_slider_logo') : get_template_directory_uri().'/img/logo_slide.png';
		$this->assign('logo_slider_img_uri', $logo_slider);
		return $this->render(array('controller' => 'Index', 'action' => $view));
	}

	public static function save($post_id){
		if(isset($_POST['cp-press-slider'])){
			if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
				return;

			update_post_meta($post_id, 'cp-press-slider', $_POST['cp-press-slider']);
		}
	}
	
	private function cppressSlider($slidersData){
		$sliders = array();
		foreach($slidersData as $id => $slideData){
			if(in_array($id, $this->sliderOptions))
				continue;
			$sliders[$id]['title'] = $slideData['title'];
			$sliders[$id]['content'] = $slideData['content'];
			$sliders[$id]['media'] = wp_get_attachment_image_src($id, 'full');
		}
		
		return $sliders;
	}
	
	private function parallaxSlider($slidersData){
		$sliders = array();
		foreach($slidersData as $id => $slideData){
			if(in_array($id, $this->sliderOptions))
				continue;
			if($slideData['action'] == 'add_parallax_bg'){
				$sliders['bg']['media'] = wp_get_attachment_image_src($id, 'full');
			}else{
				$sliders[$id]['title'] = $slideData['title'];
			}
		}
		return $sliders;
	}
	
	private function bootstrapSlider($slidersData){
		$sliders = array();
		
		return $sliders;
	}

}

?>
