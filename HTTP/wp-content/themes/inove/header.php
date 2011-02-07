<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<?php
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

	<?php
		if (is_home()) { 
			$description = $options['description'];
			$keywords = $options['keywords'];
		} else if (is_single()) {
			$description =  $post->post_title;
			$keywords = "";
			$tags = wp_get_post_tags($post->ID);
			foreach ($tags as $tag ) {
				$keywords = $keywords . $tag->name . ", ";
			}
		} else if (is_category()) {
			$description = category_description();
		}
	?>
	<meta name="keywords" content="<?=$keywords?>" />
	<meta name="description" content="<?=$description?>" />

	<title><?php bloginfo('name'); ?><?php wp_title(); ?></title>
	<link rel="alternate" type="application/rss+xml" title="<?php _e('RSS 2.0 - all posts', 'inove'); ?>" href="<?php echo $feed; ?>" />
	<link rel="alternate" type="application/rss+xml" title="<?php _e('RSS 2.0 - all comments', 'inove'); ?>" href="<?php bloginfo('comments_rss2_url'); ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

	<!-- style -->
	<style type="text/css" media="screen">@import url( <?php bloginfo('stylesheet_url'); ?> );</style>
	<?php if (strtoupper(get_locale()) == 'ZH_CN') : ?><link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/css/zh_CN.css" type="text/css" media="screen" /><?php endif; ?>
	<?php if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 6')) : ?><link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/css/ie6.css" type="text/css" media="screen" /><?php endif; ?>

	<!-- script -->
	<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/util.js"></script>

	<?php wp_head(); ?>

</head>

<?php flush(); ?>

<body>
<!-- wrap START -->
<div id="wrap">
<!-- container START -->
<div id="container">

<!-- header START -->
<div id="header">
	<div id="caption">
		<h1 id="title"><a href="<?php bloginfo('url'); ?>/"><?php bloginfo('name'); ?></a></h1>
		<div id="tagline"><?php bloginfo('description'); ?></div>
	</div>

	<!-- navigation START -->
	<div id="navigation">
		<ul id="menus">
			<li class="<?php echo($home_menu); ?>"><a class="home" title="<?php _e('Home', 'inove'); ?>" href="<?php echo get_settings('home'); ?>/"><?php _e('Home', 'inove'); ?></a></li>
			<?php wp_list_pages('depth=2&title_li=0&sort_column=menu_order'); ?>
			<li><a class="lastmenu" href="javascript:void(0);"></a></li>
		</ul>

		<!-- searchbox START -->
		<div id="searchbox">
<?php if($options['google_cse'] && $options['google_cse_cx']) : ?>
			<form action="http://www.google.com/cse" method="get">
				<div class="content">
					<input type="text" class="textfield" name="q" size="24" />
					<input type="hidden" name="cx" value="<?php echo $options['google_cse_cx']; ?>" />
					<input type="hidden" name="ie" value="UTF-8" />
					<a class="switcher" ><?php _e('Switcher', 'inove'); ?></a>
				</div>
			</form>
<?php else : ?>
			<form action="<?php bloginfo('home'); ?>" method="get">
				<div class="content">
					<input type="text" class="textfield" name="s" size="24" value="<?php echo wp_specialchars($s, 1); ?>" />
					<a class="switcher" ><?php _e('Switcher', 'inove'); ?></a>
				</div>
			</form>
<?php endif; ?>
		</div>
		<!-- searchbox END -->

		<div class="fixed"></div>
	</div>
	<!-- navigation END -->

	<div class="fixed"></div>
</div>
<!-- header END -->

<!-- content START -->
<div id="content">

	<!-- main START -->
	<div id="main">
