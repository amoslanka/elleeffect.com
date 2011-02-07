<?php get_header(); ?>

		<div class="content">

		<?php if (have_posts()) : ?>

			<div class="post">
		 <?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
<?php /* If this is a category archive */ if (is_category()) { ?>				
		<h2>Archive for the '<?php echo single_cat_title(); ?>' Category</h2>
		
 	  <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
		<h2>Archive for <?php the_time('F jS, Y'); ?></h2>
		
	 <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
		<h2>Archive for <?php the_time('F, Y'); ?></h2>

		<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
		<h2>Archive for <?php the_time('Y'); ?></h2>
		
	  <?php /* If this is a search */ } elseif (is_search()) { ?>
		<h2>Search Results</h2>
		
	  <?php /* If this is an author archive */ } elseif (is_author()) { ?>
		<h2>Author Archive</h2>

		<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
		<h2>Blog Archives</h2>

		<?php } ?>
			</div>


			<?php while(have_posts())  : the_post(); ?>
			<div class="post" id="post-<?php the_ID(); ?>">

				<h2><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>

					<?php include (TEMPLATEPATH . '/postinfo.php'); ?>

				<div class="entry">

				<?php the_excerpt(); ?>

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