<?php
/*
Template Name: Widgets
Description: Use this template to completely widgetize any page on your blog.
Note: This template is under heavy development, and functionality may change in the future.
*/
?>

<?php get_header(); ?>

<?php dynamic_sidebar(__('Widget Template','hybrid')); ?>

<?php wp_reset_query(); ?>

<?php if(have_posts()) : while(have_posts()) : the_post(); ?>

	<?php edit_post_link(__('Edit','hybrid'), '<p class="post-meta-data"><span class="edit">', '</span></p>'); ?>

	<?php hybrid_after_page(); // After page hook ?>

	<?php comments_template('', true); ?>

	<?php endwhile; ?>

<?php else: ?>

	<p class="no-data"><?php _e('Sorry, no page matched your criteria.','hybrid'); ?></p>

<?php endif; ?>

<?php get_footer(); ?>