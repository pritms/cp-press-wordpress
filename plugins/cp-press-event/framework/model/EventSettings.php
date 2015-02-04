<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace CpPressEvent;
\import('model.Options');
class EventSettings extends \CpPressOnePage\Options{
	
	public function __construct(){
		$this->group = 'chpress_event_settings';
		$this->options = get_option($this->group);
		parent::__construct();
	}
}
?>