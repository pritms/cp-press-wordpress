<?php
namespace CpPressEvent;


/**
 * Import library from framework
 *
 * @param  string  $libs java import like library path
 * @return string
 */
function import($libs){
	CpEvent::import($libs, __NAMESPACE__, WPCHOP_EVENT_RELATIVE);
}

/**
 * Import external library from webapp lib folder
 *
 * @param  string  $libs java import like library path
 * @return string
 */
function external($libs){
	CpEvent::external($libs);
}

/**
 * Import external exception
 *
 * @param  string  $libs java import like library path
 * @return string
 */
function exception($exception){
	CpEvent::exception($exception);
}
?>