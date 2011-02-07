<?php
/**
 * Template Name: Info Page, Centered Content
 */

	function add_info_page_body_class($classes) {
		$classes[] = 'info-page';
		return $classes;
	}
	add_filter('body_class', 'add_info_page_body_class');
		
	include('page.php');
?>
