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

global $tpl;
$tpl["nav_posts"] = array(
	"next_posts_link" => get_next_posts_link(__('&laquo; Older posts', 'carrington')),
	"previous_posts_link" => get_previous_posts_link(__('Newer posts &raquo;', 'carrington'))
);

?>