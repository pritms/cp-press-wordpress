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
 * HttpResponse class
 *
 * HttpResponse provides access to send HTTP response messages
 *
 * @access public
 * @author Marco Trognoni, <mtrognoni@elitedivision.it>
 */
class HttpResponse extends Object{

	private static $instance;

	private static $headers = array();
	private static $outputBuffer = false;
	private static $htmlOutput = true;
	private static $jsonOutput = false;
	private $content;


	public function __construct($content){
		$this->content = $content;
	}

	public static function getInstance($content){
		if(self::$instance == null){
			self::$instance = new HttpResponse($content);
		}

		return self::$instance;
	}

	/**
	 * Get the flow content output
	 */
	public function getContent(){
		return $this->content;
	}

	/**
	 * Set a new flow content output
	 */
	public function setContent($content){
		$this->content = $content;
	}

	/**
	* Redefine ob_start php function
	*
	* @access public
	* @static
	* @see http://www.php.net/manual/en/function.ob-start.php
	* @param string An optional output_callback function may be specified. This function takes a string as a parameter and should return a string
	*/
	public static function obStart($callback=''){
		self::$outputBuffer = true;
		if($callback){
			ob_start($callback);
		}else{
			ob_start();
		}
	}

	/**
	* Redefine ob_flush php function
	*
	* @access public
	* @static
	* @see http://www.php.net/manual/en/function.ob-flush.php
	* @see http://www.php.net/manual/en/function.ob-end-flush.php
	* @param bool (Optional) when setted to true flush (send) the output buffer and turn off output buffering
	*/
	public static function obFlush($clean=false){
		if($clean){
			self::$outputBuffer = false;
			ob_end_flush();
		}else{
			ob_flush();
		}
	}

	/**
	* Redefine ob_clean php function
	*
	* @access public
	* @static
	* @see http://www.php.net/manual/en/function.ob-clean.php
	* @see http://www.php.net/manual/en/function.ob-end-clean.php
	* @param bool (Optional) when setted to true clean (erase) the output buffer and turn off output buffering
	*/
	public static function obClean($end=false){
		if($end){
			self::$outputBuffer = false;
			ob_end_clean();
		}else{
			ob_clean();
		}
	}

	/**
	* Redefine ob_get_contents php function
	*
	* @access public
	* @static
	* @see http://www.php.net/manual/en/function.ob-get-contents.php
	*/
	public static function obGetContents(){
		return ob_get_contents();
	}

	/**
	* Redefine ob_get_length php function
	*
	* @access public
	* @static
	* @see http://www.php.net/manual/en/function.ob-get-length.php
	*/
	public static function obGetLength(){
		return ob_get_length();
	}

	/**
	* Set the HTTP reponse header to be send
	*
	* @access public
	* @static
	* @param string response header name
	* @param string response header value
	* @param bool replace an old setted header
	*/
	public static function setHeader($name, $value, $replace=false){
		/* cast $name and $value val to prevent error during headers sending */
		$name = (string) $name;
		$value = (string) $value;

		if($replace){
			foreach(self::$headers as $key => $header){
				if($name == $header['name']){
					unset(self::$headers[$key]);
				}
			}
		}

		self::$headers[] = array(
			'name'  => $name,
			'value' => $value
		);
	}

	/**
	* It force to not send the default (text/html) Content-Type header.
	*
	* @access public
	* @static
	*/
	public static function setNoTextOutput(){
		self::$htmlOutput = false;
		self::$jsonOutput = false;
	}

	/**
	* It force to send the default (text/plain) Content-Type header to handle a Json output.
	*
	* @access public
	* @static
	*/
	public static function setJsonOutput(){
		self::$htmlOutput = false;
		self::$jsonOutput = true;
	}

	public static function sendHeaders(){
		if(!headers_sent()){
			foreach(self::$headers as $header){
				header($header['name'].': '.$header['value']);
			}
		}
	}


	/**
	* Flush out all the HTTP reponse buffer stream
	*
	* @access public
	* @static
	* @throws HttpResponseException
	*/
	public function render(){
		if(self::$htmlOutput){
			/* TODO framework charset handling */
			self::setHeader('Content-Type', 'text/html; charset=UTF-8', true);
		}else if(self::$jsonOutput){
			self::setHeader('Content-Type', 'text/plain', true);
		}
		self::sendHeaders();
		if(self::$outputBuffer){
			self::obFlush(true);
			exit();
		}else{
			echo $this->content;
			exit();
		}
	}



}

?>
