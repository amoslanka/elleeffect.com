<?php
/*
Template Name: Archives
*/
?>

<?php get_header(); ?>

		<div class="content">

			<div class="post">

<h2>Search:</h2>
<?php include (TEMPLATEPATH . '/searchform.php'); ?>
<br />

<h2>Archives by Month:</h2>
  <ul>
    <?php wp_get_archives('type=monthly'); ?>
  </ul>

<h2>Archives by Subject:</h2>
  <ul>
     <?php wp_list_cats(); ?>
  </ul>

			</div> <!-- end post -->
		</div> <!-- end content -->

<?php get_footer(); ?>
