<?php
/**
* Define theme hooks and add actions to them
*
* Actions can be added to these hooks throughout the theme
* This can be done through child themes and/or plugins
*
* Hooks should be defined and named by the order called (generated) relative to a theme element
*/

// Head actions
	add_action('hybrid_head', 'hybrid_enqueue_script');
	add_action('wp_head', 'hybrid_enqueue_style');
	add_action('wp_head', 'hybrid_theme_meta');
	remove_action('wp_head', 'pagenavi_css');

// Header actions
	add_action('hybrid_header', 'hybrid_site_title');
	add_action('hybrid_header', 'hybrid_site_description');
	add_action('hybrid_after_header', 'hybrid_page_nav');

// Container actions
	add_action('hybrid_after_container', 'hybrid_get_primary');
	add_action('hybrid_after_container', 'hybrid_get_secondary');
	add_action('hybrid_after_container', 'hybrid_insert');

// Content actions
	add_action('hybrid_before_content', 'hybrid_breadcrumb');
	add_action('hybrid_after_content', 'hybrid_navigation_links');
	add_action('hybrid_after_page', 'hybrid_footnote');
	add_action('hybrid_after_single', 'hybrid_footnote');

// Secondary actions
	add_action('hybrid_after_secondary', 'wp_meta');

// Footer actions
	add_action('hybrid_footer', 'hybrid_footer_insert');
	add_action('hybrid_footer', 'hybrid_copyright');
	add_action('hybrid_footer', 'hybrid_credit');
	add_action('hybrid_footer', 'hybrid_query_counter');

/**
* hybrid_head()
* 
* @since 0.1
* @file header.php
*/
function hybrid_head() {
	do_action('hybrid_head');
}

/**
* hybrid_before_header()
*
* @since 0.1
* @file header.php
*/
function hybrid_before_header() {
	do_action('hybrid_before_header');
}

/**
* hybrid_header()
*
* @since 0.1
* @file header.php
*/
function hybrid_header() {
	do_action('hybrid_header');
}

/**
* hybrid_after_header()
*
* @since 0.1
* @file header.php
*/
function hybrid_after_header() {
	do_action('hybrid_after_header');
}

/**
* hybrid_before_page_nav()
*
* @since 0.2
* @file filters.php
*/
function hybrid_before_page_nav() {
	do_action('hybrid_before_page_nav');
}

/**
* hybrid_after_page_nav()
*
* @since 0.2
* @file filters.php
*/
function hybrid_after_page_nav() {
	do_action('hybrid_after_page_nav');
}

/**
* hybrid_before_cat_nav()
*
* @since 0.2
* @file filters.php
*/
function hybrid_before_cat_nav() {
	do_action('hybrid_before_cat_nav');
}

/**
* hybrid_after_cat_nav()
*
* @since 0.2
* @file filters.php
*/
function hybrid_after_cat_nav() {
	do_action('hybrid_after_cat_nav');
}

/**
* hybrid_before_container()
*
* @since 0.1
* @file header.php
*/
function hybrid_before_container() {
	do_action('hybrid_before_container');
}

/**
* hybrid_before_content()
*
* @since 0.1
* @file header.php
*/
function hybrid_before_content() {
	do_action('hybrid_before_content');
}

/**
* hybrid_after_content()
*
* @since 0.1
* @file header.php
*/
function hybrid_after_content() {
	do_action('hybrid_after_content');
}

/**
* hybrid_after_single()
*
* @since 0.2
* @file single.php
*/
function hybrid_after_single() {
	do_action('hybrid_after_single');
}

/**
* hybrid_after_page()
*
* @since 0.2
* @file page.php
*/
function hybrid_after_page() {
	do_action('hybrid_after_page');
}

/**
* hybrid_before_comments()
*
* @since 0.3
* @file page.php
*/
function hybrid_before_comments() {
	do_action('hybrid_before_comments');
}

/**
* hybrid_before_primary()
*
* @since 0.1
* @file insert.php
*/
function hybrid_before_primary() {
	do_action('hybrid_before_primary');
}

/**
* hybrid_after_primary()
*
* @since 0.1
* @file insert.php
*/
function hybrid_after_primary() {
	do_action('hybrid_after_primary');
}

/**
* hybrid_before_secondary()
*
* @since 0.2
* @file insert.php
*/
function hybrid_before_secondary() {
	do_action('hybrid_before_secondary');
}

/**
* hybrid_after_secondary()
*
* @since 0.2
* @file insert.php
*/
function hybrid_after_secondary() {
	do_action('hybrid_after_secondary');
}

/**
* hybrid_after_container()
*
* @since 0.1
* @file insert.php
*/
function hybrid_after_container() {
	do_action('hybrid_after_container');
}

/**
* hybrid_before_footer()
*
* @since 0.1
* @file footer.php
*/
function hybrid_before_footer() {
	do_action('hybrid_before_footer');
}

/**
* hybrid_footer()
*
* @since 0.1
* @file footer.php
*/
function hybrid_footer() {
	do_action('hybrid_footer');
}

/**
* hybrid_after_footer()
*
* @since 0.1
* @file footer.php
*/
function hybrid_after_footer() {
	do_action('hybrid_after_footer');
}

/**
* hybrid_child_settings()
* 
* @since 0.2.1
* @file child-settings.php
*/
function hybrid_child_settings() {
	do_action('hybrid_child_settings');
}
?>