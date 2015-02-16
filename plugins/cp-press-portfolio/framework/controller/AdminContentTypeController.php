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
namespace CpPressPortfolio;
\import('util.Set');

class AdminContentTypeController extends \CpPressOnePage\Controller{

	protected $uses = array('Portfolio', 'PortfolioSettings', 'Section', 'PostMeta', 'PostType', 'Post');
	
	public function portfolio($row='', $col='', $content=array()){
            $this->assign('row', $row);
            $this->assign('col', $col);
            $this->assign('content', $content);
            $this->assign('title', 'portfolio');
            $this->assign('type', 'portfolio');
            $this->assign('ns', '\CpPressPortfolio\CpPortfolio');
            $this->assign('controller', 'AdminContentType');
            $this->assign('action', 'portfolio');
            $portfolios = $this->Portfolio->findAll();
            $this->assign('items', \Set::combine($portfolios->posts, '{n}.ID', '{n}.post_title'));
	}
}

?>
