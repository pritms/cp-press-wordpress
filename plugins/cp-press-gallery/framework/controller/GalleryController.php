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
namespace CpPressGallery;
\import('util.Set');
class GalleryController extends \CpPressOnePage\Controller{
	
	protected $uses = array('Gallery', 'PostMeta');
	
	public function show($post){
		$this->autoRender = false;
		if($post->post_type != 'gallery')
			$gallery['id'] = $this->PostMeta->find(array($post->ID, 'cp-press-gallery-select'));
		else
			$gallery['id'] = $post->ID;
		if(!empty($gallery['id']) && $gallery['id'] != '')
			return CpGallery::dispatch_template('AdminGallery', 'gallery_view', array($gallery));
		else
			return false;
	}
	
}

?>