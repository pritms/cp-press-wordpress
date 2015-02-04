<?php
/**
 * @package       WPChop.Controller
 * @subpackage Controller
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
 * Controller
 *
 * Controller defines the inerface to access MVC Controller
 *
 * @author Marco Trognoni, <mtrognon@commonhelp.it>
 */
namespace CpPressOnePage;
\import('util.enviroment.*');
import('view.View');
abstract class Controller extends \Object{

	protected $request;
	public $controller;
	public $ns;
	protected $args;
	protected $get;
	protected $post;
	protected $file;
	protected $autoRender = true;
	protected $action;
	protected $options;
	public $isAjax = false;
	protected $isChildView = false;
	protected $template = null;
	protected $tFolder = null; /* folder template */

	/* FILTERS */
	protected $afterFilters = array();
	protected $beforeFilters = array();

	/* VIEW */
	private $View = null;

	public function __construct(){
		$this->request = \HttpRequest::getInstance();
		list($this->ns, $this->controller) = $this->getControllerName();
		$this->args = $this->setArgs();
		$this->View = new View($this->helpers, $this->ns);
		$this->initModel();
	}

	protected function setArgs($args=array()){
		$this->args = $args;
		if(empty($args)){
			if($this->request->getPostArray()){
				$this->args['post'] = $this->request->getPostArray();
				$this->post = $this->args['post'];
			}
			if($this->request->getQueryStringArray()){
				$this->args['get'] = $this->request->getQueryStringArray();
				$this->get = $this->args['get'];
			}
			if($this->request->getFiles()){
				$this->args['files'] = $this->request->getFiles();
				$this->files = $this->args['files'];
			}
		}
	}

	public function setAction($action){
		$this->action = $action;
	}

	public function getAction(){
		return $this->action;
	}

	/**
	 * Render a template using the ApplicationView interface.
	 * It's facade method for ApplicationView with the exception of $new param.
	 *
	 * @access protected
	 * @param array it contains template info
	 * @param bool define if a new ApplicationView instance is needed
	 * @return string rendered template
	*/
	public function render($args = array()){
		$template = array();
		if(isset($args['ns']))
			$template['ns'] = $args['ns'];
		if(is_null($this->template)){
			if(isset($args['action'])){
				$action = $args['action'];
			}else{
				$action = $this->action;
			}
		}else{
			$action = $this->template;
		}
		if(is_null($this->tFolder)){
			if(isset($args['controller'])){
				$controller = \String::underscore($args['controller']);
			}else{
				$controller = \String::underscore($this->controller);
			}
		}else{
			$controller = $this->tFolder;
		}
		if($action){
				$template['folder'] = $controller;
				$template['file'] = \String::underscore($action);
		}else{
				$template['folder'] = \String::underscore($controller);
		}
		$output = $this->View->render($template, $this->isChildView);
		$this->isChildView = false;
		return $output;
	}

	/**
	 * Checks wheter controller auto rendering is enabled
	 *
	 * @access public
	 * @return bool
	 */
	public function isAutoRender(){
		return $this->autoRender;
	}

	/**
	 * Sets the value (default is true) for the auto rendering feature
	 *
	 * @access protected
	 * @params bool auto layouting value
	 */
	public function setAutoRender($bool){
		$this->autoRender = $bool;
	}

	/**
	 * Assign a value at the template engine using View interface
	 * facade method for View
	 *
	 * @access protected
	 * @see View
	 * @param string name of assignment
	 * @param mixed the object to bind with $name in a template engine enviroment
	*/
	protected function assign($name, $value, $bypass = false){
		/*if($bypass && in_array($name, $this->assigProtected)){
			throw new ApplicationControllerException('view variable '.$name.' is reserved');
		}*/
		$this->View->assign($name, $value);
	}

	/**
	 * Retrive the before filters chain
	 */
	public function getBeforeFilters(){
		return $this->beforeFilters;
	}

	/**
	 * Retrive the after filters chain
	 */
	public function getAfterFilters(){
		return $this->afterFilters;
	}

		/* MODEL INTEGRATION */
	/**
	* Load a model onFly this may increase performances on heavy model use
	*
	* @access public
	* @param string Model name
	*/
	public function loadModel($modelName){
		$this->_loadModel($modelName);
	}

	public function initModel(){
		/* instantiate model */
		if($this->uses === null || ($this->uses === array())){
			$modelClass = $perClass = ucfirst($this->controller);
			$this->_loadModel($modelClass, true);
		}
		if($this->uses){
			foreach($this->uses as $modelClass){
				$this->_loadModel($modelClass);
			}
		}
	}

	private function _loadModel($modelClass, $softly=false){
		$ns = '\\';
		if(preg_match("/(.*)\\\(.*)/", get_called_class(), $match)){
			$ns = $match[1];
		}
		$framework = ABSPATH.DS.PLUGINDIR.DS.CpOnePage::$namespaces[$ns];
		$modelFile = $framework.DS.'model'.DS.$modelClass.'.php';
		$modelClassNS = '\\'.$ns.'\\'.$modelClass;

		if(!$this->__load($modelFile)){
			$framework = ABSPATH.DS.PLUGINDIR.DS.CpOnePage::$namespaces['global'];
			$modelFile = $framework.DS.'model'.DS.$modelClass.'.php';
			$modelClassNS = '\\CpPressOnePage\\'.$modelClass;
			if(!$this->__load($modelFile)){
				if(!$softly)
					throw new \Exception('Connot include application model file: '.$modelFile);
				else
					return;
			}
		}
		if(class_exists($modelClassNS)){
			$this->appModels[] = $modelClass;
			$this->{$modelClass} = new $modelClassNS();
			$this->{$modelClass}->afterConstruct();
		}else{
			if(!$softly){
				throw new \Exception('Cannot get instance of application model: '.$modelClass);
			}else{
				return;
			}
		}
	}


	/* PRIVATE ACTION */
	private function getControllerName(){
		$match = array();
		preg_match("/(.*)\\\([a-z_]+)_controller/", \String::underscore(get_class($this)), $match);
		$controller = \String::camelize($match[2]);
		$ns = \String::camelize($match[1]);


		return array($ns, $controller);
	}
}

?>
