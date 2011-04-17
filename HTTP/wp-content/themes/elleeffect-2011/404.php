<?php
/**
 * The template for displaying 404 pages (Not Found).
 */

get_header(); ?>
	
	<div id="error-404">
		<h1><?php _e( 'Page Not Found', 'twentyten' ); ?></h1>
		<p><?php _e( 'Oops, the page you requested could not be found. ', 'twentyten' ); ?></p>
	</div>

<?php get_footer(); ?>