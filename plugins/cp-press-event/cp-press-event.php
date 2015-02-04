<?php
/*  Copyright 2014  Marco Trognoni  (email : mtrognon@commonhelp.it)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/**
 * Plugin Name: Commonhelp OnePage Event Manager Plugin
 * Depends: Commonhelp OnePage Plugin
 * Plugin URI: http://wp.commonhelp.it/slider
 * Depends: Commonhelp OnePage Plugin
 * Description: Make galleries for Commonhelp OnePage Plugin.
 * Version: 1.0
 * Author: Marco Trognoni
 * Author URI: http://www.commonhelp.it
 * License: GPL2
 */

/* FORCE base plugin load */
if(!class_exists(CpPressOnePage)){
	$basePlugin = array_filter(wp_get_active_and_valid_plugins(),function($value){return preg_match("/cp-press-onepage\/.*/", $value);});
	if(empty($basePlugin))
		wp_die('CPEvent Plugin requires CPPress plugin installed and activated');
	
	include_once(array_pop($basePlugin));
}
define('WPCHOP_EVENT',dirname(__FILE__).DS.'framework');
define('WPCHOP_EVENT_RELATIVE', 'cp-press-event/framework/');
define('WPCHOP_EVENT_BASE_FILE', __FILE__);
define('WPCHOP_EVENT_BASE', dirname(__FILE__));


include WPCHOP_EVENT.DS.'import.php';

require(WPCHOP_EVENT.DS.'CpEvent.php');
register_activation_hook(__FILE__, function(){
	CpPressEvent\CpEvent::install();
});

CpPressEvent\CpEvent::start();

?>