<?php
/*
Template Name: Sitemap Page
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

					<ul id="sitemap-page" class="xoxo">
						<li id="all-pages">
							<h3><?php _e( 'All Pages', 'plaintxtblog' ) ?></h3>
							<ul>
<?php wp_list_pages('title_li='); ?>
							</ul>
						</li>
						<li id="all-posts">
							<h3><?php _e( 'All Posts', 'plaintxtblog' ) ?></h3>
							<ul>
<?php $post_archives = new wp_query('showposts=1000'); 
while ( $post_archives->have_posts() ) : $post_archives->the_post(); ?>
								<li class="hentry">
									<span class="entry-title"><a href="<?php the_permalink() ?>" title="<?php printf(__( 'Permalink to %s', 'plaintxtblog' ), wp_specialchars( get_the_title(), 1 ) ) ?>" rel="bookmark"><?php the_title(); ?></a></span>
								</li>
<?php endwhile; ?>
							</ul>
						</li>
						<li id="monthly-archives">
							<h3><?php _e( 'All Monthly Archives', 'plaintxtblog' ) ?></h3>
							<ul>
<?php wp_get_archives('type=monthly&show_post_count=1') ?>
							</ul>
						</li>
						<li id="category-archives">
							<h3><?php _e( 'All Category Archives', 'plaintxtblog' ) ?></h3>
							<ul>
<?php wp_list_categories('optioncount=1&title_li=&show_count=1') ?> 
							</ul>
						</li>
						<li>
							<h3><?php _e('Archives by Tag', 'plaintxtblog') ?></h3>
							<p><?php wp_tag_cloud() ?></p>
						</li>
					</ul>

<?php link_pages('<div class="page-link">'.__('Pages: ', 'plaintxtblog'), '</div>', 'number'); ?>

<?php edit_post_link(__('Edit this entry.', 'barthelme'),'<p class="entry-edit">','</p>') ?>

				</div>
			</div><!-- .post -->

<?php if ( get_post_custom_values('comments') ) comments_template() // Add a key/value of "comments" to load comments on a page ?>

		</div><!-- #content .hfeed -->
	</div><!-- #container -->

<?php get_sidebar() ?>
<?php get_footer() ?>