<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace CpPressGallery;
\import('model.Options');
class GallerySettings extends \CpPressOnePage\Options{
	
	public function __construct(){
		$this->group = 'chpress_gallery_settings';
		$this->options = get_option($this->group);
		parent::__construct();
	}
}
?>