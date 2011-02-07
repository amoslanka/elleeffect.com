<?php add_filter('comment_text', 'popuplinks'); ?>

<?php while (have_posts()) : the_post(); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head>
<title><?php hybrid_document_title(); ?></title>

<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />

<?php hybrid_head(); // Hybrid head hook ?>

<?php wp_head(); // WP head hook ?>

</head>

<body class="<?php hybrid_body_class(); ?>">

<div id="body-container">

	<div id="header-container">

		<div id="header">

			<div id="site-title">
				<a href="<?php bloginfo('home'); ?>" title="<?php bloginfo('name'); ?>"><span><?php bloginfo('name'); ?></span></a>
			</div>
			<div id="site-description">
				<?php bloginfo('description'); ?>
			</div>

		</div>

	</div>

	<div id="container">

		<div id="content">


		<div id="comments-template">

<?php
	global $hybrid_settings;

	if('comments-popup.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die(__('Please do not load this page directly. Thanks!','hybrid'));
?>

<?php
	$commenter = wp_get_current_commenter();
	extract($commenter);
	$comments = get_approved_comments($id);
	$post = get_post($id);

	if(post_password_required($post)) :
		echo(get_the_password_form());
	endif;
?>

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

					<abbr class="published time date" title="<?php comment_date(__('F jS, Y, g:i a (P - e)','hybrid')); ?>">
						<?php printf(__('%1$s at %2$s','hybrid'), get_comment_date(), get_comment_time()); ?>
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

		<h3 id="reply">
			<?php _e('Leave a Reply','hybrid'); ?>
		</h3>

	<?php if(get_option('comment_registration') && !$user_ID) : ?>

		<p class="register">
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

			<p class="form-comment">
				<label for="comment"><?php _e('Comment','hybrid'); ?></label>
				<textarea name="comment" id="comment" cols="60" rows="10" tabindex="4"></textarea>
			</p>

			<p class="form-submit">
				<input class="submit-comment" name="submit" type="submit" id="submit" tabindex="5" value="<?php _e('Submit','hybrid'); ?>" />
				<input class="reset-comment" name="reset" type="reset" id="reset" tabindex="6" value="<?php _e('Reset','hybrid'); ?>" />
				<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
				<input type="hidden" name="redirect_to" value="<?php echo attribute_escape($_SERVER["REQUEST_URI"]); ?>" />
			</p>

			<div class="comment-action">
				<?php do_action('comment_form', $post->ID); ?>
			</div>

		</form>

	<?php endif; ?>

	</div>

<?php endif; ?>

</div>

<?php endwhile; ?>

		</div>

	</div>

	<div id="footer-container">

		<div id="footer">

			<?php hybrid_footer(); // Hybrid footer hook ?>

			<?php wp_footer(); // WordPress footer hook ?>

		</div>

	</div>

</div>

<script type="text/javascript">
<!--
document.onkeypress = function esc(e) {
	if(typeof(e) == "undefined") { e=event; }
	if (e.keyCode == 27) { self.close(); }
}
// -->
</script>

</body>
</html>