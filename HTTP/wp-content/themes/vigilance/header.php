<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" 
   "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xml:lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
		<?php if( is_front_page() ) : ?>
		<title><?php bloginfo('name'); ?> | <?php bloginfo('description');?></title>
		<?php elseif( is_404() ) : ?>
		<title>Page Not Found | <?php bloginfo('name'); ?></title>
    <?php elseif( is_search() ) : ?>
    <title><?php  print 'Search Results for ' . wp_specialchars($s); ?> | <?php bloginfo('name'); ?></title>
		<?php else : ?>
		<title><?php wp_title($sep = ''); ?> | <?php bloginfo('name');?></title>
		<?php endif; ?>

	<!-- Basic Meta Data -->
	<meta name="Copyright" content="Copyright 2008 Jestro LLC" />
	<meta http-equiv="imagetoolbar" content="no" />
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<?php if((is_single() || is_category() || is_page() || is_home()) && (!is_paged())){} else {?>
	<meta name="robots" content="noindex,follow" /><?php } ?>
	
	<!-- Favicon -->
	<link rel="shortcut icon" href="<?php bloginfo('template_url'); ?>/images/favicon.ico" />

	<!--Stylesheets-->
	<link href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" rel="stylesheet" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" media="screen" href="<?php bloginfo('template_url'); ?>/css/ie.css" />
	<![endif]-->
	<!--[if lte IE 6]>
	<link rel="stylesheet" type="text/css" media="screen" href="<?php bloginfo('template_url'); ?>/css/ie6.css" />
	<![endif]-->

	<!--Wordpress-->
	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<!--WP Hook-->
  <?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
	<?php wp_head(); ?>
</head>
<body>
<div id="wrapper">
	<div id="header" class="clear">
		<?php if (is_home()) echo('<h1 id="title">'); else echo('<div id="title">');?><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a><?php if (is_home()) echo('</h1>'); else echo('</div>');?>
		<div id="description">
			<h2><?php bloginfo('description'); ?></h2>
		</div><!--end description-->
		<div id="nav">
			<ul>
				<li class="page_item <?php if (is_home()) echo('current_page_item');?>"><a href="<?php bloginfo('url'); ?>">Home</a></li>
        <?php $exclude_pages = get_option('V_pages_to_exclude'); ?>
        <?php wp_list_pages('depth=1&title_li=&exclude=' . $exclude_pages); ?>
			</ul>
		</div><!--end nav-->
	</div><!--end header-->
	<div id="content" class="pad">
		<?php include (TEMPLATEPATH . '/header-banner.php'); ?>
    <?php if (is_home()) include (TEMPLATEPATH . '/header-alertbox.php'); ?>