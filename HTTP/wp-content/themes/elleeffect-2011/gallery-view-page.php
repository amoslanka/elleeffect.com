<?php
/*
* Template Name: Gallery Viewer
*/

	define("CONDENSED_GALLERIES", true);

	function add_info_page_body_class($classes) {
		$classes[] = 'gallery-view-page';
		return $classes;
	}
	add_filter('body_class', 'add_info_page_body_class');

    wp_enqueue_script( 'swfobject', get_bloginfo('template_url') . '/javascripts/swfobject.js' );
    wp_enqueue_script( 'swfaddress', get_bloginfo('template_url') . '/javascripts/swfaddress.js' );
		
?>

<?php include('page-header.php'); ?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

		<div class="post">
			<h2><?php the_title() ?></h2>
			<?php the_content() ?>
		</div>
		
<?php endwhile; ?>


<div id='elleviewer-container'>
	<div id="elleviewer">
		
	</div>
</div>

<?php include('page-footer.php') ?>
