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
 * File handling class
 *
 * @access public
 * @author Marco Trognoni, <mtrognoni@elitedivision.it>
 */
import('util.ftp.FileTransferAbstract');
final class File{

    /**
	* Gets the extension of a file name
	*
	* @access public
	* @static
	* @param string $file The file name
	* @return string The file extension
	*/
	public static function getExtensions($file) {
		$dot = strrpos($file, '.') + 1;
		return substr($file, $dot);
	}

    /**
	* Strips the last extension off a file name
	*
	* @access public
	* @static
	* @param string $file The file name
	* @return string The file name without the extension
	*/
	public static function stripExtension($file) {
		return preg_replace('#\.[^.]*$#', '', $file);
	}

    /**
	* Makes file name safe to use
	*
	* @access public
	* @static
	* @param string $file The name of the file [not full path]
	* @return string The sanitised string
	*/
	public static function makeSafe($file) {
		$regex = array('#(\.){2,}#', '#[^A-Za-z0-9\.\_\- ]#', '#^\.#');
		return preg_replace($regex, '', $file);
	}

    /**
	* Copies a file
	*
	* @access public
	* @static
	* @param string $src The path to the source file
	* @param string $dest The path to the destination file
	* @param string $path An optional base path to prefix to the file names
	* @return boolean True on success
	*/
	public static function copy($src, $dest, $path = null){

		if ($path) {
			$src = Path::clean($path.DIRECTORY_SEPARATOR.$src);
			$dest = Path::clean($path.DIRECTORY_SEPARATOR.$dest);
		}

		if(!is_readable($src)){
			throw new FileSystemException("Unable to find: ".$src);
		}

		if(IS_FTP_ENABLED){
			$ftp = self::getFtpConnection();

			if(!file_exists(dirname($dest))){
				Folder::create(dirname($dest));
			}

			$dest = Path::clean(str_replace(WEB_ROOT, Configurable::queryConf("ftp", "root"), $dest), '/');
			if(!$ftp->store($src, $dest)){
				return false;
			}else{
				return true;
			}


		}else{
			throw new FileSystemException("FTP support is disabled. Check configuration");
		}
	}

    /**
	* Delete a file or array of files
	*
	* @access public
	* @static
	* @param mixed $file The file name or an array of file names
	* @return boolean  True on success
	*/
	public static function delete($file){

		if(is_array($file)){
			$files = $file;
		}else{
			$files[] = $file;
		}

		if(IS_FTP_ENABLED){
			$ftp = self::getFtpConnection();
		}

		foreach($files as $file){
			$file = Path::clean($file);

			/* try to chmod file */
			@chmod($file, 0777);

			if(@unlink($file)){
				//Do nothing
			}else if(IS_FTP_ENABLED){
				$file = Path::clean(str_replace(WEB_ROOT, Configurable::queryConf("ftp", "root"), $file), '/');
				if(!$ftp->delete($file)){
					return false;
				}
			}else{
				$filename = basename($file);
				throw new FileSystemException("Unable to delete the file: ".$filename);
			}
		}

		return true;

	}

    /**
	* Moves a file
	*
	* @access public
	* @static
	* @param string $src The path to the source file
	* @param string $dest The path to the destination file
	* @param string $path An optional base path to prefix to the file names
	* @return boolean True on success
	*/
	public static function move($src, $dest, $path = ''){

		if($path){
			$src = Path::clean($path.DIRECTORY_SEPARATOR.$src);
			$dest = Path::clean($path.DIRECTORY_SEPARATOR.$dest);
		}

		if(!is_readable($src) && !is_writable($src)){
			throw new FileSystemException("Unable to find: ".$src);
		}

		if(IS_FTP_ENABLED){
			$ftp = self::getFtpConnection();

			$src = Path::clean(str_replace(WEB_ROOT, Configurable::queryConf("ftp", "root"), $src), '/');
			$dest = Path::clean(str_replace(WEB_ROOT, Configurable::queryConf("ftp", "root"), $dest), '/');

			if(!$ftp->rename($src, $dest)){
				return false;
			}
		}else{
			if(!@rename($src, $dest)){
				$filename = basename($src);
				throw new FileSystemException("Unable to move file: ".$filename);
			}
		}

		return true;

	}

    /**
	* Read the contents of a file
	*
	* @access public
	* @static
	* @param string $filename The full file path
	* @param boolean $incpath Use include path
	* @return mixed Returns file contents or boolean False if failed
	*/
	public static function read($filename, $incpath = false){
		$data = null;
		if (!($fh = fopen($filename, 'rb', $incpath))) {
			throw new FileSystemException("Unable to open file: ".$filename);
		}
		clearstatcache();
		if ($fsize = @ filesize($filename)) {
			$data = fread($fh, $fsize);
		} else {
			$data = '';
			while (!feof($fh)) {
				$data .= fread($fh, 8192);
			}
		}
		fclose($fh);

		return $data;
	}

    /**
	* Write contents to a file
	*
	* @access public
	* @static
	* @param string $file The full file path
	* @param string $buffer The buffer to write
	* @return boolean True on success
	*/
	public static function write($file, $buffer){
		if(!Folder::exists(dirname($file))) {
			Folder::create(dirname($file));
		}
		if(IS_FTP_ENABLED){
			$ftp = self::getFtpConnection();
			$file = Path::clean(str_replace(WEB_ROOT, Configurable::queryConf("ftp", "root"), $file), '/');
			$ret = $ftp->write($file, $buffer);
		}else{
			$file = Path::clean($file);
			$ret = file_put_contents($file, $buffer);
		}

		return $ret;

	}

    /**
	* Moves an uploaded file to a destination folder
	*
	* @access public
	* @static
	* @param string $src The name of the php (temporary) uploaded file
	* @param string $dest The path (including filename) to move the uploaded file to
	* @return boolean True on success
	*/
	public static function upload($src, $dest){
		$ret = false;
		$dest = Path::clean($dest);

		$baseDir = dirname($dest);
		if(!is_dir($baseDir)){
			Folder::create($baseDir);
		}

		if(IS_FTP_ENABLED){
			$ftp = self::getFtpConnection();
			$dest = Path::clean(str_replace(WEB_ROOT, Configurable::queryConf("ftp", "root"), $dest), '/');

			if($ftp->store($src, $dest)){
				$ftp->chmod($dest, 0777);
				$ret = true;
			}else{
				throw new FileSystemException("Unable to copy src: ".basename($src)." to the destination directory");
			}
		}else{
			if(is_writeable($baseDir) && move_uploaded_file($src, $dest)){
				if(Path::setPermissions($dest)){
					$ret = true;
				}else{
					throw new FileSystemException("Unable to set base permission to: ".basename($dest));
				}
			}else{
				throw new FileSystemException("Unable to copy src: ".basename($src)." to the destination directory");
			}
		}

		return $ret;
	}
	
	/**
	* Get mime file
	*
	* @access public
	* @static
	* @param string $filename The full file path
	* @return string information about file
	*/
	public static function getMime ($filename){
		$ext = self::getExtensions($filename);
	    $mime_types = array(
	         "ez" => "application/andrew-inset",
	         "hqx" => "application/mac-binhex40",
	         "cpt" => "application/mac-compactpro",
	         "doc" => "application/msword",
	         "bin" => "application/octet-stream",
	         "dms" => "application/octet-stream",
	         "lha" => "application/octet-stream",
	         "lzh" => "application/octet-stream",
	         "exe" => "application/octet-stream",
	         "class" => "application/octet-stream",
	         "so" => "application/octet-stream",
	         "dll" => "application/octet-stream",
	         "oda" => "application/oda",
	         "pdf" => "application/pdf",
	         "ai" => "application/postscript",
	         "eps" => "application/postscript",
	         "ps" => "application/postscript",
	         "smi" => "application/smil",
	         "smil" => "application/smil",
	         "wbxml" => "application/vnd.wap.wbxml",
	         "wmlc" => "application/vnd.wap.wmlc",
	         "wmlsc" => "application/vnd.wap.wmlscriptc",
	         "bcpio" => "application/x-bcpio",
	         "vcd" => "application/x-cdlink",
	         "pgn" => "application/x-chess-pgn",
	         "cpio" => "application/x-cpio",
	         "csh" => "application/x-csh",
	         "dcr" => "application/x-director",
	         "dir" => "application/x-director",
	         "dxr" => "application/x-director",
	         "dvi" => "application/x-dvi",
	         "spl" => "application/x-futuresplash",
	         "gtar" => "application/x-gtar",
	         "hdf" => "application/x-hdf",
	         "js" => "application/x-javascript",
	         "skp" => "application/x-koan",
	         "skd" => "application/x-koan",
	         "skt" => "application/x-koan",
	         "skm" => "application/x-koan",
	         "latex" => "application/x-latex",
	         "nc" => "application/x-netcdf",
	         "cdf" => "application/x-netcdf",
	         "sh" => "application/x-sh",
	         "shar" => "application/x-shar",
	         "swf" => "application/x-shockwave-flash",
	         "sit" => "application/x-stuffit",
	         "sv4cpio" => "application/x-sv4cpio",
	         "sv4crc" => "application/x-sv4crc",
	         "tar" => "application/x-tar",
	         "tcl" => "application/x-tcl",
	         "tex" => "application/x-tex",
	         "texinfo" => "application/x-texinfo",
	         "texi" => "application/x-texinfo",
	         "t" => "application/x-troff",
	         "tr" => "application/x-troff",
	         "roff" => "application/x-troff",
	         "man" => "application/x-troff-man",
	         "me" => "application/x-troff-me",
	         "ms" => "application/x-troff-ms",
	         "ustar" => "application/x-ustar",
	         "src" => "application/x-wais-source",
	         "xhtml" => "application/xhtml+xml",
	         "xht" => "application/xhtml+xml",
	         "zip" => "application/zip",
	         "au" => "audio/basic",
	         "snd" => "audio/basic",
	         "mid" => "audio/midi",
	         "midi" => "audio/midi",
	         "kar" => "audio/midi",
	         "mpga" => "audio/mpeg",
	         "mp2" => "audio/mpeg",
	         "mp3" => "audio/mpeg",
	         "aif" => "audio/x-aiff",
	         "aiff" => "audio/x-aiff",
	         "aifc" => "audio/x-aiff",
	         "m3u" => "audio/x-mpegurl",
	         "ram" => "audio/x-pn-realaudio",
	         "rm" => "audio/x-pn-realaudio",
	         "rpm" => "audio/x-pn-realaudio-plugin",
	         "ra" => "audio/x-realaudio",
	         "wav" => "audio/x-wav",
	         "pdb" => "chemical/x-pdb",
	         "xyz" => "chemical/x-xyz",
	         "bmp" => "image/bmp",
	         "gif" => "image/gif",
	         "ief" => "image/ief",
	         "jpeg" => "image/jpeg",
	         "jpg" => "image/jpeg",
	         "jpe" => "image/jpeg",
	         "png" => "image/png",
	         "tiff" => "image/tiff",
	         "tif" => "image/tif",
	         "djvu" => "image/vnd.djvu",
	         "djv" => "image/vnd.djvu",
	         "wbmp" => "image/vnd.wap.wbmp",
	         "ras" => "image/x-cmu-raster",
	         "pnm" => "image/x-portable-anymap",
	         "pbm" => "image/x-portable-bitmap",
	         "pgm" => "image/x-portable-graymap",
	         "ppm" => "image/x-portable-pixmap",
	         "rgb" => "image/x-rgb",
	         "xbm" => "image/x-xbitmap",
	         "xpm" => "image/x-xpixmap",
	         "xwd" => "image/x-windowdump",
	         "igs" => "model/iges",
	         "iges" => "model/iges",
	         "msh" => "model/mesh",
	         "mesh" => "model/mesh",
	         "silo" => "model/mesh",
	         "wrl" => "model/vrml",
	         "vrml" => "model/vrml",
	         "css" => "text/css",
	         "html" => "text/html",
	         "htm" => "text/html",
	         "asc" => "text/plain",
	         "txt" => "text/plain",
	         "rtx" => "text/richtext",
	         "rtf" => "text/rtf",
	         "sgml" => "text/sgml",
	         "sgm" => "text/sgml",
	         "tsv" => "text/tab-seperated-values",
	         "wml" => "text/vnd.wap.wml",
	         "wmls" => "text/vnd.wap.wmlscript",
	         "etx" => "text/x-setext",
	         "xml" => "text/xml",
	         "xsl" => "text/xml",
	         "mpeg" => "video/mpeg",
	         "mpg" => "video/mpeg",
	         "mpe" => "video/mpeg",
	         "qt" => "video/quicktime",
	         "mov" => "video/quicktime",
	         "mxu" => "video/vnd.mpegurl",
	         "avi" => "video/x-msvideo",
	         "movie" => "video/x-sgi-movie",
	         "ice" => "x-conference-xcooltalk",
	         "xls" => "application/vnd.ms-excel",
	         "doc" => "application/vnd.ms-word",
	         "pps" => "application/vnd.ms-powerpoint",
	         "ppt" => "application/vnd.ms-powerpoint"
	      );
	    
	    if(!$m = $mime_types[$ext]){
			if(function_exists("mime_content_type")){
				$m = mime_content_type($filename);
			}
			// if PECL installed
			else if(function_exists("finfo_open")){
				$finfo = finfo_open(FILEINFO_MIME);
				$m = finfo_file($finfo, $filename);
				finfo_close($finfo);
			}
			// try shell
			else{
				if(strstr($_SERVER[HTTP_USER_AGENT], "Windows")){
					return "";
				}
				if(strstr($_SERVER[HTTP_USER_AGENT], "Macintosh")){
					$m = trim(exec('file -b --mime '.escapeshellarg($filename)));
				}else{
					$m = trim(exec('file -bi '.escapeshellarg($filename)));
				}
			}
			$m = split(";", $m);
			
	        return trim($m[0]);
	    }
	    else return $m;
	}

    /**
	* Wrapper for the standard file_exists function
	*
	* @access public
	* @static
	* @param string $file File path
	* @return boolean True if path is a file
	*/
	public static function exists($file){
		return is_file(Path::clean($file));
	}

	/**
	* Wrapper for the standard file_get_contents function
	*
	* @access public
	* @static
	* @param string $file File path
	* @return file content
	*/
	public static function getContent($file){
		return file_get_contents($file);
	}

    /**
	* Returns the name, sans any path
	*
	* @access public
	* @static
	* param string $file File path
	* @return string filename
	*/
	public static function getName($file) {
		$slash = strrpos($file, DS) + 1;
		return substr($file, $slash);
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