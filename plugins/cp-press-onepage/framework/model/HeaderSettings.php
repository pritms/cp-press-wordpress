<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace CpPressOnePage;
import('model.Options');
class HeaderSettings extends Options{
	
	public function __construct(){
		$this->group = 'chpress_header_settings';
		$this->options = get_option($this->group);
		parent::__construct();
	}
}
?>