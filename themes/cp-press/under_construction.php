
<?php 
/*
 Template Name: UnderConstruction
*/
	$current_user = wp_get_current_user();
	if ($current_user->roles[0] != 'administrator'){
		\CpPressOnePage\CpOnePage::dispatch('index', 'under_construction');
	}else{
		// Override global query object
		get_template_part('onepage');
	}
?>