<?php

/**
* Shows a breadcrumb for all types of pages
* Child themes and plugins can filter this
* Allow filtering of only the arguments ($args)
*
* Date-based archives need some work
* Currently, months and days, don't trail back through the date archives
*
* Check for page templates in use: archives.php, authors.php, categories.php, tags.php
* This is to set the breadcrumb for archives: date.php, author.php, category.php, tag.php
* If in use, add the first page found using it as part of the breadcrumb for archives
*
* @since 0.1
* @filter $args
* @hook hybrid_before_content
* @echo string
*/
function hybrid_breadcrumb($args = array()) {
	global $post;

// Set up the default arguments for the breadcrumb
	$defaults = array(
		'separator' => '/',
		'before' => '<span class="breadcrumb-title">' . __('Browse:','hybrid') . '</span>',
		'after' => false,
		'front_page' => false,
		'show_home' => __('Home','home'),
		'echo' => true,
	);

// Apply filters to the arguments
	$args = apply_filters('hybrid_breadcrumb', $args);

// Parse the arguments and extract them for easy variable naming
	$args = wp_parse_args($args, $defaults);
	extract($args);

// Put spaces around the separator
	$separator = ' ' . $separator . ' ';

// If it is the home page
// Return no value
	if((is_home() || is_front_page()) && (!$front_page))
		return;

// Begin the breadcrumb
	$breadcrumb = '<div class="breadcrumb">';
	$breadcrumb .= $before;
	if($show_home)
		$breadcrumb .= ' <a href="' . get_bloginfo('url') . '" title="' . get_bloginfo('name') . '" class="trail-home">' . $show_home . '</a>';
	$breadcrumb .= $separator;

// If home or front page
	if((is_home() || is_front_page()) && ($front_page)) :
		$breadcrumb = '<div class="breadcrumb">' . $before . ' ' . $show_home;
// If attachment
	elseif(is_attachment()) :
	/*
	* Don't like categories by default on attachment pages
	*
		$categories = get_the_category($post->post_parent);
		foreach($categories as $cat) :
			$cats[] = '<a href="' . get_category_link($cat->term_id) . '" title="' . $cat->name . '">' . $cat->name . '</a>';
		endforeach;
		$breadcrumb .= join(', ', $cats);
		$breadcrumb .= $separator;
	*/
		$breadcrumb .= '<a href="' . get_permalink($post->post_parent) . '" title="' . get_the_title($post->post_parent) . '">' . get_the_title($post->post_parent) . '</a>';
		$breadcrumb .= $separator;
		$breadcrumb .= '<span class="trail-end">' . get_the_title() . '</span>';
// Single posts
	elseif(is_single()) :
		$categories = get_the_category(', ');
		foreach($categories as $cat) :
			$cats[] = '<a href="' . get_category_link($cat->term_id) . '" title="' . $cat->name . '">' . $cat->name . '</a>';
		endforeach;
		$breadcrumb .= join(', ', $cats);
		$breadcrumb .= $separator . '<span class="trail-end">' . single_post_title(false,false) . '</span>';

// Pages
	elseif(is_page()) :
		$parents = array();
		$parent_id = $post->post_parent;
		while($parent_id) :
			$page = get_page($parent_id);
			if($params["link_none"])
				$parents[]  = get_the_title($page->ID);
			else
				$parents[]  = '<a href="'.get_permalink($page->ID).'" title="'.get_the_title($page->ID).'">'.get_the_title($page->ID).'</a> ' . $separator;
			$parent_id  = $page->post_parent;
		endwhile;
		$parents = array_reverse($parents);
		$breadcrumb .= join(' ', $parents);
		$breadcrumb .= '<span class="trail-end">' . get_the_title() . '</span>';

// Categories
	elseif(is_category()) :
		$pages = get_pages(array(
			'title_li' => '',
			'meta_key' => '_wp_page_template',
			'meta_value' => 'categories.php',
			'echo' => 0
		));
		if($pages && $pages[0]->ID !== get_option('page_on_front')) $breadcrumb .= '<a href="' . get_page_link($pages[0]->ID) . '" title="' . $pages[0]->post_title . '">' . $pages[0]->post_title . '</a>' . $separator;
	// Category parents
		$cat = intval( get_query_var('cat') );
		$parent = &get_category($cat);
		if(is_wp_error($parent))
			$parents = false;
		if($parent->parent && ($parent->parent != $parent->term_id) )
			$parents = get_category_parents($parent->parent, true, $separator, false);

		if($parents) $breadcrumb .= $parents;
		$breadcrumb .= '<span class="trail-end">' . single_cat_title(false,false) . '</span>';

// Tags
	elseif(is_tag()) :
		$pages = get_pages(array(
			'title_li' => '',
			'meta_key' => '_wp_page_template',
			'meta_value' => 'tags.php',
			'echo' => 0
		));
		if($pages && $pages[0]->ID !== get_option('page_on_front')) $breadcrumb .= '<a href="' . get_page_link($pages[0]->ID) . '" title="' . $pages[0]->post_title . '">' . $pages[0]->post_title . '</a>' . $separator;
		$breadcrumb .= '<span class="trail-end">' . single_tag_title(false,false) . '</span>';

// Authors
	elseif(is_author()) :
		$pages = get_pages(array(
			'title_li' => '',
			'meta_key' => '_wp_page_template',
			'meta_value' => 'authors.php',
			'echo' => 0
		));
		if($pages && $pages[0]->ID !== get_option('page_on_front')) $breadcrumb .= '<a href="' . get_page_link($pages[0]->ID) . '" title="' . $pages[0]->post_title . '">' . $pages[0]->post_title . '</a>' . $separator;
		$breadcrumb .= '<span class="trail-end">' . wp_title(false,false,false) . '</span>';

// Search
	elseif(is_search()) :
		$breadcrumb .= '<span class="trail-end">' . __('Search results for','hybrid') . ' &quot;' . attribute_escape(get_search_query()) . '&quot;</span>';

// Day
	elseif(is_day()) :
		$pages = get_pages(array(
			'title_li' => '',
			'meta_key' => '_wp_page_template',
			'meta_value' => 'archives.php',
			'echo' => 0
		));
		if($pages && $pages[0]->ID !== get_option('page_on_front')) $breadcrumb .= '<a href="' . get_page_link($pages[0]->ID) . '" title="' . $pages[0]->post_title . '">' . $pages[0]->post_title . '</a>' . $separator;
		$breadcrumb .= '<a href="' . get_year_link(get_the_time('Y')) . '" title="' . get_the_time(__('Y','hybrid')) . '">' . get_the_time(__('Y','hybrid')) . '</a>' . $separator;
		$breadcrumb .= '<a href="' . get_month_link(get_the_time('Y'), get_the_time('m')) . '" title="' . get_the_time(__('F','hybrid')) . '">' . get_the_time(__('F','hybrid')) . '</a>' . $separator;
		$breadcrumb .= '<span class="trail-end">' . get_the_time(__('j','hybrid')) . '</span>';

// Month
	elseif(is_month()) :
		$pages = get_pages(array(
			'title_li' => '',
			'meta_key' => '_wp_page_template',
			'meta_value' => 'archives.php',
			'echo' => 0
		));
		if($pages && $pages[0]->ID !== get_option('page_on_front')) $breadcrumb .= '<a href="' . get_page_link($pages[0]->ID) . '" title="' . $pages[0]->post_title . '">' . $pages[0]->post_title . '</a>' . $separator;
		$breadcrumb .= '<a href="' . get_year_link(get_the_time('Y')) . '" title="' . get_the_time(__('Y','hybrid')) . '">' . get_the_time(__('Y','hybrid')) . '</a>' . $separator;
		$breadcrumb .= '<span class="trail-end">' . get_the_time(__('F','hybrid')) . '</span>';

// Year
	elseif(is_year()) :
		$pages = get_pages(array(
			'title_li' => '',
			'meta_key' => '_wp_page_template',
			'meta_value' => 'archives.php',
			'echo' => 0
		));
		if($pages && $pages[0]->ID !== get_option('page_on_front')) $breadcrumb .= '<a href="' . get_page_link($pages[0]->ID) . '" title="' . $pages[0]->post_title . '">' . $pages[0]->post_title . '</a>' . $separator;
		$breadcrumb .= '<span class="trail-end">' . get_the_time(__('Y','hybrid')) . '</span>';

// 404
	elseif(is_404()) :
		$breadcrumb .= '<span class="trail-end">' . __('404 Not Found','hybrid') . '</span>';

	endif;

// End the breadcrumb
	$breadcrumb .= $after . '</div>';

// Output the breadcrumb
	if($echo)
		echo $breadcrumb;
	else
		return $breadcrumb;
}
?>