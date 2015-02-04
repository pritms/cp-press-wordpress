<?php
namespace CpPressOnePage{
	/**
	 * Import library from framework
	 *
	 * @param  string  $libs java import like library path
	 * @return string
	 */
	function import($libs){
		CpOnePage::import($libs, __NAMESPACE__, WPCHOP_RELATIVE);
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
}

namespace{
	/**
	 * Import library from framework
	 *
	 * @param  string  $libs java import like library path
	 * @return string
	 */
	function import($libs){
		CpPressOnePage\CpOnePage::import($libs);
	}

	/**
	 * Import external library from webapp lib folder
	 *
	 * @param  string  $libs java import like library path
	 * @return string
	 */
	function external($libs){
		CpPressOnePage\CpOnePage::external($libs);
	}

	/**
	 * Import external exception
	 *
	 * @param  string  $libs java import like library path
	 * @return string
	 */
	function exception($exception){
		CpPressOnePage\CpOnePage::exception($exception);
	}
}
?>