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
