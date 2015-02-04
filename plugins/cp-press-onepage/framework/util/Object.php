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
 * Object
 *
 * Object is the base class for all OndaPHP's framework classes
 *
 * @abstract
 * @access public
 * @author Marco Trognoni, <mtrognoni@elitedivision.it>
 */
abstract class Object implements Observable{
	// --- ATTRIBUTES ---

	/**
	* Log levels.
	*/
	const DEBUG=0x01;
	const INFO=0x02;
	const NOTICE=0x04;
	const WARNING=0x08;
	const ERROR=0x10;
	const ALERT=0x20;
	const FATAL=0x40;

	protected $observers;

	private $state = "";

	protected $logger;
	
	public static $sqlStack = array();


	/**
	*
	* @access protected
	* @var array['msg', 'level']
	* level:
	* DEBUG
	* INFO
	* NOTICE
	* WARNING
	* ERROR
	* ALERT
	* FATAL
	* use bitwise or (|) operator to append more than one level
	*/
	private $log;

	// --- OPERATIONS ---

	public function __construct(){
		$this->observers = array();
		$this->log = array();
	}

	/**
	* Attach an observer to this observable object
	*
	* @access protected
	* @param Observer observer to attach
	*/
	public function attach(Observer $obs){
		$this->observers[] = $obs;
	}

	/**
	*
	* Dettach an observer to this observable object
	*
	* @access protected
	* @author Marco Trognoni, <mtrognoni@elitedivision.it>
	* @param Observer observer to detach
	*/
	public function detach(Observer $obs){
		/* TODO find a valid algorithm to implement it */
		trigger_error("function not implemented yet");
	}

	/**
	* Notify all the observer attached to object
	*
	* @access public
	* @param stm optional object state string
	*/
	public function notify($stm = null){
		if($stm){
			$this->setState($stm);
		}
		$this->updateObservers();
	}


	/**
	* Get the object statement string
	*
	* @access public
	* @return string object state
	*/
	public function getState(){
		return $this->state;
	}

	/**
	* Set the object statement string
	*
	* @access public
	* @author Marco Trognoni, <mtrognoni@elitedivision.it>
	* @param string object state
	*/
	protected function setState($stm){
		$this->state = $stm;
	}

	/**
	* Get the notified log message
	*
	* @access public
	* @return string log message
	*/
	public function getLog(){
		return $this->log;
	}

	/**
	* Set the log message to notify
	*
	* @access public
	* @param string log message
	*/
	protected function setLog($log){
		$this->log = $log;
	}

	protected function __load($file){
		if(file_exists($file)){
			require_once($file);
			return true;
		}
		return false;
	}
	 

	/**
	 * Stop execution of the current script
	 *
	 * @param $status see http://php.net/exit for values
	 * @return void
	 * @access public
	 */
	protected function stopScript($status = 0) {
		exit($status);
	}


	private function updateObservers(){
		if(!empty($this->observers)){
			foreach($this->observers as $observer){
				$observer->update($this);
			}
		}
	}

}

?>