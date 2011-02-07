<?php
	if('comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die(__('Please do not load this page directly. Thanks!','hybrid'));

	if(post_password_required()) :
		echo '<h3 id="comments">' . __('Password Protected','hybrid') . '</h3>';
		echo '<p class="alert password-protected">' . __('Enter the password to view comments.','hybrid') . '</p>';
		return;
	endif;
?>

<?php if(have_comments() || comments_open() || pings_open()) echo '<div id="comments-template">'; ?>

<?php if(have_comments()) : ?>

	<div id="comments">

		<h3 id="comments-number" class="comments-header">
			<?php comments_number(__('No Responses','hybrid'), __('One Response','hybrid'), '% '.__('Responses','hybrid')); ?> 
			<?php _e('to','hybrid'); ?> &#8220;<?php the_title(); ?>&#8221;
		</h3>

		<ol class="comment-list">
			<?php wp_list_comments(array(
				'style' => 'ol',
				'type' => 'all',
				'callback' => 'hybrid_comments_callback',
				'end-callback' => 'hybrid_comments_end_callback'
				)
			); ?>
		</ol>

		<?php if(get_option('page_comments')) : ?>
			<div class="paged-navigation">
				<?php paginate_comments_links(); ?>
			</div>
		<?php endif; ?>

	</div>

<?php else : ?>

	<?php if(pings_open() && !comments_open() && is_single()) : ?>

		<p class="comments-closed pings-open">
			<?php printf(__('Comments are closed, but <a href="%1$s" title="Trackback URL for this post">trackbacks</a> and pingbacks are open.','hybrid'), trackback_url('0')); ?>
		</p>

	<?php elseif(!comments_open() && is_single()) : ?>

		<p class="comments-closed">
			<?php _e('Comments are closed.','hybrid'); ?>
		</p>

	<?php endif; ?>

<?php endif; ?>

<?php if(comments_open()) : ?>

	<div id="respond">

		<h3 id="reply">
			<?php comment_form_title(__('Leave a Reply','hybrid'), __('Leave a Reply to %s','hybrid'), true); ?>
		</h3>

		<p id="cancel-comment-reply">
			<?php cancel_comment_reply_link(__('Click here to cancel reply.','hybrid')) ?>
		</p>

	<?php if(get_option('comment_registration') && !$user_ID) : ?>

		<p class="alert">
			<?php printf(__('You must be <a href="%1$s" title="Log in">logged in</a> to post a comment.','hybrid'), hybrid_template_in_use('log-in.php')); ?>
		</p>

	<?php else : ?>

		<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">

			<?php if($user_ID) : ?>

				<p class="log-in-out">
					<?php printf(__('Logged in as <a href="%1$s" title="%2$s">%2$s</a>.','hybrid'), get_option('siteurl') . '/wp-admin/profile.php', $user_identity); ?> <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="<?php _e('Log out of this account','hybrid'); ?>"><?php _e('Logout &raquo;','hybrid'); ?></a>
				</p>

			<?php else : ?>

				<p class="form-author">
					<label for="author"><?php _e('Name','hybrid'); ?> <?php if($req) : ?><span class="required"><?php _e('*','hybrid'); ?></span><?php endif; ?></label>
					<input type="text" class="text-input" name="author" id="author" value="<?php echo $comment_author; ?>" size="40" tabindex="1" />
				</p>

				<p class="form-email">
					<label for="email"><?php _e('Email','hybrid'); ?>  <?php if($req) : ?><span class="required"><?php _e('*','hybrid'); ?></span><?php endif; ?></label>
					<input type="text" class="text-input" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="40" tabindex="2" />
				</p>

				<p class="form-url">
					<label for="url"><?php _e('Website','hybrid'); ?></label>
					<input type="text" class="text-input" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="40" tabindex="3" />
				</p>

			<?php endif; ?>

			<p class="form-textarea">
				<label for="comment"><?php _e('Comment','hybrid'); ?></label>
				<textarea name="comment" id="comment" cols="60" rows="10" tabindex="4"></textarea>
			</p>

			<p class="form-submit">
				<input class="submit-comment button" name="submit" type="submit" id="submit" tabindex="5" value="<?php _e('Submit','hybrid'); ?>" />
				<input class="reset-comment button" name="reset" type="reset" id="reset" tabindex="6" value="<?php _e('Reset','hybrid'); ?>" />
				<?php comment_id_fields(); ?>
			</p>

			<div class="comment-action">
				<?php do_action('comment_form', $post->ID); ?>
			</div>

		</form>

	<?php endif; ?>

	</div>

<?php endif; ?>

<?php if(have_comments() || comments_open() || pings_open()) echo '</div>'; ?>