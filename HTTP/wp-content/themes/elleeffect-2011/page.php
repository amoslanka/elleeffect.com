<?php 
	function add_page_body_class($classes) {
		$classes[] = basename(get_permalink());
		return $classes;
	}
	if(is_page()) 
		add_filter('body_class', 'add_page_body_class');
?>


<?php get_header(); ?>
<div id="body">
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

					<div class="post">
					<?php if ( is_front_page() ) { ?>
						<h2><?php the_title(); ?></h2>
					<?php } else { ?>	
						<h1><?php the_title(); ?></h1>
					<?php } ?>				

						<?php the_content(); ?>
						<?php wp_link_pages( array( 'before' => '' . __( 'Pages:', 'twentyten' ), 'after' => '' ) ); ?>
						<?php edit_post_link( __( 'Edit', 'twentyten' ), '', '' ); ?>
					</div>
<?php endwhile; ?>
</div>
<?php get_footer(); ?>