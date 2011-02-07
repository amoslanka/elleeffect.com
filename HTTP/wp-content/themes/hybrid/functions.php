<?php

// Load theme textdomain
	load_theme_textdomain('hybrid');

// Define constant paths (PHP files)
	define(HYBRID_DIR, TEMPLATEPATH);
	define(HYBRID_LIBRARY, TEMPLATEPATH . '/library');
	define(HYBRID_ADMIN, HYBRID_LIBRARY . '/admin');
	define(HYBRID_EXTENSIONS, HYBRID_LIBRARY . '/extensions');
	define(HYBRID_FUNCTIONS, HYBRID_LIBRARY . '/functions');
	define(HYBRID_LEGACY, HYBRID_LIBRARY . '/legacy');
	define(HYBRID_WIDGETS, HYBRID_LIBRARY . '/widgets');

// Define constant paths (other file types)
	$hybrid_dir = get_bloginfo('template_directory');
	define(HYBRID_IMAGES, $hybrid_dir . '/images');
	define(HYBRID_CSS, $hybrid_dir . '/library/css');
	define(HYBRID_JS, $hybrid_dir . '/library/js');
	define(HYBRID_SWF, $hybrid_dir . '/library/swf');

// Load required files
	require_once(HYBRID_FUNCTIONS . '/breadcrumbs.php');
	require_once(HYBRID_FUNCTIONS . '/comments.php');
	require_once(HYBRID_FUNCTIONS . '/deprecated.php');
	require_once(HYBRID_FUNCTIONS . '/filters.php');
	require_once(HYBRID_FUNCTIONS . '/functions.php');
	require_once(HYBRID_FUNCTIONS . '/get-the-image.php');
	require_once(HYBRID_FUNCTIONS . '/get-the-video.php');
	require_once(HYBRID_FUNCTIONS . '/hooks.php');
	require_once(HYBRID_FUNCTIONS . '/media.php');
	require_once(HYBRID_FUNCTIONS . '/primary.php');
	require_once(HYBRID_FUNCTIONS . '/secondary.php');
	require_once(HYBRID_FUNCTIONS . '/template-functions.php');
	require_once(HYBRID_FUNCTIONS . '/widgets.php');

// Check for legacy (pre-2.7) functions
	hybrid_legacy_functions();

// Load admin files
	if(is_admin()) :
		require_once(HYBRID_ADMIN . '/theme-settings.php');
		require_once(HYBRID_ADMIN . '/meta-box.php');
	endif;

// Get theme settings
	$hybrid_settings = get_option('hybrid_theme_settings');

?>