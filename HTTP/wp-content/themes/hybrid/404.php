<?php
/*
* 404 Template
* @plugin http://wordpress.org/extend/plugins/smart-404
*/
?>

<?php @header("HTTP/1.1 404 Not found", TRUE, 404); ?>

<?php get_header(); ?>

	<div class="<?php hybrid_post_class(); ?>">

		<h1 class="error-404-title entry-title">
			<?php _e('Not Found','hybrid'); ?>
		</h1>

		<div class="entry entry-content">

			<p>
			<?php printf(__('You tried going to %1$s, and it doesn\'t exist. All is not lost! You can search for what you\'re looking for.','hybrid'), '<code>' . get_bloginfo('url') . $_SERVER['REQUEST_URI'] . '</code>'); ?>
			</p>

			<?php hybrid_search_form(); ?>

		</div>

	</div>

	<?php if(function_exists('smart404_suggestions')) : ?>

		<?php if(smart404_has_suggestions()) : ?>

			<div class="<?php hybrid_post_class(); ?>">

				<h2><?php _e('Possibly Related','hybrid'); ?></h2>

				<ul>
				<?php smart404_loop(); ?>
				<?php while(have_posts()) : the_post(); ?>
					<li><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></li>
				<?php endwhile; ?>
				</ul>

			</div>

		<?php endif; ?>

	<?php endif; ?>

<?php get_footer(); ?>