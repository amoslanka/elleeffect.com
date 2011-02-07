<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<title><?php bloginfo('name'); ?> <?php if ( is_single() ) { ?> &raquo; Blog Archive <?php } ?> <?php wp_title(); ?> - <?php bloginfo('description'); ?> </title>

<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/includes/js/suckerfish.js"></script>
<!--[if lt IE 7]>
    <script src="http://ie7-js.googlecode.com/svn/version/2.0(beta3)/IE7.js" type="text/javascript"></script>
<![endif]--> 
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />

<?php wp_head(); ?>
<!--[if lte IE 7]>
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/ie.css" />
<![endif]-->
</head>
<body>
<div id="page">
<div id="header">
	<div id="headerimg">		
        <h1><a href="<?php echo get_option('home'); ?>/"><?php bloginfo('name'); ?></a></h1>
        <span class="description"><?php bloginfo('description'); ?></span>        
        <div id="searchdiv"><?php include (TEMPLATEPATH . '/searchform.php'); ?></div>        
	</div>
    
</div>

<div id="pagemenu">
    <ul id="page-list"  class="clearfix"><li <?php if(is_home()){ echo 'class="page_item current_page_item"'; } else { echo 'class="page_item"'; } ?>><a href="<?php bloginfo('url') ?>" title="Home" >Home</a></li><?php wp_list_pages('title_li='); ?></ul>    
</div>

<hr />