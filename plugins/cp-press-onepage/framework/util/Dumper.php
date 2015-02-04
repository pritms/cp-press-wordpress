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
 * Dumper class.
 *
 * Dumper is intended to replace the buggy PHP function var_dump and print_r.
 * It can correctly identify the recursively referenced objects in a complex
 * object structure. It also has a recursive depth control to avoid indefinite
 * recursive display of some peculiar variables.
 *
 * Dumper can be used as follows,
 * <code>
 *   echo Dumper::dump($var);
 * </code>
 *
 * @author Thanks to PRADO framework <http://www.pradosoft.com>
 * @author Marco Trognoni, <mtrognoni@elitedivision.it>
 */
class Dumper{
	private static $_objects;
	private static $_output;
	private static $_depth;

	/**
	* Converts a variable into a string representation.
	* This method achieves the similar functionality as var_dump and print_r
	* but is more robust when handling complex objects such as PRADO controls.
	* @param mixed variable to be dumped
	* @param integer maximum depth that the dumper should go into the variable. Defaults to 10.
	* @return string the string representation of the variable
	*/
	public static function dump($var,$depth=10,$highlight=false){
		self::$_output='';
		self::$_objects=array();
		self::$_depth=$depth;
		self::dumpInternal($var,0);
		if($highlight){
			$result=highlight_string("<?php\n".self::$_output,true);
			return preg_replace('/&lt;\\?php<br \\/>/','',$result,1);
		}else{
			return self::$_output;
		}
	}

	private static function dumpInternal($var,$level){
		switch(gettype($var)){
			case 'boolean':
				self::$_output.=$var?'true':'false';
				break;
			case 'integer':
				self::$_output.="$var";
				break;
			case 'double':
				self::$_output.="$var";
				break;
			case 'string':
				self::$_output.="'$var'";
				break;
			case 'resource':
				self::$_output.='{resource}';
				break;
			case 'NULL':
				self::$_output.="null";
				break;
			case 'unknown type':
				self::$_output.='{unknown}';
				break;
			case 'array':
				if(self::$_depth<=$level){
					self::$_output.='array(...)';
				}else if(empty($var)){
					self::$_output.='array()';
				}else{
					$keys=array_keys($var);
					$spaces=str_repeat(' ',$level*4);
					self::$_output.="array\n".$spaces.'(';
					foreach($keys as $key){
						self::$_output.="\n".$spaces."    [$key] => ";
						self::$_output.=self::dumpInternal($var[$key],$level+1);
					}
					self::$_output.="\n".$spaces.')';
				}
				break;
			case 'object':
				if(($id=array_search($var,self::$_objects,true))!==false){
					self::$_output.=get_class($var).'#'.($id+1).'(...)';
				}else if(self::$_depth<=$level){
					self::$_output.=get_class($var).'(...)';
				}else{
					$id=array_push(self::$_objects,$var);
					$className=get_class($var);
					$members=(array)$var;
					$keys=array_keys($members);
					$spaces=str_repeat(' ',$level*4);
					self::$_output.="$className#$id\n".$spaces.'(';
					foreach($keys as $key){
						$keyDisplay=strtr(trim($key),array("\0"=>':'));
						self::$_output.="\n".$spaces."    [$keyDisplay] => ";
						self::$_output.=self::dumpInternal($members[$key],$level+1);
					}
					self::$_output.="\n".$spaces.')';
				}
				break;
		}
	}
}

?>