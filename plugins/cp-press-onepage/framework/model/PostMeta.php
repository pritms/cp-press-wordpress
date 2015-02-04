<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace CpPressOnePage;
import('model.Model');
import('util.Set');
class PostMeta extends Model{
	
	
	public function read($args=array()){
		return $this->find($args);
	}
	
	public function find($args=array()){
		return get_post_meta($args[0], $args[1], true);
	}
	
	public function readAll($args=array()){
		return $this->findAll($args);
	}
	
	public function findAll($args=array()){
		$id = $args;
		if(is_array($args))
			$id = $args[0];
		$metas = get_post_meta($id);
		$toReturn = array();
		foreach($metas as $key => $meta){
			foreach($meta as $k => $v){
				if(is_serialized($v))
					$toReturn[$key] = unserialize($v);
				else
					$toReturn[$key] = $v;
			}
		}
		
		return $toReturn;
	}
	
	public function save($data){
		return false;
	}
	
	public function delete($data){
		return false;
	}
}
?>