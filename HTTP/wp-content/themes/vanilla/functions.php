<?php

// This file is part of the Carrington Theme for WordPress
// http://carringtontheme.com
//
// Copyright (c) 2008 Crowd Favorite, Ltd. All rights reserved.
// http://crowdfavorite.com
//
// Released under the GPL license
// http://www.opensource.org/licenses/gpl-license.php
//
// **********************************************************************
// This program is distributed in the hope that it will be useful, but
// WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. 
// **********************************************************************

if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) { die(); }

//	ini_set('display_errors', '1');
//	ini_set('error_reporting', E_ALL);

load_theme_textdomain('carrington');

define('CFCT_DEBUG', false);
define('CFCT_PATH', trailingslashit(TEMPLATEPATH));
define('CFCT_HOME_LIST_LENGTH', 5);
define('CFCT_HOME_LATEST_LENGTH', 250);

define('VANILLA_DEBUG', false);

$cfct_options = array(
	'cfct_home_column_1_cat'
	, 'cfct_home_column_1_content'
	, 'cfct_latest_limit_1'
	, 'cfct_list_limit_1'
	, 'cfct_home_column_2_cat'
	, 'cfct_home_column_2_content'
	, 'cfct_latest_limit_2'
	, 'cfct_list_limit_2'
	, 'cfct_home_column_3_cat'
	, 'cfct_home_column_3_content'
	, 'cfct_latest_limit_3'
	, 'cfct_list_limit_3'
	, 'cfct_about_text'
	, 'cfct_ajax_load'
	, 'cfct_credit'
	, 'cfct_posts_per_archive_page'
	, 'cfct_wp_footer'
);

// master template variable used by PHPTAL
$tpl = array(
	"base_path" => CFCT_PATH,
	"child_path" => trailingslashit(STYLESHEETPATH)
);

/* ========================================
   PHPTAL
   ======================================== */

define('PHPTAL_PHP_CODE_DESTINATION', CFCT_PATH."cache/");
require_once(CFCT_PATH.'PHPTAL.php');

/* ========================================
   Carrington
   ======================================== */

include_once(CFCT_PATH.'_carrington/admin.php');
include_once(CFCT_PATH.'_carrington/templates.php');
include_once(CFCT_PATH.'_carrington/utility.php');
include_once(CFCT_PATH.'_carrington/ajax-load.php');
include_once(CFCT_PATH.'_carrington/sandbox.php');

/* ========================================
   Vanilla
   ======================================== */
   
include_once(CFCT_PATH.'_vanilla/core.php');
include_once(CFCT_PATH.'_vanilla/grid.php');
include_once(CFCT_PATH.'_vanilla/blocks.php');
include_once(CFCT_PATH.'_vanilla/widgets.php');
include_once(CFCT_PATH.'_vanilla/hooks-filters.php');
include_once(CFCT_PATH.'_vanilla/minify-html.php');
include_once(CFCT_PATH.'_vanilla/phptal-custom.php');

/* ========================================
   Custom Widgets
   ======================================== */

include_once(CFCT_PATH.'_custom-widgets/custom_widgets.php');

/* ========================================
   Hybrid
   ======================================== */

define('HYBRID_IMAGES', CFCT_PATH.'images');
define('HYBRID_CSS', CFCT_PATH.'css');
define('HYBRID_JS', CFCT_PATH.'js');
define('HYBRID_SWF', CFCT_PATH.'swf');

include_once(CFCT_PATH.'_hybrid/breadcrumbs.php');
include_once(CFCT_PATH.'_hybrid/comments.php');
include_once(CFCT_PATH.'_hybrid/deprecated.php');
include_once(CFCT_PATH.'_hybrid/filters.php');
include_once(CFCT_PATH.'_hybrid/functions.php');
include_once(CFCT_PATH.'_hybrid/get-the-image.php');
include_once(CFCT_PATH.'_hybrid/get-the-video.php');
include_once(CFCT_PATH.'_hybrid/hooks.php');
include_once(CFCT_PATH.'_hybrid/media.php');
include_once(CFCT_PATH.'_hybrid/primary.php');
include_once(CFCT_PATH.'_hybrid/secondary.php');
include_once(CFCT_PATH.'_hybrid/template-functions.php');
include_once(CFCT_PATH.'_hybrid/widgets.php');

if(is_admin()) :
	include_once(CFCT_PATH.'_hybrid/admin/theme-settings.php');
	include_once(CFCT_PATH.'_hybrid/admin/meta-box.php');
endif;

$hybrid_settings = get_option('hybrid_theme_settings');

/* ========================================
   Tarski
   ======================================== */

// Path constants
define('TARSKICLASSES', CFCT_PATH.'_tarski/classes');
define('TARSKIHELPERS', CFCT_PATH.'_tarski/helpers');
define('TARSKIDISPLAY', CFCT_PATH.'_tarski/display');
define('TARSKICACHE', CFCT_PATH.'_tarski/cache');
define('TARSKIVERSIONFILE', 'http://tarskitheme.com/version.atom');

// Core library files
//require_once(CFCT_PATH.'_tarski/core.php');
//require_once(CFCT_PATH.'_tarski/classes/options.php');
//require_once(CFCT_PATH.'_tarski/classes/asset.php');

// Admin library files
//if (is_admin()) {
//	require_once(CFCT_PATH.'_tarski/classes/version.php');
//	require_once(CFCT_PATH.'_tarski/classes/page_select.php');
//	require_once(CFCT_PATH.'_tarski/helpers/admin_helper.php');
//}

// Various helper libraries
//require_once(CFCT_PATH.'_tarski/helpers/template_helper.php');
//require_once(CFCT_PATH.'_tarski/helpers/content_helper.php');
//require_once(CFCT_PATH.'_tarski/helpers/author_helper.php');
//require_once(CFCT_PATH.'_tarski/helpers/tag_helper.php');
//require_once(CFCT_PATH.'_tarski/helpers/widgets.php');

// API files
//require_once(CFCT_PATH.'_tarski/api/hooks.php');
//require_once(CFCT_PATH.'_tarski/api/constants_helper.php');
//include_once(CFCT_PATH.'_tarski/api/deprecated.php');

// Launch
//require_once(CFCT_PATH.'_tarski/launcher.php');

cfct_load_plugins();

function cfct_init() {
	cfct_admin_request_handler();
	if (cfct_get_option('cfct_ajax_load') == 'yes') {
		cfct_ajax_load();
	}
}
add_action('init', 'cfct_init');

/* ========================================
   Header JS Additions
   ======================================== */

wp_enqueue_script('jquery');
wp_enqueue_script('carrington', get_bloginfo('template_directory').'/js/carrington.js', 'jquery', '1.0');

/* ========================================
   Footer Additions
   ======================================== */

function cfct_wp_footer() {
	echo get_option('cfct_wp_footer');
	cfct_get_option('cfct_ajax_load') == 'no' ? $ajax_load = 'false' : $ajax_load = 'true';
	echo '
<script type="text/javascript">
var CFCT_URL = "'.get_bloginfo('url').'";
var CFCT_AJAX_LOAD = '.$ajax_load.';
</script>
	';
}
add_action('wp_footer', 'cfct_wp_footer');
?>