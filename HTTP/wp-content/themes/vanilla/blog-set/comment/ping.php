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

add_filter('get_comment_author_link', 'cfct_hcard_ping_author_link');

$author_link = sprintf(__('<cite class="vcard author entry-title">%s <span class="linked-to-this-post">linked to this post</span></cite>', 'carrington'), get_comment_author_link());

remove_filter('get_comment_author_link', 'cfct_hcard_ping_author_link');

global $comment, $tpl;

$tpl["ping"] = array(
	"tpl_file" => "ping.html"
);

$tpl["pings_list"][] = array(
	"id" => get_comment_ID(),
	"class" => cfct_comment_class(false),
	"author_link" => $author_link,
	"on" => __('on'),
	"date_attribute" => get_comment_date('Y-m-d\TH:i:sO'),
	"date" => get_comment_date(),
	"author_url" => get_comment_author_url(),
	"text" => get_comment_text(),
	"edit_link" => get_edit_comment_link($comment->comment_ID),
	"edit_attribute" => __('Edit comment'),
	"edit_message" => __('Edit')
);