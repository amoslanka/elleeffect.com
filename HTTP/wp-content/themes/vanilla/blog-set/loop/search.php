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

global $tpl;

$search_title = false;
$search_message = false;

if (have_posts()) {
	while (have_posts()) {
		the_post();
		cfct_excerpt();
	}
} else {

	$search_title = __('Nothing Found', 'thematic');
	$search_message = __('Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'thematic');
	
	cfct_form('search');
}

$tpl["loop"] = array(
	"tpl_file" => "search.html",
	"have_posts" => (have_posts()) ? 1 : 0,
	"search_title" => $search_title,
	"search_message" =>  $search_message
);

?>