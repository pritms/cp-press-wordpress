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
 * String
 *
 * @access public
 * @author Marco Trognoni, <mtrognoni@elitedivision.it>
 */
class String extends Object{

	
	private $pluralRules;
	private $pluralized;
	private $singularRules;
	private $singularized;

	private function getInstance(){
		static $instance = array();

		if (!isset($instance[0]) || !$instance[0]) {
			$instance[0] = new String();
		}

		return $instance[0];
	}
	
	/**
 	* Initializes plural inflection rules
 	*
 	* @author CakePhp
 	* @see <http://trac.cakephp.org>
 	* @access private
	*/
	private function initPluralRules() {
		$_this = String::getInstance();
		$corePluralRules = array(
			'/(s)tatus$/i' => '\1\2tatuses',
			'/(quiz)$/i' => '\1zes',
			'/^(ox)$/i' => '\1\2en',
			'/([m|l])ouse$/i' => '\1ice',
			'/(matr|vert|ind)(ix|ex)$/i'  => '\1ices',
			'/(x|ch|ss|sh)$/i' => '\1es',
			'/([^aeiouy]|qu)y$/i' => '\1ies',
			'/(hive)$/i' => '\1s',
			'/(?:([^f])fe|([lr])f)$/i' => '\1\2ves',
			'/sis$/i' => 'ses',
			'/([ti])um$/i' => '\1a',
			'/(p)erson$/i' => '\1eople',
			'/(m)an$/i' => '\1en',
			'/(c)hild$/i' => '\1hildren',
			'/(buffal|tomat)o$/i' => '\1\2oes',
			'/(alumn|bacill|cact|foc|fung|nucle|radi|stimul|syllab|termin|vir)us$/i' => '\1i',
			'/us$/' => 'uses',
			'/(alias)$/i' => '\1es',
			'/(ax|cri|test)is$/i' => '\1es',
			'/s$/' => 's',
			'/$/' => 's');

		$coreUninflectedPlural = array(
			'.*[nrlm]ese', '.*deer', '.*fish', '.*measles', '.*ois', '.*pox', '.*sheep', 'Amoyese',
			'bison', 'Borghese', 'bream', 'breeches', 'britches', 'buffalo', 'cantus', 'carp', 'chassis', 'clippers',
			'cod', 'coitus', 'Congoese', 'contretemps', 'corps', 'debris', 'diabetes', 'djinn', 'eland', 'elk',
			'equipment', 'Faroese', 'flounder', 'Foochowese', 'gallows', 'Genevese', 'Genoese', 'Gilbertese', 'graffiti',
			'headquarters', 'herpes', 'hijinks', 'Hottentotese', 'information', 'innings', 'jackanapes', 'Kiplingese',
			'Kongoese', 'Lucchese', 'mackerel', 'Maltese', 'media', 'mews', 'moose', 'mumps', 'Nankingese', 'news',
			'nexus', 'Niasese', 'Pekingese', 'People', 'Piedmontese', 'pincers', 'Pistoiese', 'pliers', 'Portuguese', 'proceedings',
			'rabies', 'rice', 'rhinoceros', 'salmon', 'Sarawakese', 'scissors', 'sea[- ]bass', 'series', 'Shavese', 'shears',
			'siemens', 'species', 'swine', 'testes', 'trousers', 'trout', 'tuna', 'Vermontese', 'Wenchowese',
			'whiting', 'wildebeest', 'Yengeese');

		$coreIrregularPlural = array(
			'atlas' => 'atlases',
			'beef' => 'beefs',
			'brother' => 'brothers',
			'child' => 'children',
			'corpus' => 'corpuses',
			'cow' => 'cows',
			'ganglion' => 'ganglions',
			'genie' => 'genies',
			'genus' => 'genera',
			'graffito' => 'graffiti',
			'hoof' => 'hoofs',
			'loaf' => 'loaves',
			'menu' => 'menues',
			'man' => 'men',
			'money' => 'monies',
			'mongoose' => 'mongooses',
			'move' => 'moves',
			'mythos' => 'mythoi',
			'numen' => 'numina',
			'occiput' => 'occiputs',
			'octopus' => 'octopuses',
			'opus' => 'opuses',
			'ox' => 'oxen',
			'penis' => 'penises',
			'person' => 'people',
			'sex' => 'sexes',
			'soliloquy' => 'soliloquies',
			'testis' => 'testes',
			'trilby' => 'trilbys',
			'turf' => 'turfs');

		$pluralRules = $corePluralRules;
		$uninflected = $coreUninflectedPlural;
		$irregular = $coreIrregularPlural;

		
		/** 
		 * TODO
		 * Load configurable ini file with plural rules
		 */
		/*if (file_exists(CONFIGS . 'inflections.php')) {
			include(CONFIGS.'inflections.php');
			$pluralRules = Set::pushDiff($pluralRules, $corePluralRules);
			$uninflected = Set::pushDiff($uninflectedPlural, $coreUninflectedPlural);
			$irregular = Set::pushDiff($irregularPlural, $coreIrregularPlural);
		}*/
		$_this->pluralRules = array('pluralRules' => $pluralRules, 'uninflected' => $uninflected, 'irregular' => $irregular);
		$_this->pluralized = array();
	}
	
	/**
	 * Return $word in plural form.
	 * @author CakePhp
 	 * @see <http://trac.cakephp.org>
	 * @param string $word Word in singular
	 * @return string Word in plural
	 * @access public
	 * @static
	 */
	public static function pluralize($word) {
		$_this = String::getInstance();
		if (!isset($_this->pluralRules) || empty($_this->pluralRules)) {
			$_this->initPluralRules();
		}

		if (isset($_this->pluralized[$word])) {
			return $_this->pluralized[$word];
		}
		
		
		extract($_this->pluralRules);
		if (!isset($regexUninflected) || !isset($regexIrregular)) {
			$regexUninflected = __enclose(join( '|', $uninflected));
			$regexIrregular = __enclose(join( '|', array_keys($irregular)));
			$_this->pluralRules['regexUninflected'] = $regexUninflected;
			$_this->pluralRules['regexIrregular'] = $regexIrregular;
		}

		if (preg_match('/(.*)\\b(' . $regexIrregular . ')$/i', $word, $regs)) {
			$_this->pluralized[$word] = $regs[1] . substr($word, 0, 1) . substr($irregular[strtolower($regs[2])], 1);
			return $_this->pluralized[$word];
		}

		if (preg_match('/^(' . $regexUninflected . ')$/i', $word, $regs)) {
			$_this->pluralized[$word] = $word;
			return $word;
		}

		foreach ($pluralRules as $rule => $replacement) {
			if (preg_match($rule, $word)) {
				$_this->pluralized[$word] = preg_replace($rule, $replacement, $word);
				return $_this->pluralized[$word];
			}
		}
		$_this->pluralized[$word] = $word;
		return $word;
	}
	
	
	/**
	 * Initializes singular inflection rules
	 * @author CakePhp
 	 * @see <http://trac.cakephp.org>
	 * @access private
	 */
	private function initSingularRules() {
		$_this = String::getInstance();
		$coreSingularRules = array(
			'/(s)tatuses$/i' => '\1\2tatus',
			'/(quiz)zes$/i' => '\\1',
			'/(matr)ices$/i' => '\1ix',
			'/(vert|ind)ices$/i' => '\1ex',
			'/^(ox)en/i' => '\1',
			'/(alias)(es)*$/i' => '\1',
			'/(alumn|bacill|cact|foc|fung|nucle|radi|stimul|syllab|termin|viri?)i$/i' => '\1us',
			'/(cris|ax|test)es$/i' => '\1is',
			'/(shoe)s$/i' => '\1',
			'/(o)es$/i' => '\1',
			'/ouses$/' => 'ouse',
			'/uses$/' => 'us',
			'/([m|l])ice$/i' => '\1ouse',
			'/(x|ch|ss|sh)es$/i' => '\1',
			'/(m)ovies$/i' => '\1\2ovie',
			'/(s)eries$/i' => '\1\2eries',
			'/([^aeiouy]|qu)ies$/i' => '\1y',
			'/([lr])ves$/i' => '\1f',
			'/(tive)s$/i' => '\1',
			'/(hive)s$/i' => '\1',
			'/(drive)s$/i' => '\1',
			'/([^f])ves$/i' => '\1fe',
			'/(^analy)ses$/i' => '\1sis',
			'/((a)naly|(b)a|(d)iagno|(p)arenthe|(p)rogno|(s)ynop|(t)he)ses$/i' => '\1\2sis',
			'/([ti])a$/i' => '\1um',
			'/(p)eople$/i' => '\1\2erson',
			'/(m)en$/i' => '\1an',
			'/(c)hildren$/i' => '\1\2hild',
			'/(n)ews$/i' => '\1\2ews',
			'/^(.*us)$/' => '\\1',
			'/s$/i' => '');

		$coreUninflectedSingular = array(
			'.*[nrlm]ese', '.*deer', '.*fish', '.*measles', '.*ois', '.*pox', '.*sheep', '.*ss', 'Amoyese',
			'bison', 'Borghese', 'bream', 'breeches', 'britches', 'buffalo', 'cantus', 'carp', 'chassis', 'clippers',
			'cod', 'coitus', 'Congoese', 'contretemps', 'corps', 'debris', 'diabetes', 'djinn', 'eland', 'elk',
			'equipment', 'Faroese', 'flounder', 'Foochowese', 'gallows', 'Genevese', 'Genoese', 'Gilbertese', 'graffiti',
			'headquarters', 'herpes', 'hijinks', 'Hottentotese', 'information', 'innings', 'jackanapes', 'Kiplingese',
			'Kongoese', 'Lucchese', 'mackerel', 'Maltese', 'media', 'mews', 'moose', 'mumps', 'Nankingese', 'news',
			'nexus', 'Niasese', 'Pekingese', 'Piedmontese', 'pincers', 'Pistoiese', 'pliers', 'Portuguese', 'proceedings',
			'rabies', 'rice', 'rhinoceros', 'salmon', 'Sarawakese', 'scissors', 'sea[- ]bass', 'series', 'Shavese', 'shears',
			'siemens', 'species', 'swine', 'testes', 'trousers', 'trout', 'tuna', 'Vermontese', 'Wenchowese',
			'whiting', 'wildebeest', 'Yengeese');

		$coreIrregularSingular = array(
			'atlases' => 'atlas',
			'beefs' => 'beef',
			'brothers' => 'brother',
			'children' => 'child',
			'corpuses' => 'corpus',
			'cows' => 'cow',
			'ganglions' => 'ganglion',
			'genies' => 'genie',
			'genera' => 'genus',
			'graffiti' => 'graffito',
			'hoofs' => 'hoof',
			'loaves' => 'loaf',
			'men' => 'man',
			'menues' => 'menu',
			'monies' => 'money',
			'mongooses' => 'mongoose',
			'moves' => 'move',
			'mythoi' => 'mythos',
			'numina' => 'numen',
			'occiputs' => 'occiput',
			'octopuses' => 'octopus',
			'opuses' => 'opus',
			'oxen' => 'ox',
			'penises' => 'penis',
			'people' => 'person',
			'sexes' => 'sex',
			'soliloquies' => 'soliloquy',
			'testes' => 'testis',
			'trilbys' => 'trilby',
			'turfs' => 'turf');

		$singularRules = $coreSingularRules;
		$uninflected = $coreUninflectedSingular;
		$irregular = $coreIrregularSingular;
		/** 
		 * TODO
		 * Load configurable ini file (the same of plural rules) with plural rules
		 */
		/*if (file_exists(CONFIGS . 'inflections.php')) {
			include(CONFIGS.'inflections.php');
			$singularRules = Set::pushDiff($singularRules, $coreSingularRules);
			$uninflected = Set::pushDiff($uninflectedSingular, $coreUninflectedSingular);
			$irregular = Set::pushDiff($irregularSingular, $coreIrregularSingular);
		}*/
		$_this->singularRules = array('singularRules' => $singularRules, 'uninflected' => $uninflected, 'irregular' => $irregular);
		$_this->singularized = array();
	}
	
	/**
	 * Return $word in singular form.
	 * 
	 * @author CakePhp
 	 * @see <http://trac.cakephp.org>
	 * @param string $word Word in plural
	 * @return string Word in singular
	 * @access public
	 * @static
	 */
	public static function singularize($word) {
		$_this = String::getInstance();
		if (!isset($_this->singularRules) || empty($_this->singularRules)) {
			$_this->initSingularRules();
		}

		if (isset($_this->singularized[$word])) {
			return $_this->singularized[$word];
		}

		extract($_this->singularRules);
		if (!isset($regexUninflected) || !isset($regexIrregular)) {
			$regexUninflected = __enclose(join( '|', $uninflected));
			$regexIrregular = __enclose(join( '|', array_keys($irregular)));
			$_this->singularRules['regexUninflected'] = $regexUninflected;
			$_this->singularRules['regexIrregular'] = $regexIrregular;
		}

		if (preg_match('/(.*)\\b(' . $regexIrregular . ')$/i', $word, $regs)) {
			$_this->singularized[$word] = $regs[1] . substr($word, 0, 1) . substr($irregular[strtolower($regs[2])], 1);
			return $_this->singularized[$word];
		}

		if (preg_match('/^(' . $regexUninflected . ')$/i', $word, $regs)) {
			$_this->singularized[$word] = $word;
			return $word;
		}

		foreach ($singularRules as $rule => $replacement) {
			if (preg_match($rule, $word)) {
				$_this->singularized[$word] = preg_replace($rule, $replacement, $word);
				return $_this->singularized[$word];
			}
		}
		$_this->singularized[$word] = $word;
		return $word;
	}


	/**
	 * Returns given a lower_case_and_underscored_word as a camelCased word.
	 *
	 * @param string $lower_case_and_underscored_word Word to camelize
	 * @return string Camelized word. likeThis.
	 */
	public static function camelize($lowerCaseAndUnderscoredWord) {
		$replace = str_replace(" ", "", ucwords(str_replace("_", " ", $lowerCaseAndUnderscoredWord)));
		return $replace;
	}

	/**
	 * Returns an underscore-syntaxed (like_this_dear_reader) version of the camel_cased_word.
	 *
	 * @param string $camelCasedWord Camel-cased word to be "underscorized"
	 * @return string Underscore-syntaxed version of the $camel_cased_word
	 */
	public static function underscore($camelCasedWord) {
		$replace = strtolower(preg_replace('/(?<=\\w)([A-Z])/', '_\\1', $camelCasedWord));
		return $replace;
	}
	
	/**
	 * Returns corresponding table name for given $class_name. ("posts" for the model class "Post").
	 *
	 * @param string $class_name Name of class to get database table name for
	 * @return string Name of the database table for given class
	 * @access public
	 * @static
	 */
	public static function getTblName($className) {
		$replace = String::pluralize(String::underscore($className));
		return $replace;
	}
	
	
	
	/**
	 * Returns model class name ("Post" for the database table "posts".) for given database table.
	 *
	 * @param string $tableName Name of database table to get class name for
	 * @return string
	 * @access public
	 * @static
	 */
	public static function getClassName($tableName) {
		$replace = String::camelize(String::singularize($tableName));
		return $replace;
	}


	public static function parseCamelCase($string){
		$split = preg_split("/(?<=[a-z]) (?=[A-Z])/x", $string);
		return implode(' ',$split);
	}

	public static function isCamelCase($string){
		return (bool)preg_match("/(?<=[a-z]) (?=[A-Z])/x", $string);
	}
	
	public static function getFldName($name){
		foreach(str_split($name) as $char){
			if(self::is_upper($char)){
				$str .= '_';
			}

			$str .= strtoupper($char);

		}
		return $str;
	}
	
	/**
	* Tokenizes a string using $separator, ignoring any instance of $separator that appears between
	* $leftBound and $rightBound
	*
	* @param string $data The data to tokenize
	* @param string $separator The token to split the data on.
	* @param string $leftBound The left boundary to ignore separators in.
	* @param string $rightBound The right boundary to ignore separators in.
	* @return mixed Array of tokens in $data or original input if empty.
	*/
	public static function tokenize($data, $separator = ',', $leftBound = '(', $rightBound = ')') {
		if (empty($data) || is_array($data)) {
			return $data;
		}

		$depth = 0;
		$offset = 0;
		$buffer = '';
		$results = array();
		$length = strlen($data);
		$open = false;

		while ($offset <= $length) {
			$tmpOffset = -1;
			$offsets = array(
				strpos($data, $separator, $offset),
				strpos($data, $leftBound, $offset),
				strpos($data, $rightBound, $offset)
			);
			for ($i = 0; $i < 3; $i++) {
				if ($offsets[$i] !== false && ($offsets[$i] < $tmpOffset || $tmpOffset == -1)) {
					$tmpOffset = $offsets[$i];
				}
			}
			if ($tmpOffset !== -1) {
				$buffer .= substr($data, $offset, ($tmpOffset - $offset));
				if (!$depth && $data{$tmpOffset} == $separator) {
					$results[] = $buffer;
					$buffer = '';
				} else {
					$buffer .= $data{$tmpOffset};
				}
				if ($leftBound != $rightBound) {
					if ($data{$tmpOffset} == $leftBound) {
						$depth++;
					}
					if ($data{$tmpOffset} == $rightBound) {
						$depth--;
					}
				} else {
					if ($data{$tmpOffset} == $leftBound) {
						if (!$open) {
							$depth++;
							$open = true;
						} else {
							$depth--;
						}
					}
				}
				$offset = ++$tmpOffset;
			} else {
				$results[] = $buffer . substr($data, $offset);
				$offset = $length + 1;
			}
		}
		if (empty($results) && !empty($buffer)) {
			$results[] = $buffer;
		}

		if (!empty($results)) {
			return array_map('trim', $results);
		}

		return array();
	}


	private static function is_upper($char){
		if(ereg(strtoupper($char), $char)){
			return true;
		}else{
			return false;
		}
	}

	private static function is_lower($char){
		if(ereg(strtolower($char), $char)){
			return true;
		}else{
			return false;
		}
	}
	
	
	
}

function __enclose($string) {
	return '(?:' . $string . ')';
}

?>