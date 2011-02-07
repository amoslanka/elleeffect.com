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

// Alister - added to handle Thematic-naming-convention of options/variables
global $options, $tpl;
foreach ($options as $value) {
	$$value['id'] = (get_settings( $value['id'] ) === FALSE) ? $value['std'] : get_settings( $value['id'] );
}

$tpl["loop"] = array(
	"tpl_file" => "loop-default.html"
);

if (have_posts()) {
	
	while (have_posts()) {
		the_post();
		cfct_content();
	}
}

?>