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
namespace CpPressPortfolio;
class AdminPortfolioController extends \CpPressOnePage\Controller{

	protected $uses = array('Portfolio', 'PortfolioSettings', 'Section', 'PostMeta', 'PostType', 'Post');

	private $portfolioOptions = array('title', 'thumb', 'item_per_row', 'show_link');

	private $fluidGrid = array(
		'1' => '12',
		'2' => '6',
		'3' => '4',
		'4' => '3',
		'6' => '2'
	);

	public function create($post, $box){
		$items = $this->PostMeta->find(array($post->ID, 'cp-press-portfolio'));
		$content = '';
		if(!empty($items)){
			foreach($items as $key => $item){
				if(!in_array($key, $this->portfolioOptions) && is_numeric($key)){
					$enable_link = isset($item['enable_link']) ? true : false;
					$content .= CpPortfolio::dispatch_template('AdminPortfolio', 'add_item', array($item['id'], $item['type'], $enable_link));
				}
			}
		}
		$this->assign('title', isset($items['title']) ? $items['title'] : '');
		$this->assign('thumb', isset($items['thumb']) ? $items['thumb'] : '');
		$this->assign('show_link', isset($items['show_link']) ? $items['show_link'] : false);
		$this->assign('item_per_row', isset($items['item_per_row']) ? $items['item_per_row'] : '3');
		$this->assign('portfolio_body', $content);
		$this->assign('portfolio_id', $post->ID);
	}

	public function add_item($item='', $type='', $enable_link=true){
		if(!$item){
			$this->isAjax = true;
			$args = array(
				'p'			=> $this->post['item_id'],
				'post_type'	=> $this->post['post_type']
			);
			$item_id = $this->post['item_id'];
			$item_type = $this->post['post_type'];
		}else{
			$this->isAjax = false;
			$args = array(
				'p'			=> $item,
				'post_type'	=> $type
			);
			$item_id = $item;
			$item_type = $type;
		}
		$post = $this->PostType->find($args)->posts[0];
		$thumb_id = get_post_thumbnail_id($post->ID);
		$item_img_thumb = wp_get_attachment_image_src($thumb_id, array('150', '150'));
		$item_img_full = wp_get_attachment_image_src($thumb_id, 'full');
		$this->assign('item_img_thumb', $item_img_thumb);
		$this->assign('item_img_full', $item_img_full);
		$this->assign('item_id', $item_id);
		$this->assign('item_type', $item_type);
		$this->assign('item_enable_link', $enable_link);
		$this->assign('item_link', get_permalink($post->ID));
		$this->assign('item_title', $post->post_title);
		$this->assign('item_content', $post->post_excerpt);
	}

	public function add_item_modal(){
		$this->isAjax = true;
		$settings = \Set::extract($this->PortfolioSettings->findAll(), 'chpress_portfolio_settings.exclude');
		$validPostTypes = array_diff(get_post_types(), get_post_types(array('_builtin' => true)), array('portfolio'), $settings);
		$validPostTypesObj = array();
		foreach($validPostTypes as $key => $postType){
			$obj  = get_post_type_object($postType);
			$posts = $this->PostType->findAll(array('post_type' => $postType));
			$validPostTypesObj[$key]['label'] = $obj->labels->singular_name;
			$validPostTypesObj[$key]['name'] = $obj->name;
			$validPostTypesObj[$key]['posts'] = \Set::combine($posts->posts, '{n}.ID', '{n}.post_title');
		}

		$this->assign('post_types', $validPostTypesObj);

	}

	public function delete_item(){
		$this->autoRender = false;
		$this->isAjax = true;
		$items = $this->PostMeta->find(array($this->post['portfolio_id'], 'cp-press-portfolio'));
		update_post_meta($this->post['item_id'], 'cp-press-portfolio', \Set::remove($items, $this->post['item_id']));
		return json_encode(true);
	}

	public static function save($post_id){
		if(isset($_POST['cp-press-portfolio'])){
			if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
				return;
			update_post_meta($post_id, 'cp-press-portfolio', $_POST['cp-press-portfolio']);
		}
	}

	public function portfolio_view($content=array(), $col=0){
		$this->autoRender = false;
		$portfolio = $this->Portfolio->find(array('p' => $content['id']));
		$portfolioPost = $portfolio->posts[0];
		$portfolioData = $this->PostMeta->find(array($portfolioPost->ID, 'cp-press-portfolio'));
		$items = array();
		if(isset($portfolioData) && !empty($portfolioData)){
			$i=0;
			foreach($portfolioData as $id => $item){
				if(in_array($id, $this->portfolioOptions))
					continue;
				$itemPost = $this->Post->find(array('p' => $id, 'post_type' => $item['type']))->posts[0];
				$items[$i]['image'] = wp_get_attachment_image_src(get_post_thumbnail_id($itemPost->ID), 'full');
				$items[$i]['title'] = $itemPost->post_title;
				$items[$i]['caption'] = $itemPost->post_excerpt;
				$items[$i]['type'] = $item['type'];
				if($item['enable_link'])
					$items[$i]['link'] = get_permalink($itemPost->ID);
				else
					$items[$i]['link'] = false;
				$items[$i]['id'] = $itemPost->ID;
				$i++;
			}
			$formatItems = array();
			$column =  ceil(count($items) / $portfolioData['item_per_row']);
			$k = 0;
			for($i=0; $i<$column; $i++){
				for($j=0; $j<$portfolioData['item_per_row']; $j++){
					if(isset($items[$k])){
						$formatItems[$i][$j] = $items[$k];
					}
					$k++;
				}
			}
			$this->assign('col', $this->fluidGrid[$portfolioData['item_per_row']]);
			$this->assign('coffset', ceil($this->fluidGrid[$portfolioData['item_per_row']])/2);
			$this->assign('thumb_size', $portfolioData['thumb']);
			$this->assign('item_per_row', $portfolioData['item_per_row']);
			$this->assign('item_box_width', 100/$portfolioData['item_per_row']);
			$this->assign('title', $portfolioData['title']);
			$this->assign('items', $formatItems);
		}
		return $this->render(array('controller' => 'Index'));
	}

	public function select_portfolio($content = array(), $col=0){
		$this->autoRender = false;
		if(empty($content)){
			$this->isAjax = true;
			$this->assign('ajax', true);
		}else{
			$this->assign('ajax', false);
		}
		$this->assign('content', $content);
		$this->assign('title', 'portfolio');
		$this->assign('type', 'portfolio');
		$this->assign('ns', '\CpPressPortfolio\CpPortfolio');
		$this->assign('controller', 'AdminPortfolio');
		$this->assign('action', 'select_portfolio');
		$portfolios = $this->Portfolio->findAll();
		$this->assign('items', \Set::combine($portfolios->posts, '{n}.ID', '{n}.post_title'));
		$this->assign('section', $this->Section->find(array('p' => $this->get['section'])));
		if(isset($this->get['num_col']))
			$this->assign('num_col', $this->get['num_col']);
		else
			$this->assign('num_col', $col);

		return $this->render(array('controller' => 'AdminSection', 'action' => 'select_content', 'ns' => 'cp-press-onepage'));
	}

}

?>
