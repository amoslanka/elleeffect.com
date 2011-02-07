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

global $previousday, $authordata, $tpl;
$previousday = -1;

$tpl_tags_list = get_the_tag_list("", ",", "");
$tpl_edit_link = get_edit_post_link();
$tpl_pages_link = wp_link_pages('before=&after=&echo=0');

$content = get_the_content('<span class="more-link">'.__('Continued...', 'carrington').'</span>');
$content = apply_filters('the_content', $content);
$content = str_replace(']]>', ']]&gt;', $content);

$tpl["content"] = array(
	"tpl_file" => "content-default.html"
);

$tpl["entries"][] = array(
	"id" => get_the_ID(),
	"class" => sandbox_post_class(false),
	"permalink" => get_permalink(),
	"title_attribute" => the_title_attribute('echo=0'),
	"title" => the_title("", "", false),
	"content" => $content,
	"pages_link" => ($tpl_pages_link == '') ? false : $tpl_pages_link,
	"categories_list" => get_the_category_list(', '),
	"tags_list" => ($tpl_tags_list == '') ? false : $tpl_tags_list,
	"author" => array(
		"link" => get_author_link(false, get_the_author_ID(), $authordata->user_nicename),
		"name_attribute" => attribute_escape($authordata->display_name),
		"name" => get_the_author()
		),
	"date_time" => get_the_time('Y-m-d\TH:i:sO'),
	"date" => the_date("", "", "", false),
	"comments_link" => vanilla_comments_popup_link(__('No comments', 'carrington'), __('1 comment', 'carrington'), __('% comments', 'carrington')),
	"edit_link" => ($tpl_edit_link == '') ? false : $tpl_edit_link,
	"edit_link_text" => __('Edit This', 'carrington')
);
?>