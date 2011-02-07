<?php
/*
Template Name: Splash Page
*/
?>

<?php
	// global $inove_nosidebar;
	$inove_nosidebar = true;
	// include('page.php');
?>


<?php include('portfolio/header.php'); ?>

	<!-- <style type="text/css" media="screen">

		.stretch-bg {
			position:fixed;
			top:0;
			left:0;
			width:100%;
			height:100%;
		}
	
		a.bg-btn {
			background-repeat: no-repeat;
			background-position: top left;
			display: block;
			height: 50px;
		}
		a.bg-btn:hover {
			background-position: bottom left;
		}
		a.gallery-button {
			background: url(<?php bloginfo('template_directory');?>/images/btn-gallery.png) no-repeat;
			width: 100px;
		}
		a.about-button {
			background: url(<?php bloginfo('template_directory');?>/images/btn-about.png) no-repeat;
			width: 64px;
		}
		a.contact-button {
			background: url(<?php bloginfo('template_directory');?>/images/btn-contact.png) no-repeat;
			width: 60px;
		}
		
		div#splash-nav {
			position: absolute;
			bottom:0px;
			left:50%;
			margin-left:-130px;
		}
		div#splash-nav a {
			margin:3px;
		}
		
	</style> -->




	
	<table cellspacing="0" cellpadding="0" border="0" width="100%" height="100%">

	<?php // if (have_posts()) : the_post(); update_post_caches($posts); ?>
		<tr><td align="center" valign="center">
			<!-- <div style="position:absolute; top:50%; margin-top:-80px; left:50%; margin-left:-420px" >  -->
				<img src="<?php bloginfo('template_directory'); ?>/images/splash-title.png" width="843" height="160" alt="Photographs by Lauren Stonestreet">
			<!-- </div> -->
		</td></tr>
	<?php // endif; ?>
	
		<tr><td align="center" valign="center" height="1">
			<div id="splash-nav">  <!-- id="splash-nav" class="absolute-navX" align="center"  -->
				<table cellspacing="0" cellpadding="0" border="0" align="center">
					<tr><td>
						<a class="elle-effect-button bg-btn" href="<?php bloginfo('url'); ?>" ></a>
					</td><td>
						<div style="width:20px"></div>
					</td><td>
						<!-- <a class="wedding-button bg-btn" href="<?php bloginfo('url'); ?>/wedding/" ></a> -->
					</td><td>
						<!-- <a class="travel-button bg-btn" href="<?php bloginfo('url'); ?>/travel/" ></a> -->
					</td><td>
						<!-- <a class="lifestyle-button bg-btn" href="<?php bloginfo('url'); ?>/lifestyle/" ></a> -->
					</td><td>
						<a class="gallery-button bg-btn" href="" ></a>
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

