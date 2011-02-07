<?php 
  $feed_title = get_option('V_feed_title'); 
  $feed_intro = get_option('V_feed_intro');
  $feed_email = get_option('V_feed_email');
?>
    <h2 class="widgettitle"><?php echo $feed_title; ?></h2>
    <div id="rss-feed" class="clear"> 
      <p><?php echo $feed_intro; ?></p>
      <a class ="rss" href="<?php bloginfo('rss2_url'); ?>">Subscribe to RSS</a>
      <a class="email" href="<?php echo htmlspecialchars($feed_email, UTF-8); ?>">Receive email updates</a>
    </div>
  	