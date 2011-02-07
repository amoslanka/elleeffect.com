<?php
/*
Template Name: Categories
Description: The categories page template lists your categories along with a link to the RSS feed and post count.
@plugin http://wordpress.org/extend/plugins/no-widget-category-cloud
*/
?>

<?php get_header(); ?>

<?php if(have_posts()) : while(have_posts()) : the_post(); ?>

	<div class="<?php hybrid_post_class(); ?>">

		<?php the_title('<h1 class="page-title entry-title"><a href="' . get_permalink() . '" title="' . the_title_attribute('echo=0') . '" rel="bookmark">', '</a></h1>'); ?>

		<div class="entry entry-content">

			<?php the_content(); ?>

			<?php if(function_exists('nw_catcloud')) : ?>

				<?php nw_catcloud(); ?>

			<?php else : ?>
			
				<ul>
				<?php wp_list_categories('feed=RSS&show_count=1&use_desc_for_title=0&title_li='); ?>
				</ul>

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