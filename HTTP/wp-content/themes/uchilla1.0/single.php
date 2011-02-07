<?php get_header(); ?>

<div id="main" class="clear">
	   <div id="content">
				
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
		<div class="navigation postNav clear">
			<div class="alignleft"><?php previous_post_link('&laquo; %link') ?></div>
			<div class="alignright"><?php next_post_link('%link &raquo;') ?></div>
		</div>
	
		<div class="post single clear" id="post-<?php the_ID(); ?>">
			
			<div class="entry-date">
					<div class="entry-day"><?php the_time('d'); ?></div>
					<div class="entry-month"><?php the_time('M'); ?></div>
					<div class="entry-year"><?php the_time('Y'); ?></div>
				</div>
			
			<h2 class="singlePostTitle"><?php the_title(); ?></h2>
	
			<div class="entry-text">
				<?php the_content('<p class="serif">Read the rest of this entry &raquo;</p>'); ?>
				
				<br /><br />
	
				<?php wp_link_pages('<p><strong>Pages:</strong> ', '</p>', 'number'); ?>
				
				<?=get_the_tag_list('<span class="entry-filed">Tags: ',', ','</span>')?>
	
				<div class="underpost">
					
						This entry was posted
						
						on <?php the_time('l, F jS, Y') ?> at <?php the_time() ?>
						and is filed under <?php the_category(', ') ?>.
						You can follow any responses to this entry through the <?php comments_rss_link('RSS 2.0'); ?> feed. 
						
						<?php if (('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
							// Both Comments and Pings are open ?>
							You can <a href="#respond">leave a response</a>, or <a href="<?php trackback_url(true); ?>" rel="trackback">trackback</a> from your own site.
						
						<?php } elseif (!('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
							// Only Pings are Open ?>
							Responses are currently closed, but you can <a href="<?php trackback_url(true); ?> " rel="trackback">trackback</a> from your own site.
						
						<?php } elseif (('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
							// Comments are open, Pings are not ?>
							You can skip to the end and leave a response. Pinging is currently not allowed.
			
						<?php } elseif (!('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
							// Neither Comments, nor Pings are open ?>
							Both comments and pings are currently closed.			
						
						<?php } edit_post_link('Edit this entry.','',''); ?>
						
					
				</div><!-- end underpost div-->
	
			</div><!-- end entry-text div -->
			
		</div><!-- end post div-->
		
	<?php comments_template(); ?>
	
	<?php endwhile; else: ?>
	
		<p>Sorry, no posts matched your criteria.</p>
	
<?php endif; ?>

 </div> <!-- end content div-->
 
 	  

<?php get_sidebar(); ?>
  </div>                  <!-- end the main div-->
<?php get_footer(); ?>
