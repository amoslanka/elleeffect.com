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

global $comment, $tpl;

add_filter('get_comment_author_link', 'cfct_hcard_comment_author_link');

$author_link = sprintf(__('%s <span class="said">said</span>', 'carrington'), get_comment_author_link());

remove_filter('get_comment_author_link', 'cfct_hcard_comment_author_link');

$comment_date = sprintf(
	__('<span class="on">on</span> <abbr class="published" title="%s"><a title="Permanent link to this comment" rel="bookmark" href="%s#comment-%s">%s</a></abbr>'
	, 'carrington'
	)
	, get_comment_date('Y-m-d\TH:i:sO')
	, get_permalink()
	, get_comment_ID()
	, get_comment_date()
);

$tpl["comment"] = array(
	"tpl_file" => "comment-default.html"
);

$tpl["comments_list"][] = array(
	"id" => get_comment_ID(),
	"class" => cfct_comment_class(false),
	"approved" => ($comment->comment_approved) ? 1 : 0,
	"message" => __('Your comment is awaiting moderation.', 'carrington'),
	"avatar" => get_avatar($comment, 36),
	"author_link" => $author_link,
	"date" => $comment_date,
	"author_url" => get_comment_author_url(),
	"text" => get_comment_text(),
	"edit_link" => get_edit_comment_link($comment->comment_ID),
	"edit_attribute" => __('Edit comment'),
	"edit_message" => __('Edit')
);

?>