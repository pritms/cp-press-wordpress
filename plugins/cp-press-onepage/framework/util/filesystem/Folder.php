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
 * Directory handling class
 *
 * @access public
 * @author Marco Trognoni, <mtrognoni@elitedivision.it>
*/
import('util.ftp.FileTransferAbstract');
class Folder{

	/**
	* Copies a folder
	*
	* @access public
	* @static
	* @param    string    $src    The path to the source folder
	* @param    string    $dest    The path to the destination folder
	* @param    string    $path    An optional base path to prefix to the file names
	* @param    boolean    $force    Optionally force folder/file overwrites
	* @return    mixed    JError object on failure or boolean True on success
	*/
	public static function copy($src, $dest, $path = '', $force = false, $exclude = array('.svn', 'CVS')){
		if($path){
			$src = Path::clean($path.DIRECTORY_SEPARATOR.$src);
			$dest = Path::clean($path.DIRECTORY_SEPARATOR.$dest);
		}

		$src = rtrim($src, DIRECTORY_SEPARATOR);
		$dest = rtrim($dest, DIRECTORY_SEPARATOR);
		if(!self::exists($src)){
			throw new FileSystemException("Unable to find source directory");
		}

		if(self::exists($dest) && !$force){
			throw new FileSystemException("Directory already exists");
		}

		// Make sure the destination exists
		if (!self::create($dest)) {
			throw new FileSystemException("Unable to create target directory");
		}

		if(IS_FTP_ENABLED){
			$ftp = self::getFtpConnection();

			if(!($dh = @opendir($src))){
				throw new FileSystemException("Unable to open source folder");
			}
			// Walk through the directory copying files and recursing into folders.
			while(($file = readdir($dh)) !== false){
				$sfid = $src.DIRECTORY_SEPARATOR.$file;
				$dfid = $dest.DIRECTORY_SEPARATOR.$file;
				switch(filetype($sfid)){
					case 'dir':
						if($file != '.' && $file != '..' && (!in_array($file, $exclude))){
							$ret = self::copy($sfid, $dfid, null, $force);
							if ($ret !== true) {
								return $ret;
							}
						}
						break;

					case 'file':
						//Translate path for the FTP account
						$dfid = Path::clean(str_replace(WEB_ROOT, Configurable::queryConf("ftp", "root"), $dfid), '/');
						if (! $ftp->store($sfid, $dfid)) {
							throw new \Exception("Copy failed");
						}
						break;
				}
			}
		}else{
			if(! ($dh = @opendir($src))) {
				throw new FileSystemException("Unable to open source folder");
			}
			// Walk through the directory copying files and recursing into folders.
			while(($file = readdir($dh)) !== false){
				$sfid = $src.DIRECTORY_SEPARATOR.$file;
				$dfid = $dest.DIRECTORY_SEPARATOR.$file;
				switch(filetype($sfid)){
					case 'dir':
						if($file != '.' && $file != '..' && (!in_array($file, $exclude))){
							$ret = self::copy($sfid, $dfid, null, $force);
							if ($ret !== true) {
								return $ret;
							}
						}
						break;

					case 'file':
						if(!@ copy($sfid, $dfid)){
							throw new \Exception("Copy failed");
						}
						break;
				}
			}
		}

		return true;

	}

    /**
	* Create a folder -- and all necessary parent folders
	*
	* @access public
	* @static
	* @param string $path A path to create from the base path
	* @param int $mode Directory permissions to set for folders created
	* @return boolean True if successful
	*/
	public static function create($path = '', $mode = 0755){
		static $nested = 0;

		// Check to make sure the path valid and clean
		$path = Path::clean($path);

		// Check if parent dir exists
		$parent = dirname($path);
		if(!self::exists($parent)) {
			// Prevent infinite loops!
			$nested++;
			if(($nested > 20) || ($parent == $path)){
				$nested--;
				throw new \Exception("Infinite loop detected");
			}

			// Create the parent directory
			if(self::create($parent, $mode) !== true){
				// self::create throws an error
				$nested--;
				return false;
			}

			// OK, parent directory has been created
			$nested--;
		}

		// Check if dir already exists
		if(self::exists($path)){
			return true;
		}

		// Check for safe mode
		if(IS_FTP_ENABLED){

			$ftp = self::getFtpConnection();
			// Translate path to FTP path
			$path = Path::clean(str_replace(WEB_ROOT, Configurable::queryConf("ftp", "root"), $path), '/');
			$ret = $ftp->mkdir($path);
			$ftp->chmod($path, $mode);
		}else{
			// We need to get and explode the open_basedir paths
			$obd = ini_get('open_basedir');

			// If open_basedir is set we need to get the open_basedir that the path is in
			if ($obd != null){
				$obdSeparator = ":";
				// Create the array of open_basedir paths
				$obdArray = explode($obdSeparator, $obd);
				$inOBD = false;
				// Iterate through open_basedir paths looking for a match
				foreach ($obdArray as $test) {
					$test = Path::clean($test);
					if (strpos($path, $test) === 0) {
						$obdpath = $test;
						$inOBD = true;
						break;
					}
				}
				if ($inOBD == false) {
					// Return false for JFolder::create because the path to be created is not in open_basedir
					throw new \Exception("Path not in open_basedir paths");
				}
			}

			// First set umask
			$origmask = @ umask(0);

			// Create the path
			if(!$ret = @mkdir($path, $mode)){
				@ umask($origmask);
				throw new \Exception("Could not create directory ".$path);
			}

			// Reset umask
			@ umask($origmask);
		}

		return $ret;
	}

    /**
	* Delete a folder
	*
	* @access public
	* @static
	* @param string $path The path to the folder to delete
	* @return boolean True on success
	*/
	public static function delete($path){
		// Check to make sure the path valid and clean
		$path = Path::clean($path);
		// Is this really a folder?
		if(!is_dir($path)){
			throw new \Exception($path." Path is not a folder");
			return false;
		}

		// Remove all the files in folder if they exist
		$files = self::files($path, false, true, '.', array());
		if (count($files)) {
			if (File::delete($files) !== true) {
				return false;
			}
		}

		// Remove sub-folders of folder
		$folders = self::folders($path, '.', false, true, array());
		foreach ($folders as $folder) {
			if (self::delete($folder) !== true) {
				// JFolder::delete throws an error
				return false;
			}
		}

		if(IS_FTP_ENABLED){
			$ftp = self::getFtpConnection();
		}

		// In case of restricted permissions we zap it one way or the other
		// as long as the owner is either the webserver or the ftp
		if(@rmdir($path)){
			$ret = true;
		}else if(IS_FTP_ENABLED){
			// Translate path and delete
			$path = Path::clean(str_replace(WEB_ROOT, Configurable::queryConf("ftp", "root"), $path), '/');
			// FTP connector throws an error
			$ret = $ftp->delete($path);
		}else{
			throw new \Exception("Could not delete folder ".$path);
		}

		return $ret;
	}

    /**
	* Moves a folder
	*
	* @access public
	* @static
	* @param string $src The path to the source folder
	* @param string $dest The path to the destination folder
	* @param string $path An optional base path to prefix to the file names
	* @return mixed Error message on false or boolean True on success
	*/
	public static function move($src, $dest, $path = ''){
		if($path){
			$src = Path::clean($path.DIRECTORY_SEPARATOR.$src);
			$dest = Path::clean($path.DIRECTORY_SEPARATOR.$dest);
		}

		if(!self::exists($src) && !is_writable($src)) {
			throw new \Exception("Cannot find source folder");
		}
		if (self::exists($dest)) {
			throw new \Exception("Folder already exists");
		}

		if(IS_FTP_ENABLED){
			$ftp = self::getFtpConnection();

			//Translate path for the FTP account
			$src = Path::clean(str_replace(WEB_ROOT, Configurable::queryConf("ftp", "root"), $src), '/');
			$dest = Path::clean(str_replace(WEB_ROOT, Configurable::queryConf("ftp", "root"), '/'));

			// Use FTP rename to simulate move
			if (!$ftp->rename($src, $dest)) {
				throw new \Exception("Rename failed");
			}
			$ret = true;
		}else{
			if(!@ rename($src, $dest)){
				throw new \Exception("Rename failed");
			}
			$ret = true;
		}
		return $ret;
	}


	/**
	* Wrapper for the standard file_exists function
	*
	* @access public
	* @static
	* @param string $path Folder name relative to installation dir
	* @return boolean True if path is a folder
	* @since 1.5
		*/
	public static function exists($path){
		return is_dir(Path::clean($path));
	}

    /**
	* Utility function to read the files in a folder
	*
	* @access public
	* @static
	* @param    string    $path        The path of the folder to read
	* @param    string    $filter        A filter for file names
	* @param    mixed    $recurse    True to recursively search into sub-folders, or an integer to specify the maximum depth
	* @param    boolean    $fullpath    True to return the full path to the file
	* @param    array    $exclude    Array with names of files which should not be shown in the result
	* @return    array    Files in the given folder
	*/
	public static function files($path, $recurse = false, $fullpath = false, $filter = '.', $exclude = array('.svn', 'CVS'), $relDir = null){
        $arr = array ();

        $path = Path::clean($path);

        // Is the path a folder?
		if (!is_dir($path)) {
			throw new \Exception($path." Path is not a folder");
		}

        // read the source directory
		$handle = opendir($path);
		while (($file = readdir($handle)) !== false){
			$dir = $path.DS.$file;
			$isDir = is_dir($dir);
			if (($file != '.') && ($file != '..') && (!in_array($file, $exclude))) {
				if ($isDir) {
					if ($recurse) {
						if (is_integer($recurse)) {
							$recurse--;
						}
						$arr2 = self::files($dir, $recurse, $fullpath, $filter, $exclude, $file);
						$arr = array_merge($arr, $arr2);
					}
				} else {
					if (preg_match("/$filter/", $file)) {
						if ($fullpath) {
							$arr[] = $path.DS.$file;
						} else {
							if($relDir){
								$arr[] = $relDir.DS.$file;
							}else{
								$arr[] = $relDir.DS.$file;
							}
						}
					}
				}
			}
		}
		closedir($handle);

		asort($arr);
		return $arr;
	}

    /**
	* Utility function to read the folders in a folder
	*
	* @access public
	* @static
	* @param    string    $path        The path of the folder to read
	* @param    string    $filter        A filter for folder names
	* @param    mixed    $recurse    True to recursively search into sub-folders, or an integer to specify the maximum depth
	* @param    boolean    $fullpath    True to return the full path to the folders
	* @param    array    $exclude    Array with names of folders which should not be shown in the result
	* @return    array    Folders in the given folder
	* @since 1.5
	*/
	public static function folders($path, $filter = '.', $recurse = false, $fullpath = false, $exclude = array('.svn', 'CVS')){
		$arr = array ();

		$path = Path::clean($path);
		if (!is_dir($path)) {
			throw new \Exception($path." Path is not a folder");
		}

        // read the source directory
		$handle = opendir($path);
		while (($file = readdir($handle)) !== false) {
			$dir = $path."/".$file;
			$isDir = is_dir($dir);
			if (($file != '.') && ($file != '..') && (!in_array($file, $exclude)) && $isDir) {
                // removes SVN directores from list
				if (preg_match("/$filter/", $file)) {
					if ($fullpath) {
						$arr[] = $dir;
					} else {
						$arr[] = $file;
					}
				}
				if ($recurse) {
					if (is_integer($recurse)) {
						$recurse--;
					}
					$arr2 = self::folders($dir, $filter, $recurse, $fullpath);
					$arr = array_merge($arr, $arr2);
				}
			}
		}
		closedir($handle);

		asort($arr);
		return $arr;
	}

	private static function getFtpConnection(){
		$host = Configurable::queryConf("ftp", "host");
		$port = Configurable::queryConf("ftp", "port");
		$user = Configurable::queryConf("ftp", "user");
		$pass = Configurable::queryConf("ftp", "password");
		$ftp = FileTransferAbstract::getInstance($host, $port, null, $user, $pass);
		return $ftp;
	}
}

?>