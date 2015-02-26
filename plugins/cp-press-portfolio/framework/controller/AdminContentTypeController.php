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
\import('util.Set');
import('controller.AdminPortfolioController');

class AdminContentTypeController extends \CpPressOnePage\Controller{

	protected $uses = array('Portfolio', 'PortfolioSettings', 'Section', 'PostMeta', 'PostType', 'Post');
	private $fluidGrid = array(
		'1' => '12',
		'2' => '6',
		'3' => '4',
		'4' => '3',
		'6' => '2'
	);
	
	public function portfolio($row='', $col='', $content=array()){
            $this->assign('row', $row);
            $this->assign('col', $col);
            $this->assign('content', $content);
            $this->assign('title', 'portfolio');
            $this->assign('type', 'portfolio');
            $this->assign('ns', '\CpPressPortfolio\CpPortfolio');
            $this->assign('controller', 'AdminContentType');
            $this->assign('action', 'portfolio');
            $portfolios = $this->Portfolio->findAll();
            $this->assign('items', \Set::combine($portfolios->posts, '{n}.ID', '{n}.post_title'));
	}
	
	public function portfolio_view($row='', $col='', $content=array()){
		$this->autoRender = false;
		$portfolio = $this->Portfolio->find(array('p' => $content['id']));
		$portfolioPost = $portfolio->posts[0];
		$portfolioData = $this->PostMeta->find(array($portfolioPost->ID, 'cp-press-portfolio'));
		$items = array();
		if(isset($portfolioData) && !empty($portfolioData)){
			$i=0;
			foreach($portfolioData as $id => $item){
				if(in_array($id, AdminPortfolioController::$portfolioOptions))
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
			$this->assign('hideinfo', isset($portfolioData['hideinfo']) ? true : false);
		}
		return $this->render(array('controller' => 'Index'));
	}
}

?>
