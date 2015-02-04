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
class AssetsController extends \CpPressOnePage\Controller{
	
	private $javascriptOptions = array();
	protected $uses = array('PortfolioSettings');
	
	public function __construct(){
		parent::__construct();
		$this->autoRender = false;
		$this->javascriptOptions = $this->PortfolioSettings->findAll();
	}
	
	public function styles(){
		wp_enqueue_style('cp-press-portfolio');
	}
	
	public function inline_styles(){
		return $this->render();
	}
	
	public function javascripts(){
		wp_enqueue_script('cp-press-portfolio');
		wp_localize_script('cp-press-portfolio', 'cpPressPortfolioOptions', $this->javascriptOptions['chpress_portfolio_settings']);
	}
}

?>