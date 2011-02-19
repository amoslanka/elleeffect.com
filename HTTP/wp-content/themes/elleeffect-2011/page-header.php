<?php 

	if (defined("CONDENSED_GALLERIES")) { define("CONDENSED_GALLERIES", true); }

	function add_page_body_class($classes) {
		$classes[] = basename(get_permalink());
		return $classes;
	}
	if(is_page()) 
		add_filter('body_class', 'add_page_body_class');
?>


<?php get_header(); ?>
<div id="body">
