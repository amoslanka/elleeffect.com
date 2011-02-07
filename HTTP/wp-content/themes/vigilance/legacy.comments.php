<?php if ( !empty($post->post_password) && $_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) : ?>
<p><?php _e('Enter your password to view comments.'); ?></p>
<?php return; endif; ?>

<?php if ( $comments ) : ?>
<div class="comment-number">
	<span><?php comments_number(__('No Comments'), __('1 Comment'), __('% Comments')); ?></span>
	<?php if ( comments_open() ) : ?>
	<a id="leavecomment" href="#respond" title="<?php _e("Leave One"); ?>"> leave one &rarr;</a>
	<?php endif; ?>
</div>

<?php else : // If there are no comments yet ?>
<div class="comment-number">
	<span>No comments yet</span>
</div>
<?php endif; ?>

<?php if ( $comments ) : ?>
  <div id="comments">
  	<?php foreach ($comments as $comment) : ?>
  	<?php $isByAuthor = false; if($comment->comment_author_email == get_the_author_email()) { $isByAuthor = true; } ?>
  		<div class="c-single clear <?php if($isByAuthor ) { echo 'admin';} ?> <?php echo $oddcomment; ?>" id="comment-<?php comment_ID() ?>" >
  			<div class="c-grav"><?php echo get_avatar( get_comment_author_email(), '80' )?></div>
  			<div class="c-body">
          <div class="c-date">
            <span><?php comment_date('Y'); ?></span> <?php comment_date('F j'); ?>
          </div>
          <div class="c-head">
            <?php comment_author_link() ?> <span class="c-permalink"><a href="<?php echo get_permalink(); ?>#comment-<?php comment_ID(); ?>">permalink</a></span>
          </div>
          <?php if ($comment->comment_approved == '0') : ?>
            <p><em><strong>Please Note:</strong> Your comment is awaiting moderation.</em></p>
          <?php endif; ?>
  				<?php comment_text() ?>
          <?php comment_type((''),('Trackback'),('Pingback')); ?>
  				<?php edit_comment_link('edit','<p>','</p>'); ?>
  			</div>
  		</div>
  	<?php /* Changes every other comment to a different class */    
              if("alt" == $oddcomment) {$oddcomment="";}
              else { $oddcomment="alt"; }
        ?> 
  	<?php endforeach; ?>
  </div><!--end commentlist-->
<?php endif; ?>

<?php if ( comments_open() ) : ?>
  <h4 id="postcomment"><?php _e('Leave A Comment'); ?></h4>
  <div id="respond">
    <?php if ( get_option('comment_registration') && !$user_ID ) : ?>
      <p>You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php the_permalink(); ?>">logged in</a> to post a comment.</p>
      </div><!--end respond-->
    <?php else : ?>
      <form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
      <?php if ( $user_ID ) : ?>
        <p>Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="<?php _e('Log out of this account') ?>">Logout &raquo;</a></p>
      <?php else : ?>
        <p><label for="author" class="comment-field"><small>Name <?php if ($req) _e('(required)'); ?>:</small></label><input class="text-input" type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" /></p>
        <p><label for="email" class="comment-field"><small>Email <?php if ($req) _e('(required)'); ?>:</small></label><input class="text-input" type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" /></p>
        <p><label for="url" class="comment-field"><small>Website:</small></label><input class="text-input" type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" /></p>
      <?php endif; ?>
      <p><label for="comment" class="comment-field"><small>Comment:</small></label><textarea name="comment" id="comment" cols="50" rows="10" tabindex="4"></textarea></p>
      <p class="guidelines"><strong>Note:</strong> You can use basic XHTML in your comments. Your email address will <strong>never</strong> be published.</p>
      <p class="comments-rss"><?php comments_rss_link(__('Subscribe to this comment feed via RSS')); ?></p>
      <?php do_action('comment_form', $post->ID); ?>
      <p><input name="submit" type="submit" id="submit" tabindex="5" value="Submit Comment" /><input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" /></p>
      </form><!--end commentform-->
  </div><!--end respond-->
    <?php endif;?>
<?php else : // Comments are closed ?>
  <p class="note">Comments are closed for this entry.</p>
<?php endif; ?>
