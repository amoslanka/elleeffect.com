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

global $vnl_width, $vnl_nesting, $vnl_template, $vnl_utility, $tpl;
$vnl_width =  (isset($vnl_width))  ? $vnl_width  : vanilla_get_option("vnl_grid_width");
$vnl_nesting =  (isset($vnl_nesting))  ? $vnl_nesting  : vanilla_get_option("vnl_grid_nesting");
$vnl_template = (isset($vnl_template)) ? $vnl_template : vanilla_get_option("vnl_grid_template");
$vnl_utility =  (isset($vnl_utility))  ? $vnl_utility  : vanilla_get_option("vnl_utility_nesting");
// Page-specific overides
//$vnl_width = "yui-d3";
//$vnl_nesting = "yui-gf";
//$vnl_template = "yui-t2";
//$vnl_utility = "yui-bg";

// create a new PHPTAL template object 
$template = new PHPTAL(vanilla_get_template('pages/pages-default.html') );
$template->cleanUpCache();

$tpl["page"] = array(
	"width" => $vnl_width,
	"nesting" => $vnl_nesting,
	"template" => $vnl_template,
	"utility" => $vnl_utility,
	"body_class" => sandbox_body_class(false),
	"bd_class" => $vnl_width." ".$vnl_template
);

get_header();

cfct_loop();

cfct_comments();

get_footer();

// Execute the PHPTAL template
vanilla_output_page($template);

?>