<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace CpPressOnePage;
import('model.Model');
import('util.Set');
abstract class Options extends Model{

	protected $options=array();
	protected $group;

	public function __construct() {
		if($this->options == '')
			$this->options = array();
	}

	public function read($args=array()){
		return $this->find($args);
	}

	public function find($args=''){
		$toFind = array();
		if($args != ''){
			$toFind[] = $args;
		}
		$finded = $this->findAll($toFind);
		if(is_null($finded))
			return null;
		return array_pop($finded);
	}

	public function readAll($args=array()){
		return $this->findAll($args);
	}

	public function findAll($args=array()){
		if(empty($args))
			return $this->options;
		if(empty($this->options))
			return null;
		if(isset($this->options[$this->group])){
			$finded = array_intersect_key($this->options[$this->group], array_flip($args));
		}else
			$finded = array_intersect_key($this->options, array_flip($args));
		if(empty($finded))
			return null;

		return $finded;
	}

	public function save($data){
		if($this->beforseSave($data)){
			foreach($data as $key => $values){
				foreach($values as $subKey => $value)
					$this->options = \Set::insert($this->options, $this->group.'.'.$key.'.'.$subKey, $value);
			}
			delete_option($this->group);
			$toReturn = update_option($this->group, $this->options);
			return $this->afterSave($toReturn);
		}

		return false;
	}

	public function delete($data=array()){
		if($this->beforeDelete($data)){
			if(!empty($data)){
				foreach($data as $path){
					$this->options = \Set::remove($this->options, $this->group.'.'.$path);
				}
				if(empty($this->options[$this->group]))
					$this->options = array();
				$toReturn = delete_option($this->group);
				update_option($this->group, $this->options);
			}else{
				$toReturn = delete_option($this->group);
				$this->options = array();
			}
			return $this->afterDelete($toReturn);
		}

		return false;
	}
}
?>
