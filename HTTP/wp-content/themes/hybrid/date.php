<?php get_header(); ?>

<div class="date-info">
	<h1 class="date-title">
		<?php
			if(is_day()) $time = get_the_time(__('F jS, Y','hybrid'));
			elseif(is_month()) $time = single_month_title(' ', false);
			elseif(is_year()) $time = get_the_time(__('Y','hybrid'));
			echo $time;
		?>
	</h1>

	<div class="date-description">
		<p><?php printf(__('You are browsing the archive for %1$s.','hybrid'), $time); ?></p>
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

	<p class="no-data"><?php printf(__('Sorry, there are no posts for %1$s.','hybrid'), $time); ?></p>

<?php endif; ?>

<?php get_footer(); ?>