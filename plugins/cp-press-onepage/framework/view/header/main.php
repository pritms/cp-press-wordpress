<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html class="desktop">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<meta name="format-detection" content="telephone=no" />

<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<link rel="icon" type="image/png" href="<?= $favicon ?>">
<title>
<?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf('Pagina %s', max( $paged, $page ) );

	?>
</title>
<?php wp_head(); ?>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/site.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<? \CpPressOnePage\CpOnePage::dispatch('Assets', 'inline_styles'); ?>
<!--[if lt IE 9]>
  <script type="text/javascript" src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<!--[if lt IE 9]>
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'template_directory' ); ?>/css/ie8.css" />
<![endif]-->
</head>
<body <?php if(is_page() || is_single()) : ?> class="page"<?php endif; ?>>
	<div id="site-wrapper" style="opacity: 0; visibility: hidden;">
		<div class="head-wrapper">
			<div class="wpchop-menu-sticky" id="dynamic-menu">

				<!--main bar-->
				<div class="menu-container">
					<header class="row">
						<div class="col-md-12">
							<?php if(!is_smartphone()): ?>
							<!-- logo -->
							<?php
								\CpPressOnePage\CpOnePage::dispatch('header', 'logo');
							?>
							<!--main navigation-->
							<nav class="wpchop-menu-main wpchop-menu-main-dynamic">
								<?php
									\CpPressOnePage\CpOnePage::dispatch('menu', 'main');
								?>

							</nav>
							<?php else: ?>
							<nav class="wpchop-menu-main wpchop-menu-main-dynamic">
								<div class="menu-toggle">
									<b class="icon-menu"></b>
								</div>
								<?php
									\CpPressOnePage\CpOnePage::dispatch('menu', 'main');
								?>
							</nav>
							<? endif; ?>

						</div>
					</header><!-- end header  -->
				</div><!--end container-->
			</div><!--end sticky bar-->

			</div> <!-- end head wrapper -->
