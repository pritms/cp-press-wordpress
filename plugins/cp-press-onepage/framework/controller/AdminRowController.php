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
namespace CpPressOnePage;
\import('util.Set');

class AdminRowController extends Controller{

	protected $uses = array('Section', 'PostMeta');
	
	private $colConfigStyle = array(
		'2' => array(
			array(2,10),
			array(6,6),
			array(4,8),
			array(10,2),
			array(8,4)
		),
		'3' => array(
			array(4,4,4),
			array(3,6,3),
			array(2,5,5),
			array(5,5,2)
		)
	);

	public function add_row_modal(){
		$this->isAjax = true;
		$fluidGrid = array(
			'1' => '12',
			'2' => '6',
			'3' => '4',
			'4' => '3'
		);
		$this->assign('grid', $fluidGrid);
	}
	
	public function add_row(){
		$this->isAjax = true;
		$this->assign('columns', $this->post['cols']);
		$this->assign('row_number', $this->post['rows']);
	}
	
	public function modify_row_modal(){
		$this->isAjax = true;
		$this->assign('colconfig', $this->colConfigStyle[$this->post['cols']]);
		$this->assign('columns', $this->post['cols']);
		$this->assign('bootstrap', $this->post['class']);
	}

	

}

?>
