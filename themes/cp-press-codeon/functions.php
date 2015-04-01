<?php
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

	if(is_plugin_active('cp-press-onepage'.DIRECTORY_SEPARATOR.'cp-press-onepage.php')){
		register_sidebar(array(
				'name' => 'maps',
			)
		);
		register_sidebar(array(
				'name' => 'contact-form',
			)
		);
		register_sidebar(array(
				'name' => 'footer-nav',
				'class' => 'footer-nav',
				'before_widget' => '',
				'after_widget'  => '',
				'before_title'  => '',
				'after_title'   => ''
			)
		);
		register_nav_menus(
			array(
				'header-menu'	=> 'Header Menu',
				'splash-menu'	=> 'Splash Menu'
			)
		);
		add_theme_support('post-thumbnails');
		wp_register_script( 'bootstrap-hover-dropdown', get_template_directory_uri().'/js/lib/bootstrap-hover-dropdown.min.js');
		wp_register_script( 'easypiechart', get_template_directory_uri().'/js/lib/easypiechart.js');
		wp_register_script( 'jqBootstrapValidation', get_template_directory_uri().'/js/lib/jqBootstrapValidation.js');
		wp_register_script( 'jquery.countdown', get_template_directory_uri().'/js/lib/jquery.countdown.js');
		wp_register_script( 'jquery.counterup.min', get_template_directory_uri().'/js/lib/jquery.counterup.min.js');
		wp_register_script( 'jquery.easing.1.3.min', get_template_directory_uri().'/js/lib/jquery.easing.1.3.min.js');
		wp_register_script( 'jquery.flexslider-min', get_template_directory_uri().'/js/lib/jquery.flexslider-min.js');
		wp_register_script( 'jquery.mixitup.min', get_template_directory_uri().'/js/lib/jquery.mixitup.min.js');
		wp_register_script( 'jquery.nicescroll.min', get_template_directory_uri().'/js/lib/jquery.nicescroll.min.js');
		wp_register_script( 'jquery.stellar.min', get_template_directory_uri().'/js/lib/jquery.stellar.min.js');
		wp_register_script( 'jquery.sticky', get_template_directory_uri().'/js/lib/jquery.sticky.js');
		wp_register_script( 'owl.carousel.min', get_template_directory_uri().'/js/lib/owl.carousel.min.js');
		wp_register_script( 'waypoints.min', get_template_directory_uri().'/js/lib/waypoints.min.js');
		wp_register_script( 'wow.min', get_template_directory_uri().'/js/lib/wow.min.js');
		wp_register_script( 'contact_me', get_template_directory_uri().'/js/contact_me.js');
		wp_register_script( 'cp-press-codeon', get_template_directory_uri().'/js/cp-press-codeon.js');
		wp_register_style( 'flexslider', get_template_directory_uri().'/css/flexslider.css');
		wp_register_style( 'owl.carousel', get_template_directory_uri().'/css/owl.carousel.css');
		wp_register_style( 'owl.theme', get_template_directory_uri().'/css/owl.theme.css');
		add_action('wp_enqueue_scripts', function(){
			wp_enqueue_script( 'bootstrap-hover-dropdown');
			wp_enqueue_script( 'easypiechart');
			wp_enqueue_script( 'jqBootstrapValidation');
			wp_enqueue_script( 'jquery.countdown');
			wp_enqueue_script( 'jquery.counterup.min');
			wp_enqueue_script( 'jquery.easing.1.3.min');
			wp_enqueue_script( 'jquery.flexslider-min');
			wp_enqueue_script( 'jquery.mixitup.min');
			wp_enqueue_script( 'jquery.nicescroll.min');
			wp_enqueue_script( 'jquery.stellar.min');
			wp_enqueue_script( 'jquery.sticky');
			wp_enqueue_script( 'owl.carousel.min');
			wp_enqueue_script( 'waypoints.min');
			wp_enqueue_script( 'wow.min');
			wp_enqueue_script( 'contact_me');
			wp_enqueue_script( 'cp-press-codeon');
			wp_enqueue_style( 'flexslider');
			wp_enqueue_style( 'owl.carousel');
			wp_enqueue_style( 'owl.theme');
		});
		
		require_once WP_PLUGIN_DIR.DIRECTORY_SEPARATOR.'cp-press-onepage'.DIRECTORY_SEPARATOR.'cp-press-onepage.php';

	}else{
		if(!is_admin())
			wp_die('these theme will only work with cp-press-onepage plugin!!');
	}
?>
