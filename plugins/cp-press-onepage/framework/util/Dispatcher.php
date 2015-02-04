<?
/**
 * @package		Es2Mvc
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
 *
 * @access public
 * @author Marco Trognoni, <mtrognon@commonhelp.it>
 */
class Dispatcher extends Object{

	
	public function dispatch($app, $action, $params, $return, $scope){
		$import = $scope.'\import';
		$app = ucfirst($app);
		$import('controller.'.$app.'Controller');
		$class = '\\'.$scope.'\\'.$app.'Controller';
		$controller = new $class();
		$controller->setAction($action);
		return $this->start($controller, $action, $params, $return);
	}

	private function start($controller, $action, $params, $return){
		$this->runBeforeFilters($controller, $action);
		$response = call_user_func_array(array($controller, $action), $params);
		if($controller->isAutoRender()){
			$response = $controller->render();
		}
		if($return){
			return $response;
		}
		wp_reset_postdata();
		
		$this->runAfterFilters($controller, $action);
		if($controller->isAjax){
				$response = array(
				'what'		=> $controller->controller,
				'action'	=> $action,
				'data'		=> $response	
			);
		
			echo json_encode($response);
			exit;
		}
		echo $response;
		return null;
	}

	public function runBeforeFilters($controller, $action, $bypass=false){
		foreach($controller->getBeforeFilters() as $beforeFilter){
			$filter = $beforeFilter['callback'];
			if(isset($beforeFilter['only']) && !in_array($action, $beforeFilter['only'])){
				break;
			}
			if(isset($beforeFilter['except']) && in_array($action, $beforeFilter['except'])){
				break;
			}
			if($bypass){
				if(!$controller->$filter()){
					return false;
				}
			}else{
				$controller->$filter();
			}
		}

		return true;
	}

	public function runAfterFilters($controller, $action){
		$type = 'after_filters';
		foreach($controller->getAfterFilters() as $afterFilter){
			if(isset($afterFilter['only']) && !in_array($action, $afterFilter['only'])){
				break;
			}
			if(isset($afterFilter['except']) && in_array($action, $afterFilter['except'])){
				break;
			}
			$filter = $afterFilter['callback'];
			$controller->$filter();
		}
	}
}

?>