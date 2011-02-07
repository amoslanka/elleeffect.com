<?php
/*
Template Name: Logged In
Description: A template that only allows logged in users to view the content.
Optional: Set a custom field value with a valid capability and the key Capability to only allow certain users acces.
See: http://codex.wordpress.org/Roles_and_Capabilities
*/
?>

<?php get_header(); ?>

<?php if(hybrid_capability_check()) : // If user is logged in ?>

	<?php if(have_posts()) : while(have_posts()) : the_post(); ?>

		<div class="<?php hybrid_post_class(); ?>">

			<?php the_title('<h1 class="page-title entry-title"><a href="' . get_permalink() . '" title="' . the_title_attribute('echo=0') . '" rel="bookmark">', '</a></h1>'); ?>

			<div class="entry entry-content">
				<?php the_content(); ?>
				<?php wp_link_pages("before=<p class='pages'>".__('Pages:','hybrid')."&after=</p>"); ?>
			</div>

			<?php edit_post_link(__('Edit','hybrid'), '<p class="post-meta-data"><span class="edit">', '</span></p>'); ?>

		</div>

		<?php endwhile; ?>

		<?php hybrid_after_page(); // After page hook ?>

		<?php comments_template('', true); ?>

	<?php else: ?>

		<p class="no-data"><?php _e('Sorry, no page matched your criteria.','hybrid'); ?></p>

	<?php endif; ?>

<?php else : // If user is not logged in ?>

	<div class="<?php hybrid_post_class(); ?>">

		<?php the_title('<h1 class="page-title entry-title"><a href="' . get_permalink() . '" title="' . the_title_attribute('echo=0') . '" rel="bookmark">', '</a></h1>'); ?>

		<div class="entry entry-content">

			<p class="alert">
				<?php printf(__('You must be <a href="%1$s" title="Log in">logged in</a> to view the content of this page.','hybrid'), hybrid_template_in_use('log-in.php')); ?>

				<?php if(get_option('users_can_register')) : ?>
					<?php printf(__('If you\'re not currently a member, please take a moment to <a href="%1$s" title="Register">register</a>.','hybrid'), hybrid_template_in_use('register.php')); ?>
				<?php endif; ?>
			</p>

		</div>

	</div>

	<?php hybrid_after_page(); // After page hook ?>

<?php endif; ?>

<?php get_footer(); ?>