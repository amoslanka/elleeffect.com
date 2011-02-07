<?php
/*
Template Name: Tags
Description: This template creates a tag cloud of all your tags.
@plugin http://wordpress.org/extend/plugins/configurable-tag-cloud-widget
*/
?>

<?php get_header(); ?>

<?php if(have_posts()) : while(have_posts()) : the_post(); ?>

	<div class="<?php hybrid_post_class(); ?>">

		<?php the_title('<h1 class="page-title entry-title"><a href="' . get_permalink() . '" title="' . the_title_attribute('echo=0') . '" rel="bookmark">', '</a></h1>'); ?>

		<div class="entry entry-content">

			<?php the_content(); ?>

			<?php if(function_exists('ctc')) : ?>

				<p><?php ctc(); ?></p>

			<?php else : ?>

				<p class="tag-cloud"><?php wp_tag_cloud('number=0'); ?></p>

			<?php endif; ?>

			<?php wp_link_pages("before=<p class='pages'>".__('Pages:','hybrid')."&after=</p>"); ?>

		</div>

		<?php edit_post_link(__('Edit','hybrid'), '<p class="post-meta-data"><span class="edit">', '</span></p>'); ?>

	</div>

	<?php hybrid_after_page(); // After page hook ?>

	<?php comments_template('', true); ?>

	<?php endwhile; ?>

<?php else: ?>

	<p class="no-data"><?php _e('Sorry, no page matched your criteria.','hybrid'); ?></p>

<?php endif; ?>

<?php get_footer(); ?>