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

$tpl["excerpt"] = array(
	"tpl_file" => "search.html"
);

$author = sprintf(__('<span class="by">By</span> %s', 'carrington'), '<a class="url fn" href="'.get_author_link(false, get_the_author_ID(), $authordata->user_nicename).'" title="View all posts by ' . attribute_escape($authordata->display_name) . '">'.get_the_author().'</a>');

$tpl["entries"][] = array(
	"id" => get_the_ID(),
	"class" => sandbox_post_class(false),
	"permalink" => get_permalink(),
	"author" => $author,
	"title_attribute" => the_title_attribute('echo=0'),
	"title" => the_title("", "", false),
	"date_time" => get_the_time('Y-m-d\TH:i:sO'),
	"date" => get_the_time('F j, Y'),
	"content" => get_the_excerpt()
);
?>