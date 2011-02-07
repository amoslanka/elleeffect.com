<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">

<title><?php
    if ( is_single() ) { single_post_title(); }
    elseif ( is_home() ) { bloginfo('name'); print ' | '; bloginfo('description'); pageGetPageNo(); }
    elseif ( is_page() ) { bloginfo('name'); single_post_title(' | '); }
    elseif ( is_search() ) { bloginfo('name'); print ' | Search results for ' . wp_specialchars($s); pageGetPageNo(); }
    elseif ( is_404() ) { bloginfo('name'); print ' | Not Found'; }
    else { bloginfo('name'); wp_title('|'); pageGetPageNo(); }
?></title>

	<meta http-equiv="content-type" content="<?php bloginfo('html_type') ?>; charset=<?php bloginfo('charset') ?>" />
	<meta name="description" content="<?php bloginfo('description') ?>" />
	<meta name="generator" content="WordPress <?php bloginfo('version') ?>" /><!-- Please leave for stats -->

	<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" />
    <!--[if lt IE 7]>
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/styles/ie.css" />
    <![endif]-->
    <link rel="alternate" type="application/rss+xml" href="<?php bloginfo('rss2_url') ?>" title="<?php echo wp_specialchars(get_bloginfo('name'), 1) ?> <?php _e('Posts RSS feed', 'sandbox'); ?>" />
	<link rel="alternate" type="application/rss+xml" href="<?php bloginfo('comments_rss2_url') ?>" title="<?php echo wp_specialchars(get_bloginfo('name'), 1) ?> <?php _e('Comments RSS feed', 'sandbox'); ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url') ?>" />
	
<?php wp_head() ?>

</head>

<body class="<?php sandbox_body_class() ?>">

<div id="wrapper" class="hfeed">

	<div id="header">
		<div id="branding">
			<div id="blog-title"><a href="<?php echo get_option('home') ?>/" title="<?php bloginfo('name') ?>" rel="home"><?php bloginfo('name') ?></a></div>
			<?php if (is_home()) { ?>
			<h1 id="blog-description"><?php bloginfo('description') ?></h1>
			<?php } else { ?>	
			<div id="blog-description"><?php bloginfo('description') ?></div>
			<?php } ?>
		</div><!-- #branding -->
		<div id="access">
			<div class="skip-link"><a href="#content" title="<?php _e('Skip navigation to the content', 'sandbox'); ?>"><?php _e('Skip to content', 'sandbox'); ?></a></div>
			<?php sandbox_globalnav() ?>
		</div><!-- #access -->
        <!--[if lt IE 7]>
    	<a class="browser-upgrade" href="http://www.microsoft.com/windows/products/winfamily/ie/default.mspx">Still using Internet Explorer 6?</a>
        <![endif]-->
	</div><!--  #header -->
	
	<div id="content-wrap">