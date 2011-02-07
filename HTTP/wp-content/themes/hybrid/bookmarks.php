<?php
/*
Template Name: Bookmarks
Description: This page template lists your bookmarks/links below the main content of the page.
@plugin http://wordpress.org/extend/plugins/hot-friends
*/
?>

<?php get_header(); ?>

<?php if(have_posts()) : while(have_posts()) : the_post(); ?>

	<div class="<?php hybrid_post_class(); ?>">

		<?php the_title('<h1 class="page-title entry-title"><a href="' . get_permalink() . '" title="' . the_title_attribute('echo=0') . '">', '</a></h1>'); ?>

		<div class="entry entry-content">

			<?php the_content(); ?>

			<?php if(function_exists('hot_friends')) : ?>

				<?php hot_friends();?>

			<?php else : ?>

				<ul class="bookmarks xoxo">
				<?php
					$args = array(
						'title_li' => false,
						'title_before' => '<li>',
						'title_after' => false,
						'category_before' => false,
						'category_after' => '</li>',
						'categorize' => 1,
						'show_description' => 1,
						'between' => '<br />',
						'show_images' => 0,
						'show_rating' => 0,
					);
				?>
					<?php wp_list_bookmarks($args); ?>
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