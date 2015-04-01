<?php
namespace CpPressOnePage;
\import('util.Registry');
class CpOnePage {
	const PHP_FILE_EXTENSION = "php";
	public static $instances = array();
	private static $autoloadLibClassMap = array(
		'global' => array(
			'Path'				=> "cp-press-onepage/framework/util/filesystem/Path.php",
			'Folder'			=> "cp-press-onepage/framework/util/filesystem/Folder.php",
			'File'				=> "cp-press-onepage/framework/util/filesystem/File.php",
			'Dumper'			=> "cp-press-onepage/framework/util/Dumper.php",
			'String'			=> "cp-press-onepage/framework/util/String.php",
			'Set'				=> "cp-press-onepage/framework/util/Set.php",
			'Object'			=> "cp-press-onepage/framework/util/Object.php",
			'Observer'			=> "cp-press-onepage/framework/util/Observer.php",
			'Observable'		=> "cp-press-onepage/framework/util/Observable.php",
			'Dispatcher'		=> "cp-press-onepage/framework/util/Dispatcher.php"
		),
		'CpPressOnePage' => array(
			'Controller'		=> "cp-press-onepage/framework/controller/Controller.php"
		)
	);

	public static $namespaces = array(
		'global'			=> 'cp-press-onepage/framework',
		'CpPressOnePage'	=> 'cp-press-onepage/framework',
	);

	public static function install(){
		if(version_compare(PHP_VERSION, '5.3.0', '<')){
			wp_die('CpPress Plugin requires php version 5.3.0 or higher');
		}
		self::dispatch('Admin', 'install');

	}

	public static function start(){
		//self::dispatch('Admin', 'install');
		add_filter('show_admin_bar', '__return_false');
		add_action('init', function(){
			CpOnePage::setup();
		});
		add_action('wp_enqueue_scripts', function(){
			CpOnePage::enqueue_assets();
		});
		add_action('admin_head', function(){
			CpOnePage::dispatch('Admin', 'favicon');
		});
		add_action('login_head', function(){
			CpOnePage::dispatch('Admin', 'favicon');
		});
		add_action('admin_init', function(){
			CpOnePage::dispatch('Admin', 'admin_init', func_get_args());
		});
		add_action('admin_menu', function(){
			CpOnePage::dispatch('Admin', 'admin_menu', func_get_args());
		});
		add_action('add_meta_boxes', function(){
			CpOnePage::dispatch('Admin', 'add_meta_boxes', func_get_args());
		});
		add_action('save_post', function(){
			CpOnePage::dispatch('Admin', 'save_post', func_get_args());
		}, 10, 3);
		add_action('admin_enqueue_scripts', function(){
			CpOnePage::dispatch('Admin', 'admin_enqueue_scripts', func_get_args());
		});
		add_action('plugins_loaded', function(){
			CpOnePage::include_widgets();
		}, 1);
		add_action('widgets_init', function(){
			CpOnePage::setup_widgets();
		});
		add_shortcode('cp_content_type', function($attr, $content){
			return CpOnePage::dispatch_template('AdminContentType', 'shortcode', array('attr' => $attr, 'content' => $content));
		});
		$filtersFile = get_template_directory().DS.'view'.DS.'helpers'.DS.'Filters.php';
		if(!file_exists($filtersFile)){
			$filtersFile = WPCHOP.DS.'view'.DS.'helpers'.DS.'Filters.php';
		}
		require_once $filtersFile;
		new Filters();
	}

	public static function setup() {
		load_plugin_textdomain('cp-press-onepage', false, plugin_basename(__FILE__).DS.'loaclization');
		$sectionArgs = array(
			'public'			=> true,
			'has_archive'		=> false,
			'taxonomies'		=> array(),
			'supports'			=> array('title'),
			'menu_icon'			=> 'dashicons-exerpt-view',
			'show_in_nav_menus'	=> true,
			'labels'			=> array(
				'name'					=> 'Sections',
				'singular_bane'			=> 'Section',
				'add_new'				=> 'Add New Section',
				'add_new_item'			=> 'Add New Section',
				'edit_item'				=> 'Edit Section',
				'new_item'				=> 'New Section',
				'all_item'				=> 'All Sections',
				'view_item'				=> 'View Section',
				'search_item'			=> 'Search Section',
				'not_found'				=> 'No sections found',
				'not_found_in_trash'	=> 'No sections found in Trash',
				'parent_item_col'		=> '',
				'menu_name'				=> 'Sections'
			)
		);
		register_post_type('section', $sectionArgs);
		wp_register_style( 'bootstrap', plugins_url('/css/bootstrap/css/bootstrap.css', __FILE__), false, '', 'all');
		wp_register_style( 'font-awesome', plugins_url('/css/font-awesome/css/font-awesome.css', __FILE__), false, '', 'all');
		wp_register_style( 'entypo-icon', plugins_url('css/entypo-icon-font/entypo-icon-font.css', __FILE__));
		wp_register_style( 'animate', plugins_url('css/animate.css', __FILE__));
		wp_register_script( 'bootstrap', plugins_url('js/bootstrap.js', __FILE__));
		wp_register_script( 'cp-press', plugins_url('js/cp-press.js', __FILE__));
		if(is_admin()){
			wp_register_script( 'jquery-ui', plugins_url('js/jquery-ui.js', __FILE__), false, '1.10.4');
			wp_register_script( 'form-validator', plugins_url('js/form-validator.js', __FILE__));
			wp_register_script( 'cp-press-dragbg', plugins_url('js/cp-press-dragbg.js', __FILE__));
			wp_register_script( 'cp-press-admin', plugins_url('js/cp-press-admin.js', __FILE__), false, '1.0.0');
			wp_register_style( 'jquery-ui', plugins_url('css/jquery-ui-smoothness.css', __FILE__));
			wp_register_style( 'cp-press-admin', plugins_url('css/cp-press-admin.css', __FILE__));
		}


	}

	public static function setup_widgets(){
		register_widget('\CpPressOnePage\CpCalendarWidget');
		register_widget('\CpPressOnePage\CpSocialWidget');
	}

	public static function include_widgets(){
		require_once(ABSPATH.DS.PLUGINDIR.DS.WPCHOP_RELATIVE.'widgets'.DS.'CpCalendarWidget.php');
		require_once(ABSPATH.DS.PLUGINDIR.DS.WPCHOP_RELATIVE.'widgets'.DS.'CpSocialWidget.php');
	}

	public static function enqueue_assets(){
		if ( is_singular() && get_option( 'thread_comments' ) )
			wp_enqueue_script( 'comment-reply' );
		self::dispatch('Assets', 'styles');
		self::dispatch('Assets', 'javascripts');
	}

	public static function dispatch($app, $action='start', $params=array(), $scope = 'CpPressOnePage'){
		if(!isset(self::$instances['Dispatcher'])){
			self::$instances['Dispatcher'] = new \Dispatcher();
		}
		return self::$instances['Dispatcher']->dispatch($app, $action, $params, false, $scope);
	}

	public static function dispatch_template($app, $action, $params=array(), $scope = 'CpPressOnePage'){
		if(!isset(self::$instances['Dispatcher'])){
			self::$instances['Dispatcher'] = new \Dispatcher();
		}
		$res = self::$instances['Dispatcher']->dispatch($app, $action, $params, true, $scope);

		return $res;
	}

	public static function dispatch_method($app, $action, $params=array(), $scope = 'CpPressOnePage'){
		return self::dispatch_template($app, $action, $params, $scope );
	}


	public static function import($libs, $ns='', $scope=''){
		if($scope == '')
			$scope = WPCHOP_RELATIVE;
		if($ns == '')
			$ns = 'global';
		self::addLibs($libs, $ns, $scope);
	}

	protected static function addLibs($libs, $ns, $scope){
		$import = array();
		$libParts = explode('.', $libs);
		$path = '';
		foreach($libParts as $part){
			if($part != '*'){
				$path .= $part.DS;
			}
		}
		if(preg_match('/\.\*$/', $libs)){
			$abspath = ABSPATH.PLUGINDIR.DS.$scope.DS.$path;
			$package = \Folder::files($abspath, true, false, '.php');
			foreach($package as $packageFile){
				$pkg = array_pop(explode('/', $packageFile));
				if(!isset(self::$autoloadLibClassMap[$ns][\File::stripExtension($pkg)]))
					$import[$ns][\File::stripExtension($pkg)] = $path.$packageFile;
			}
		}else{
			$abspath = ABSPATH.PLUGINDIR.DS.$scope.substr($path, 0, -1);
			$lib = array_pop($libParts);
			if(!isset(self::$autoloadLibClassMap[$ns][$lib]))
				$import[$ns][$lib] = $abspath.'.'.self::PHP_FILE_EXTENSION;
		}
		if(!empty($libs)){
			self::$autoloadLibClassMap = array_merge_recursive(self::$autoloadLibClassMap, $import);
		}
	}

	public static function autoload($className){
		$scope = 'global';
		if(preg_match("/(.*)\\\(.*)/", $className, $match)){
			$scope = $match[1];
			$className = ($match[2]);
		}
		if(isset(self::$autoloadLibClassMap[$scope][$className])){
			require_once(self::$autoloadLibClassMap[$scope][$className]);
			return true;
		}
		return false;
	}

}

?>
