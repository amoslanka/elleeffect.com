<?php
/*
Template Name: Register
Description: Allow users to register from any page on your site.
Note: This template is under active development and may change drastically in the future.
*/

require_once( ABSPATH . WPINC . '/registration.php');
$registration = get_option('users_can_register');

if('POST' == $_SERVER['REQUEST_METHOD'] && !empty($_POST['action']) && $_POST['action'] == 'adduser') :

	$userdata = array(
		'user_pass' => $_POST['pass1'],
		'user_login' => $_POST['user-name'],
		'user_url' => $_POST['url'],
		'user_email' => $_POST['email'],
		'first_name' => $_POST['first-name'],
		'last_name' => $_POST['last-name'],
		'description' => $_POST['description'],
		'role' => get_option('default_role'),
	);

	if(($_POST['user-name']) && ($_POST['email']) && ($_POST['pass1']) && ($_POST['pass1'] == $_POST['pass2'])) :
		$new_user = wp_insert_user($userdata);
	else :
		if(!$_POST['user-name'])
			$error = __('A username is required for registration.','hybrid');
		elseif(!$_POST['email'])
			$error = __('You must enter an email address.','hybrid');
		elseif(!$_POST['pass1'])
			$error = __('You must enter a password.','hybrid');
		elseif(!$_POST['pass2'])
			$error = __('You must enter your password twice.','hybrid');
		elseif($_POST['pass1'] !== $_POST['pass2'])
			$error = __('You must enter the same password twice.','hybrid');
		else
			$error = __('User registration failed.  Please try again.','hybrid');
	endif;

endif;

get_header(); ?>

<?php if(have_posts()) : while(have_posts()) : the_post(); ?>

	<div class="<?php hybrid_post_class(); ?>">

		<?php the_title('<h1 class="page-title entry-title"><a href="' . get_permalink() . '" title="' . the_title_attribute('echo=0') . '" rel="bookmark">', '</a></h1>'); ?>

		<div class="entry entry-content">

			<?php the_content(); ?>

			<?php if(is_user_logged_in() && !current_user_can('create_users')) : ?>

				<p class="log-in-out alert">
					<?php printf(__('You are logged in as <a href="%1$s" title="%2$s">%2$s</a>.  You don\'t need another account.','hybrid'), get_author_posts_url($curauth->ID), $user_identity); ?> <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="<?php _e('Log out of this account','hybrid'); ?>"><?php _e('Logout &raquo;','hybrid'); ?></a>
				</p>

			<?php elseif($new_user) : ?>

				<p class="alert">
				<?php
					if(current_user_can('create_users'))
						printf(__('A user account for %1$s has been created.','hybrid'), $_POST['user-name']);
					else 
						printf(__('Thank you for registering, %1$s.','hybrid'), $_POST['user-name']);
				?>
				</p>

			<?php else : ?>

				<?php if($error) : ?>
					<p class="error">
						<?php echo $error; ?>
					</p>
				<?php endif; ?>

				<?php if(current_user_can('create_users')) :
					if($registration)
						echo '<p class="alert">' . __('Users can register themselves or you can manually create users here.','hybrid') . '</p>';
					else
						echo '<p class="alert">' . __('Users cannot currently register themselves, but you can manually create users here.','hybrid') . '</p>';
				endif; ?>

				<?php if($registration || current_user_can('create_users')) : ?>

					<form method="post" id="adduser" action="http://<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>">

					<p>
						<em><?php _e('Required fields are marked <span class="required">*</span>','hybrid'); ?></em>
					</p>
					<p>
						<label for="user-name"><?php _e('Username *','hybrid'); ?></label>
						<input class="text-input" name="user-name" type="text" id="user-name" <?php if($_POST['user-name'] && !$new_user) echo 'value="' . stripslashes(htmlentities($_POST['user-name'], ENT_QUOTES)) . '"'; ?> />
					</p>
					<p>
						<label for="first-name"><?php _e('First Name','hybrid'); ?></label>
						<input class="text-input" name="first-name" type="text" id="first-name" <?php if($_POST['first-name'] && !$new_user) echo 'value="' . stripslashes(htmlentities($_POST['first-name'], ENT_QUOTES)) . '"'; ?> />
					</p>
					<p>
						<label for="last-name"><?php _e('Last Name','hybrid'); ?></label>
						<input class="text-input" name="last-name" type="text" id="last-name" <?php if($_POST['last-name'] && !$new_user) echo 'value="' . stripslashes(htmlentities($_POST['last-name'], ENT_QUOTES)) . '"'; ?> />
					</p>
					<p>
						<label for="email"><?php _e('E-mail *','hybrid'); ?></label>
						<input class="text-input" name="email" type="text" id="email" <?php if($_POST['email'] && !$new_user) echo 'value="' . stripslashes(htmlentities($_POST['email'], ENT_QUOTES)) . '"'; ?> />
					</p>
					<p>
						<label for="url"><?php _e('Website','hybrid'); ?></label>
						<input class="text-input" name="url" type="text" id="url" <?php if($_POST['url'] && !$new_user) echo 'value="' . stripslashes(htmlentities($_POST['url'], ENT_QUOTES)) . '"'; ?> />
					</p>

					<?php if(apply_filters('show_password_fields', true)) : ?>
						<p>
							<label for="pass1"><?php _e('Password *','hybrid'); ?> </label>
							<input class="text-input" name="pass1" type="password" id="pass1" />
						</p>
						<p>
							<label for="pass2"><?php _e('Repeat Password *','hybrid'); ?></label>
							<input class="text-input" name="pass2" type="password" id="pass2" />
						</p>
					<?php endif; ?>

					<p>
						<label for="description"><?php _e('Biographical Information','hybrid') ?></label>
						<textarea name="description" id="description" rows="3" cols="50"><?php if($_POST['description'] && !$new_user) echo stripslashes(htmlentities($_POST['description'], ENT_QUOTES)); ?></textarea>
					</p>

					<p>
						<?php echo $referer; ?>
						<input name="adduser" type="submit" id="addusersub" class="submit button" value="<?php if(current_user_can('create_users')) _e('Add User','hybrid'); else _e('Register','hybrid'); ?>" />
						<?php wp_nonce_field('add-user') ?>
						<input name="action" type="hidden" id="action" value="adduser" />
					</p>

					</form>

				<?php endif; ?>

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