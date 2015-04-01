<div class="navbar navbar-default navbar-static-top" role="navigation">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="<?= home_url(); ?>"><?php bloginfo('name') ?></a>
		</div>
		<div class="navbar-collapse collapse">

			<?php
			$menu_options = array(
				'theme_location'  => $menu,
				'menu'            => "",
				'container'       => "",
				'container_class' => "",
				'container_id'    => "",
				'menu_class'      => null,
				'menu_id'         => null,
				'echo'            => true,
				'before'          => "",
				'after'           => "",
				'link_before'     => "",
				'link_after'      => "",
				'items_wrap'      => apply_filters("cp_menu_wrap",'<ul id="navigation" class="nav navbar-nav navbar-right scrollto">%3$s</ul>'),
				'walker'		  => $walker,
				'depth'           => 0,
				'pe_type'		  => "default"
			);
			wp_nav_menu($menu_options);
			?>

		</div><!--/.nav-collapse -->
	</div><!--/.container -->
</div>

