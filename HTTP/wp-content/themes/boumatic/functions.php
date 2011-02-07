<?php

//	Favorite Icon
function childtheme_favicon() { ?>
    <link rel="shortcut icon" href="<?php echo bloginfo('stylesheet_directory') ?>/img/favicon.ico">
<?php }
 
add_action('wp_head', 'childtheme_favicon');

//	Custom IE Style Sheet
function childtheme_iefix() { ?>
    <!--[if lte IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo bloginfo('stylesheet_directory') ?>/ie.css" />
    <![endif]-->
<?php }
 
add_action('wp_head', 'childtheme_iefix');

//	Overides default FULL SIZE image size
$GLOBALS['content_width'] = 550;

//	Child Theme Menu
function childtheme_menu() { 
	$menu .= '<div id="menu"><ul><li class="page_item"><a href="'. get_settings('home') .'/" title="'. get_bloginfo('name') .'" rel="home">Home</a></li>';
	// Note the include below. It only shows pages with those IDs. Change the ID number to whatever you like.
	$menu .= str_replace( array( "\r", "\n", "\t" ), '', wp_list_pages('title_li=&sort_column=menu_order&echo=0') );
	$menu .= '<li class="page_item"><a class="rss-link" href="'. get_bloginfo_rss('rss2_url') .'">RSS</a></li></ul></div>';
    echo $menu;
}

add_filter( 'globalnav_menu', 'childtheme_menu' );

//	Custom Post Header
function childtheme_postheader() {
    global $post; 
 
    if (is_page()) { ?>
        <h2 class="entry-title"><?php the_title(); ?></h2>        
    <?php } elseif (is_404()) { ?>
        <h2 class="entry-title">Not Found</h2>        
    <?php } elseif (is_single()) { ?>
		<h2 class="entry-title"><?php the_title(); ?></h2>
		<div class="date-meta"><span class="date-day"><?php the_time('j') ?><span class="date-tense"><?php the_time('S') ?></span></span><span class="date-month-year"><?php the_time('M. × ’y') ?></span></div>
		<div class="entry-meta"><span class="author vcard"><?php printf(__('By %s', 'thematic'), wp_specialchars(get_the_author(), 1)) ?></span></div>

    <?php } else { ?>
		<h2 class="entry-title"><a href="<?php the_permalink() ?>" title="<?php printf(__('Permalink to %s', 'thematic'), wp_specialchars(get_the_title(), 1)) ?>" rel="bookmark"><?php the_title() ?></a></h2>
		<div class="date-meta"><div class="date-day"><?php the_time('j') ?><span class="date-tense"><?php the_time('S') ?></span></div><span class="date-month-year"><?php the_time('M. × ’y') ?></span></div>
		<div class="entry-meta"><span class="author vcard"><?php printf(__('By %s', 'thematic'), wp_specialchars(get_the_author(), 1)) ?></span></div>
		<?php if ($post->post_type == 'post') { // Hide entry meta on searches ?>

		<?php } ?>
    <?php }
}

add_filter ('thematic_postheader', 'childtheme_postheader');

?>