<?php
/**
 * @package		OndaPHP.Util
 *
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
 * Observable interface
 *
 * Observableinterface defines an interface to implements a generic Observable object
 *
 * @access public
 * @author Marco Trognoni, <mtrognoni@elitedivision.it>
 */
interface Observable{
	// --- OPERATIONS ---

	/**
	* Attach an {@link Observer} object to the Observable
	*
	* @access public
	* @param Observer the observed object
	*/
	public function attach(Observer $observable);

	/**
	* Dettach an {@link Observer} object from the Observable
	*
	* @access public
	* @param Observer the observed object
	*/
	public function detach(Observer $observable);

	/**
	* Notify all Observer object
	*
	* @access public
	*/
	public function notify();



}

?>