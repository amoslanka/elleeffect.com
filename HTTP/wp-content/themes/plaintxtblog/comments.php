<div class="comments">
<?php
	$req = get_settings('require_name_email'); // Checks if fields are required
	if ( 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']) )
		die ( 'Please do not load this page directly. Thanks!' );
	if ( ! empty($post->post_password) ) :
		if ( $_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password ) :
?>
	<div class="nopassword"><?php _e('Enter the password to view comments to this post.', 'plaintxtblog') ?></div>
</div>
<?php
			return;
		endif;
	endif;
?>
<?php if ( $comments ) : ?>
<?php global $plaintxtblog_comment_alt // Gives .alt class for every-other comment/pingback ?>

<?php
$ping_count = $comment_count = 0;
foreach ( $comments as $comment )
	get_comment_type() == "comment" ? ++$comment_count : ++$ping_count;
?>

<?php if ( $comment_count ) : ?>
<?php $plaintxtblog_comment_alt = 0 // Resets comment count for .alt classes ?>

	<h3 class="comment-header" id="numcomments"><?php printf(__($comment_count > 1 ? '%d Comments' : 'One Comment', 'plaintxtblog'), $comment_count) ?></h3>
	<ol id="comments" class="commentlist">
<?php foreach ($comments as $comment) : ?>
<?php if ( get_comment_type() == "comment" ) : ?>
		<li id="comment-<?php comment_ID() ?>" class="<?php plaintxtblog_comment_class() ?>">
			<div class="comment-author vcard"><?php plaintxtblog_commenter_link() ?></div>
			<?php if ($comment->comment_approved == '0') : ?><span class="unapproved"><?php _e('Your comment is awaiting moderation.', 'plaintxtblog') ?></span><?php endif; ?>
			<?php comment_text() ?>
			<div class="comment-meta">
				<?php printf(__('<span class="comment-datetime">Posted on %1$s at %2$s</span> <span class="meta-sep">|</span> <span class="comment-permalink"><a href="%3$s" title="Permalink to this comment">Permalink</a></span>', 'plaintxtblog'),
						get_comment_date('d-M-y'),
						get_comment_time(),
						'#comment-' . get_comment_ID() );
				?> <?php edit_comment_link(__('Edit', 'plaintxtblog'), '<span class="comment-edit"> | ', '</span>'); ?>

			</div>
		</li>

<?php endif; ?>
<?php endforeach; ?>

	</ol><!-- end #comments .commentlist -->

<?php endif; ?>

<?php if ( $ping_count ) : ?>
<?php $plaintxtblog_comment_alt = 0 // Resets comment count for .alt classes ?>

	<h3 class="comment-header" id="numpingbacks"><?php printf(__($ping_count > 1 ? '%d Trackbacks/Pingbacks' : 'One Trackback/Pingback', 'plaintxtblog'), $ping_count) ?></h3>
	<ol id="pingbacks" class="commentlist">

<?php foreach ( $comments as $comment ) : ?>
<?php if ( get_comment_type() != "comment" ) : ?>

		<li id="comment-<?php comment_ID() ?>" class="<?php plaintxtblog_comment_class() ?>">
			<div class="comment-meta">
				<?php printf(__('<span class="pingback-author fn">%1$s</span> <span class="pingback-datetime">on %2$s at %3$s</span>', 'plaintxtblog'),
					get_comment_author_link(),
					get_comment_date('d-M-y'),
					get_comment_time());
				?> <?php edit_comment_link(__('Edit', 'plaintxtblog'), '<span class="comment-edit"> | ', '</span>'); ?>
			</div>
			<?php if ($comment->comment_approved == '0') : ?><span class="unapproved"><?php _e('Your trackback/pingback is awaiting moderation.', 'plaintxtblog') ?></span><?php endif; ?>
			<?php comment_text() ?>
		</li>

<?php endif ?>
<?php endforeach; ?>

	</ol><!-- end #pingbacks .commentlist -->

<?php endif ?>
<?php endif ?>

<?php if ( 'open' == $post->comment_status ) : ?>

	<h3 id="respond"><?php _e('Post a Comment', 'plaintxtblog') ?></h3>
<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
	<div id="mustlogin"><?php printf(__('You must be <a href="%s" title="Log in">logged in</a> to post a comment.', 'plaintxtblog'),
			get_option('siteurl') . '/wp-login.php?redirect_to=' . get_permalink() ) ?></div>

<?php else : ?>

	<div class="formcontainer">	

		<form id="commentform" action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post">

<?php if ( $user_ID ) : ?>

			<div id="loggedin"><?php printf(__('Logged in as <a href="%1$s" title="View your profile" class="fn">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'plaintxtblog'),
					get_option('siteurl') . '/wp-admin/profile.php',
					wp_specialchars($user_identity, true),
					get_option('siteurl') . '/wp-login.php?action=logout&amp;redirect_to=' . get_permalink() ) ?></div>

<?php else : ?>

			<div id="comment-notes"><?php _e('Your email is <em>never</em> published nor shared.', 'plaintxtblog') ?> <?php if ($req) _e('Required fields are marked <span class="req-field">*</span>', 'plaintxtblog') ?></div>

			<div class="form-input"><input id="author" name="author" type="text" value="<?php echo $comment_author ?>" size="30" maxlength="20" tabindex="3" /></div>
			<div class="form-label"><label for="author"><?php _e('Name', 'plaintxtblog') ?></label> <?php if ($req) _e('<span class="req-field">*</span>', 'plaintxtblog') ?></div>

			<div class="form-input"><input id="email" name="email" type="text" value="<?php echo $comment_author_email ?>" size="30" maxlength="50" tabindex="4" /></div>
			<div class="form-label"><label for="email"><?php _e('Email', 'plaintxtblog') ?></label> <?php if ($req) _e('<span class="req-field">*</span>', 'plaintxtblog') ?></div>

			<div class="form-input"><input id="url" name="url" type="text" value="<?php echo $comment_author_url ?>" size="30" maxlength="50" tabindex="5" /></div>
			<div class="form-label"><label for="url"><?php _e('Website', 'plaintxtblog') ?></label></div>

<?php endif ?>

			<div class="form-textarea"><textarea id="comment" name="comment" cols="45" rows="8" tabindex="6"></textarea></div>
			<div class="form-label"><label for="comment"><?php _e('Comment', 'plaintxtblog') ?></label></div>

			<div class="form-submit"><input id="submit" name="submit" type="submit" value="<?php _e('Submit', 'plaintxtblog') ?>" tabindex="7" /><input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" /></div>

<?php do_action('comment_form', $post->ID); ?>

		</form><!-- #commentform -->
	</div><!-- .formcontainer -->

<?php endif ?>
<?php endif ?>

</div><!-- .comments -->