<?php
namespace CpPressSlider;


/**
 * Import library from framework
 *
 * @param  string  $libs java import like library path
 * @return string
 */
function import($libs){
	CpSlider::import($libs, __NAMESPACE__, WPCHOP_SLIDER_RELATIVE);
}

/**
 * Import external library from webapp lib folder
 *
 * @param  string  $libs java import like library path
 * @return string
 */
function external($libs){
	CpOnePage::external($libs);
}

/**
 * Import external exception
 *
 * @param  string  $libs java import like library path
 * @return string
 */
function exception($exception){
	CpOnePage::exception($exception);
}
?>