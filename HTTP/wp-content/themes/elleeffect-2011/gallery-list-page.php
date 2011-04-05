<?php
/**
 * Template Name: Gallery List, Centered Content
 */

	define("CONDENSED_GALLERIES", true);

	function add_info_page_body_class($classes) {
		$classes[] = 'gallery-list-page';
		return $classes;
	}
	add_filter('body_class', 'add_info_page_body_class');
		
?>

<?php include('page-header.php'); ?>


<?php // $add_to_gallery_nav = '<li id="text-block">'; ?>
<?php $add_to_gallery_nav = ''; ?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); 

		$add_to_gallery_nav .= '<div class="post">';
		$add_to_gallery_nav .= '<h2>' . get_the_title() . '</h2>';
		$add_to_gallery_nav .= get_the_content();

						// wp_link_pages( array( 'before' => '' . __( 'Pages:', 'twentyten' ), 'after' => '' ) );
						// edit_post_link( __( 'Edit', 'twentyten' ), '', '' );
		$add_to_gallery_nav .= '</div>';
endwhile; ?>

<?php // $add_to_gallery_nav .= '</li>'; ?>
<?php echo $add_to_gallery_nav; ?>

<?php get_gallery_nav('', true, 'block-gallery-nav'); ?>

<?php include('page-footer.php') ?>
