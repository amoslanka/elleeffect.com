<?php get_header(); ?>

		<div class="content">

			<?php if(have_posts()) : ?><?php while(have_posts())  : the_post(); ?>
			<div class="post" id="post-<?php the_ID(); ?>">
				<h2><?php the_title(); ?></h2>
				<div class="entry">

				<?php the_content(); ?>
				<?php link_pages('<p><strong>Pages:</strong> ', '</p>', 'number'); ?>

				<?php edit_post_link('Edit', '<p>', '</p>'); ?>

				<!-- <?php trackback_rdf(); ?> -->

				</div>
				<div class="comments">
					<?php comments_template(); ?>
				</div>
			</div>
			<?php endwhile; ?>

			<?php else : ?>

			<div class="post">
				<?php _e('404 Error&#58; Not Found'); ?>
			</div>

			<?php endif; ?>

		</div>

<?php get_footer(); ?>