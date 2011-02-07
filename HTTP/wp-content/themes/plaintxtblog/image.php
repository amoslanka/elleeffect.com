<?php get_header(); ?>

	<div id="container">
		<div id="content" class="hfeed">

<?php the_post() ?>

<?php $attachment_link = get_the_attachment_link($post->ID, true, array(450, 800)); ?>
<?php $_post = &get_post($post->ID); $classname = ($_post->iconsize[0] <= 128 ? 'small' : '') . 'attachment'; ?>

			<div id="post-<?php the_ID(); ?>" class="<?php plaintxtblog_post_class() ?>">
				<div class="entry-header">
					<h2 class="entry-title"><?php the_title(); ?></h2>
					<div id="nav-above" class="post-parent"><a href="<?php echo get_permalink($post->post_parent) ?>" rev="attachment">&laquo; <?php echo get_the_title($post->post_parent) ?></a></div>
				</div>
				<div class="entry-content">
					<div class="entry-attachment"><a href="<?php echo wp_get_attachment_url($post->ID); ?>" title="<?php echo wp_specialchars( get_the_title($post->ID), 1 ) ?>" rel="attachment"><?php echo wp_get_attachment_image( $post->ID, 'large' ); ?></a></div>
					<div class="entry-caption"><?php if ( !empty($post->post_excerpt) ) the_excerpt(); ?></div>
<?php the_content('<span class="more-link">'.__('More&hellip;', 'plaintxtblog').'</span>') ?>

				</div>
				<div id="nav-images" class="navigation">
					<div class="nav-previous"><?php previous_image_link() ?></div>
					<div class="nav-next"><?php next_image_link() ?></div>
				</div>
				<div class="entry-meta">
<?php if (('open' == $post-> comment_status) && ('open' == $post->ping_status)) : // COMMENTS & PINGS OPEN ?>
					<?php printf(__('<span class="entry-comments"><a href="#respond" title="Post a comment">Post a comment</a></span> <span class="meta-sep">&mdash;</span> <span class="entry-trackbacks"><a href="%s" rel="trackback" title="Trackback URI for your post">Trackback URI</a></span>', 'plaintxtblog'), get_trackback_url()) ?>
<?php elseif (!('open' == $post-> comment_status) && ('open' == $post->ping_status)) : // PINGS ONLY OPEN ?>
					<?php printf(__('<span class="entry-comments">Comments closed</span> <span class="meta-sep">&mdash;</span> <span class="entry-trackbacks"><a href="%s" rel="trackback" title="Trackback URL for your post">Trackback URI</a></span>', 'plaintxtblog'), get_trackback_url()) ?>
<?php elseif (('open' == $post-> comment_status) && !('open' == $post->ping_status)) : // COMMENTS OPEN ?>
					<?php printf(__('<span class="entry-comments"><a href="#respond" title="Post a comment">Post a comment</a></span> <span class="meta-sep">&mdash;</span> <span class="entry-trackbacks">Trackbacks closed</span>', 'plaintxtblog')) ?>
<?php elseif (!('open' == $post-> comment_status) && !('open' == $post->ping_status)) : // NOTHING OPEN ?>
					<?php _e('<span class="entry-comments">Comments closed</span> <span class="meta-sep">&mdash;</span> <span class="entry-trackbacks">Trackbacks closed</span>', 'plaintxtblog') ?>
<?php endif; ?>

					<span class="entry-commentslink"><?php printf(__('<a href="%1$s" title="%2$s comments RSS feed" rel="alternate" type="application/rss+xml">RSS 2.0 feed</a> for these comments', 'plaintxtblog'),
							comments_rss(),
							wp_specialchars(get_the_title(), 'double') ) ?></span>

					<span class="entry-metainfo"><?php printf(__('This image (<a href="%1$s" title="Permalink to %2$s" rel="bookmark">permalink</a>) was posted on <abbr class="published" title="%3$sT%4$s">%5$s at %6$s</abbr> by %7$s. Filed in %8$s%9$s.', 'plaintxtblog'),
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

<?php comments_template() ?>

		</div><!-- #content .hfeed -->
	</div><!-- #container -->

<?php get_sidebar() ?>
<?php get_footer() ?>