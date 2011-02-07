<?php get_header(); ?>

	<div id="main" class="clear">
	   <div id="content">

		<?php if (have_posts()) : ?>

		 <?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
<?php /* If this is a category archive */ if (is_category()) { ?>				
		<h1 class="pagetitle">Archive for  <strong><?php echo single_cat_title(); ?></strong></h1>
		
 	  <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
		<h1 class="pagetitle">Archive for <strong><?php the_time('F jS, Y'); ?></strong></h1>
		
	 <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
		<h1 class="pagetitle">Archive for <strong><?php the_time('F, Y'); ?></strong></h1>

		<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
		<h1 class="pagetitle">Archive for <strong><?php the_time('Y'); ?></strong></h1>
		
	  <?php /* If this is a search */ } elseif (is_search()) { ?>
		<h1 class="pagetitle">Search Results</h1>
		
	  <?php /* If this is an author archive */ } elseif (is_author()) { ?>
		<h1 class="pagetitle">Author Archive</h1>

		<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
		<h1 class="pagetitle">Blog Archives</h1>

		<?php } ?>


	

		<?php
		while (have_posts()) : the_post();
		$image = get_post_meta($post->ID, 'photo', true);
		?>
		<div class="post clear" id="post-<?php the_ID(); ?>">
				<div class="entry-date">
					<div class="entry-day"><?php the_time('d'); ?></div>
					<div class="entry-month"><?php the_time('M'); ?></div>
					<div class="entry-year"><?php the_time('Y'); ?></div>
				</div>	
				<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h2>			
				<?=get_the_tag_list('<div class="entry-filed">Tags: ',', ','</div>')?>
				<div class="entry-content">
					<?php if($image!=''): ?>
						<div class="image"><img src="<?=$image?>" alt="<?php the_title(); ?>" /></div>
					<?php endif; ?>
					<?php the_excerpt(''); ?>
				</div>
				
				<div style="clear:both"></div>
				
				<p><a href="<?php the_permalink() ?>" class="more-link">Continue reading &raquo;</a> <span class="comments_link"><?php comments_popup_link('No comments', '1 Comment', '% Comments'); ?></span></p>
				
		      <?php wp_link_pages();?>

	
  	</div>
  	<!-- end the post div-->
		<?php endwhile; ?>

		<div class="navigation">
			<div class="alignleft"><?php next_posts_link('&laquo; Previous Entries') ?></div>
			<div class="alignright"><?php previous_posts_link('Next Entries &raquo;') ?></div>
		</div>
	
	<?php else : ?>

		<h2>Nothing found</h2>
		<p class="center">Sorry, but you are looking for something that isn't here.</p>
		<p><a href="javascript:history.back(-1)"><strong>&laquo; Go back</strong></a></p>

	<?php endif; ?>
		

      </div><!-- end content div-->
       	  
<?php get_sidebar(); ?>
</div> <!-- end main div-->
<?php get_footer(); ?>
