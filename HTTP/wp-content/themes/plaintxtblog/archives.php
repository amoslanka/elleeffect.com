<?php
/*
Template Name: Archives Page
*/
?>
<?php get_header() ?>
	
	<div id="container">
		<div id="content" class="hfeed">

<?php the_post() ?>

			<div id="post-<?php the_ID() ?>" class="<?php plaintxtblog_post_class() ?>">
				<h2 class="entry-title"><?php the_title() ?></h2>
				<div class="entry-content">
<?php the_content(); ?>

					<ul id="archives-page" class="xoxo">
						<li class="monthly-archives">
							<h3><?php _e('Monthly Archives', 'plaintxtblog') ?></h3>
							<ul>
								<?php wp_get_archives('type=monthly&show_post_count=1'); ?>
							</ul>
						</li>
						<li class="category-archives">
							<h3><?php _e('Category Archives', 'plaintxtblog') ?></h3>
							<ul>
								<?php wp_list_categories('title_li=&orderby=name&show_count=1&use_desc_for_title=1&feed_image='.get_bloginfo('template_url').'/images/feed.png') ?>
							</ul>
						</li>
						<li class="tag-archives">
							<h3><?php _e('Tag Archives', 'plaintxtblog') ?></h3>
							<p><?php wp_tag_cloud() ?></p>
						</li>
						<li class="feed-links">
							<h3><?php _e('RSS Feeds', 'plaintxtblog') ?></h3>
							<ul>
								<li><a href="<?php bloginfo('rss2_url') ?>" title="<?php echo wp_specialchars(get_bloginfo('name'), 1) ?> RSS 2.0 Feed" rel="alternate" type="application/rss+xml"><?php _e('All posts', 'plaintxtblog') ?></a></li>
								<li><a href="<?php bloginfo('comments_rss2_url') ?>" title="<?php echo wp_specialchars(bloginfo('name'), 1) ?> Comments RSS 2.0 Feed" rel="alternate" type="application/rss+xml"><?php _e('All comments', 'plaintxtblog') ?></a></li>							
							</ul>
						</li>
					</ul>

<?php edit_post_link(__('Edit this entry.', 'plaintxtblog'),'<p class="entry-edit">','</p>') ?>

				</div>
			</div><!-- .post -->

<?php if ( get_post_custom_values('comments') ) comments_template() // Add a key/value of "comments" to load comments on a page ?>

		</div><!-- #content .hfeed -->
	</div><!-- #container -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>