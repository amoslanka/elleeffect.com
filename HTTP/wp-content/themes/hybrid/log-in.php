<?php
/*
Template Name: Log In
Description: Allow users to log in from any page on your site.
Note: This template is under active development and may change drastically in the future.
*/

if('POST' == $_SERVER['REQUEST_METHOD'] && !empty($_POST['action']) && $_POST['action'] == 'log-in') :

	global $error;
	$login = wp_login($_POST['user-name'], $_POST['password']);
	$login = wp_signon(array('user_login' => $_POST['user-name'], 'user_password' => $_POST['password'], 'remember' => $_POST['remember-me']), false);

endif;

get_header(); ?>

<?php if(have_posts()) : while(have_posts()) : the_post(); ?>

	<div class="<?php hybrid_post_class(); ?>">

		<?php the_title('<h1 class="page-title entry-title"><a href="' . get_permalink() . '" title="' . the_title_attribute('echo=0') . '" rel="bookmark">', '</a></h1>'); ?>

		<div class="entry entry-content">
			<?php the_content(); ?>

			<?php if(is_user_logged_in()) : // Already logged in ?>

				<?php global $user_ID; $login = get_userdata($user_ID); ?>

				<p class="alert">
					<?php printf(__('You are currently logged in as <a href="%1$s" title="%2$s">%2$s</a>.','hybrid'), get_author_posts_url($login->ID), $login->display_name); ?> <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="<?php _e('Log out of this account','hybrid'); ?>"><?php _e('Logout &raquo;','hybrid'); ?></a>
				</p>

			<?php elseif($login->ID) : // Successful login ?>

				<?php $login = get_userdata($login->ID); ?>

				<p class="alert">
					<?php printf(__('You have successfully logged in as <a href="%1$s" title="%2$s">%2$s</a>.','hybrid'), get_author_posts_url($login->ID), $login->display_name); ?>
				</p>

			<?php else : // Not logged in ?>

				<?php if($error) : ?>
					<p class="error">
						<?php echo $error; ?>
					</p>
				<?php endif; ?>

				<form action="<?php the_permalink(); ?>" method="post" class="sign-in">
					<p class="form-username">
						<label for="user-name"><?php _e('Username','hybrid'); ?></label>
						<input type="text" name="user-name" id="user-name" class="text-input" value="<?php echo stripslashes(htmlentities($_POST['user-name'], ENT_QUOTES)); ?>" />
					</p>

					<p class="form-password">
						<label for="password"><?php _e('Password','hybrid'); ?></label>
						<input type="password" name="password" id="password" class="text-input" />
					</p>

					<p class="form-submit">
						<input type="submit" name="submit" class="submit button" value="<?php _e('Log in','hybrid'); ?>" />
						<input class="remember-me checkbox" name="remember-me" id="remember-me" type="checkbox" checked="checked" value="forever" />
						<label for="remember-me"><?php _e('Remember me','hybrid'); ?></label>
						<input type="hidden" name="action" value="log-in" />
					</p>
				</form>

			<?php endif; ?>

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

<?php get_footer(); ?>