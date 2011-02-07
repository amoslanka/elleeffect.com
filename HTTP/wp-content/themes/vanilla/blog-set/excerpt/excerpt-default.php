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
	"tpl_file" => "excerpt-default.html"
);

$tpl["entries"][] = array(
	"id" => get_the_ID(),
	"class" => sandbox_post_class(false),
	"permalink" => get_permalink(),
	"title_attribute" => the_title_attribute('echo=0'),
	"title" => the_title("", "", false),
	"categories_list" => get_the_category_list(', '),
	"date_time" => get_the_time('Y-m-d\TH:i:sO'),
	"date" => get_the_time('F j, Y'),
	"comments_link" => vanilla_comments_popup_link(__('No comments', 'carrington'), __('1 comment', 'carrington'), __('% comments', 'carrington'))
);
?>