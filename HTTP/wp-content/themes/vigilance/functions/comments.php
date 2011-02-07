<?php
// Template for comments
  function custom_comment($comment, $args, $depth) {
  $GLOBALS['comment'] = $comment;
?>
      <li <?php comment_class(); ?> id="comment-<?php comment_ID() ?>" >
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
          <div class="reply">
            <?php echo comment_reply_link(array('depth' => $depth, 'max_depth' => $args['max_depth']));  ?>
          </div>
  				<?php edit_comment_link('edit','<p>','</p>'); ?>
        </div><!--end c-body-->
<?php } ?>
<?php
// Template for pingbacks/trackbacks
  function list_pings($comment, $args, $depth) {
  $GLOBALS['comment'] = $comment;
?>
  <li id="comment-<?php comment_ID(); ?>"><?php comment_author_link(); ?>
<?php } ?>