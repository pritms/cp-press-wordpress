<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace CpPressPortfolio;
\import('model.Options');
class PortfolioSettings extends \CpPressOnePage\Options{
	
	public function __construct(){
		$this->group = 'chpress_portfolio_settings';
		$this->options = get_option($this->group);
		parent::__construct();
	}
}
?>