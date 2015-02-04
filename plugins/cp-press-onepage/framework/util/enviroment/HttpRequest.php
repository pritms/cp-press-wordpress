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
 * HttpRequest class
 *
 * HttpRequest provides access to get HTTP request messages
 *
 * @access public
 * @author Marco Trognoni, <mtrognoni@elitedivision.it>
 */

class HttpRequest extends Registry{

	private $type;
	private $client;

	public function __construct(){
		$this->type = $_SERVER['REQUEST_METHOD'];
		/* sent header handling */
		$this->client = new Client();

		/* TODO input filter */


		if(!empty($_GET)){
			$this->registerSub("GET", $_GET);
		}

		if(!empty($_POST)){
			$this->registerSub("POST", $_POST);
		}

		if(!empty($_COOKIE)){
			$this->registerSub("COOKIE", $_COOKIE);
		}

		if(!empty($_FILES)){
			$this->registerSub("FILES", $_FILES);
		}
	}

	/**
	* Retrives Client object
	*
	* @access public
	*
	* @see Client
	* @return Client Client object
	*/
	public function getClient(){
		return $this->client;
	}

	/**
	* Retrives the requested URI
	*
	* @access public
	*
	* @return string requested URI
	*/
	public function getURI(){
		return $this->uri;
	}

	/**
	* Retrives a QueryString value given a param name key
	*
	* Retrives the $_GET[$var] php globals parsed and sanitized
	*
	* @access public
	* @param string param name key
	* @return string requested param
	*/
	public function getQueryString($var){
		return $this->get("GET", $var);
	}

	/**
	* Retrives all the QueryString array values
	*
	* Retrives the $_GET php globals parsed and sanitized
	*
	* @access public
	* @return array QueryString array
	*/
	public function getQueryStringArray(){
		return $this->get("GET");
	}

	/**
	* Retrives a Post value given a param name key
	*
	* Retrives the $_POST[$var] php globals parsed and sanitized
	*
	* @access public
	* @param string param name key
	* @return string requested param
	*/
	public function getPost($var){
		return $this->get("POST", $var);
	}

	/**
	* Retrives all the Post array values
	*
	* Retrives the $_POST php globals parsed and sanitized
	*
	* @access public
	* @return array Post array
	*/
	public function getPostArray(){
		return $this->get("POST");
	}

	/**
	* Retrives a Cookie value given a param name key
	*
	* Retrives the $_COOKIE[$var] php globals parsed and sanitized
	*
	* @access public
	* @param string param name key
	* @return string requested param
	*/
	public function getCookie($var){
		return $this->get("COOKIE", $var);
	}

	/**
	* Retrives all the Cookies array values
	*
	* Retrives the $_COOKIE php globals parsed and sanitized
	*
	* @access public
	* @return array Cookie array
	*/
	public function getCookies(){
		return $this->get("COOKIE");
	}

	/**
	* Retrives a File value given a param name key
	*
	* Retrives the $_FILES[$var] php globals parsed and sanitized
	*
	* @access public
	* @param string param name key
	* @return string requested param
	*/
	public function getFiles(){
		return $this->get("FILES");
	}

	/**
	* Retrives HTTP REST operation
	*
	* @return string requested HTTP REST operation
	*/
	public function getType(){
		return $this->type;
	}

	public static function getInstance(){
		if(self::$instance == null){
			return new HttpRequest();
		}

		return self::$instance;
	}

}

?>