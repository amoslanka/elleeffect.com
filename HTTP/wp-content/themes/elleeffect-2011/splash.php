<?php
/*
Template Name: Splash Page
*/

	define("CONDENSED_GALLERIES", true);

	function add_info_page_body_class($classes) {
		$classes[] = 'splash-page';
		return $classes;
	}
	add_filter('body_class', 'add_info_page_body_class');

?>

<?php include('page-header.php'); ?>

<img src="<?php bloginfo('template_directory'); ?>/images/splash-title.png" width="843" height="160" alt="Photographs by Lauren Stonestreet">

<?php include('page-footer.php') ?>
