<?
/**
 * @package        OndaPHP.Util
 * @subpackage    Filesystem
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
 * Path handling class
 *
 * @access public
 * @author Marco Trognoni, <mtrognoni@elitedivision.it>
*/

final class Path{

	/**
	* Checks if a path's permissions can be changed
	*
	* @access public
	* @static
	* @param	string	$path	Path to check
	* @return	boolean	True if path can have mode changed
	*/
	public static function canChmod($path){
		$perms = fileperms($path);
		if($perms !== false){
			if(@ chmod($path, $perms ^ 0001)){
				@chmod($path, $perms);
				return true;
			}
		}
		return false;
	}

	/**
	* Chmods files and directories recursivly to given permissions
	*
	* @access public
	* @static
	* @param	string	$path		Root path to begin changing mode [without trailing slash]
	* @param	string	$filemode	Octal representation of the value to change file mode to [null = no change]
	* @param	string	$foldermode	Octal representation of the value to change folder mode to [null = no change]
	* @return	boolean	True if successful [one fail means the whole operation failed]
	*/
	public static function setPermissions($path, $filemode = '0644', $foldermode = '0755') {

		// Initialize return value
		$ret = true;

		if(is_dir($path)){
			$dh = opendir($path);
			while($file = readdir($dh)){
				if($file != '.' && $file != '..'){
					$fullpath = $path.'/'.$file;
					if(is_dir($fullpath)){
						if(!self::setPermissions($fullpath, $filemode, $foldermode)){
							$ret = false;
						}
					}else{
						if(isset($filemode)){
							if (!@ chmod($fullpath, octdec($filemode))){
								$ret = false;
							}
						}
					}
				}
			}
			closedir($dh);
			if(isset($foldermode)){
				if (!@ chmod($path, octdec($foldermode))){
					$ret = false;
				}
			}
		}else{
			if(isset($filemode)){
				$ret = @ chmod($path, octdec($filemode));
			}
		}
		return $ret;
	}

	/**
	* Get the permissions of the file/folder at a give path
	*
	* @access public
	* @static
	* @param	string	$path	The path of a file/folder
	* @return	string	Filesystem permissions
	*/
	public static function getPermissions($path){
		$path = Path::clean($path);
		$mode = @ decoct(@ fileperms($path) & 0777);

		if(strlen($mode) < 3){
			return '---------';
		}
		$parsed_mode = '';
		for ($i = 0; $i < 3; $i ++){
			// read
			$parsed_mode .= ($mode { $i } & 04) ? "r" : "-";
			// write
			$parsed_mode .= ($mode { $i } & 02) ? "w" : "-";
			// execute
			$parsed_mode .= ($mode { $i } & 01) ? "x" : "-";
		}
		return $parsed_mode;
	}

	/**
	* Checks for snooping outside of the file system root
	*
	* @access public
	* @static
	* @param	string	$path	A file system path to check
	* @return	string	A cleaned version of the path
	*/
	public static function check($path){
		if (strpos($path, '..') !== false) {
			throw new FileSystemException("check Use of relative paths not permitted");
		}
		$path = Path::clean($path);
		if (strpos($path, Path::clean(WEB_ROOT)) !== 0) {
			throw new FileSystemException("JPath::check Snooping out of bounds @ ".$path);
		}
	}

	/**
	* Function to strip additional / or \ in a path name
	*
	* @access public
	* @static
	* @param	string	$path	The path to clean
	* @param	string	$ds		Directory separator (optional)
	* @return	string	The cleaned path
	*/
	public static function clean($path, $ds=DS){
		$path = trim($path);
		if(empty($path)){
			$path = WEB_ROOT;
		} else {
			// Remove double slashes and backslahses and convert all slashes and backslashes to DS
			$path = preg_replace('#[/\\\\]+#', $ds, $path);
		}

		return $path;
	}


	/**
	* Searches the directory paths for a given file.
	*
	* @access public
	* @static
	* @access	protected
	* @param	array	$path	An array of paths to search in
	* @param	string	$file	The file name to look for.
	* @return	mixed	The full path and file name for the target file, or boolean false if the file is not found in any of the paths.
	*/
	public static function find($paths, $file){
		// start looping through the path set
		foreach($paths as $path){
			// get the path to the file
			$fullname = $path.DS.$file;
			// is the path based on a stream?
			if(strpos($path, '://') === false){
				// not a stream, so do a realpath() to avoid directory
				// traversal attempts on the local file system.
				$path = realpath($path); // needed for substr() later
				$fullname = realpath($fullname);
			}

			// the substr() check added to make sure that the realpath()
			// results in a directory registered so that
			// non-registered directores are not accessible via directory
			// traversal attempts.
			if (file_exists($fullname) && substr($fullname, 0, strlen($path)) == $path) {
				return $fullname;
			}
		}

		// could not find the file in the set of paths
		return false;
	}
	
	public static function pathToUri($path){
		$file = basename($path);
		$dirPath = dirname($path);
		ereg(ROOT.DS.APP_DIR.'/[a-zA-Z0-9]+(.*)', $path, $match);
		return BASE_URI.$match[1];
	}

}

?>