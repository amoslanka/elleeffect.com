<?php get_header(); ?>

		<div class="content">

			<?php if(have_posts()) : ?><?php while(have_posts())  : the_post(); ?>
			<div class="post" id="post-<?php the_ID(); ?>">

				<h2><?php the_title(); ?></h2>

					<?php include (TEMPLATEPATH . '/postinfo.php'); ?>

				<div class="entry">

				<?php the_content(); ?>

				<?php link_pages('<p><strong>Pages:</strong> ', '</p>', 'number'); ?>

				<!-- <?php trackback_rdf(); ?> -->

				</div>
				<div class="comments">
					<?php comments_template(); ?>
				</div>
			</div>
			<?php endwhile; ?>

			<div class="navigation">
			<div class="alignleft"><?php previous_post_link('&laquo; %link') ?></div>
			<div class="alignright"><?php next_post_link('%link &raquo;') ?></div>
			<div style="clear:both;"></div>
			</div>

			<?php else : ?>

			<div class="post">
				<?php _e('404 Error&#58; Not Found'); ?>
			</div>

			<?php endif; ?>

		</div>

<?php get_footer(); ?>