<?php get_header() ?>

	<div id="container">
		<div id="content" class="hfeed">

<?php while ( have_posts() ) : the_post() ?>

			<div id="post-<?php the_ID() ?>" class="<?php plaintxtblog_post_class() ?>">
				<div class="entry-header">
					<h2 class="entry-title"><a href="<?php the_permalink() ?>" title="<?php printf(__('Permalink to %s', 'plaintxtblog'), wp_specialchars(get_the_title(), 1)) ?>" rel="bookmark"><?php the_title() ?></a></h2>
					<abbr class="published" title="<?php the_time('Y-m-d\TH:i:sO'); ?>"><?php unset($previousday); printf(__('%1$s', 'plaintxtblog'), the_date('d-M-y', false)) ?></abbr>
				</div>
				<div class="entry-content">
<?php the_content('<span class="more-link">'.__('More&hellip;', 'plaintxtblog').'</span>') ?>

<?php link_pages('<div class="page-link">'.__('Pages: ', 'plaintxtblog'), "</div>\n", 'number'); ?>
				</div>
				<div class="entry-meta">
					<span class="entry-category"><?php printf(__('Filed in %s', 'plaintxtblog'), get_the_category_list(', ') ) ?></span>
					<span class="meta-sep">|</span>
					<span class="entry-tags"><?php the_tags(__('Tagged ', 'plaintxtblog'), ", ", "") ?></span>
					<span class="meta-sep">|</span>
<?php edit_post_link(__('Edit', 'plaintxtblog'), "\t\t\t\t\t<span class='entry-edit'>", "</span>\n\t\t\t\t\t<span class='meta-sep'>|</span>\n"); ?>
					<span class="entry-comments"><?php comments_popup_link(__('Comments (0) &raquo;', 'plaintxtblog'), __('Comments (1) &raquo;', 'plaintxtblog'), __('Comments (%) &raquo;', 'plaintxtblog'),'',__('Comments Off','plaintxtblog')) ?></span>
				</div>
			</div><!-- .post -->

<?php endwhile ?>

			<div id="nav-below" class="navigation">
				<div class="nav-previous"><?php next_posts_link(__('&laquo; Older posts', 'plaintxtblog')) ?></div>
				<div class="nav-next"><?php previous_posts_link(__('Newer posts &raquo;', 'plaintxtblog')) ?></div>
				<div class="nav-home"><a href="<?php echo get_settings('home') ?>/" title="<?php bloginfo('name') ?>"><?php _e('Home', 'plaintxtblog'); ?></a></div>
			</div>

		</div><!-- #content .hfeed -->
	</div><!-- #container -->

<?php get_sidebar() ?>
<?php get_footer() ?>