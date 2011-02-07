<?php get_header(); ?>

<?php if(have_posts()) : while(have_posts()) : the_post(); ?>

	<div class="<?php hybrid_post_class(); ?>">

		<?php the_title('<h1 class="attachment-title entry-title"><a href="' . get_permalink() . '" title="' . the_title_attribute('echo=0') . '" rel="bookmark">', '</a></h1>'); ?>

		<div class="entry entry-content">
			<p>
				<a href="<?php echo wp_get_attachment_url(); ?>" title="<?php the_title_attribute(); ?>" rel="lightbox">
					<img class="aligncenter" src="<?php echo wp_get_attachment_url(); ?>" alt="<?php the_title_attribute(); ?>" title="<?php the_title_attribute(); ?>" />
				</a>
			</p>

			<?php the_content(__('Continue reading','hybrid') . ' ' . the_title('"', '"', false)); ?>
			<?php wp_link_pages("before=<p class='pages'>".__('Pages:','hybrid')."&after=</p>"); ?>
		</div>

		<p class="navigation-attachment">
			<span class="alignleft"><?php previous_image_link(); ?></span>
			<span class="alignright"><?php next_image_link(); ?></span>
		</p>

		<?php edit_post_link(__('Edit','hybrid'), '<p class="post-meta-data"><span class="edit">', '</span></p>'); ?>

	</div>
	
	<?php comments_template('', true); ?>

	<div class="navigation-links">
		<?php previous_post_link('<span class="previous">&laquo; %link</span>'); ?> 
		<?php next_post_link('<span class="next">%link &raquo;</span>'); ?>
	</div>

	<?php endwhile; ?>

<?php else: ?>

	<p class="no-data"><?php _e('Sorry, no images matched your criteria.','hybrid'); ?></p>

<?php endif; ?>

<?php get_footer(); ?>