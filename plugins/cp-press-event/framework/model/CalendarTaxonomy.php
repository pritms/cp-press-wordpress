<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace CpPressEvent;
\import('model.Options');
class CalendarTaxonomy extends \CpPressOnePage\Options{
	
	public function __construct(){
		$this->group = 'calendar_taxonomy';
		$this->options = get_option($this->group);

		parent::__construct();
	}
	
	public function save($data){
		if($this->beforseSave(&$data)){
			foreach($data as $key => $value){
				$this->options = \Set::insert($this->options, $this->group.'.'.$key, $value);
			}
			delete_option($this->group);
			$toReturn = update_option($this->group, $this->options);
			return $this->afterSave($toReturn);
		}
		
		return false;
	}
	
	public function delete($data=array()){
		if($this->beforeDelete(&$data)){
			if(!empty($data)){
				$this->options = \Set::remove($this->options, $this->group.'.'.$path);
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