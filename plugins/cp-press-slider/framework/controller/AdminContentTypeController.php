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
import('controller.AdminSliderController');

class AdminContentTypeController extends \CpPressOnePage\Controller{

	protected $uses = array('Slider', 'Section', 'PostMeta', 'SliderSettings');
	
	public function slider($row='', $col='', $content=array()){
            $this->assign('row', $row);
            $this->assign('col', $col);
            $this->assign('content', $content);
            $this->assign('title', 'slider');
            $this->assign('type', 'slider');
            $this->assign('ns', '\CpPressSlider\CpSlider');
            $this->assign('controller', 'AdminContentType');
            $this->assign('action', 'slider');
            $sliders = $this->Slider->findAll();
            $this->assign('items', \Set::combine($sliders->posts, '{n}.ID', '{n}.post_title'));
	}
	
	public function slider_view($row='', $col='', $content=array()){
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
	
	private function cppressSlider($slidersData){
		$sliders = array();
		foreach($slidersData as $id => $slideData){
			if(in_array($id, AdminSliderController::$sliderOptions))
				continue;
			if(isset($slideData['link'])){
				$sliders[$id]['link'] = $slideData['link'];
			}else{
				$sliders[$id]['link'] = null;
			}
			$sliders[$id]['title'] = $slideData['title'];
			$sliders[$id]['content'] = $slideData['content'];
			$sliders[$id]['media'] = wp_get_attachment_image_src($id, 'full');
		}
		
		return $sliders;
	}
	
	private function parallaxSlider($slidersData){
		$sliders = array();
		foreach($slidersData as $id => $slideData){
			if(in_array($id, AdminSliderController::$sliderOptions))
				continue;
			if($slideData['action'] == 'add_parallax_bg'){
				$sliders['bg']['media'] = wp_get_attachment_image_src($id, 'full');
			}else{
				if(isset($slideData['link'])){
					$sliders[$id]['link'] = $slideData['link'];
				}else{
					$sliders[$id]['link'] = null;
				}
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
