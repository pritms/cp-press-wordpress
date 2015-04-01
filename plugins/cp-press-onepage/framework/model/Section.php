<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace CpPressOnePage;
import('model.PostType');
import('model.PostMeta');
import('util.Set');
class Section extends PostType{
	
	private $PostMeta;
	
	public function __construct(){
		$this->PostMeta = new PostMeta();
	}
	
}
?>