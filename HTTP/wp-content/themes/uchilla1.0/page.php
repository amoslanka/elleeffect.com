<?php get_header(); ?>

		<div id="main" class="clear">
	   <div id="content">

    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="post" id="post-<?php the_ID(); ?>">
		<h2 class="singlePostTitle"><?php the_title(); ?></h2>
			<div class="entry-text">
				<?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>
	
				<?php wp_link_pages('<p><strong>Pages:</strong> ', '</p>', 'number'); ?>
	
			</div>
		</div>
	  <?php endwhile; endif; ?>	<?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>
	  	  	<?php comments_template(); ?>


 </div> <!-- end content div-->
 
  	  
 
<?php get_sidebar(); ?>
  </div>                  <!-- end the main div-->
<?php get_footer(); ?>
