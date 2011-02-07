<?php
	if('legacy.comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die(__('Please do not load this page directly. Thanks!','hybrid'));

	if(!empty($post->post_password)) :

		if($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) :
			echo '<h3 id="comments">' . __('Password Protected','hybrid') . '</h3>';
			echo '<p class="password-protected">' . __('Enter the password to view comments.','hybrid') . '</p>';
			return;
		endif;

	endif;
?>

<?php if($comments || 'open' == $post->comment_status || 'open' == $post->ping_status) echo '<div id="comments-template">'; ?>

<?php if($comments) : ?>

	<div id="comments">

		<h3 id="comments-number" class="comments-header">
			<?php comments_number(__('No Responses','hybrid'), __('One Response','hybrid'), '% '.__('Responses','hybrid')); ?> 
			<?php _e('to','hybrid'); ?> &#8220;<?php the_title(); ?>&#8221;
		</h3>

		<ol class="comment-list">

		<?php foreach($comments as $comment) : ?>

			<li id="comment-<?php comment_ID(); ?>" class="<?php hybrid_comment_class(); ?>">

				<?php hybrid_avatar(); // Avatar filter ?>

				<div class="comment-meta-data">

					<div class="comment-author vcard">
						<?php hybrid_comment_author(); ?>
					</div>

					<abbr class="comment-time" title="<?php comment_date(__('c','hybrid')); ?>">
						<?php comment_date(__('M jS, Y','hybrid')); ?> 
						<?php _e('at','hybrid'); ?> <?php comment_time(); ?>
					</abbr> 

					<span class="separator">|</span> 
					<a class="permalink" href="#comment-<?php comment_ID(); ?>" title="<?php _e('Permalink to comment','hybrid'); ?>"><?php _e('Permalink','hybrid'); ?></a>

					<?php edit_comment_link('<span class="edit">'.__('Edit','hybrid').'</span>',' <span class="separator">|</span> ',''); ?> 

					<?php if($comment->comment_approved == '0') : ?>
						<em><?php _e('Your comment is awaiting moderation.','hybrid'); ?></em>
					<?php endif; ?>
				</div>

				<div class="comment-text">
					<?php comment_text(); ?>
				</div>
			</li>

		<?php endforeach; ?>

		</ol>

	</div>

<?php else : ?>

	<?php if('open' == $post->comment_status) : ?>

	<?php elseif('open' == $post->ping_status && is_single()) : ?>

		<p class="comments-closed">
			<?php printf(__('Comments are closed, but <a href="%1$s" title="Trackback URL for this post">trackbacks</a> and pingbacks are open.','hybrid'), trackback_url('0')); ?>
		</p>

	<?php elseif(is_single()) : ?>

		<p class="comments-closed">
			<?php _e('Comments are closed.','hybrid'); ?>
		</p>

	<?php endif; ?>

<?php endif; ?>

<?php if('open' == $post->comment_status) : ?>

	<div id="respond">

	<h3 id="reply"><?php _e('Leave a Reply','hybrid'); ?></h3>

	<?php if(get_option('comment_registration') && !$user_ID) : ?>

		<p class="register">
			<?php printf(__('You must be <a href="%1$s" title="Log in">logged in</a> to post a comment.','hybrid'), hybrid_template_in_use('log-in.php')); ?>
		</p>

	<?php else : ?>

		<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">

			<?php if($user_ID) : ?>

				<p class="logged-in">
					<?php printf(__('Logged in as <a href="%1$s" title="%2$s">%2$s</a>.','hybrid'), get_option('siteurl') . '/wp-admin/profile.php', $user_identity); ?> <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="<?php _e('Log out of this account','hybrid'); ?>"><?php _e('Logout','hybrid'); ?> &raquo;</a>
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

			<p class="form-comment">
				<label for="comment"><?php _e('Comment','hybrid'); ?></label>
				<textarea name="comment" id="comment" cols="60" rows="10" tabindex="4"></textarea>
			</p>

			<p class="form-submit">
				<input class="submit-comment button" name="submit" type="submit" id="submit" tabindex="5" value="<?php _e('Submit','hybrid'); ?>" />
				<input class="reset-comment button" name="reset" type="reset" id="reset" tabindex="6" value="<?php _e('Reset','hybrid'); ?>" />
				<input type="hidden" name="comment_parent" id="comment-parent" value="0" />
				<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
			</p>

			<div class="comment-action">
				<?php do_action('comment_form', $post->ID); ?>
			</div>

		</form>

	<?php endif; ?>

	</div>

<?php endif; ?>

<?php if($comments || 'open' == $post->comment_status || 'open' == $post->ping_status) echo '</div>'; ?>