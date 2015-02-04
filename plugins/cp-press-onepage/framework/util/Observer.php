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
 * Observer interface
 *
 * Observer interface defines an interface to implements a generic Observer object
 *
 * @access public
 * @author Marco Trognoni, <mtrognoni@elitedivision.it>
 */
interface Observer{
	// --- OPERATIONS ---

	/**
	* Update the {@link Observable} after its notify
	*
	* @access public
	* @param Observable
	*/
	public function update(Observable $obs);

}

?>