<?php get_header(); ?>

<div class="author-profile vcard">

	<?php $curauth = get_userdata(get_query_var('author'));  ?>

	<h1 class="author-title fn n"><?php echo $curauth->display_name; ?></h1>

	<div class="author-info">
		<?php echo get_avatar($curauth->user_email, '100', $hybrid_settings['default_avatar']); ?>

		<p class="author-bio">
			<?php echo $curauth->description; ?>
		</p>

		<address class="author-email">
			<a href="mailto:<?php echo antispambot($curauth->user_email); ?>" class="email" title="<?php printf(__('Send an email to %1$s','hybrid'), antispambot($curauth->user_email)); ?>"><?php printf(__('Email %1$s','hybrid'),$curauth->display_name); ?></a>
		</address>
	</div>

</div>

<?php if(have_posts()) : while(have_posts()) : the_post(); ?>

	<div class="<?php hybrid_post_class(); ?>">

		<?php get_the_image('custom_key=Thumbnail,thumbnail&default_size=thumbnail'); ?>

		<?php the_title('<h2 class="post-title entry-title"><a href="' . get_permalink() . '" title="' . the_title_attribute('echo=0') . '" rel="bookmark">', '</a></h2>'); ?>

		<p class="byline">
			<span class="text"><?php _e('By','hybrid'); ?></span> 
			<span class="author vcard"><?php the_author_posts_link(); ?></span> <span class="text"><?php _e('on','hybrid'); ?></span> 
			<abbr class="published time date" title="<?php the_time(__('F jS, Y, g:i a (P - e)','hybrid')); ?>"><?php the_time(__('F j, Y','hybrid')); ?></abbr> 
			<?php edit_post_link(__('Edit','hybrid'), ' <span class="separator">|</span> <span class="edit">', '</span> '); ?>
		</p>

		<div class="entry entry-content">
			<?php the_excerpt(); ?>
		</div>

		<p class="post-meta-data">
			<span class="categories"><span class="text"><?php _e('Posted in','hybrid'); ?></span> <?php the_category(', ') ?></span> 
			<?php the_tags('<span class="tags"> <span class="separator">|</span> <span class="text">' . __('Tagged','hybrid') . '</span> ', ', ', '</span>'); ?> 
			<?php if(comments_open()) : ?><span class="separator">|</span><?php endif; ?> <?php comments_popup_link(__('Leave a comment','hybrid'), __('1 Comment','hybrid'), __('% Comments','hybrid'), 'comments-link', false); ?> 
		</p>

	</div>

	<?php endwhile; ?>

<?php else: ?>

	<p class="no-data"><?php printf(__('%1$s hasn\'t written any posts yet.','hybrid'), $curauth->display_name); ?></p>

<?php endif; ?>

<?php get_footer(); ?>