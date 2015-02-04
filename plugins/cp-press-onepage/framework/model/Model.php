<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace CpPressOnePage;
abstract class Model extends \Object{
	
	protected $data;
	
	public function __construct(){
	}
	
	
	public function afterConstruct(){
	}
	
	/** FILTER */
	public function beforeFind($args){
		return true;
	}
	
	public function afterFind($results){
		return $results;
	}
	
	public function beforseSave($data){
		return true;
	}
	
	public function afterSave($toReturn){
		return $toReturn;
	}
	
	public function beforeDelete($data){
		return true;
	}
	
	public function afterDelete($toReturn){
		return $toReturn;
	}
	
	/**
	 * find()
	 *
	 * @access public
	 * @return result set array
	*/
	abstract public function read($args=array());
	
	abstract public function find($args=array());
	
	abstract public function readAll($args=array());
	
	abstract public function findAll($args=array());
	
	abstract public function save($data);
	
	abstract public function delete($data);
}
?>