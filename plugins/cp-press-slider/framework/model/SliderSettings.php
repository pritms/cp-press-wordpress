<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace CpPressSlider;
\import('model.Options');
class SliderSettings extends \CpPressOnePage\Options{
	
	public function __construct(){
		$this->group = 'chpress_slider_settings';
		$this->options = get_option($this->group);
		parent::__construct();
	}
}
?>