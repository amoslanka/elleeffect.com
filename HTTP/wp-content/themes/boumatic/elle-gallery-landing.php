<?php
/*
Template Name: Elle Gallery Landing
*/
?>



<?php
	// global $inove_nosidebar;
	$inove_nosidebar = true;
	// include('page.php');
?>
<?php include('portfolio/header.php'); ?>

<style type="text/css" media="screen">
	a img {
		border:none;
	}
	
/*	.greenBorder {border: 1px solid green;}*/

	.gallery-landing-block, .gallery-landing-image-rollover {
/*		border: 1px solid #999;*/
		width:384px;
		height:384px;
	}
	.gallery-landing-image, .gallery-landing-image-ghost{
		width:360px;
		height:360px;
		padding: 12px;
	}
	.gallery-landing-image {
		position:absolute;
	}
	.gallery-landing-image-bg {
		position:absolute;
		width:auto;
		height:auto;
	}
	.gallery-landing-text-block {
		padding-left:12px;
		padding-top:12px;
	}
	a.gallery-landing-image-link {
		
	}
	a.gallery-landing-image-link:hover img.gallery-landing-image {
		opacity:0.3;
		filter:alpha(opacity=30);
	}
	a.gallery-landing-image-link:hover .gallery-landing-image-rollover {
		visibility:visible;
	}
	.gallery-landing-image-rollover {
		position:absolute;
		z-index:100;
		visibility:hidden;
	}
	.gallery-landing-image-rollover img{

	}
	
	#grid-container {
		margin-top: 12px;
		width:768px;
		margin-left: auto;
		margin-right: auto;
	}
</style>

<?php if (have_posts()) : the_post(); update_post_caches($posts); 
	$custom_fields = get_post_custom();
	$gallery_landing_image_1 = $custom_fields['gallery_landing_image_1'][0];
	$gallery_landing_image_2 = $custom_fields['gallery_landing_image_2'][0];
	$gallery_landing_image_3 = $custom_fields['gallery_landing_image_3'][0];
	$gallery_landing_page_id = $custom_fields['gallery_landing_page_id'][0];
	$content = get_the_content();
	endif;
?>

<!-- <center> -->

<!-- <div class="greenBorder" style="display: table; height: 100%; #position: relative; width:auto"> -->
<!-- <div style=" #position: absolute; width:50px; display:table-cell;"></div> -->
<!-- <div style=" #position: absolute; #top: 50%; display:table-cell; vertical-align: middle; "> -->
<!-- <div class="greenBorder" style=" #position: relative; #top: -50%; "> -->

	<!-- <table cellspacing="0" cellpadding="0" border="0" align="center" style="text-align:center; width:auto"><tr><td> -->
	
	<div id="grid-container">
	
	<div class="gallery-landing-block" style="display:inline; float:left">
		<img class="gallery-landing-image-bg" src="<?php echo get_bloginfo('template_directory') . '/images/gallery-landing-image-bg.png' ?>" />
		<a class="gallery-landing-image-link" href="one/">
			<div class="gallery-landing-image-rollover"><table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0" align="center"><tr><td align="center" valign="center"><img src="<?php echo get_bloginfo('template_directory') . '/images/one.png' ?>" /></td></tr></table></div>
			<img class="gallery-landing-image" src="<?php echo $gallery_landing_image_1; ?>" />
		</a>
		<img class="gallery-landing-image-ghost" src="<?php echo get_bloginfo('template_directory') . '/images/transparent.png' ?>" />
	</div>
	<div class="gallery-landing-block" style="display:inline; float:left">
		<img class="gallery-landing-image-bg" src="<?php echo get_bloginfo('template_directory') . '/images/gallery-landing-image-bg.png' ?>" />
		<a class="gallery-landing-image-link" href="two/">
			<div class="gallery-landing-image-rollover"><table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0" align="center"><tr><td align="center" valign="center"><img src="<?php echo get_bloginfo('template_directory') . '/images/two.png' ?>" /></td></tr></table></div>
			<img class="gallery-landing-image" src="<?php echo $gallery_landing_image_2; ?>" />
		</a>
		<img class="gallery-landing-image-ghost" src="<?php echo get_bloginfo('template_directory') . '/images/transparent.png' ?>" />
	</div>
	<!-- <div style="clear:left"></div> -->
	<div class="gallery-landing-block" style="display:inline; float:left">
		<img class="gallery-landing-image-bg" src="<?php echo get_bloginfo('template_directory') . '/images/gallery-landing-image-bg.png' ?>" />
		<a class="gallery-landing-image-link" href="three/">
			<div class="gallery-landing-image-rollover"><table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0" align="center"><tr><td align="center" valign="center"><img src="<?php echo get_bloginfo('template_directory') . '/images/three.png' ?>" /></td></tr></table></div>
			<img class="gallery-landing-image" src="<?php echo $gallery_landing_image_3; ?>" />
		</a>
		<img class="gallery-landing-image-ghost" src="<?php echo get_bloginfo('template_directory') . '/images/transparent.png' ?>" />
	</div>
	<div class="gallery-landing-block" style="display:inline; float:left">
		<div class="gallery-landing-text-block">
			<table cellspacing="0" cellpadding="0" border="0">
			<tr><td align="center" valign="center" height="1">
				<div id="splash-nav">
					<table cellspacing="0" cellpadding="0" border="0" align="center">
						<tr><td colspan=88>
							<a class="elle-effect-button bg-btn" href="<?php bloginfo('url'); ?>" ></a>
						</td><td>
							<div style="width:20px"></div>
						</td>
						</tr><tr>
						<td>
							<a class="<?php if ($gallery_landing_page_id == 'wedding') echo 'btn-selected '; ?>wedding-button bg-btn" href="<?php bloginfo('url'); ?>/wedding/" ></a>
						</td><td>
							<a class="<?php if ($gallery_landing_page_id == 'travel') echo 'btn-selected '; ?>travel-button bg-btn " href="<?php bloginfo('url'); ?>/travel/" ></a>
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
						<tr><td align="center" valign="center" colspan="88">
							<div class="content Xinfo-div"><?php echo $content; ?></div>
						</td></tr>
						
					</table>
				</div>
			</td></tr>
			</table>
		</div>
		<!-- <img class="gallery-landing-image-ghost" src="<?php echo get_bloginfo('template_directory') . '/images/transparent.png' ?>" /> -->
	</div>
	<!-- <div style="clear:left"></div> -->
	</div>

	<!-- </td></tr></table> -->
	</div>

<!-- </div> -->
<!-- </div> -->
<!-- <div style=" #position: absolute; width:50px; display:table-cell;"></div> -->
<!-- </div> -->

<!-- </center> -->

<?php // require "elle-info.php"; ?>
<?php $bg_image_path = "";//get_bloginfo('template_directory') . "/images/bl-info-bg.jpg"; ?>


