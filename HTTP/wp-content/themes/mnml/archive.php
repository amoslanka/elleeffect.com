<?php get_header() ?>

	<div id="container">
		<div id="content">

<?php the_post() ?>

<?php if ( is_day() ) : ?>
			<h2 class="page-title"><?php printf(__('Daily Archives: <span>%s</span>', 'sandbox'), get_the_time(get_option('date_format'))) ?></h2>
<?php elseif ( is_month() ) : ?>
			<h2 class="page-title"><?php printf(__('Monthly Archives: <span>%s</span>', 'sandbox'), get_the_time('F Y')) ?></h2>
<?php elseif ( is_year() ) : ?>
			<h2 class="page-title"><?php printf(__('Yearly Archives: <span>%s</span>', 'sandbox'), get_the_time('Y')) ?></h2>
<?php elseif ( isset($_GET['paged']) && !empty($_GET['paged']) ) : ?>
			<h2 class="page-title"><?php _e('Blog Archives', 'sandbox') ?></h2>
<?php endif; ?>

<?php rewind_posts() ?>

			<div id="nav-above" class="navigation">
				<div class="nav-previous"><?php next_posts_link(__('<span class="meta-nav">&laquo;</span> Older posts', 'sandbox')) ?></div>
				<div class="nav-next"><?php previous_posts_link(__('Newer posts <span class="meta-nav">&raquo;</span>', 'sandbox')) ?></div>
			</div>

<?php while ( have_posts() ) : the_post(); ?>

			<div id="post-<?php the_ID() ?>" class="<?php sandbox_post_class() ?>">
				<h3 class="entry-title"><a href="<?php the_permalink() ?>" title="<?php printf(__('Permalink to %s', 'sandbox'), wp_specialchars(get_the_title(), 1)) ?>" rel="bookmark"><?php the_title() ?></a></h3>
				<div class="entry-content">
<?php the_excerpt(''.__('Read More <span class="meta-nav">&raquo;</span>', 'sandbox').'') ?>

				</div>
				<div class="comments-link"><?php comments_popup_link(__('Add a comment', 'sandbox'), __('Comments (1)', 'sandbox'), __('Comments (%)', 'sandbox')) ?></div>
				<?php edit_post_link(__('Edit', 'sandbox'), "\t\t\t\t\t<div class=\"edit-link\">", "</span>\n\t\t\t\t\t</div>\n"); ?>
			</div><!-- .post -->

<?php endwhile ?>

			<div id="nav-below" class="navigation">
				<div class="nav-previous"><?php next_posts_link(__('<span class="meta-nav">&laquo;</span> Older posts', 'sandbox')) ?></div>
				<div class="nav-next"><?php previous_posts_link(__('Newer posts <span class="meta-nav">&raquo;</span>', 'sandbox')) ?></div>
			</div>

		</div><!-- #content .hfeed -->
	</div><!-- #container -->

<?php get_sidebar() ?>
<?php get_footer() ?>