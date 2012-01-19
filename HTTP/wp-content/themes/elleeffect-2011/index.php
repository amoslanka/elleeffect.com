<?php get_header(); ?>

<div id="content">
	
	<?php query_posts($query_string . '&post_type=post'); ?>
	
	<?php if ( have_posts() ) : ?>

		<?php while ( have_posts() ) : the_post(); ?>

			<div <?php post_class() ?> id="post-<?php the_ID(); ?>">

				<div class="post-head">
					<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
					<div class="post-meta">posted by <?php the_author_posts_link(); ?> on <?php the_time('F jS, Y') ?></div>
				</div>

				<div class="entry">
					<?php the_content('Read more...'); ?>
					<div class="clearfix"></div>
				</div>

			</div>

		<?php endwhile; ?>
	
		<div class="post-navigation">
			<?php if (is_single()) : ?>
				<div class="alignleft"><?php previous_post_link('<strong>%link</strong>'); ?> </div>
				<div class="alignright"><?php next_post_link('<strong>%link</strong>'); ?> </div>
			<?php else : ?>
				<div class="alignleft"><?php next_posts_link('<strong>Older Entries</strong>'); ?></div>
				<div class="alignright"><?php previous_posts_link('<strong>Newer Entries</strong>'); ?></div>
			<?php endif; ?>
		</div>
	
		<?php comments_template(); ?>

	<?php else : ?>

		<h3>Error</h3>
		<p>Sorry, but you are looking for something that isn't here.</p>

	<?php endif; ?>
	
</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>