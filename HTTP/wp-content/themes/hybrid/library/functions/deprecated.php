<?php

/**
* get_the_image_link()
* Catchall function for getting images with a link
*
* @since 0.1
* @deprecated 0.2.3
* @replaced get_the_image() now handles an echo argument
*/
function get_the_image_link($args = array(), $deprecated =false, $deprecated_2 = false) {
	get_the_image($args, $deprecated, $deprecated_2);
}

/**
* Returns an array of the available tags (slugs)
*
* @since 0.2
* @deprecated 0.2.3
* @return array
* @replaced with hybrid_all_tag_slugs() for proper naming conventions
*/
function hybrid_all_tags() {
	$tags = hybrid_all_tag_slugs();
	return $tags;
}

/**
* hybrid_page_id()
* Dynamic page ID
*
* @since 1.0
* @deprecated 0.2
*/
function hybrid_page_id() {

	if(is_front_page() || is_home() && !is_paged()) :
		$page_id = 'home';
	else :
		$page_id = 'content';
	endif;

	return $page_id;
}

/**
* hybrid_page_class()
* Dynamic page class
*
* @since 0.1
* @deprecated 0.2
*/
function hybrid_page_class() {

	if(is_front_page() || is_home()) : $class = 'home front-page';
	elseif(is_attachment()) : $class = 'attachment';
	elseif(is_single()) : $class = 'single';
	elseif(is_page()) : $class = 'page';
	elseif (is_category()) : $class = 'category';
	elseif(is_tag()) : $class = 'tag';
	elseif(is_search()) : $class = 'search';
	elseif (is_404()) : $class = 'error-404';
	elseif(is_year()) : $class = 'year';
	elseif(is_month()) : $class = 'month';
	elseif(is_day()) : $class = 'day';
	elseif(is_time()) : $class = 'time';
	elseif(is_author()) : $class = 'author';
	endif;

	if(is_date()) $class .= ' date';
	if(is_archive()) $class .= ' archive';
	if(is_paged()) $class .= ' paged';

	echo $class;
}


/*
	=== Removed Functions ===
*/

/**
* hybrid_get_insert()
* Function for getting insert
* Replacement for get_sidebar()
*
* @since 0.1
* @removed 0.2.2
*/
function hybrid_get_insert() {
	_e('This function has been removed or replaced by another function.','hybrid');
}

?>