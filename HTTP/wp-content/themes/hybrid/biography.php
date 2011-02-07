<?php
/*
Template Name: Biography
Description: A page template for listing the page author's avatar, biographical info, and other links set in their profile.
Should make it easy to create an about page or biography for single-author blogs.
*/
?>

<?php get_header(); ?>

<?php if(have_posts()) : while(have_posts()) : the_post(); ?>

	<div class="<?php hybrid_post_class(); ?>">

		<?php the_title('<h1 class="page-title entry-title"><a href="' . get_permalink() . '" title="' . the_title_attribute('echo=0') . '" rel="bookmark">', '</a></h1>'); ?>

		<div class="entry entry-content">

		<?php if($page != $wp_query->get('page')) : ?>

			<?php $curauth = get_userdata(get_the_author_ID()); ?>

			<div class="author-profile author-info vcard">

				<a href="<?php echo get_author_posts_url($curauth->ID); ?>" title="<?php echo $curauth->display_name; ?>">
					<?php echo get_avatar($curauth->user_email, '100', $hybrid_settings['default_avatar']); ?>
				</a>

				<p class="author-bio">
					<?php echo $curauth->description; ?> <?php echo $curauth->user_role; ?>
				</p>

				<ul class="clear">

					<?php if($curauth->nickname) : ?>
						<li><strong><?php _e('Nickname:','hybrid'); ?></strong> <span class="nickname"><?php echo $curauth->nickname; ?></span></li>
					<?php endif; ?>

					<li>
						<strong><?php _e('Email:','hybrid'); ?></strong> <a class="author-email email" href="mailto:<?php echo antispambot($curauth->user_email); ?>" title="<?php printf(__('Send an email to %1$s','hybrid'), antispambot($curauth->user_email)); ?>"><?php echo antispambot($curauth->user_email); ?></a>
					</li>

					<?php if($curauth->user_url && $curauth->user_url !== 'http://') : ?>
						<li><strong><?php _e('Website:','hybrid'); ?></strong> <a class="url" href="<?php echo $curauth->user_url; ?>" title="<?php echo $curauth->user_url; ?>"><?php echo $curauth->user_url; ?></a></li>
					<?php endif; ?>

					<?php if($curauth->aim) : ?>
						<li><strong><?php _e('AIM:','hybrid'); ?></strong> <a class="url" href="aim:goim?screenname=<?php echo $curauth->aim; ?>" title="<?php printf(__('IM with %1$s','hybrid'), $curauth->aim); ?>"><?php echo $curauth->aim; ?></a></li>
					<?php endif; ?>

					<?php if($curauth->jabber) : ?>
						<li><strong><?php _e('Jabber:','hybrid'); ?></strong> <a class="url" href="xmpp:<?php echo $curauth->jabber; ?>@jabberservice.com" title="<?php printf(__('IM with %1$s','hybrid'), $curauth->jabber); ?>"><?php echo $curauth->jabber; ?></a></li>
					<?php endif; ?>

					<?php if($curauth->yim) : ?>
						<li><strong><?php _e('Yahoo:','hybrid'); ?></strong> <a class="url" href="ymsgr:sendIM?<?php echo $curauth->yim; ?>" title="<?php printf(__('IM with %1$s','hybrid'), $curauth->yim); ?>"><?php echo $curauth->yim; ?></a></li>
					<?php endif; ?>

				</ul>

			</div>

		<?php endif; ?>

			<?php the_content(); ?>
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