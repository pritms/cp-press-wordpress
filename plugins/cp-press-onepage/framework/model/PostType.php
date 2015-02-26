<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace CpPressOnePage;
import('model.Model');
class PostType extends Model{

	public function read($args = array()){
		$this->readAll($args);
		if(isset($this->data) && !empty($this->data)){
			if(is_array($this->data)){
				list($toReturn) = array_values($this->data);
				return $toReturn;
			}else{
				return $this->data;
			}
		}

		return array();
	}

	public function find($args=array()){
		return $this->read($args);
	}

	public function readAll($args=array()){
		if($this->beforeFind($args)){
			if(!isset($args['post_type']))
				$args['post_type'] = strtolower($this->getPostType());
			if(!isset($args['posts_per_page']))
				$args['posts_per_page'] = -1;
			$this->data = new \WP_Query($args);
			$ret = $this->afterFind($this->data);
			if($ret !== true){
				$this->data = $ret;
			}
			return $this->data;
		}else{
			return array();
		}
	}

	public function findAll($args=array()){
		return $this->readAll($args);
	}

	public function count($perm='all'){
		if($perm == 'all')
			return wp_count_posts(strtolower(get_called_class()));
		else{
			$count = wp_count_posts(strtolower(get_called_class()));
			return $count->{$perm};
		}
	}

	public function save($data){
		return false;
	}

	public function delete($data){
		return false;
	}

	private function getPostType(){
		preg_match("/(.*)\\\([a-z_]+)/", \String::underscore(get_class($this)), $match);
		return $match[2];
	}
}
?>
