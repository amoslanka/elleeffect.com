<?php
/*
Template Name: Blog
Description: If you want to set up an alternate blog page, just use this template for your page.
Note: This template shows your latest posts.  It will only display the page title and content if there is content written.
*/
?>

<?php get_header(); ?>

<?php if($post->post_content && !is_paged()) : ?>

	<?php if(have_posts()) : while(have_posts()) : the_post(); ?>

		<div class="post">

			<?php the_title('<h1 class="page-title entry-title"><a href="' . get_permalink() . '" title="' . the_title_attribute('echo=0') . '" rel="bookmark">', '</a></h1>'); ?>

			<div class="entry entry-content">
				<?php the_content(); ?>
				<?php wp_link_pages("before=<p class='pages'>".__('Pages:','hybrid')."&after=</p>"); ?>
			</div>

		</div>

		<?php endwhile; ?>

	<?php endif; ?>

<?php endif; ?>

<?php
	$posts_wanted = get_option('posts_per_page');
	$wp_query = new WP_Query();
	$wp_query->query("posts_per_page=$posts_wanted&paged=$paged");
?>

<?php if($wp_query->have_posts()) : while($wp_query->have_posts()) : $wp_query->the_post(); ?>

	<div class="<?php hybrid_post_class(); ?>">

		<?php the_title('<h2 class="post-title entry-title"><a href="' . get_permalink() . '" title="' . the_title_attribute('echo=0') . '" rel="bookmark">', '</a></h2>'); ?>

		<p class="byline">
			<span class="text"><?php _e('By','hybrid'); ?></span> 
			<span class="author vcard"><?php the_author_posts_link(); ?></span> <span class="text"><?php _e('on','hybrid'); ?></span> 
			<abbr class="published time date" title="<?php the_time(__('F jS, Y, g:i a (P - e)','hybrid')); ?>"><?php the_time(__('F j, Y','hybrid')); ?></abbr> 
			<?php edit_post_link(__('Edit','hybrid'), ' <span class="separator">|</span> <span class="edit">', '</span> '); ?>
		</p>

		<div class="entry entry-content">
			<?php the_content(__('Continue reading','hybrid') . ' ' . the_title('"', '"', false)); ?>
			<?php wp_link_pages("before=<p class='pages'>".__('Pages:','hybrid')."&after=</p>"); ?>
		</div>

		<p class="post-meta-data">
			<span class="categories"><span class="text"><?php _e('Posted in','hybrid'); ?></span> <?php the_category(', ') ?></span> 
			<?php the_tags('<span class="tags"> <span class="separator">|</span> <span class="text">' . __('Tagged','hybrid') . '</span> ', ', ', '</span>'); ?> 
			<?php if(comments_open()) : ?><span class="separator">|</span><?php endif; ?> <?php comments_popup_link(__('Leave a comment','hybrid'), __('1 Comment','hybrid'), __('% Comments','hybrid'), 'comments-link', false); ?> 
		</p>

	</div>

	<?php endwhile; ?>

	<?php hybrid_after_page(); // After page hook ?>

<?php else: ?>

	<p clas="no-data"><?php _e('Sorry, no page matched your criteria.','hybrid'); ?></p>

<?php endif; ?>

<?php get_footer(); ?>