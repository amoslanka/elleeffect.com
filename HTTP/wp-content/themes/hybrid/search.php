<?php get_header(); ?>

<div class="search-info">

	<h1 class="search-title"><?php echo attribute_escape(get_search_query()); ?></h1>

	<div class="search-description">
		<p><?php printf(__('You are browsing the search results for &quot;%1$s.&quot','hybrid'), attribute_escape(get_search_query())); ?>	</p>
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

		<div class="entry">
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

	<p class="no-data">
		<?php _e('Sorry, no posts matched your criteria.','hybrid'); ?> <?php _e('Maybe you\'d like to try inputting different search terms.','hybrid'); ?>
	</p>
	<?php hybrid_search_form(); ?>

<?php endif; ?>

<?php get_footer(); ?>