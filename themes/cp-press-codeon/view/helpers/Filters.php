<?php
namespace CpPressOnePage;
class Filters{
	
	private $toFilters = array('home', 'navigation', 'map');
	private $toFiltersTitle = array('home', 'navigation', 'footer', 'map', 'contact-info');
	
	public function __construct(){
		if(!is_admin()){
			add_filter('the_title', array($this, 'filter_title'), 8, 2);
			add_filter('the_content_more_link', array($this, 'filter_more_link'), 10, 2);
			add_filter('cp-col-open', function($div, $post_name){
				return $this->exclude($div, $post_name);
			}, 10, 2);
			add_filter('cp-col-close', function($div, $post_name){
				return $this->exclude($div, $post_name);
			}, 10, 2);
			add_filter('cp-section-attributes', function($val, $post_name){
				return $this->attributes($val, $post_name);
			}, 10, 2);
			add_filter('cp-section-title', function($val, $post_name, $title, $subtitle, $id){
				if(!in_array($post_name, $this->toFiltersTitle)){
					return $this->filter_title($title, $id, $subtitle);
				}
			}, 9, 5);
			add_filter('cp-row-close', function($val, $post_name){
				return $this->exclude($val, $post_name);
			}, 10, 2);
			add_filter('cp-row-open', function($val, $post_name){
				return $this->exclude($val, $post_name);
			}, 10, 2);
			add_filter('cp-container-close', function($val, $post_name){
				return $this->exclude($val, $post_name);
			}, 10, 2);
			add_filter('cp-container-open', function($val, $post_name){
				return $this->filterContainer($val, $post_name);
			}, 10, 2);
			add_filter('cp-textbox-title', function($title, $containerClass, $section){
				if($section == 'servizi'){
					if(preg_match("/services-info/", $containerClass)){
						return $this->changeHTag($title, 3);
					}
				}
				
				return $title;
			}, 10, 3);
			add_filter('cp-textbox-containerclass', function($class, $section, $hasIcon){
				if($section == 'servizi'){
					return $this->addClass($class, 'row margin-btm-20');
				}
				
				return $class;
			}, 10, 3);
			add_filter('cp-textbox-textclass', function($class, $section, $hasIcon){
				if($section == 'servizi'){
					if($hasIcon){
						if(is_smartphone()){
							return $this->addClass($class, 'col-xs-9');
						}else{
							return $this->addClass($class, 'col-md-10');
						}
					}else{
						return $this->addClass($class, 'col-md-12');
					}
				}
				
				return $class;
			}, 10, 3);
			add_filter('cp-textbox-iconclass', function($class, $section, $hasIcon){
				if($section == 'servizi'){
					if(is_smartphone()){
						return $this->addClass($class, 'col-xs-3');
					}else{
						return $this->addClass($class, 'col-md-2');
					}
				}
			
				return $class;
			}, 10, 3);
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
	
	public function filter_col($div, $span, $col, $post, $content){
		if(!in_array($post->post_name, $this->toFilters)){
			$content = '<div class="col-md-'.$span.'">';
			$content .= apply_filters('cp-content-section', $content, $post);
			$content .= '</div>';
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
	
	public function filterContainer($val, $post_name){
		$val = $this->exclude($val, $post_name);
		if($val != ''){
			if($post_name == 'contact-info'){
				$val = $this->addClass($val, 'text-center');
			}
		}
		
		return $val;
	}
	
	public function exclude($val, $post_name){
		if(in_array($post_name, $this->toFilters)){
			return '';
		}
		return $val;
	}
	
	
	
	public function changeHTag($title, $hnum){
		return preg_replace("/(<h[0-6]>)(.*)(<\/h[0-6]>)/", "<h".$hnum.">$2</h".$hnum.">", $title);
	}
	
	public function addClass($class, $classes){
		return preg_replace("/(class=\"[a-zA-Z0-9\-\s]*)(\")/", "$1 ".$classes."$2", $class);
	}
}
?>