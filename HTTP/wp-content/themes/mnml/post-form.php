<?php
$user			= get_userdata( $current_user->ID );
$first_name		= attribute_escape( $user->first_name );
?>

<div id="postbox">
	<form id="new_post" name="new_post" method="post" action="<?php bloginfo( 'url' ); ?>/">
		<input type="hidden" name="action" value="post" />
		<?php wp_nonce_field( 'new-post' ); ?>

		<label for="posttext">Hi, <?php echo $first_name; ?>. Write a Quick Post.</label>
		<textarea name="posttext" id="posttext" rows="3" cols="60"></textarea>
	
		<label for="tags">Tag it</label>
		<input type="text" name="tags" id="tags" autocomplete="off" />
	
		<input id="submit" type="submit" value="Post it" />
	</form>

	<div id="user-info">[<a href="<?php echo get_option('siteurl'); ?>/wp-admin/post-new.php" title="<?php _e('Write a Full Post') ?>"><?php _e('Write a Full Post'); ?></a>, <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="<?php _e('Log out of this account') ?>"><?php _e('Sign Out'); ?></a>, <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php" title="<?php _e('View and Edit Your Profile') ?>"><?php _e('My Profile'); ?></a>] </p></div>

</div> <!-- #postbox -->
