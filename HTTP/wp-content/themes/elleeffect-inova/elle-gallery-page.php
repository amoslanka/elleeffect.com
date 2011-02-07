<?php
/*
Template Name: Elle Gallery Page
*/
?>

<?php
	// global $inove_nosidebar;
	$inove_nosidebar = true;
	// include('page.php');
?>


<?php // $bg_image_path = get_bloginfo('template_directory') . "/images/bl-info-bg.jpg"; ?>

<?php include('portfolio/header.php'); ?>



<table cellspacing="0" cellpadding="0" border="0" width="100%" height="100%">

	<tr><td align="center" valign="center" width="100%" height="100%">
		<?php if (have_posts()) : the_post(); update_post_caches($posts); 
			$custom_fields = get_post_custom();
			$gallery_landing_image_1 = $custom_fields['gallery_landing_image_1'][0];
			$gallery_landing_image_2 = $custom_fields['gallery_landing_image_2'][0];
			$gallery_landing_image_3 = $custom_fields['gallery_landing_image_3'][0];
			$gallery_landing_page_id = $custom_fields['gallery_landing_page_id'][0];
			the_content();
			endif;
		?>
	</td></tr>
	<tr><td align="center" valign="center" height="1">
		<div id="splash-nav">  <!-- id="splash-nav" class="absolute-navX" align="center"  -->
			<table cellspacing="0" cellpadding="0" border="0" align="center">
				<tr><td>
					<a class="elle-effect-button bg-btn" href="<?php bloginfo('url'); ?>" ></a>
				</td><td>
					<div style="width:20px"></div>
				</td><td>
					<a class="<?php if ($gallery_landing_page_id == 'wedding') echo 'btn-selected '; ?>wedding-button bg-btn" href="<?php bloginfo('url'); ?>/wedding/" ></a>
				</td><td>
					<a class="<?php if ($gallery_landing_page_id == 'travel') echo 'btn-selected '; ?>travel-button bg-btn" href="<?php bloginfo('url'); ?>/travel/" ></a>
				</td><td>
					<a class="<?php if ($gallery_landing_page_id == 'lifestyle') echo 'btn-selected '; ?>lifestyle-button bg-btn" href="<?php bloginfo('url'); ?>/lifestyle/" ></a>
				</td><td>
					<!-- <a class="gallery-button bg-btn" href="" ></a> -->
				</td><td>
					<div style="width:20px"></div>
				</td><td>
					<a class="about-button bg-btn" href="<?php bloginfo('url'); ?>/portfolio/about/" ></a>
				</td><td>
					<a class="contact-button bg-btn" href="<?php bloginfo('url'); ?>/portfolio/contact/" ></a>
				</td></tr>
			</table>
		</div>
	</td></tr>
</table>
<?php include('portfolio/footer.php'); ?>

