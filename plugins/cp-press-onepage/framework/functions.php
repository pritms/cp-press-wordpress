<?
/**
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

function is_assoc($array){
    return is_array($array) && count($array) !== array_reduce(array_keys($array), 'is_assoc_callback', 0);
}

function is_assoc_callback($a, $b){
    return $a === $b ? $a + 1 : 0;
}



/* create an array of object's properties (private, public and protected) */
function obj2array(&$instance){
    $clone = (array)$instance;
    $rtn = array();
    $tmp['___SOURCE_KEYS_'] = $clone;

	//clear all keys
    while(list($key, $value) = each($clone)){
        $aux = explode("\0", $key);
        $newkey = $aux[count($aux)-1];
        $rtn[$newkey] = &$tmp['___SOURCE_KEYS_'][$key];
    }

    return $rtn;
}

/* bless perl porting function: it creates an instance of $Class object from an assoc array of $Class properties */
function bless(&$instance, $class){
    if (!(is_array($instance))){
        return NULL;
    }

    // First get source keys if available
    if (isset($instance['___SOURCE_KEYS_'])){
        $instance = $instance['___SOURCE_KEYS_'];
    }

    // Get serialization data from array
    $serData = serialize($instance);

    list($arrayParams, $arrayElems) = explode('{', $serData, 2);
    list($arrayTag, $arrayCount) = explode(':', $arrayParams, 3);
    $serData = "O:".strlen($class).":\"$class\":$arrayCount:{".$arrayElems;
    $instance = unserialize($serData);
    return $instance;
}

function domNodeList_to_string($DomNodeList) {
	$output = '';
	$doc = new DOMDocument;
	while ( $node = $DomNodeList->item($i) ) {
		// import node
		$domNode = $doc->importNode($node, true);
		// append node
		$doc->appendChild($domNode);
		$i++;
	}
	$output = $doc->saveXML();
	$output = print_r($output, 1);
	// I added this because xml output and ajax do not like each others
	$output = htmlspecialchars($output);
	return $output;
}



function isDebugMode(){
	if(Configurable::queryConf("server", "debug")){
		return true;
	}else{
		return false;
	}
}

function isSmartyDebugMode(){
	if(Configurable::queryConf("server", "smarty")){
		return true;
	}else{
		return false;
	}
}

function isLogEnabled(){
	if(Configurable::queryConf("server", "log")){
		return true;
	}else{
		return false;
	}
}


function createThumb($fileName, $absolutePath, $dirImages, $dirThumbs){
	/* Get information about the installed GD.*/
	$gdVersion = getGDversion();

	if ($gdVersion == false) return false;

	$file = $absolutePath.$dirImages.$fileName;
	$fileDest = $absolutePath.$dirThumbs.$fileName;

	// Get the image dimensions.
	$dimensions = getimagesize($file);
	$width = $dimensions[0];
	$height = $dimensions[1];

	$outputX = 140;
	$outputY = 140;
	$quality = 85;


	if($width < $height){ /* The image is of vertical shape */
		$deltaX = 0;
		$deltaY = ($height - $width) / 2;
		$portionX = $width;
		$portionY = $width;
	}elseif($width > $height){ /* The image is of horizontal shape */
		$deltaY = 0;
		$deltaX = ($width - $height) / 2;
		$portionX = $height;
		$portionY = $height;
	}else{ /* The image is of squared shape */
		$deltaX = 0;
		$deltaY = 0;
		$portionX = $width;
		$portionY = $height;
	}

	$imageSrc = imagecreatefromjpeg($file);


	if($gdVersion < 2){ /* ---- The thumbnail creation with GD1.x functions does the job. ------	*/
		$imageDest = imagecreate($outputX, $outputY); // Create an empty thumbnail image.
		if(imagecopyresized($imageDest, $imageSrc, 0, 0, $deltaX, $deltaY, $outputX, $outputY, $portionX, $portionY)){
			/*Try to create the thumbnail from the source image. */
			imagejpeg($imageDest, $fileDest, $quality); /* save the thumbnail image into a file. */
			imagedestroy($imageSrc); /* Delete both image resources.*/
			imagedestroy($imageDest); /* Delete both image resources.*/
			return true;
		}
	}else{ /* ------ The recommended approach is the usage of the GD2.x functions. ----- */
		$imageDest = imagecreatetruecolor($outputX, $outputY); /* Create an empty thumbnail image.*/
		if (imagecopyresampled($imageDest, $imageSrc, 0, 0, $deltaX, $deltaY, $outputX, $outputY, $portionX, $portionY)){
			/* Try to create the thumbnail from the source image.*/
			imagejpeg($imageDest, $fileDest, $quality); /* save the thumbnail image into a file. */
			imagedestroy($imageSrc); /* Delete both image resources. */
			imagedestroy($imageDest); /* Delete both image resources. */
			return true;
		}
	}

	return false;
}


function getGDversion(){
	static $gd_version_number = null;
	if ($gd_version_number === null){
	       /* Use output buffering to get results from phpinfo() without disturbing the page we're in.
	        Output buffering is "stackable" so we don't even have to worry about previous or encompassing buffering.*/
		ob_start();
		phpinfo(8);
		$module_info = ob_get_contents();
		ob_end_clean();
		if (preg_match("/\bgd\s+version\b[^\d\n\r]+?([\d\.]+)/i", $module_info,$matches)){
			$gd_version_number = $matches[1];
		}else{
			$gd_version_number = 0;
		}
	}
	return $gd_version_number;
}

function dump($obj, $limit=10, $die = 1){
	echo Dumper::dump($obj, $limit, true);
	if ($die) exit;
}

function sqldump($sqlRes, $block=true){
	dump($sqlRes, 10, false);
	pr('');
	dump(Object::$sqlStack, 10, $block);
}

if(false === function_exists('lcfirst')){
    /**
     * Make a string's first character lowercase
     *
     * @param string $str
     * @return string the resulting string.
     */
    function lcfirst($str){
        $str[0] = strtolower($str[0]);
        return (string)$str;
    }
}

require_once('util/MobileDetect.php');

$useragent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : "";
$mobble_detect = new MobileDetect();
$mobble_detect->setDetectionType('extended');



/***************************************************************
* Function is_iphone
* Detect the iPhone
***************************************************************/

function is_iphone() {
	global $mobble_detect;
	return($mobble_detect->isIphone());
}

/***************************************************************
* Function is_ipad
* Detect the iPad
***************************************************************/

function is_ipad() {
	global $mobble_detect;
	return($mobble_detect->isIpad());
}

/***************************************************************
* Function is_ipod
* Detect the iPod, most likely the iPod touch
***************************************************************/

function is_ipod() {
	global $mobble_detect;
	return($mobble_detect->is('iPod'));
}

/***************************************************************
* Function is_android
* Detect an android device.
***************************************************************/

function is_android() {
	global $mobble_detect;
	return($mobble_detect->isAndroidOS());
}

/***************************************************************
* Function is_blackberry
* Detect a blackberry device 
***************************************************************/

function is_blackberry() {
	global $mobble_detect;
	return($mobble_detect->isBlackBerry());
}

/***************************************************************
* Function is_opera_mobile
* Detect both Opera Mini and hopefully Opera Mobile as well
***************************************************************/

function is_opera_mobile() {
	global $mobble_detect;
	return($mobble_detect->isOpera());
}

/***************************************************************
* Function is_palm - to be phased out as not using new detect library?
* Detect a webOS device such as Pre and Pixi
***************************************************************/

function is_palm() {
	_deprecated_function('is_palm', '1.2', 'is_webos');
	global $mobble_detect;
	return($mobble_detect->is('webOS'));
}

/***************************************************************
* Function is_webos
* Detect a webOS device such as Pre and Pixi
***************************************************************/

function is_webos() {
	global $mobble_detect;
	return($mobble_detect->is('webOS'));
}

/***************************************************************
* Function is_symbian
* Detect a symbian device, most likely a nokia smartphone
***************************************************************/

function is_symbian() {
	global $mobble_detect;
	return($mobble_detect->is('Symbian'));
}

/***************************************************************
* Function is_windows_mobile
* Detect a windows smartphone
***************************************************************/

function is_windows_mobile() {
	global $mobble_detect;
	return($mobble_detect->is('WindowsMobileOS') || $mobble_detect->is('WindowsPhoneOS'));
}

/***************************************************************
* Function is_lg
* Detect an LG phone
***************************************************************/

function is_lg() {
	_deprecated_function('is_lg', '1.2');
	global $useragent;
	return(preg_match('/LG/i', $useragent));
}

/***************************************************************
* Function is_motorola
* Detect a Motorola phone
***************************************************************/

function is_motorola() {
	global $mobble_detect;
	return($mobble_detect->is('Motorola'));
}

/***************************************************************
* Function is_nokia
* Detect a Nokia phone
***************************************************************/

function is_nokia() {
	_deprecated_function('is_nokia', '1.2');
	global $useragent;
	return(preg_match('/Series60/i', $useragent) || preg_match('/Symbian/i', $useragent) || preg_match('/Nokia/i', $useragent));
}

/***************************************************************
* Function is_samsung
* Detect a Samsung phone
***************************************************************/

function is_samsung() {
	global $mobble_detect;
	return($mobble_detect->is('Samsung'));
}

/***************************************************************
* Function is_samsung_galaxy_tab
* Detect the Galaxy tab
***************************************************************/

function is_samsung_galaxy_tab() {
	_deprecated_function('is_samsung_galaxy_tab', '1.2', 'is_samsung_tablet');
	return is_samsung_tablet();
}

/***************************************************************
* Function is_samsung_tablet
* Detect the Galaxy tab
***************************************************************/

function is_samsung_tablet() {
	global $mobble_detect;
	return($mobble_detect->is('SamsungTablet'));
}

/***************************************************************
* Function is_kindle
* Detect an Amazon kindle
***************************************************************/

function is_kindle() {
	global $mobble_detect;
	return($mobble_detect->is('Kindle'));
}

/***************************************************************
* Function is_sony_ericsson
* Detect a Sony Ericsson
***************************************************************/

function is_sony_ericsson() {
	global $mobble_detect;
	return($mobble_detect->is('Sony'));
}

/***************************************************************
* Function is_nintendo
* Detect a Nintendo DS or DSi
***************************************************************/

function is_nintendo() {
	global $useragent;
	return(preg_match('/Nintendo DSi/i', $useragent) || preg_match('/Nintendo DS/i', $useragent));
}


/***************************************************************
* Function is_smartphone
* Grade of phone A = Smartphone - currently testing this
***************************************************************/

function is_smartphone() {
	return is_iphone() || is_android() || is_samsung() || is_windows_mobile() || is_opera_mobile();
}

/***************************************************************
* Function is_handheld
* Wrapper function for detecting ANY handheld device
***************************************************************/

function is_handheld() {
	return(is_mobile() || is_iphone() || is_ipad() || is_ipod() || is_android() || is_blackberry() || is_opera_mobile() || is_webos() || is_symbian() || is_windows_mobile() || is_motorola() || is_samsung() || is_samsung_tablet() || is_sony_ericsson() || is_nintendo());
}

/***************************************************************
* Function is_mobile
* For detecting ANY mobile phone device
***************************************************************/

function is_mobile() {
	global $mobble_detect;
	if (is_tablet()) return false;
	return ($mobble_detect->isMobile());
}

/***************************************************************
* Function is_ios
* For detecting ANY iOS/Apple device
***************************************************************/

function is_ios() {
	global $mobble_detect;
	return($mobble_detect->isiOS());
}

/***************************************************************
* Function is_tablet
* For detecting tablet devices (needs work)
***************************************************************/

function is_tablet() {
	global $mobble_detect;
	return($mobble_detect->isTablet());
}


?>