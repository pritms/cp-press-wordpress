<?php
namespace CpPressOnePage;
class Filters{
	
	public function __construct(){
		if(!is_admin()){
			add_filter('the_title', array($this, 'filter_title'), 10, 2);
			add_filter('the_content_more_link', array($this, 'filter_more_link'), 10, 2);
		}
	}
	
	public function filter_title($title, $id){
		global $post;
		$type = get_post_type($id);
		if($type == 'section' && $title != '')
			return '<h2>'.$title.'</h2>';
		else if($type == 'nav_menu_item')
			return strtoupper($title);
		else
			return '<h3 class="title"><a href="'.get_the_permalink().'">'.$title.'</a></h3>';
	}
	
	public function filter_more_link($link){
		global $post;
		return '<div class="cp-button"><a href="'.get_permalink().'">leggi tutto</a></div>';
	}
}
?>