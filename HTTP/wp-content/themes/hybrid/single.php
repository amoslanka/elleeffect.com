<?php get_header(); ?>

<?php if(have_posts()) : while(have_posts()) : the_post(); ?>

	<div class="<?php hybrid_post_class(); ?>">

		<?php the_title('<h1 class="single-title entry-title"><a href="' . get_permalink() . '" title="' . the_title_attribute('echo=0') . '" rel="bookmark">', '</a></h1>'); ?>

		<p class="byline">
			<span class="text"><?php _e('By','hybrid'); ?></span> 
			<span class="author vcard"><?php the_author_posts_link(); ?></span> <span class="text"><?php _e('on','hybrid'); ?></span> 
			<abbr class="published time date" title="<?php the_time(__('F jS, Y, g:i a (P - e)','hybrid')); ?>"><?php the_date(); ?></abbr> 
			<?php edit_post_link(__('Edit','hybrid'), ' <span class="separator">|</span> <span class="edit">', '</span> '); ?>
		</p>

		<div class="entry entry-content">
			<?php the_content(); ?>
			<?php wp_link_pages("before=<p class='pages'>".__('Pages:','hybrid')."&after=</p>"); ?>
		</div>

		<p class="post-meta-data">
			<?php if(function_exists('wp_email')) : ?><span class="wp-email"><?php email_link(); ?></span> <span class="separator">|</span> <?php endif; ?> 
			<span class="categories"><span class="text"><?php _e('Posted in','hybrid'); ?></span> <?php the_category(', ') ?></span> 
			<?php the_tags('<span class="tags"> <span class="separator">|</span> <span class="text">' . __('Tagged','hybrid') . '</span> ', ', ', '</span>'); ?> 
		</p>

	</div>

	<?php endwhile; ?>

	<?php hybrid_after_single(); // After single post hook ?>

	<?php comments_template('', true); ?>

	<div class="navigation-links">
		<?php previous_post_link('<span class="previous">&laquo; %link</span>'); ?> 
		<?php next_post_link('<span class="next">%link &raquo;</span>'); ?>
	</div>

<?php else : ?>

	<p class="no-data"><?php _e('Sorry, no posts matched your criteria.','hybrid'); ?></p>

<?php endif; ?>

<?php get_footer(); ?>