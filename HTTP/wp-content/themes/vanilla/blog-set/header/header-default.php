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
if (CFCT_DEBUG) { cfct_banner(__FILE__); }

// Default YUI Grid settings
global $vnl_width, $vnl_nesting, $vnl_template, $vnl_utility, $tpl;
$vnl_width = get_option("vnl_grid_width");
$vnl_nesting = get_option("vnl_grid_nesting");
$vnl_template = get_option("vnl_grid_template");
$vnl_utility = get_option("vnl_utility_nesting");

$language_attributes = "";
function redir_language_attributes($out){
	global $language_attributes;
	$language_attributes = $out;
	return "";
}
add_filter('language_attributes', 'redir_language_attributes');
language_attributes();

$set = vanilla_get_option('vnl_tpl_set').'-set/';

$ie_cond_stylesheet = "<!--[if lt IE 8]>\n" .
	'<link rel="stylesheet" href="'.get_bloginfo('template_url').'/'.$set.'ie.css" type="text/css" media="screen" charset="utf-8" />' . "\n" .
	"<![endif]-->\n";

$tpl["header"] = array(
	"tpl_file" => "header-default.html",
	"language_attributes" => "", //$language_attributes,
	"content_type" => get_bloginfo('html_type')."; charset=".get_bloginfo('charset'),
	"stylesheet_url" => str_replace("style.css", "", get_bloginfo('stylesheet_url')).$set.'style.css',
	"template_url" => get_bloginfo('template_url').'/'.$set,
	"ie_cond_stylesheet" => $ie_cond_stylesheet
);

?>