<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<?php
	global $inove_nosidebar;
	
	$options = get_option('inove_options');
	if (is_home()) {
		$home_menu = 'current_page_item';
	} else {
		$home_menu = 'page_item';
	}
	if($options['feed'] && $options['feed_url']) {
		if (substr(strtoupper($options['feed_url']), 0, 7) == 'HTTP://') {
			$feed = $options['feed_url'];
		} else {
			$feed = 'http://' . $options['feed_url'];
		}
	} else {
		$feed = get_bloginfo('rss2_url');
	}
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/11">
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />

	<title><?php bloginfo('name'); ?><?php wp_title(); ?></title>
	<link rel="alternate" type="application/rss+xml" title="<?php _e('RSS 2.0 - all posts', 'inove'); ?>" href="<?php echo $feed; ?>" />
	<link rel="alternate" type="application/rss+xml" title="<?php _e('RSS 2.0 - all comments', 'inove'); ?>" href="<?php bloginfo('comments_rss2_url'); ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

	<!-- <script src="<?php echo NGGFLASHVIEWER_URLPATH ?>js/swfaddress/SWFAddressOptimizer.js" type="text/javascript" charset="utf-8"></script> -->
	<script src="<?php echo NGGFLASHVIEWER_URLPATH ?>js/swfobject.js" type="text/javascript" charset="utf-8"></script>
	<script src="<?php echo NGGFLASHVIEWER_URLPATH ?>js/swffit.js" type="text/javascript" charset="utf-8"></script>
	<script src="<?php echo NGGFLASHVIEWER_URLPATH ?>js/swfaddress2.4/SWFAddress.js" type="text/javascript" charset="utf-8"></script>


	<!-- style START -->
	<!-- default style -->
	<!-- <style type="text/css" media="screen">@import url( <?php bloginfo('stylesheet_url'); ?> );</style> -->
	<style type="text/css" media="screen">@import url( <?php bloginfo('template_directory'); ?>/portfolio/style.css );</style>
	<!--[if IE]>
		<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/ie.css" type="text/css" media="screen" />
	<![endif]-->
	<!-- style END -->

	<!-- script START -->
	<!-- <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/base.js"></script> -->
	<!-- <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/menu.js"></script> -->
	<!-- script END -->

	<?php //wp_head(); ?>
	
	<style type="text/css" media="screen">

		.stretch-bg {
			position:fixed;
			top:0;
			left:0;
			width:100%;
			height:100%;
			z-index:-1;
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
		.btn-selected {
			background-position: bottom left!important;
		}
		
		a.gallery-button {
			background: url(<?php bloginfo('template_directory');?>/images/btn-gallery.png) no-repeat;
			width: 100px;
		}
		a.elle-effect-button {
			background: url(<?php bloginfo('template_directory');?>/images/btn-elle-effect.png) no-repeat;
			width: 194px;
		}
		a.about-button {
			background: url(<?php bloginfo('template_directory');?>/images/btn-about.png) no-repeat;
			width: 64px;
		}
		a.wedding-button {
			background: url(<?php bloginfo('template_directory');?>/images/btn-wedding.png) no-repeat;
			width: 90px;
		}
		a.travel-button {
			background: url(<?php bloginfo('template_directory');?>/images/btn-travel.png) no-repeat;
			width: 76px;
		}
		a.lifestyle-button {
			background: url(<?php bloginfo('template_directory');?>/images/btn-lifestyle.png) no-repeat;
			width: 80px;
		}
		a.contact-button {
			background: url(<?php bloginfo('template_directory');?>/images/btn-contact.png) no-repeat;
			width: 60px;
		}
		
		div.absolute-nav {
			position: absolute;
			bottom:0px;
			left:50%;
			margin-left:-130px;
		}
		div.absolute-nav a {
			margin:3px;
		}
		div#splash-nav {
/*			width:230px;*/
			text-align:center;
			margin-left: auto;
		    margin-right: auto;
			height:50px;
		}
		
		div.content {
			text-align:left;
		}
		div.info-div {
			width:320px;
		}
		div.info-div img {
			margin-left:-7px;
		}
		

		p, font, div, td, body {
			font-size:11px;
			font-family:"Geneva", "Helvetica", "Helvetica Neue", sans-serif;
			color:#333333;
		}
		a {
			color:#000000;
		}


		
		table div{
			height:100%;
			width:100%;
		}
		div.elleviewer {
			offset:0px; /*this is for ff*/
		}
		
	</style>
	
	
</head>

<?php flush(); ?>

<body>

	<?php
		if (isset($bg_image_path) == false) {
			$bg_image_path = get_bloginfo('template_directory') . "/images/bl-bg.jpg";
		}
	?>

	<img src="<?php echo $bg_image_path; ?>" alt="background image" class="stretch-bg" />


<!-- wrap START -->
<div id="wrap">

<!-- container START -->
<div id="container" <?php if($options['nosidebar'] || $inove_nosidebar){echo 'class="one-column"';} ?> >

<?php // include('templates/header.php'); ?>

<!-- content START -->
<!-- <div id="content"> -->

	<!-- main START -->
	<!-- <div id="main"> -->

