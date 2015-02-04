<?
/**
 * @package        OndaPHP.Util
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
 * Registry
 *
 * Registry class defines an interface to implement a Registry pattern which handle an instance of a global object list
 *
 * @access public
 * @author Marco Trognoni, <mtrognoni@elitedivision.it>
 */
abstract class Registry extends Object{

	protected $globals = array();

	protected static $instance = null;

	public function __construct(){
	}

	/**
	 * Register an object in the global object list
	 *
	 * @access public
	 * @param string sub registry key
	 * @param string main registry key
	 * @param mixed object to store
	*/
	public function register($sub, $label, $object){
		if(!isset($this->globals[$sub][$label])){
			$this->globals[$sub][$label] = $object;
		}
	}

	/**
	 * Register an object list in the global object list
	 *
	 * @access public
	 * @param string sub registry key
	 * @param mixed object to store
	*/
	public function registerSub($sub, $object){
		if(!isset($this->globals[$sub])){
			$this->globals[$sub] = $object;
		}
	}

	/**
	 * Unregister an object from the global object list
	 *
	 * @access public
	 * @param string sub registry key
	 * @param string main registry key
	*/
	public function unregister($sub, $label){
		if(isset($this->globals[$sub][$label])){
			unset($this->globals[$label]);
		}
	}

	/**
	 * Unregister an object list from the global object list
	 *
	 * @access public
	 * @param string sub registry key
	*/
	public function unregisterSub($sub){
		if(isset($this->globals[$sub])){
			unset($this->globals[$sub]);
		}
	}

	/**
	 * Get an object from the global object list
	 *
	 * @access public
	 * @param string sub registry key
	 * @param string main registry key
	 * @return mixed registered object
	*/
	public function get($sub, $label=''){
		if($label != ''){
			if(isset($this->globals[$sub][$label])){
				return $this->globals[$sub][$label];
			}
		}else{
			if(isset($this->globals[$sub])){
				return $this->globals[$sub];
			}
		}

		return null;
	}

	/**
	 * Check wheter a registered objet exists in the global object list
	 *
	 * @access public
	 * @param string sub registry key
	 * @param string main registry key
	*/
	public function has($sub, $label){
		if(isset($this->globals[$sub][$label])){
			return true;
		}

		return false;
	}

	/**
	 * Get the whole global object list
	 *
	 * @access public
	 * @return array global object list
	*/
	public function getGlobals(){
		return $this->globals;
	}

}
?>