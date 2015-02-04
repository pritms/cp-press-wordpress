<?php
namespace CpPressGallery;


/**
 * Import library from framework
 *
 * @param  string  $libs java import like library path
 * @return string
 */
function import($libs){
	CpGallery::import($libs, __NAMESPACE__, WPCHOP_GALLERY_RELATIVE);
}

/**
 * Import external library from webapp lib folder
 *
 * @param  string  $libs java import like library path
 * @return string
 */
function external($libs){
	CpGallery::external($libs);
}

/**
 * Import external exception
 *
 * @param  string  $libs java import like library path
 * @return string
 */
function exception($exception){
	CpGallery::exception($exception);
}
?>