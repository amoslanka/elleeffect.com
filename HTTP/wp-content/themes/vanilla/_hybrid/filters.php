<?php

/* Functions that can be filtered or that filter other functions. */

// Filters to be added
	add_filter('comments_template', 'hybrid_legacy_comments');

/**
* Filters the comments_template() function
* Grabs the file legacy.comments.php if older than WP 2.7
*
* @since 0.3
* @return return $file legacy.comments.php
*/
function hybrid_legacy_comments($file) {
	if(!function_exists('wp_list_comments')) :
		$file = HYBRID_LEGACY . '/legacy.comments.php';
	endif;
	return $file;
}

/**
* Shows the allowed tags on the comment form
*
* @since 0.2.2
* @filter
* @hook comment_form()
*/
function hybrid_allowed_tags() {

	$tags = array();

	$tags[] = '&lt;a href=&quot;&quot; title=&quot;&quot;&gt;';
	$tags[] = '&lt;abbr title=&quot;&quot;&gt;';
	$tags[] = '&lt;acronym title=&quot;&quot;&gt;';
	$tags[] = '&lt;blockquote cite=&quot;&quot;&gt;';
	$tags[] = '&lt;cite&gt;';
	$tags[] = '&lt;code&gt;';
	$tags[] = '&lt;del datetime=&quot;&quot;&gt;';
	$tags[] = '&lt;em&gt;';
	$tags[] = '&lt;q cite=&quot;&quot;&gt;';
	$tags[] = '&lt;strong&gt;';

	$tags = join(' ', $tags);

	echo '<p class="allowed-tags">';
	echo '<strong>' . __('You can use these <acronym title="Extensible Hypertext Markup Language">XHTML</acronym> tags&#58;','hybrid') . '</strong> ';
	echo apply_filters('hybrid_allowed_tags', $tags);
	echo '</p>';
}

/**
* Dynamic site title element
* Wrap in an <h1> element if on the home page
* All other pages, wrap in <div>
*
* @since 0.1
* @filter
*/
function hybrid_site_title() {
	if(is_home() || is_front_page()) $tag = 'h1';
	else $tag = 'div';

	$name = '<' . $tag . ' id="site-title">';
	$name .= '<a href="' . get_bloginfo('url') . '" title="' . get_bloginfo('name') . '"><span>' . get_bloginfo('name') . '</span></a>';
	$name .= '</' . $tag . '>';

	echo apply_filters('hybrid_site_title', $name);
}

/**
* Dynamic site description element
* Add <h2> around the description if on the home page
* Add <div> for all other pages
*
* @since 0.1
* @filter
*/
function hybrid_site_description() {
	if(is_home() || is_front_page()) $tag = 'h2';
	else $tag = 'div';

	$desc = '<' . $tag . ' id="site-description">';
	$desc .= '<span>' . get_bloginfo('description') . '</span>';
	$desc .= '</' . $tag . '>';

	echo apply_filters('hybrid_site_description', $desc);
}

/**
* Filterable page navigation
* Users should filter wp_page_menu() or wp_page_menu_args() if only changing links
* wp_page_menu() recreated in legacy.functions.php (pre-WP 2.7)
*
* @since 0.1
* @hook hybrid_after_header
* @filter
*/
function hybrid_page_nav() {
	echo "<div id='navigation'>\n\t\t";

	hybrid_before_page_nav(); // Before navigation hook

		if(is_front_page() || is_home()) $home = 'current_page_item';
		else $home = 'page_item';

		$nav = wp_page_menu('show_home=Home&menu_class=page-nav&depth=1&echo=0');

		echo apply_filters('hybrid_page_nav', $nav);

	hybrid_after_page_nav(); // After navigation hook

	echo "\t</div>\n";
}


/**
* Filterable category navigation block
* Users should filter hybrid_category_menu() if only wanting to filter links
* This should only be filtered if directly adding something outside of the nav list
* Also, added hooks for before and after
* This will allow for custom content to be added in the same div
*
* @since 0.1
* @filter
*/
function hybrid_cat_nav() {
	echo "\n\t<div id='cat-navigation'>\n\t\t";

	hybrid_before_cat_nav(); // Before category navigation

	$nav = hybrid_category_menu('menu_class=cat-nav&echo=0');
	echo apply_filters('hybrid_cat_nav',$nav);

	hybrid_after_cat_nav(); // After category navigation hook

	echo "\n\t</div>\n";
}

/**
* Menu listing for categories
* Much like WP 2.7's wp_page_menu() functionality
* Ability to easily filter or call hybrid template tag to show cat list
* Add all the default arguments of wp_list_categories()
* Always set the title_li paramater to false b/c this is a menu list
*
* Allow users to filter the function in child themes
* Filter should return an array of arguments for $cats
*
* @since 0.2.3
* @param array Optional $args
* Ability to add a home link with show_home=Home
* @filter hybrid_category_menu_args to filter arguments
* @filter hybrid_category_menu to filter entire menu
*/
function hybrid_category_menu($args = array()) {

	$defaults = array(
		'show_home' => false,
		'menu_class' => 'cat-nav',
		'show_option_all' => '',
		'orderby' => 'name',
		'order' => 'ASC',
		'show_last_update' => 0,
		'style' => 'list',
		'show_count' => 0,
		'hide_empty' => 1,
		'use_desc_for_title' => 0,
		'child_of' => 0,
		'feed' => '',
		'feed_image' => '',
		'exclude' => '',
		'depth' => 1,
		'orderby' => 'name',
		'hierarchical' => true,
		'echo' => 1
	);

	// Allow filter of arguments
	$args = apply_filters('hybrid_category_menu_args', $args);

	$args = wp_parse_args($args, $defaults);
	extract($args);

	if($echo) :
		$echo = false;
		$echo_menu = true;
	endif;

	$args = array(
		'title_li' => false,
		'show_option_all' => $show_option_all,
		'orderby' => $orderby,
		'order' => $order,
		'show_last_update' => $show_last_update,
		'style' => $style,
		'show_count' => $show_count,
		'hide_empty' => 1,
		'use_desc_for_title' => $use_descr_for_title,
		'child_of' => $child_of,
		'feed' => $feed,
		'feed_image' => $feed_image,
		'exclude' => $exclude,
		'depth' => $depth,
		'hierarchical' => $hierarchical,
		'echo' => false
	);

	if($show_home) :
		$cats[0] = '<li class="' . $home . '"><a href="' . get_bloginfo('url') . '" title="' . $show_home . '">' . $show_home . '</a></li>';
	endif;

	$cats[1] = str_replace(array("\t","\n","\r"), '', wp_list_categories($args));

	$cats = join('', $cats);

	$menu = '<div id="' . $menu_class . '"><ul>' . $cats . '</ul></div>';

	$menu = apply_filters('hybrid_category_menu', $menu);

	if($echo_menu) :
		echo $menu;
	else :
		return $menu;
	endif;
}

/**
* Displays a search form
* Iterates for each search form called so no repeat IDs
*
* @since 0.1
* @filter
*/

function hybrid_search_form() {

	global $search_form_num;
	if(!$search_form_num)
		$search_num = false;
	else
		$search_num = '-' . $search_form_num;

	if(is_search()) $search_text = attribute_escape(get_search_query());  
	else $search_text = __('Search this site...','hybrid');

	$search = "\n\t\t<div id='search" . $search_num . "'>\n\t\t\t";
		$search .= '<form method="get" class="search-form" id="search-form' . $search_num . '" action="' . get_bloginfo("home") . '">';
		$search .= '<div>';
		$search .= '<input class="search-text" type="text" name="s" id="search-text' . $search_num . '" tabindex="7" value="' . $search_text . '" onfocus="if(this.value==this.defaultValue)this.value=\'\';" onblur="if(this.value==\'\')this.value=this.defaultValue;" />';
		$search .= '<input class="search-submit button" name="submit" type="submit" id="search-submit' . $search_num . '" tabindex="8" value="' . __('Search','hybrid') . '" />';
		$search .= '</div>';
		$search .= '</form>';
	$search .= "\n\t\t</div>\n";

	echo apply_filters('hybrid_search_form',$search);
	$search_form_num++;
}

/**
* Ability to design custom sidebars with/without widgets
* Changed from action to filter in 0.2.2
* Only useful if adding completely custom sidebars/widget areas
* One could simply create a custom function and hook it w/o using this function
*
* @since 0.2
* @filter
*/
function hybrid_insert() {
	$insert = false;
	echo apply_filters('hybrid_insert', $insert);
}

/**
* Displays site copyright info with link back to site
* Can be removed/added through theme settings
*
* @since 0.1
* @filter
*/
function hybrid_copyright() {

	global $hybrid_settings;

	if($hybrid_settings['copyright']) :

		$copyright = '<p class="copyright">';
		$copyright .= '<span class="text">' . __('Copyright','hybrid') . ' &#169; ' . date(__('Y','hybrid')) . '</span> <a href="' . get_bloginfo('url') . '" title="' . get_bloginfo('name') . '" rel="bookmark"><span>' . get_bloginfo('name') . '</span></a>. ';
		$copyright .= '</p>';

	endif;

	echo apply_filters('hybrid_copyright', $copyright);
}

/**
* Displays Hybrid and/or WordPress credit links
* Can be added/removed through theme settings
*
* @since 0.1
* @filter
*/
function hybrid_credit() {

	global $hybrid_settings;

	if($hybrid_settings['wp_credit'] || $hybrid_settings['th_credit']) :

		$data = get_theme_data(TEMPLATEPATH . '/style.css');

		$credit = '<p class="credit">';
		$credit .= '<span class="text">' . __('Powered by','hybrid') . '</span>';
		if($hybrid_settings['wp_credit'])
			$credit .= ' <a href="http://wordpress.org" class="wp-link" title="' . __('Powered by WordPress, state-of-the-art semantic personal publishing platform','hybrid') . '"><span>' . __('Wordpress','hybrid') . '</span></a>';
		if($hybrid_settings['wp_credit'] && $hybrid_settings['th_credit'])
			$credit .= ' <span class="text">' . __('and','hybrid') . '</span> ';
		if($hybrid_settings['th_credit'])
			$credit .= ' <a class="hybrid-link" href="' . $data['URI'] . '" title="' . __('Hybrid Theme Framework','hybrid') . '">' . __('Hybrid','hybrid') . '</a>';
		$credit .= '.</p>';

	endif;

	echo apply_filters('hybrid_credit', $credit);
}
?>