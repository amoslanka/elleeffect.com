<?php
/*
Template Name: Archives
Description: This will list your categories and monthly archives by default.  Or, you can activate one of the plugins.
@plugin http://justinblanton.com/projects/smartarchives
@plugin http://wordpress.org/extend/plugins/clean-archives-reloaded
@plugin http://www.geekwithlaptop.com/projects/clean-archives
*/
?>

<?php get_header(); ?>

<?php if(have_posts()) : while(have_posts()) : the_post(); ?>

	<div class="<?php hybrid_post_class(); ?>">

		<?php the_title('<h1 class="page-title entry-title"><a href="' . get_permalink() . '" title="' . the_title_attribute('echo=0') . '">', '</a></h1>'); ?>

		<div class="entry entry-content">

			<?php the_content(); ?>

			<?php if(function_exists('smartArchives')) : smartArchives('both',''); ?>

			<?php elseif(function_exists('wp_smart_archives')) : wp_smart_archives(); ?>

			<?php elseif(function_exists('srg_clean_archives')) : srg_clean_archives(); ?>

			<?php else : ?>

				<h2><?php _e('Archives by category','hybrid'); ?></h2>

				<ul>
					<?php wp_list_categories('feed=RSS&show_count=1&use_desc_for_title=0&title_li='); ?>
				</ul>

				<h2><?php _e('Archives by month','hybrid'); ?></h2>

				<ul class="archives-list">
					<?php wp_get_archives('show_post_count=1&type=monthly'); ?>
				</ul>

			<?php endif; ?>
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