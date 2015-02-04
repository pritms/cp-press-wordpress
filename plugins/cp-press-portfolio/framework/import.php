<?php
namespace CpPressPortfolio;


/**
 * Import library from framework
 *
 * @param  string  $libs java import like library path
 * @return string
 */
function import($libs){
	CpPortfolio::import($libs, __NAMESPACE__, WPCHOP_PORTFOLIO_RELATIVE);
}

/**
 * Import external library from webapp lib folder
 *
 * @param  string  $libs java import like library path
 * @return string
 */
function external($libs){
	CpPortfolio::external($libs);
}

/**
 * Import external exception
 *
 * @param  string  $libs java import like library path
 * @return string
 */
function exception($exception){
	CpPortfolio::exception($exception);
}
?>