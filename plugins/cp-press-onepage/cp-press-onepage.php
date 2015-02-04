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
 * Plugin Name: Commonhelp OnePage Plugin
 * Plugin URI: http://wp.commonhelp.it/onepage
 * Description: Make one page wordpress.
 * Version: 1.0
 * Author: Marco Trognoni
 * Author URI: http://www.commonhelp.it
 * License: GPL2
 */

define('DS', DIRECTORY_SEPARATOR);
define('WPCHOP',dirname(__FILE__).DS.'framework');
define('WPCHOP_RELATIVE', 'cp-press-onepage/framework/');
define('WPCHOP_BASE_FILE', __FILE__);
define('WPCHOP_BASE', dirname(__FILE__));
set_include_path(ABSPATH.DS.PLUGINDIR . PATH_SEPARATOR . get_include_path());
include WPCHOP.DS.'convenience.php';
include WPCHOP.DS.'functions.php';
include WPCHOP.DS.'import.php';

require(WPCHOP.DS.'CpOnePage.php');

spl_autoload_register('CpPressOnePage\\CpOnePage::autoload');
register_activation_hook(__FILE__, function(){
	CpPressOnePage\CpOnePage::install();
});
CpPressOnePage\CpOnePage::start();

?>