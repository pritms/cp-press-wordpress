<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace CpPressOnePage;
import('model.Options');
class Settings extends Options{
	
	public function __construct(){
		$this->group = 'chpress_settings';
		$this->options = get_option('chpress_settings');
		parent::__construct();
	}
}
?>