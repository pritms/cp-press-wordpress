<?php
/**
 * @package        WPChop.view
 * @subpackage View
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
 * View
 *
 * View defines the inerface to access MVC View and the Template engine System
 *
 * @access public
 * @author Marco Trognoni, <mtrognon@commonhelp.it>
 */

namespace CpPressOnePage;

final class View extends \Object{
	protected $assigned = array();
	protected $helpers = array();
	protected $ns;

	public function __construct($helpers=array(), $ns){
		$this->helpers = $helpers;
		$this->ns = $ns;
	}

	/**
	 * Render the given template name
	 *
	 * @access protected
	 * @author Marco Trognoni, <mtrognoni@elitedivision.it>
	 * @param string template's name
	 * @param bool force template engine to render a layout template
	 * @return string rendered template
	 */
	public function render($template, $child=false){
		if(!$child)
			$templateDir = get_template_directory();
		else{
			$templateDir = get_stylesheet_directory();
		}
		$templateFile = $templateDir.DS.'view'.DS.$template['folder'].DS.$template['file'].'.php';
		if(!file_exists($templateFile)){
			if(!isset($template['ns']))
				$framework = ABSPATH.PLUGINDIR.DS.CpOnePage::$namespaces[$this->ns];
			else
				$framework = ABSPATH.PLUGINDIR.DS.$template['ns'].DS.'framework';
			$templateFile = $framework.DS.'view'.DS.$template['folder'].DS.$template['file'].'.php';
			if(!file_exists($templateFile))
				dump($templateFile);
		}
		extract($this->assigned);
		ob_start();
		include $templateFile;
		$output = ob_get_clean();
		return $output;
	}

	/**
	 * Assign a value at the template engine
	 *
	 * @access protected
	 * @author Marco Trognoni, <mtrognoni@elitedivision.it>
	 * @param string name of assignment
	 * @param mixed the object to bind with $name in a template engine enviroment
	 * @param bool (Only for xslt template engine) select if the value object is an XML (dom compatible) to attach directly to the template engine's DOM tree
	*/
	public function assign($name, $value){
		$this->assigned[$name] = $value;
	}




}

?>
