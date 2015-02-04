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
 * Set
 *
 * @access public
 * @author Marco Trognoni, <mtrognoni@elitedivision.it>
 */
import('util.String');
class Set extends Object{
	
	/**
	 * Get a single value specified by $path out of $data.
	 * Does not support the full dot notation feature set,
	 * but is faster for simple read operations.
	 *
	 * @param array $data Array of data to operate on.
	 * @param string|array $path The path being searched for. Either a dot
	 *   separated string, or an array of path segments.
	 * @return mixed The value fetched from the array, or null.
	 * @link http://book.cakephp.org/2.0/en/core-utility-libraries/hash.html#Hash::get
	 */
	public static function get(array $data, $path) {
		if (empty($data)) {
			return null;
		}
		if (is_string($path) || is_numeric($path)) {
			$parts = explode('.', $path);
		} else {
			$parts = $path;
		}
		foreach ($parts as $key) {
			if (is_array($data) && isset($data[$key])) {
				$data =& $data[$key];
			} else {
				return null;
			}
		}
		return $data;
	}
	
	/**
	* Gets the values from an array matching the $path expression.
	* The path expression is a dot separated expression, that can contain a set
	* of patterns and expressions:
	*
	* - `{n}` Matches any numeric key, or integer.
	* - `{s}` Matches any string key.
	* - `Foo` Matches any key with the exact same value.
	*
	* There are a number of attribute operators:
	*
	*  - `=`, `!=` Equality.
	*  - `>`, `<`, `>=`, `<=` Value comparison.
	*  - `=/.../` Regular expression pattern match.
	*
	* Given a set of User array data, from a `$User->find('all')` call:
	*
	* - `1.User.name` Get the name of the user at index 1.
	* - `{n}.User.name` Get the name of every user in the set of users.
	* - `{n}.User[id]` Get the name of every user with an id key.
	* - `{n}.User[id>=2]` Get the name of every user with an id key greater than or equal to 2.
	* - `{n}.User[username=/^paul/]` Get User elements with username matching `^paul`.
	*
	* @param array $data The data to extract from.
	* @param string $path The path to extract.
	* @return array An array of the extracted values. Returns an empty array
	*   if there are no matches.
	* @link http://book.cakephp.org/2.0/en/core-utility-libraries/hash.html#Hash::extract
	*/
	public static function extract(array $data, $path) {
		if (empty($path)) {
			return $data;
		}

		// Simple paths.
		if (!preg_match('/[{\[]/', $path)) {
			return (array)self::get($data, $path);
		}

		if (strpos($path, '[') === false) {
			$tokens = explode('.', $path);
		} else {
			$tokens = String::tokenize($path, '.', '[', ']');
		}

		$_key = '__set_item__';

		$context = array($_key => array($data));

		foreach ($tokens as $token) {
			$next = array();

			$conditions = false;
			$position = strpos($token, '[');
			if ($position !== false) {
				$conditions = substr($token, $position);
				$token = substr($token, 0, $position);
			}

			foreach ($context[$_key] as $item) {
				foreach ((array)$item as $k => $v) {
					if (self::_matchToken($k, $token)) {
						$next[] = $v;
					}
				}
			}

			// Filter for attributes.
			if ($conditions) {
				$filter = array();
				foreach ($next as $item) {
					if (is_array($item) && self::_matches($item, $conditions)) {
						$filter[] = $item;
					}
				}
				$next = $filter;
			}
			$context = array($_key => $next);

		}
		return $context[$_key];
	}
	
	/**
	* Creates an associative array using `$keyPath` as the path to build its keys, and optionally
	* `$valuePath` as path to get the values. If `$valuePath` is not specified, all values will be initialized
	* to null (useful for Hash::merge). You can optionally group the values by what is obtained when
	* following the path specified in `$groupPath`.
	*
	* @param array $data Array from where to extract keys and values
	* @param string $keyPath A dot-separated string.
	* @param string $valuePath A dot-separated string.
	* @param string $groupPath A dot-separated string.
	* @return array Combined array
	* @link http://book.cakephp.org/2.0/en/core-utility-libraries/hash.html#Hash::combine
	* @throws CakeException CakeException When keys and values count is unequal.
	*/
	public static function combine(array $data, $keyPath, $valuePath = null, $groupPath = null) {
		if (empty($data)) {
			return array();
		}

		if (is_array($keyPath)) {
			$format = array_shift($keyPath);
			$keys = self::format($data, $keyPath, $format);
		} else {
			$keys = self::extract($data, $keyPath);
		}
		if (empty($keys)) {
			return array();
		}

		if (!empty($valuePath) && is_array($valuePath)) {
			$format = array_shift($valuePath);
			$vals = self::format($data, $valuePath, $format);
		} elseif (!empty($valuePath)) {
			$vals = self::extract($data, $valuePath);
		}
		if (empty($vals)) {
			$vals = array_fill(0, count($keys), null);
		}

		if (count($keys) !== count($vals)) {
			throw new \Exception(
				'Hash::combine() needs an equal number of keys + values.'
			);
		}

		if ($groupPath !== null) {
			$group = self::extract($data, $groupPath);
			if (!empty($group)) {
				$c = count($keys);
				for ($i = 0; $i < $c; $i++) {
					if (!isset($group[$i])) {
						$group[$i] = 0;
					}
					if (!isset($out[$group[$i]])) {
						$out[$group[$i]] = array();
					}
					$out[$group[$i]][$keys[$i]] = $vals[$i];
				}
				return $out;
			}
		}
		if (empty($vals)) {
			return array();
		}
		return array_combine($keys, $vals);
	}

	/**
	 * Checks to see if all the values in the array are numeric
	 *
	 * @param array $array The array to check.  If null, the value of the current Set object
	 * @return boolean true if values are numeric, false otherwise
	 * @access public
	 * @static
	 */
	public static function isNumeric($array = null) {
		if (empty($array)) {
			return null;
		}

		if ($array === range(0, count($array) - 1)) {
			return true;
		}

		$numeric = true;
		$keys = array_keys($array);
		$count = count($keys);

		for ($i = 0; $i < $count; $i++) {
			if (!is_numeric($array[$keys[$i]])) {
				$numeric = false;
				break;
			}
		}
		return $numeric;
	}

	
	
	/**
	 * Computes the difference between a Set and an array, two Sets, or two arrays
	 *
	 * @param mixed $val1 First value
	 * @param mixed $val2 Second value
	 * @return array Computed difference
	 * @access public
	 * @static
	 */
	public static function diff($val1, $val2 = null) {
		if (empty($val1)) {
			return (array)$val2;
		}
		if (empty($val2)) {
			return (array)$val1;
		}
		$out = array();

		foreach ($val1 as $key => $val) {
			$exists = array_key_exists($key, $val2);

			if ($exists && $val2[$key] != $val) {
				$out[$key] = $val;
			} elseif (!$exists) {
				$out[$key] = $val;
			}
			unset($val2[$key]);
		}

		foreach ($val2 as $key => $val) {
			if (!array_key_exists($key, $out)) {
				$out[$key] = $val;
			}
		}
		return $out;
	}
	
	/**
	 * Determines if two Sets or arrays are equal
	 *
	 * @param array $val1 First value
	 * @param array $val2 Second value
	 * @return boolean true if they are equal, false otherwise
	 * @access public
	 * @static
	 */
	public static function isEqual($val1, $val2 = null) {
		return ($val1 == $val2);
	}
	
	/**
	 * Determines if one Set or array contains the exact keys and values of another.
	 *
	 * @param array $val1 First value
	 * @param array $val2 Second value
	 * @return boolean true if $val1 contains $val2, false otherwise
	 * @access public
	 * @static
	 */
	public static function contains($val1, $val2 = null) {
		if (empty($val1) || empty($val2)) {
			return false;
		}

		foreach ($val2 as $key => $val) {
			if (is_numeric($key)) {
				Set::contains($val, $val1);
			} else {
				if (!isset($val1[$key]) || $val1[$key] != $val) {
					return false;
				}
			}
		}
		return true;
	}
	
	/**
	 * Counts the dimensions of an array. If $all is set to false (which is the default) it will
	 * only consider the dimension of the first element in the array.
	 *
	 * @param array $array Array to count dimensions on
	 * @param boolean $all Set to true to count the dimension considering all elements in array
	 * @param integer $count Start the dimension count at this number
	 * @return integer The number of dimensions in $array
	 * @access public
	 * @static
	 */
	public static function countDim($array = null, $all = false, $count = 0) {
		if ($all) {
			$depth = array($count);
			if (is_array($array) && reset($array) !== false) {
				foreach ($array as $value) {
					$depth[] = Set::countDim($value, true, $count + 1);
				}
			}
			$return = max($depth);
		} else {
			if (is_array(reset($array))) {
				$return = Set::countDim(reset($array)) + 1;
			} else {
				$return = 1;
			}
		}
		return $return;
	}
	
	/**
	 * Flattens an array for sorting
	 *
	 * @param array $results
	 * @param string $key
	 * @return array
	 * @access private
	 */
	private static function __flatten($results, $key = null) {
		$stack = array();
		foreach ($results as $k => $r) {
			$id = $k;
			if (!is_null($key)) {
				$id = $key;
			}
			if (is_array($r)) {
				$stack = array_merge($stack, Set::__flatten($r, $id));
			} else {
				$stack[] = array('id' => $id, 'value' => $r);
			}
		}
		return $stack;
	}
	
	
	public static function getKey($data, $key){
		if(array_key_exists($key, $data)){
			return $data[$key];
		}
		
		foreach($data as $k => $v){
			if(is_array($v) && array_key_exists($key)){
				return $v[$key];
			}else if(is_array($v[$k])){
				return self::getKey($v, $key);
			}
		}
		
		return null;
	}
	
	/**
	 * Pushes the differences in $array2 onto the end of $array
	 *
	 * @param mixed $array Original array
	 * @param mixed $array2 Differences to push
	 * @return array Combined array
	 * @access public
	 * @static
	 */
	public static function pushDiff($array, $array2) {
		if (empty($array) && !empty($array2)) {
			return $array2;
		}
		if (!empty($array) && !empty($array2)) {
			foreach ($array2 as $key => $value) {
				if (!array_key_exists($key, $array)) {
					$array[$key] = $value;
				} else {
					if (is_array($value)) {
						$array[$key] = Set::pushDiff($array[$key], $array2[$key]);
					}
				}
			}
		}
		return $array;
	}
	
	/**
	 * Maps the given value as an object. If $value is an object,
	 * it returns $value. Otherwise it maps $value as an object of
	 * type $class, and if primary assign _name_ $key on first array.
	 * If $value is not empty, it will be used to set properties of
	 * returned object (recursively). If $key is numeric will maintain array
	 * structure
	 *
	 * @param mixed $value Value to map
	 * @param string $class Class name
	 * @param boolean $primary whether to assign first array key as the _name_
	 * @return mixed Mapped object
	 * @access public
	 * @static
	 */
	public static function map($array, $primary = false) {
		$out = new stdClass;
		if (is_array($array)) {
			$keys = array_keys($array);
			foreach ($array as $key => $value) {
				if($keys[0] === $key) {
					$primary = true;
				}
				if (is_numeric($key)) {
					if (is_object($out)) {
						$out = get_object_vars($out);
					}
					$out[$key] = Set::map($value, true);
				} elseif ($primary === true && is_array($value)) {
					$out->_name_ = $key;
					$primary = false;
					foreach($value as $key2 => $value2) {
						$out->{$key2} = Set::map($value2, true);
					}
				} else {
					$out->{$key} = Set::map($value);
				}
			}
		} else {
			$out = $array;
		}
		return $out;
	}
	
	/**
	 * Remove the given keys from given set
	 *
	 * @param array $set The set to remove key
	 * @param array $toRemove a set of key to remove
	 * @return array The modified Set
	 * @access public
	 * @static
	 */
	public static function removeKey($set, $toRemove){
		$toReturn = $set;
		foreach($toRemove as $key => $val){
			if(isset($toReturn[$val])){
				unset($toReturn[$val]);
			}
		}
		
		return $toReturn;
	}
	
	/**
	 * Remove the given values from given set
	 *
	 * @param array $set The set to remove key
	 * @param string $toRemove a series of values to remove
	 * @return array The modified Set
	 * @access public
	 * @static
	 */
	public static function removeValue($set, $toRemove){
		$toReturn = $set;
		foreach($toRemove as $key => $val){
			$keySearched = array_search($val, $set);
			if($keySearched === false){
				continue;
			}
			
			unset($toReturn[$keySearched]);
		}
		
		return $toReturn;
	}
	
	/**
	* Insert $values into an array with the given $path. You can use
	* `{n}` and `{s}` elements to insert $data multiple times.
	*
	* @param array $data The data to insert into.
	* @param string $path The path to insert at.
	* @param array $values The values to insert.
	* @return array The data with $values inserted.
	* @link http://book.cakephp.org/2.0/en/core-utility-libraries/hash.html#Hash::insert
	*/
	   public static function insert(array $data, $path, $values = null) {
		   $tokens = explode('.', $path);
		   if (strpos($path, '{') === false) {
			   return self::_simpleOp('insert', $data, $tokens, $values);
		   }

		   $token = array_shift($tokens);
		   $nextPath = implode('.', $tokens);
		   foreach ($data as $k => $v) {
			   if (self::_matchToken($k, $token)) {
				   $data[$k] = self::insert($v, $nextPath, $values);
			   }
		   }
		   return $data;
	   }

	/**
	* Perform a simple insert/remove operation.
	*
	* @param string $op The operation to do.
	* @param array $data The data to operate on.
	* @param array $path The path to work on.
	* @param mixed $values The values to insert when doing inserts.
	* @return array $data.
	*/
	   protected static function _simpleOp($op, $data, $path, $values = null) {
		   $_list =& $data;

		   $count = count($path);
		   $last = $count - 1;
		   foreach ($path as $i => $key) {
			   if (is_numeric($key) && intval($key) > 0 || $key === '0') {
				   $key = intval($key);
			   }
			   if ($op === 'insert') {
				   if ($i === $last) {
					   $_list[$key] = $values;
					   return $data;
				   }
				   if (!isset($_list[$key])) {
					   $_list[$key] = array();
				   }
				   $_list =& $_list[$key];
				   if (!is_array($_list)) {
					   $_list = array();
				   }
			   } elseif ($op === 'remove') {
				   if ($i === $last) {
					   unset($_list[$key]);
					   return $data;
				   }
				   if (!isset($_list[$key])) {
					   return $data;
				   }
				   $_list =& $_list[$key];
			   }
		   }
	   }

	/**
	* Remove data matching $path from the $data array.
	* You can use `{n}` and `{s}` to remove multiple elements
	* from $data.
	*
	* @param array $data The data to operate on
	* @param string $path A path expression to use to remove.
	* @return array The modified array.
	* @link http://book.cakephp.org/2.0/en/core-utility-libraries/hash.html#Hash::remove
	*/
	   public static function remove(array $data, $path) {
		   $tokens = explode('.', $path);
		   if (strpos($path, '{') === false) {
			   return self::_simpleOp('remove', $data, $tokens);
		   }

		   $token = array_shift($tokens);
		   $nextPath = implode('.', $tokens);
		   foreach ($data as $k => $v) {
			   $match = self::_matchToken($k, $token);
			   if ($match && is_array($v)) {
				   $data[$k] = self::remove($v, $nextPath);
			   } elseif ($match) {
				   unset($data[$k]);
			   }
		   }
		   return $data;
	   }
	   
	   /**
		* Check a key against a token.
		*
		* @param string $key The key in the array being searched.
		* @param string $token The token being matched.
		* @return boolean
		*/
		   protected static function _matchToken($key, $token) {
			   if ($token === '{n}') {
				   return is_numeric($key);
			   }
			   if ($token === '{s}') {
				   return is_string($key);
			   }
			   if (is_numeric($token)) {
				   return ($key == $token);
			   }
			   return ($key === $token);
		   }


	
}
?>