<?php
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

	if(is_plugin_active('cp-press-onepage'.DIRECTORY_SEPARATOR.'cp-press-onepage.php')){
		register_sidebar(array(
				'name' => 'calendar',
			)
		);
		register_sidebar(array(
				'name' => 'twitter',
			)
		);

		register_nav_menus(
			array(
				'header-menu'	=> 'Header Menu',
				'splash-menu'	=> 'Splash Menu'
			)
		);
		
		wp_register_script( 'browser', get_template_directory_uri().'/js/browser.js');
		wp_register_script( 'mobile', get_template_directory_uri().'/js/mobile.js');
		wp_register_script( 'transit', get_template_directory_uri().'/js/transit.js');
		wp_register_script( 'lazyload', get_template_directory_uri().'/js/lazyload.js');
		wp_register_script( 'scrollto', get_template_directory_uri().'/js/scrollto.js');
		wp_register_script( 'nav', get_template_directory_uri().'/js/nav.js');
		wp_register_script( 'cp-press', get_template_directory_uri().'/js/cp-press.js', false, '1.0.0');
		wp_register_script( 'cp-press-carousel', get_template_directory_uri().'/js/cp-press-carousel.js');
		wp_register_style( 'cp-press', get_template_directory_uri().'/css/cp-press.css', false, '1.0.0', 'all');
		
		add_action('wp_enqueue_scripts', function(){
			wp_enqueue_style('cp-press');
			wp_enqueue_script('browser');
			wp_enqueue_script('mobile');
			wp_enqueue_script('transit');
			wp_enqueue_script('lazyload');
			wp_enqueue_script('scrollto');
			wp_enqueue_script('nav');
			wp_enqueue_script('cp-press');
			wp_enqueue_script('cp-press-carousel');
		});
		
		add_theme_support('post-thumbnails');

		require_once WP_PLUGIN_DIR.DIRECTORY_SEPARATOR.'cp-press-onepage'.DIRECTORY_SEPARATOR.'cp-press-onepage.php';
		add_filter('cp-columns', function($div, $span, $col, $post){
			$grid = array(5,5,2);
			if($post->post_name == 'appuntamenti' || $post->post_name == 'news'){
				$div = preg_replace("/col-(md|xs|lg)-\d/", "col-$1-".$grid[$col], $div);
			}

			return $div;
		}, 10, 4);

		add_filter('cp-content-section', function($content, $post){
			$n_content = '';
			if($post->post_name == 'appuntamenti' || $post->post_name == 'news'){
				$n_content .= '<div class="cp-col-wrapper">';
				$n_content .= $content;
				$n_content .= '</div>';
			}else{
				$n_content = $content;
			}
			return $n_content;
		}, 10, 2);

	}else{
		if(!is_admin())
			wp_die('these theme will only work with cp-press-onepage plugin!!');
	}
?>
