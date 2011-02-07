<?php get_header(); ?>

<?php if(have_posts()) : while(have_posts()) : the_post(); ?>

	<div class="<?php hybrid_post_class(); ?>">

		<?php the_title('<h1 class="attachment-title entry-title"><a href="' . get_permalink() . '" title="' . the_title_attribute('echo=0') . '" rel="bookmark">', '</a></h1>'); ?>

		<div class="entry entry-content">

			<?php hybrid_handle_attachment(get_post_mime_type(), wp_get_attachment_url()); ?>

			<?php the_content(__('Continue reading','hybrid') . ' ' . the_title('"', '"', false)); ?>

			<p class="download">
				<?php hybrid_mime_type_icon(get_post_mime_type(), wp_get_attachment_url()); ?>
				<a href="<?php echo wp_get_attachment_url(); ?>" title="<?php the_title_attribute(); ?>"><?php printf(__('Download &quot;%1$s&quot;','hybrid'), get_the_title()); ?></a>
			</p>

			<?php wp_link_pages("before=<p class='pages'>".__('Pages:','hybrid')."&after=</p>"); ?>

		</div>

		<?php edit_post_link(__('Edit','hybrid'), '<p class="post-meta-data"><span class="edit">', '</span></p>'); ?>

	</div>

	<?php comments_template('', true); ?>

	<div class="navigation-links">
		<?php previous_post_link('<span class="previous">&laquo; %link</span>'); ?> 
		<?php next_post_link('<span class="next">%link &raquo;</span>'); ?>
	</div>

	<?php endwhile; ?>

<?php else: ?>

	<p class="no-data"><?php _e('Sorry, no audio files matched your criteria.','hybrid'); ?></p>

<?php endif; ?>

<?php get_footer(); ?>