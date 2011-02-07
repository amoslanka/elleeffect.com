<?php
/*
Template Name: No Widgets
Description: A template to use on pages that shouldn't have widgets, such as in the sidebar.
If writing custom widget sections, need to check for page_template('no-widgets.php').
*/
?>

<?php get_header(); ?>

<?php if(have_posts()) : while(have_posts()) : the_post(); ?>

	<div class="<?php hybrid_post_class(); ?>">

		<?php the_title('<h1 class="page-title entry-title"><a href="' . get_permalink() . '" title="' . the_title_attribute('echo=0') . '" rel="bookmark">', '</a></h1>'); ?>

		<div class="entry entry-content">
			<?php the_content(); ?>
			<?php wp_link_pages("before=<p class='pages'>".__('Pages:','hybrid')."&after=</p>"); ?>
		</div>

		<?php edit_post_link(__('Edit','hybrid'), '<p class="post-meta-data"><span class="edit">', '</span></p>'); ?>

	</div>

	<?php endwhile; ?>

	<?php hybrid_after_page(); // After page hook ?>

	<?php comments_template('', true); ?>

<?php else: ?>

	<p class="no-data"><?php _e('Sorry, no page matched your criteria.','hybrid'); ?></p>

<?php endif; ?>

<?php get_footer(); ?>