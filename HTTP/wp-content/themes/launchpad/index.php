<?php
global $options;
foreach ($options as $value) {
if (get_settings( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; } else { $$value['id'] = get_settings( $value['id'] ); } }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
<title><?php bloginfo('name') ?></title>
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>
<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" />
<!--[if IE]>
<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_directory') ?>/ie.css" />
<![endif]-->
<link rel="alternate" type="application/rss+xml" href="<?php if($lp_feedburner_address) { echo $lp_feedburner_address; } else { bloginfo('rss2_url'); }?>" title="<?php echo wp_specialchars(get_bloginfo('name'), 1) ?> <?php _e('Posts RSS feed', 'sandbox'); ?>" />
<?php wp_head(); ?>
<!--[if lt IE 8]><script src="http://ie7-js.googlecode.com/svn/version/2.0(beta)/IE8.js" type="text/javascript"></script><![endif]-->
</head>
<body>
<div id="wrapper">
	<div id="main">
		<h1><span>You&rsquo;ve found</span> <?php bloginfo('name') ?></h1>
		<p>We&rsquo;re not <em>quite</em> there yet&mdash;<em>but we&rsquo;re getting there!</em>&mdash;and we <strong>really</strong> want you to know when we&rsquo;re ready. Here&rsquo;s how to stay updated:</p>
	</div><!-- #main -->
	<div id="options-wrap">
		<div id="subscribe-options">
			<p class="rss-subscribe"><a href="<?php if($lp_feedburner_address) { echo $lp_feedburner_address; } else { bloginfo('rss2_url'); }?>" title="<?php echo wp_specialchars(get_bloginfo('name'), 1) ?> <?php _e('RSS feed', ''); ?>" rel="alternate" type="application/rss+xml">Subscribe with <img src="<?php bloginfo('stylesheet_directory') ?>/images/rss-icon.gif" alt="RSS" /> in your feed reader</a></p>
			<form action="http://www.feedburner.com/fb/a/emailverify" method="post" target="popupwindow" onsubmit="window.open('http://www.feedburner.com/fb/a/emailverifySubmit?feedId=<?php echo $eb_feedburner_id; ?>', 'popupwindow', 'scrollbars=yes,width=550,height=520');return true">
				<p class="form-label">Enter your email address:</p><p><input type="text" style="width:140px" name="email"/></p>
				<input type="hidden" value="http://feeds.feedburner.com/~e?ffid=<?php echo $lp_feedburner_id; ?>" name="url"/>
				<input type="hidden" value="<?php bloginfo('name') ?>" name="title"/>
				<input type="hidden" name="loc" value="en_US"/>
				<input id="submit" type="submit" value="Subscribe" />
			</form>
		</div><!-- #subscribe-options -->
	</div><!-- #options-wrap -->
	<div id="page-info">
		<p>Powered by <a href="http://wordpress.org/" title="WordPress">WordPress</a>, <a href="http://www.feedburner.com/" title="FeedBurner">FeedBurner</a> and <a href="http://themeshaper.com/" title="A ThemeShaper Theme">LaunchPad</a>.</p>
	</div><!-- #page-info -->
</div><!-- #wrapper -->
<?php wp_footer() ?>
</body>
</html>