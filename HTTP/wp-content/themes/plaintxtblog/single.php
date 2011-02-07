<?php get_header(); ?>

	<div id="container">
		<div id="content" class="hfeed">

<?php the_post(); ?>

			<div id="post-<?php the_ID(); ?>" class="<?php plaintxtblog_post_class(); ?>">
				<h2 class="entry-title"><?php the_title(); ?></h2>
				<div class="entry-content">
<?php the_content('<span class="more-link">'.__('More&hellip;', 'plaintxtblog').'</span>') ?>

<?php link_pages('<div class="page-link">'.__('Pages: ', 'plaintxtblog'), "</div>\n", 'number'); ?>
				</div>
				<div class="entry-meta">
<?php if (('open' == $post-> comment_status) && ('open' == $post->ping_status)) : ?>
					<?php printf(__('<span class="entry-comments"><a href="#respond" title="Post a comment">Post a comment</a></span> <span class="meta-sep">&mdash;</span> <span class="entry-trackbacks"><a href="%s" rel="trackback" title="Trackback URI for your post">Trackback URI</a></span>', 'plaintxtblog'), get_trackback_url()) ?>
<?php elseif (!('open' == $post-> comment_status) && ('open' == $post->ping_status)) : ?>
					<?php printf(__('<span class="entry-comments">Comments closed</span> <span class="meta-sep">&mdash;</span> <span class="entry-trackbacks"><a href="%s" rel="trackback" title="Trackback URL for your post">Trackback URI</a></span>', 'plaintxtblog'), get_trackback_url()) ?>
<?php elseif (('open' == $post-> comment_status) && !('open' == $post->ping_status)) : ?>
					<?php printf(__('<span class="entry-comments"><a href="#respond" title="Post a comment">Post a comment</a></span> <span class="meta-sep">&mdash;</span> <span class="entry-trackbacks">Trackbacks closed</span>', 'plaintxtblog')) ?>
<?php elseif (!('open' == $post-> comment_status) && !('open' == $post->ping_status)) : ?>
					<?php _e('<span class="entry-comments">Comments closed</span> <span class="meta-sep">&mdash;</span> <span class="entry-trackbacks">Trackbacks closed</span>', 'plaintxtblog') ?>
<?php endif; ?>

					<span class="entry-commentslink"><?php printf(__('<a href="%1$s" title="%2$s comments RSS feed" rel="alternate" type="application/rss+xml">RSS 2.0 feed</a> for these comments', 'plaintxtblog'),
							comments_rss(),
							wp_specialchars(get_the_title(), 'double') ) ?></span>

					<span class="entry-metainfo"><?php printf(__('This entry (<a href="%1$s" title="Permalink to %2$s" rel="bookmark">permalink</a>) was posted on <abbr class="published" title="%3$sT%4$s">%5$s at %6$s</abbr> by %7$s. Filed in %8$s%9$s.', 'plaintxtblog'),
							get_permalink(),
							wp_specialchars(get_the_title(), 'double'),
							get_the_time('Y-m-d'),
							get_the_time('H:i:sO'),
							the_date('l, F j, Y,', '', '', false),
							get_the_time(),
							'<span class="vcard"><span class="fn n">' . $authordata->display_name . '</span></span>',
							get_the_category_list(', '),
							get_the_tag_list(' and tagged ', ', ') ) ?> <?php edit_post_link(__('Edit this entry', 'plaintxtblog')); ?></span>
				</div>
			</div><!-- .post -->

<?php comments_template(); ?>

			<div id="nav-below" class="navigation">
				<div class="nav-previous"><?php previous_post_link(__('&laquo; %link', 'plaintxtblog')) ?></div>
				<div class="nav-next"><?php next_post_link(__('%link &raquo;', 'plaintxtblog')) ?></div>
				<div class="nav-home"><a href="<?php echo get_settings('home') ?>/" title="<?php bloginfo('name') ?>"><?php _e('Home', 'plaintxtblog'); ?></a></div>
			</div>

		</div><!-- #content .hfeed -->
	</div><!-- #container -->

<?php get_sidebar() ?>
<?php get_footer() ?>