<?php
namespace CpPressOnePage;
class Filters{
	
	private $toFilters = array('home', 'navigation');
	
	public function __construct(){
		if(!is_admin()){
			add_filter('the_title', array($this, 'filter_title'), 8, 2);
			add_filter('the_content_more_link', array($this, 'filter_more_link'), 10, 2);
			add_filter('cp-section-filter', function($div, $span, $col, $post, $content){
				return $this->filter_section($div, $span, $col, $post, $content);
			}, 10, 5);
			add_filter('cp-columns', function($div, $span, $col, $post){
				return $div;
			}, 10, 4);
				
			add_filter('cp-content-section', function($content, $post){
				return $content;
			}, 10, 2);
			add_filter('cp-section-attributes', function($val, $post_name){
				return $this->attributes($val, $post_name);
			}, 10, 2);
			add_filter('cp-section-title-filter', function($val, $post_name, $title, $subtitle, $id){
				if(!in_array($post_name, $this->toFilters)){
					return $this->filter_title($title, $id, $subtitle);
				}
			}, 9, 5);
			add_filter('cp-div-section-close', function($val, $post_name){
				return $this->exclude($val, $post_name);
			}, 10, 2);
			add_filter('cp-div-section-open', function($val, $post_name){
				return $this->exclude($val, $post_name);
			}, 10, 2);
		}
	}
	
	public function attributes($val, $post_name){
		switch($post_name){
			case 'home':
				return $val.' ';
			case 'navigation':
				return $val.' ';
			default:
				return $val.' class="padding-80"';
		}
	}
	
	public function filter_section($div, $span, $col, $post, $content){
		if(!in_array($post->post_name, $this->toFilters)){
			$content = apply_filters('cp-columns', '<div class="col-lg-'.$span.'">', $span, $col, $post);
			$content .= apply_filters('cp-content-section', $content_section, $post);
		}
		
		return $content;
	}
	
	public function filter_title($title, $id, $subtitle=''){
		global $post;
		$type = get_post_type($id);
		if($type == 'section' && $title != ''){
			$ftitle = '<div class="container">';
			$ftitle .= '<div class="section-heading text-center">';
			if($subtitle != '')
				$ftitle .= '<h4 class="small section-title"><span>'.$subtitle.'</span></h4>';
			$ftitle .= '<h2 class="large section-title">'.$title.'</h2>';
			$ftitle .= '</div>';
			$ftitle .= '</div>';
			return $ftitle;
		}else if($type == 'nav_menu_item')
			return strtoupper($title);
		else
			return '<h3 class="title"><a href="'.get_the_permalink().'">'.$title.'</a></h3>';
	}
	
	public function filter_more_link($link){
		global $post;
		return '<a href="'.get_permalink().'" btn btn-lg btn-theme-color>leggi tutto</a>';
	}
	
	public function exclude($val, $post_name){
		if(in_array($post_name, $this->toFilters)){
			return '';
		}
		return $val;
	}
}
?>