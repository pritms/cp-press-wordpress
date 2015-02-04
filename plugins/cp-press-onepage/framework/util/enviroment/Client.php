<?
/**
 * @package		OndaPHP.Util
 * @subpackage	Enviroment
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
 * Client class
 *
 * Client class provides access to get HTTP request messages sended by the user agent
 *
 * @access public
 * @author Marco Trognoni, <mtrognoni@elitedivision.it>
 */

class Client extends Registry{

	public function __construct(){
		$this->register("HTTP", "HOST", $_SERVER['HTTP_HOST']);
		/* TODO
		Create a keener user agent handle approach. See joomla api browser.
		*/
		$this->register("HTTP", "USER_AGENT", $_SERVER['HTTP_USER_AGENT']);
		$this->register("HTTP", "ACCEPT", $_SERVER['HTTP_ACCEPT']);
		$this->register("HTTP", "ACCEPT_LANGUAGE", $_SERVER['HTTP_ACCEPT_LANGUAGE']);
		$this->register("HTTP", "ACCEPT_ENCODING", $_SERVER['HTTP_ACCEPT_ENCODING']);
		$this->register("HTTP", "STATUS", $_SERVER['REDIRECT_STATUS']);
		$this->register("HTTP", "REFERER", $_SERVER['HTTP_REFERER']);
		if(isset($_SERVER['HTTP_ACCEPT_CHARSET'])){
			$this->register("HTTP", "ACCEPT_CHARSET", $_SERVER['HTTP_ACCEPT_CHARSET']);
		}
		if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
			$this->register("HTTP", "X_REQUESTED_WITH", $_SERVER['HTTP_X_REQUESTED_WITH']);
		}else{
			$this->register("HTTP", "X_REQUESTED_WITH", null);
		}

	}

	/**
	* Retrives HTTP Host
	*
	* @return string host name
	*/
	public function getHost(){
		return $this->get("HTTP", "HOST");
	}


	/**
	 * Retrive if this request is an ajax calling
	 */
	public function isAjax(){
		if($this->get("HTTP", "X_REQUESTED_WITH") == 'XMLHttpRequest'){
			return true;
		}

		return false;
	}

	/**
	* Retrives HTTP User-Agent
	*
	* @return string user-agent name
	*/
	public function getUserAgent(){
		return $this->get("HTTP", "USER_AGENT");
	}

	/**
	* Retrives HTTP Accept
	*
	* @return array accept parameter
	*/
	public function getAccept(){
		$chunk = explode(",", $this->get("HTTP", "ACCEPT"));
		$accept = array();
		for($i=0; $i<count($chunk); $i++){
			$subChunk = explode(";q=", $chunk[$i]);
			$accept[$i]['value'] = $subChunk[0];
			if(count($subChunk) > 1){
				$accept[$i]['quality'] = $subChunk[1];
			}else{
				$accept[$i]['quality'] = 1;
			}
		}
		return $accept;
	}

	/**
	* Retrives HTTP Accept Language
	*
	* @return string first accept language
	*/
	public function getAcceptLanguage(){
		$chunk = explode(",", $this->get("HTTP", "ACCEPT_LANGUAGE"));
		return $chunk[0];
	}

	/**
	* Retrives HTTP Accept Encoding
	*
	* @return array all accepted encoding
	*/
	public function getAcceptEncoding(){
		return explode(",", $this->get("HTTP", "ACCEPT_ENCODING"));
	}

	/**
	* Retrives HTTP Accept Charset
	*
	* @return array all accepted charset
	*/
	public function getAcceptCharset(){
		$chunk = explode(",", $this->get("HTTP", "ACCEPT_CHARSET"));
		for($i=0; $i<count($chunk); $i++){
			$subChunk = explode(";q=", $chunk[$i]);
			if(count($subChunk) > 1){
				$chunk[$i] = $subChunk[0];
			}
		}

		return $chunk;
	}
	
	public function getStatus(){
		return $this->get("HTTP", "STATUS");
	}
	
	public function getReferer(){
		return $this->get("HTTP", "REFERER");
	}

	public static function getInstance(){
		if(self::$instance == null){
			return new Client();
		}

		return self::$instance;
	}

}
?>