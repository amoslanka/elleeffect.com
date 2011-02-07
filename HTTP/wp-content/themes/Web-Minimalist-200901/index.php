<?php get_header(); ?>

		<div class="content">

			<?php if(have_posts()) : ?>
			<?php while(have_posts())  : the_post(); ?>
			<div class="post" id="post-<?php the_ID(); ?>">

				<h2><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>

					<?php include (TEMPLATEPATH . '/postinfo.php'); ?>

				<div class="entry">

				<?php the_content('Read more...'); ?><div style="clear:both;"></div>

				<!-- <?php trackback_rdf(); ?> -->

				</div>


			</div>
			<?php endwhile; ?>



			<div class="navigation">
				<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } else { ?>

				<?php next_posts_link('<span class="alignleft">&laquo; Older posts</span>') ?>
				<?php previous_posts_link('<span class="alignright">Newer posts &raquo;</span>') ?>

				<?php } ?>
			</div>




			<?php else : ?>

			<div class="post">
				<?php _e('404 Error&#58; Not Found'); ?>
			</div>

			<?php endif; ?>

		</div>

<?php get_footer(); ?>