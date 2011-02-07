<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes() ?>>
<head profile="http://gmpg.org/xfn/11">
	<title><?php bloginfo('name') ?><?php if ( is_404() ) : ?> / <?php _e('Page not found', 'plaintxtblog') ?><?php elseif ( is_home() ) : ?> / <?php bloginfo('description') ?><?php elseif ( is_category() ) : ?> / <?php echo single_cat_title(); ?><?php elseif ( is_date() ) : ?> / <?php _e('Blog Archives', 'plaintxtblog') ?><?php elseif ( is_search() ) : ?> / <?php _e('Search Results', 'plaintxtblog') ?><?php else : ?> / <?php the_title() ?><?php endif ?></title>
	<meta http-equiv="content-type" content="<?php bloginfo('html_type') ?>; charset=<?php bloginfo('charset') ?>" />
	<link rel="stylesheet" type="text/css" media="screen,projection" href="<?php bloginfo('stylesheet_url'); ?>" title="plaintxtBlog" />
	<link rel="stylesheet" type="text/css" media="print" href="<?php bloginfo('template_directory'); ?>/print.css" />
	<link rel="alternate" type="application/rss+xml" href="<?php bloginfo('rss2_url') ?>" title="<?php bloginfo('name') ?> RSS feed" />
	<link rel="alternate" type="application/rss+xml" href="<?php bloginfo('comments_rss2_url') ?>" title="<?php bloginfo('name') ?> comments RSS feed" />
	<link rel="pingback" href="<?php bloginfo('pingback_url') ?>" />

<?php wp_head() // Do not remove; helps plugins work ?>

</head>

<body class="<?php plaintxtblog_body_class() ?>">

<div id="wrapper">

	<div id="header">
		<h1 id="blog-title"><a href="<?php echo get_settings('home') ?>/" title="<?php bloginfo('name') ?>"><?php bloginfo('name') ?></a></h1>
		<div id="blog-description"><?php bloginfo('description') ?></div>
	</div><!-- #header -->
	
	<div class="access"><span class="content-access"><a href="#content" title="<?php _e('Skip to content', 'plaintxtblog'); ?>"><?php _e('Skip to content', 'plaintxtblog'); ?></a></span></div>

<?php plaintxtblog_globalnav() // Adds page links below header, which are hidden by style.css; increases accessibility ?>