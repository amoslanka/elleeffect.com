<?php

// Include files
	include(CFCT_PATH.'_hybrid/admin/theme-settings-admin.php');

// Add actions
	add_action('admin_menu', 'hybrid_add_pages');
	add_action('admin_head', 'hybrid_admin_enqueue_style');

/**
* hybrid_add_pages()
* Gets all theme admin menu pages
*
* @since 0.2
*/
function hybrid_add_pages() {
	add_theme_page(__('Hybrid Theme Settings','hybrid'), __('Hybrid Settings','hybrid'), 10, 'theme-settings.php', 'hybrid_theme_page');
}

/**
* hybrid_admin_css()
* Adds admin CSS
*
* @since 0.2
*/
function hybrid_admin_enqueue_style() {

	if(function_exists('wp_enqueue_style')) :
		wp_enqueue_style('hybrid_admin_css',HYBRID_CSS . '/theme-settings.css', false, false, 'screen');
		wp_print_styles(array('hybrid_admin_css'));
	else :
		echo '<link rel="stylesheet" href="' . HYBRID_CSS . '/theme-settings.css?ver=0.2" type="text/css" media="screen" />';
		echo "\n";
	endif;
}
?>