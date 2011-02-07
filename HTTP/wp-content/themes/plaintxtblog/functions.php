<?php
// Produces links for every page just below the header
function plaintxtblog_globalnav() {
	echo "<div id=\"globalnav\"><ul id=\"menu\">";
	if ( !is_front_page() ) { ?><li class="page_item_home home-link"><a href="<?php bloginfo('home'); ?>/" title="<?php echo wp_specialchars(get_bloginfo('name'), 1) ?>" rel="home"><?php _e('Home', 'plaintxtblog') ?></a></li><?php }
	$menu = wp_list_pages('title_li=&sort_column=menu_order&echo=0'); // Params for the page list in header.php
	echo str_replace(array("\r", "\n", "\t"), '', $menu);
	echo "</ul></div>\n";
}

// Produces an hCard for the "admin" user
function plaintxtblog_admin_hCard() {
	global $wpdb, $user_info;
	$user_info = get_userdata(1);
	echo '<span class="vcard"><a class="url fn n" href="' . $user_info->user_url . '"><span class="given-name">' . $user_info->first_name . '</span> <span class="family-name">' . $user_info->last_name . '</span></a></span>';
}

// Produces an hCard for post authors
function plaintxtblog_author_hCard() {
	global $wpdb, $authordata;
	echo '<span class="entry-author author vcard"><a class="url fn n" href="' . get_author_link(false, $authordata->ID, $authordata->user_nicename) . '" title="View all posts by ' . $authordata->display_name . '">' . get_the_author() . '</a></span>';
}

// Produces semantic classes for the body element; Originally from the Sandbox, http://www.plaintxt.org/themes/sandbox/
function plaintxtblog_body_class( $print = true ) {
	global $wp_query, $current_user;

	$c = array('wordpress');

	plaintxtblog_date_classes(time(), $c);

	is_home()       ? $c[] = 'home'       : null;
	is_archive()    ? $c[] = 'archive'    : null;
	is_date()       ? $c[] = 'date'       : null;
	is_search()     ? $c[] = 'search'     : null;
	is_paged()      ? $c[] = 'paged'      : null;
	is_attachment() ? $c[] = 'attachment' : null;
	is_404()        ? $c[] = 'four04'     : null;

	if ( is_single() ) {
		the_post();
		$c[] = 'single';
		if ( isset($wp_query->post->post_date) )
			plaintxtblog_date_classes(mysql2date('U', $wp_query->post->post_date), $c, 's-');
		foreach ( (array) get_the_category() as $cat )
			$c[] = 's-category-' . $cat->category_nicename;
			$c[] = 's-author-' . get_the_author_login();
		rewind_posts();
	}

	elseif ( is_author() ) {
		$author = $wp_query->get_queried_object();
		$c[] = 'author';
		$c[] = 'author-' . $author->user_nicename;
	}

	elseif ( is_category() ) {
		$cat = $wp_query->get_queried_object();
		$c[] = 'category';
		$c[] = 'category-' . $cat->category_nicename;
	}

	elseif ( is_page() ) {
		the_post();
		$c[] = 'page';
		$c[] = 'page-author-' . get_the_author_login();
		rewind_posts();
	}

	if ( $current_user->ID )
		$c[] = 'loggedin';

	$c = join(' ', apply_filters('body_class',  $c));

	return $print ? print($c) : $c;
}

// Produces semantic classes for the each individual post div; Originally from the Sandbox, http://www.plaintxt.org/themes/sandbox/
function plaintxtblog_post_class( $print = true ) {
	global $post, $plaintxtblog_post_alt;

	$c = array('hentry', "p$plaintxtblog_post_alt", $post->post_type, $post->post_status);

	$c[] = 'author-' . get_the_author_login();

	foreach ( (array) get_the_category() as $cat )
		$c[] = 'category-' . $cat->category_nicename;

	plaintxtblog_date_classes(mysql2date('U', $post->post_date), $c);

	if ( ++$plaintxtblog_post_alt % 2 )
		$c[] = 'alt';
	
	elseif ( $post->post_password )
		$c[] = 'protected';

	$c = join(' ', apply_filters('post_class', $c));

	return $print ? print($c) : $c;
}
$plaintxtblog_post_alt = 1;

// Produces semantic classes for the each individual comment li; Originally from the Sandbox, http://www.plaintxt.org/themes/sandbox/
function plaintxtblog_comment_class( $print = true ) {
	global $comment, $post, $plaintxtblog_comment_alt;

	$c = array($comment->comment_type);

	if ( $comment->user_id > 0 ) {
		$user = get_userdata($comment->user_id);

		$c[] = "byuser commentauthor-$user->user_login";

		if ( $comment->user_id === $post->post_author )
			$c[] = 'bypostauthor';
	}

	plaintxtblog_date_classes(mysql2date('U', $comment->comment_date), $c, 'c-');
	if ( ++$plaintxtblog_comment_alt % 2 )
		$c[] = 'alt';

	$c[] = "c$plaintxtblog_comment_alt";

	if ( is_trackback() ) {
		$c[] = 'trackback';
	}

	$c = join(' ', apply_filters('comment_class', $c));

	return $print ? print($c) : $c;
}

// Produces date-based classes for the three functions above; Originally from the Sandbox, http://www.plaintxt.org/themes/sandbox/
function plaintxtblog_date_classes($t, &$c, $p = '') {
	$t = $t + (get_option('gmt_offset') * 3600);
	$c[] = $p . 'y' . gmdate('Y', $t);
	$c[] = $p . 'm' . gmdate('m', $t);
	$c[] = $p . 'd' . gmdate('d', $t);
	$c[] = $p . 'h' . gmdate('h', $t);
}

// Returns other categories except the current one (redundant); Originally from the Sandbox, http://www.plaintxt.org/themes/sandbox/
function plaintxtblog_other_cats($glue) {
	$current_cat = single_cat_title('', false);
	$separator = "\n";
	$cats = explode($separator, get_the_category_list($separator));

	foreach ( $cats as $i => $str ) {
		if ( strstr($str, ">$current_cat<") ) {
			unset($cats[$i]);
			break;
		}
	}

	if ( empty($cats) )
		return false;

	return trim(join($glue, $cats));
}

// Returns other tags except the current one (redundant); Originally from the Sandbox, http://www.plaintxt.org/themes/sandbox/
function plaintxtblog_other_tags($glue) {
	$current_tag = single_tag_title('', '',  false);
	$separator = "\n";
	$tags = explode($separator, get_the_tag_list("", "$separator", ""));

	foreach ( $tags as $i => $str ) {
		if ( strstr($str, ">$current_tag<") ) {
			unset($tags[$i]);
			break;
		}
	}

	if ( empty($tags) )
		return false;

	return trim(join($glue, $tags));
}

// Produces an avatar image with the hCard-compliant photo class
function plaintxtblog_commenter_link() {
	$commenter = get_comment_author_link();
	if ( ereg( '<a[^>]* class=[^>]+>', $commenter ) ) {
		$commenter = ereg_replace( '(<a[^>]* class=[\'"]?)', '\\1url ' , $commenter );
	} else {
		$commenter = ereg_replace( '(<a )/', '\\1class="url "' , $commenter );
	}
	$email = get_comment_author_email();
	$avatar_size = get_option('plaintxtblog_avatarsize');
	if ( empty($avatar_size) ) $avatar_size = '24';
	$avatar = str_replace( "class='avatar", "class='photo avatar", get_avatar( "$email", "$avatar_size" ) );
	echo $avatar . ' <span class="fn n">' . $commenter . '</span>';
}

// Function to filter the default gallery shortcode
function plaintxtblog_gallery($attr) {
	global $post;
	if ( isset($attr['orderby']) ) {
		$attr['orderby'] = sanitize_sql_orderby($attr['orderby']);
		if ( !$attr['orderby'] )
			unset($attr['orderby']);
	}

	extract(shortcode_atts( array(
		'orderby'    => 'menu_order ASC, ID ASC',
		'id'         => $post->ID,
		'itemtag'    => 'dl',
		'icontag'    => 'dt',
		'captiontag' => 'dd',
		'columns'    => 3,
		'size'       => 'thumbnail',
	), $attr ));

	$id           =  intval($id);
	$orderby      =  addslashes($orderby);
	$attachments  =  get_children("post_parent=$id&post_type=attachment&post_mime_type=image&orderby={$orderby}");

	if ( empty($attachments) )
		return null;

	if ( is_feed() ) {
		$output = "\n";
		foreach ( $attachments as $id => $attachment )
			$output .= wp_get_attachment_link( $id, $size, true ) . "\n";
		return $output;
	}

	$listtag     =  tag_escape($listtag);
	$itemtag     =  tag_escape($itemtag);
	$captiontag  =  tag_escape($captiontag);
	$columns     =  intval($columns);
	$itemwidth   =  $columns > 0 ? floor(100/$columns) : 100;

	$output = apply_filters( 'gallery_style', "\n" . '<div class="gallery">', 9 ); // Available filter: gallery_style

	foreach ( $attachments as $id => $attachment ) {
		$img_lnk = get_attachment_link($id);
		$img_src = wp_get_attachment_image_src( $id, $size );
		$img_src = $img_src[0];
		$img_alt = $attachment->post_excerpt;
		if ( $img_alt == null )
			$img_alt = $attachment->post_title;
		$img_rel = apply_filters( 'gallery_img_rel', 'attachment' ); // Available filter: gallery_img_rel
		$img_class = apply_filters( 'gallery_img_class', 'gallery-image' ); // Available filter: gallery_img_class

		$output  .=  "\n\t" . '<' . $itemtag . ' class="gallery-item gallery-columns-' . $columns .'">';
		$output  .=  "\n\t\t" . '<' . $icontag . ' class="gallery-icon"><a href="' . $img_lnk . '" title="' . $img_alt . '" rel="' . $img_rel . '"><img src="' . $img_src . '" alt="' . $img_alt . '" class="' . $img_class . ' attachment-' . $size . '" /></a></' . $icontag . '>';

		if ( $captiontag && trim($attachment->post_excerpt) ) {
			$output .= "\n\t\t" . '<' . $captiontag . ' class="gallery-caption">' . $attachment->post_excerpt . '</' . $captiontag . '>';
		}

		$output .= "\n\t" . '</' . $itemtag . '>';
		if ( $columns > 0 && ++$i % $columns == 0 )
			$output .= "\n</div>\n" . '<div class="gallery">';
	}
	$output .= "\n</div>\n";

	return $output;
}


// Loads a plaintxtblog-style Search widget
function widget_plaintxtblog_search($args) {
	extract($args);
	$options = get_option('widget_plaintxtblog_search');
	$title = empty($options['title']) ? __( 'Search', 'plaintxtblog' ) : $options['title'];
	$button = empty($options['button']) ? __( 'Find', 'plaintxtblog' ) : $options['button'];
?>
		<?php echo $before_widget ?>
				<?php echo $before_title ?><label for="s"><?php echo $title ?></label><?php echo $after_title ?>
			<form id="searchform" method="get" action="<?php bloginfo('home') ?>">
				<div>
					<input id="s" name="s" class="text-input" type="text" value="<?php the_search_query() ?>" size="10" tabindex="1" accesskey="S" />
					<input id="searchsubmit" name="searchsubmit" class="submit-button" type="submit" value="<?php echo $button ?>" tabindex="2" />
				</div>
			</form>
		<?php echo $after_widget ?>
<?php
}

// Widget: Search; element controls for customizing text within Widget plugin
function widget_plaintxtblog_search_control() {
	$options = $newoptions = get_option('widget_plaintxtblog_search');
	if ( $_POST['search-submit'] ) {
		$newoptions['title'] = strip_tags( stripslashes( $_POST['search-title'] ) );
		$newoptions['button'] = strip_tags( stripslashes( $_POST['search-button'] ) );
	}
	if ( $options != $newoptions ) {
		$options = $newoptions;
		update_option( 'widget_plaintxtblog_search', $options );
	}
	$title = attribute_escape( $options['title'] );
	$button = attribute_escape( $options['button'] );
?>
			<p><label for="search-title"><?php _e( 'Title:', 'plaintxtblog' ) ?> <input class="widefat" id="search-title" name="search-title" type="text" value="<?php echo $title; ?>" /></label></p>
			<p><label for="search-button"><?php _e( 'Button Text:', 'plaintxtblog' ) ?> <input class="widefat" id="search-button" name="search-button" type="text" value="<?php echo $button; ?>" /></label></p>
			<input type="hidden" id="search-submit" name="search-submit" value="1" />
<?php
}

// Loads a plaintxtblog-style Meta widget
function widget_plaintxtblog_meta($args) {
	extract($args);
	$options = get_option('widget_meta');
	$title = empty($options['title']) ? __('Meta', 'plaintxtblog') : $options['title'];
?>
		<?php echo $before_widget; ?>
			<?php echo $before_title . $title . $after_title; ?>
			<ul>
				<?php wp_register() ?>
				<li><?php wp_loginout() ?></li>
				<?php wp_meta() ?>
			</ul>
		<?php echo $after_widget; ?>
<?php
}

function widget_plaintxtblog_homelink($args) {
	extract($args);
	$options = get_option('widget_plaintxtblog_homelink');
	$title = empty($options['title']) ? __( 'Home', 'plaintxtblog' ) : $options['title'];
	if ( !is_front_page() || is_paged() ) {
?>
			<?php echo $before_widget; ?>
				<?php echo $before_title; ?><a href="<?php bloginfo('home'); ?>/" title="<?php echo wp_specialchars(get_bloginfo('name'), 1) ?>" rel="home"><?php echo $title; ?></a><?php echo $after_title; ?>
			<?php echo $after_widget; ?>
<?php }
}

// Loads the control functions for the Home Link, allowing control of its text
function widget_plaintxtblog_homelink_control() {
	$options = $newoptions = get_option('widget_plaintxtblog_homelink');
	if ( $_POST['homelink-submit'] ) {
		$newoptions['title'] = strip_tags( stripslashes( $_POST['homelink-title'] ) );
	}
	if ( $options != $newoptions ) {
		$options = $newoptions;
		update_option( 'widget_plaintxtblog_homelink', $options );
	}
	$title = attribute_escape( $options['title'] );
?>
			<p><?php _e('Adds a link to the home page on every page <em>except</em> the home.', 'plaintxtblog'); ?></p>
			<p><label for="homelink-title"><?php _e( 'Title:', 'plaintxtblog' ) ?> <input class="widefat" id="homelink-title" name="homelink-title" type="text" value="<?php echo $title; ?>" /></label></p>
			<input type="hidden" id="homelink-submit" name="homelink-submit" value="1" />
<?php
}

// Loads plaintxtblog-style RSS Links (separate from Meta) widget
function widget_plaintxtblog_rsslinks($args) {
	extract($args);
	$options = get_option('widget_plaintxtblog_rsslinks');
	$title = empty($options['title']) ? __( 'RSS Links', 'plaintxtblog' ) : $options['title'];
?>
		<?php echo $before_widget; ?>
			<?php echo $before_title . $title . $after_title; ?>
			<ul>
				<li><a href="<?php bloginfo('rss2_url') ?>" title="<?php echo wp_specialchars( get_bloginfo('name'), 1 ) ?> <?php _e( 'Posts RSS feed', 'plaintxtblog' ); ?>" rel="alternate" type="application/rss+xml"><?php _e( 'All posts', 'plaintxtblog' ) ?></a></li>
				<li><a href="<?php bloginfo('comments_rss2_url') ?>" title="<?php echo wp_specialchars(bloginfo('name'), 1) ?> <?php _e( 'Comments RSS feed', 'plaintxtblog' ); ?>" rel="alternate" type="application/rss+xml"><?php _e( 'All comments', 'plaintxtblog' ) ?></a></li>
			</ul>
		<?php echo $after_widget; ?>
<?php
}

// Loads the control functions for the RSS Links, allowing control of its text
function widget_plaintxtblog_rsslinks_control() {
	$options = $newoptions = get_option('widget_plaintxtblog_rsslinks');
	if ( $_POST['rsslinks-submit'] ) {
		$newoptions['title'] = strip_tags( stripslashes( $_POST['rsslinks-title'] ) );
	}
	if ( $options != $newoptions ) {
		$options = $newoptions;
		update_option( 'widget_plaintxtblog_rsslinks', $options );
	}
	$title = attribute_escape( $options['title'] );
?>
			<p><label for="rsslinks-title"><?php _e( 'Title:', 'plaintxtblog' ) ?> <input class="widefat" id="rsslinks-title" name="rsslinks-title" type="text" value="<?php echo $title; ?>" /></label></p>
			<input type="hidden" id="rsslinks-submit" name="rsslinks-submit" value="1" />
<?php
}

// Loads, checks that Widgets are loaded and working
function plaintxtblog_widgets_init() {
	if ( !function_exists('register_sidebars') )
		return;

	$p = array(
		'before_title' => "<h3 class='widgettitle'>",
		'after_title' => "</h3>\n",
	);

	register_sidebars(2, $p);

	// Finished intializing Widgets plugin, now let's load the plaintxtBlog default widgets; first, plaintxtBlog search widget
	$widget_ops = array(
		'classname'    =>  'widget_search',
		'description'  =>  __( "A search form for your blog (plaintxtBlog)", "plaintxtblog" )
	);
	wp_register_sidebar_widget( 'search', __( 'Search', 'plaintxtblog' ), 'widget_plaintxtblog_search', $widget_ops );
	unregister_widget_control('search');
	wp_register_widget_control( 'search', __( 'Search', 'plaintxtblog' ), 'widget_plaintxtblog_search_control' );

	// plaintxtBlog Meta widget
	$widget_ops = array(
		'classname'    =>  'widget_meta',
		'description'  =>  __( "Log in/out and administration links (plaintxtBlog)", "plaintxtblog" )
	);
	wp_register_sidebar_widget( 'meta', __( 'Meta', 'plaintxtblog' ), 'widget_plaintxtblog_meta', $widget_ops );
	unregister_widget_control('meta');
	wp_register_widget_control( 'meta', __('Meta'), 'wp_widget_meta_control' );

	//plaintxtBlog Home Link widget
	$widget_ops = array(
		'classname'    =>  'widget_home_link',
		'description'  =>  __( "Link to the front page when elsewhere (plaintxtBlog)", "plaintxtblog" )
	);
	wp_register_sidebar_widget( 'home_link', __( 'Home Link', 'plaintxtblog' ), 'widget_plaintxtblog_homelink', $widget_ops );
	wp_register_widget_control( 'home_link', __( 'Home Link', 'plaintxtblog' ), 'widget_plaintxtblog_homelink_control' );

	//plaintxtBlog RSS Links widget
	$widget_ops = array(
		'classname'    =>  'widget_rss_links',
		'description'  =>  __( "RSS links for both posts and comments (plaintxtBlog)", "plaintxtblog" )
	);
	wp_register_sidebar_widget( 'rss_links', __( 'RSS Links', 'plaintxtblog' ), 'widget_plaintxtblog_rsslinks', $widget_ops );
	wp_register_widget_control( 'rss_links', __( 'RSS Links', 'plaintxtblog' ), 'widget_plaintxtblog_rsslinks_control' );
}

// Loads the admin menu; sets default settings for each
function plaintxtblog_add_admin() {
	if ( $_GET['page'] == basename(__FILE__) ) {
		if ( 'save' == $_REQUEST['action'] ) {
			check_admin_referer('plaintxtblog_save_options');
			update_option( 'plaintxtblog_basefontsize', strip_tags( stripslashes( $_REQUEST['ptb_basefontsize'] ) ) );
			update_option( 'plaintxtblog_basefontfamily', strip_tags( stripslashes( $_REQUEST['ptb_basefontfamily'] ) ) );
			update_option( 'plaintxtblog_headingfontfamily', strip_tags( stripslashes( $_REQUEST['ptb_headingfontfamily'] ) ) );
			update_option( 'plaintxtblog_posttextalignment', strip_tags( stripslashes( $_REQUEST['ptb_posttextalignment'] ) ) );
			update_option( 'plaintxtblog_sidebarposition', strip_tags( stripslashes( $_REQUEST['ptb_sidebarposition'] ) ) );
			update_option( 'plaintxtblog_sidebartextalignment', strip_tags( stripslashes( $_REQUEST['ptb_sidebartextalignment'] ) ) );
			update_option( 'plaintxtblog_singlelayout', strip_tags( stripslashes( $_REQUEST['ptb_singlelayout'] ) ) );
			update_option( 'plaintxtblog_avatarsize', strip_tags( stripslashes( $_REQUEST['ptb_avatarsize'] ) ) );
			header("Location: themes.php?page=functions.php&saved=true");
			die;
		} else if( 'reset' == $_REQUEST['action'] ) {
			check_admin_referer('plaintxtblog_reset_options');
			delete_option('plaintxtblog_basefontsize');
			delete_option('plaintxtblog_basefontfamily');
			delete_option('plaintxtblog_headingfontfamily');
			delete_option('plaintxtblog_posttextalignment');
			delete_option('plaintxtblog_sidebarposition');
			delete_option('plaintxtblog_sidebartextalignment');
			delete_option('plaintxtblog_singlelayout');
			delete_option('plaintxtblog_avatarsize');
			header("Location: themes.php?page=functions.php&reset=true");
			die;
		}
		add_action('admin_head', 'plaintxtblog_admin_head');
	}
	add_theme_page( __( 'plaintxtBlog Theme Options', 'plaintxtblog' ), __( 'Theme Options', 'plaintxtblog' ), 'edit_themes', basename(__FILE__), 'plaintxtblog_admin' );
}

function plaintxtblog_donate() { 
	$form = '<form id="paypal" action="https://www.paypal.com/cgi-bin/webscr" method="post">
		<div id="donate">
			<input type="hidden" name="cmd" value="_s-xclick" />
			<input type="image" name="submit" src="https://www.paypal.com/en_US/i/btn/x-click-butcc-donate.gif" alt="Donate with PayPal - it\'s fast, free and secure!" />
			<img src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1" alt="Donate with PayPal" />
			<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----" />
		</div>
	</form>' . "\n\t";
	echo $form;
}

function plaintxtblog_admin_head() {
// Additional CSS styles for the theme options menu
?>
<style type="text/css" media="screen,projection">
/*<![CDATA[*/
	p.info span{font-weight:bold;}
	label.arial,label.courier,label.georgia,label.lucida-console,label.lucida-unicode,label.tahoma,label.times,label.trebuchet,label.verdana{font-size:1.2em;line-height:175%;}
	.arial{font-family:arial,helvetica,sans-serif;}
	.courier{font-family:'courier new',courier,monospace;}
	.georgia{font-family:georgia,times,serif;}
	.lucida-console{font-family:'lucida console',monaco,monospace;}
	.lucida-unicode{font-family:'lucida sans unicode','lucida grande',sans-serif;}
	.tahoma{font-family:tahoma,geneva,sans-serif;}
	.times{font-family:'times new roman',times,serif;}
	.trebuchet{font-family:'trebuchet ms',helvetica,sans-serif;}
	.verdana{font-family:verdana,geneva,sans-serif;}
	form#paypal{float:right;margin:1em 0 0.5em 1em;}
/*]]>*/
</style>
<?php
}

function plaintxtblog_admin() { // Theme options menu 
	if ( $_REQUEST['saved'] ) { ?><div id="message1" class="updated fade"><p><?php printf(__('PlaintxtBlog theme options saved. <a href="%s">View site.</a>', 'plaintxtblog'), get_bloginfo('home') . '/'); ?></p></div><?php }
	if ( $_REQUEST['reset'] ) { ?><div id="message2" class="updated fade"><p><?php _e('PlaintxtBlog theme options reset.', 'plaintxtblog'); ?></p></div><?php } ?>

<div class="wrap">
	<h2><?php _e('PlaintxtBlog Theme Options', 'plaintxtblog'); ?></h2>
	<?php printf( __('%1$s<p>Thanks for selecting the <a href="http://www.plaintxt.org/themes/plaintxtblog/" title="PlaintxtBlog theme for WordPress">plaintxtBlog</a> theme by <span class="vcard"><a class="url fn n" href="http://scottwallick.com/" title="scottwallick.com" rel="me designer"><span class="given-name">Scott</span> <span class="additional-name">Allan</span> <span class="family-name">Wallick</span></a></span>. Please read the included <a href="%2$s" title="Open the readme.html" rel="enclosure" id="readme">documentation</a> for more information about the blog.txt and its advanced features. <strong>If you find this theme useful, please consider <label for="paypal">donating</label>.</strong> You must click on <i><u>S</u>ave Options</i> to save any changes. You can also discard your changes and reload the default settings by clicking on <i><u>R</u>eset</i>.</p>', 'plaintxtblog'), plaintxtblog_donate(), get_template_directory_uri() . '/readme.html' ); ?>

	<form action="<?php echo wp_specialchars( $_SERVER['REQUEST_URI'] ) ?>" method="post">
		<?php wp_nonce_field('plaintxtblog_save_options'); echo "\n"; ?>
		<h3><?php _e('Typography', 'plaintxtblog'); ?></h3>
		<table class="form-table" summary="PlaintxtBlog typography options">
			<tr valign="top">
				<th scope="row"><label for="ptb_basefontsize"><?php _e('Base font size', 'plaintxtblog'); ?></label></th> 
				<td>
					<input id="ptb_basefontsize" name="ptb_basefontsize" type="text" class="text" value="<?php if ( get_option('plaintxtblog_basefontsize') == "" ) { echo "70%"; } else { echo attribute_escape( get_option('plaintxtblog_basefontsize') ); } ?>" tabindex="1" size="10" />
					<p class="info"><?php _e('The base font size globally affects the size of text throughout your blog. This can be in any unit (e.g., px, pt, em), but I suggest using a percentage (%). Default is <span>70%</span>.', 'plaintxtblog'); ?></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Base font family', 'plaintxtblog'); ?></th> 
				<td>
					<input id="ptb_basefontArial" name="ptb_basefontfamily" type="radio" class="radio" value="arial, helvetica, sans-serif" <?php if ( get_option('plaintxtblog_basefontfamily') == "arial, helvetica, sans-serif" ) { echo 'checked="checked"'; } ?> tabindex="2" /> <label for="ptb_basefontArial" class="arial">Arial</label><br />
					<input id="ptb_basefontCourier" name="ptb_basefontfamily" type="radio" class="radio" value="'courier new', courier, monospace" <?php if ( get_option('plaintxtblog_basefontfamily') == "'courier new', courier, monospace" ) { echo 'checked="checked"'; } ?> tabindex="3" /> <label for="ptb_basefontCourier" class="courier">Courier</label><br />
					<input id="ptb_basefontGeorgia" name="ptb_basefontfamily" type="radio" class="radio" value="georgia, times, serif" <?php if ( get_option('plaintxtblog_basefontfamily') == "georgia, times, serif" ) { echo 'checked="checked"'; } ?> tabindex="4" /> <label for="ptb_basefontGeorgia" class="georgia">Georgia</label><br />
					<input id="ptb_basefontLucidaConsole" name="ptb_basefontfamily" type="radio" class="radio" value="'lucida console', monaco, monospace" <?php if ( get_option('plaintxtblog_basefontfamily') == "'lucida console', monaco, monospace" ) { echo 'checked="checked"'; } ?> tabindex="5" /> <label for="ptb_basefontLucidaConsole" class="lucida-console">Lucida Console</label><br />
					<input id="ptb_basefontLucidaUnicode" name="ptb_basefontfamily" type="radio" class="radio" value="'lucida sans unicode', 'lucida grande', sans-serif" <?php if ( get_option('plaintxtblog_basefontfamily') == "'lucida sans unicode', 'lucida grande', sans-serif" ) { echo 'checked="checked"'; } ?> tabindex="6" /> <label for="ptb_basefontLucidaUnicode" class="lucida-unicode">Lucida Sans Unicode</label><br />
					<input id="ptb_basefontTahoma" name="ptb_basefontfamily" type="radio" class="radio" value="tahoma, geneva, sans-serif" <?php if ( get_option('plaintxtblog_basefontfamily') == "tahoma, geneva, sans-serif" ) { echo 'checked="checked"'; } ?> tabindex="7" /> <label for="ptb_basefontTahoma" class="tahoma">Tahoma</label><br />
					<input id="ptb_basefontTimes" name="ptb_basefontfamily" type="radio" class="radio" value="'times new roman', times, serif" <?php if ( get_option('plaintxtblog_basefontfamilyfamily') == "'times new roman', times, serif" ) { echo 'checked="checked"'; } ?> tabindex="8" /> <label for="ptb_basefontTimes" class="times">Times</label><br />
					<input id="ptb_basefontTrebuchetMS" name="ptb_basefontfamily" type="radio" class="radio" value="'trebuchet ms', helvetica, sans-serif" <?php if ( get_option('plaintxtblog_basefontfamily') == "'trebuchet ms', helvetica, sans-serif" ) { echo 'checked="checked"'; } ?> tabindex="9" /> <label for="ptb_basefontTrebuchetMS" class="trebuchet">Trebuchet MS</label><br />
					<input id="ptb_basefontVerdana" name="ptb_basefontfamily" type="radio" class="radio" value="verdana, geneva, sans-serif" <?php if ( ( get_option('plaintxtblog_basefontfamily') == "") || ( get_option('plaintxtblog_basefontfamily') == "verdana, geneva, sans-serif") ) { echo 'checked="checked"'; } ?> tabindex="10" /> <label for="ptb_basefontVerdana" class="verdana">Verdana</label><br />
					<p class="info"><?php printf(__('The base font family sets the font for everything except content headings. The selection is limited to %1$s fonts, as they will display correctly. Default is <span class="verdana">Verdana</span>.', 'plaintxtblog'), '<cite><a href="http://en.wikipedia.org/wiki/Web_safe_fonts" title="Web safe fonts - Wikipedia">web safe</a></cite>'); ?></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Heading font family', 'plaintxtblog'); ?></th> 
				<td>
					<input id="ptb_headingfontArial" name="ptb_headingfontfamily" type="radio" class="radio" value="arial, helvetica, sans-serif" <?php if ( get_option('plaintxtblog_headingfontfamilyfamily') == "arial, helvetica, sans-serif" ) { echo 'checked="checked"'; } ?> tabindex="11" /> <label for="ptb_headingfontArial" class="arial">Arial</label><br />
					<input id="ptb_headingfontCourier" name="ptb_headingfontfamily" type="radio" class="radio" value="'courier new', courier, monospace" <?php if ( get_option('plaintxtblog_headingfontfamily') == "'courier new', courier, monospace" ) { echo 'checked="checked"'; } ?> tabindex="12" /> <label for="ptb_headingfontCourier" class="courier">Courier</label><br />
					<input id="ptb_headingfontGeorgia" name="ptb_headingfontfamily" type="radio" class="radio" value="georgia, times, serif" <?php if ( get_option('plaintxtblog_headingfontfamily') == "georgia, times, serif" ) { echo 'checked="checked"'; } ?> tabindex="13" /> <label for="ptb_headingfontGeorgia" class="georgia">Georgia</label><br />
					<input id="ptb_headingfontLucidaConsole" name="ptb_headingfontfamily" type="radio" class="radio" value="'lucida console', monaco, monospace" <?php if ( get_option('plaintxtblog_headingfontfamily') == "'lucida console', monaco, monospace" ) { echo 'checked="checked"'; } ?> tabindex="14" /> <label for="ptb_headingfontLucidaConsole" class="lucida-console">Lucida Console</label><br />
					<input id="ptb_headingfontLucidaUnicode" name="ptb_headingfontfamily" type="radio" class="radio" value="'lucida sans unicode', 'lucida grande', sans-serif" <?php if ( get_option('plaintxtblog_headingfontfamily') == "'lucida sans unicode', 'lucida grande', sans-serif" ) { echo 'checked="checked"'; } ?> tabindex="15" /> <label for="ptb_headingfontLucidaUnicode" class="lucida-unicode">Lucida Sans Unicode</label><br />
					<input id="ptb_headingfontTahoma" name="ptb_headingfontfamily" type="radio" class="radio" value="tahoma, geneva, sans-serif" <?php if ( get_option('plaintxtblog_headingfontfamily') == "tahoma, geneva, sans-serif" ) { echo 'checked="checked"'; } ?> tabindex="16" /> <label for="ptb_headingfontTahoma" class="tahoma">Tahoma</label><br />
					<input id="ptb_headingfontTimes" name="ptb_headingfontfamily" type="radio" class="radio" value="'times new roman', times, serif" <?php if ( get_option('plaintxtblog_headingfontfamily') == "'times new roman', times, serif" ) { echo 'checked="checked"'; } ?> tabindex="17" /> <label for="ptb_headingfontTimes" class="times">Times</label><br />
					<input id="ptb_headingfontTrebuchetMS" name="ptb_headingfontfamily" type="radio" class="radio" value="'trebuchet ms', helvetica, sans-serif" <?php if ( get_option('plaintxtblog_headingfontfamily') == "'trebuchet ms', helvetica, sans-serif" ) { echo 'checked="checked"'; } ?> tabindex="18" /> <label for="ptb_headingfontTrebuchetMS" class="trebuchet">Trebuchet MS</label><br />
					<input id="ptb_headingfontVerdana" name="ptb_headingfontfamily" type="radio" class="radio" value="verdana, geneva, sans-serif" <?php if ( ( get_option('plaintxtblog_headingfontfamily') == "verdana, geneva, sans-serif") || ( get_option('plaintxtblog_headingfontfamily') == "") ) { echo 'checked="checked"'; } ?> tabindex="19" /> <label for="ptb_headingfontVerdana" class="verdana">Verdana</label><br />
					<p class="info"><?php printf(__('The heading font family sets the font for all content headings. The selection is limited to %1$s fonts, as they will display correctly. Default is <span class="verdana">Verdana</span>. ', 'plaintxtblog'), '<cite><a href="http://en.wikipedia.org/wiki/Web_safe_fonts" title="Web safe fonts - Wikipedia">web safe</a></cite>'); ?></p>
				</td>
			</tr>
		</table>
		<h3><?php _e('Layout', 'plaintxtblog'); ?></h3>
		<table class="form-table" summary="PlaintxtBlog layout options">
			<tr valign="top">
				<th scope="row"><label for="ptb_posttextalignment"><?php _e('Post text alignment', 'plaintxtblog'); ?></label></th> 
				<td>
					<select id="ptb_posttextalignment" name="ptb_posttextalignment" tabindex="23" class="dropdown">
						<option value="center" <?php if ( get_option('plaintxtblog_posttextalignment') == "center" ) { echo 'selected="selected"'; } ?>><?php _e('Centered', 'plaintxtblog'); ?> </option>
						<option value="justify" <?php if ( get_option('plaintxtblog_posttextalignment') == "justify" ) { echo 'selected="selected"'; } ?>><?php _e('Justified', 'plaintxtblog'); ?> </option>
						<option value="left" <?php if ( ( get_option('plaintxtblog_posttextalignment') == "") || ( get_option('plaintxtblog_posttextalignment') == "left") ) { echo 'selected="selected"'; } ?>><?php _e('Left', 'plaintxtblog'); ?> </option>
						<option value="right" <?php if ( get_option('plaintxtblog_posttextalignment') == "right" ) { echo 'selected="selected"'; } ?>><?php _e('Right', 'plaintxtblog'); ?> </option>
					</select>
					<p class="info"><?php _e('Choose one of the options for the alignment of the post entry text. Default is <span>left</span>.', 'plaintxtblog'); ?></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="ptb_sidebarposition"><?php _e('Sidebar position', 'plaintxtblog'); ?></label></th> 
				<td>
					<select id="ptb_sidebarposition" name="ptb_sidebarposition" tabindex="24" class="dropdown">
						<option value="left" <?php if ( ( get_option('plaintxtblog_sidebarposition') == "") || ( get_option('plaintxtblog_sidebarposition') == "left") ) { echo 'selected="selected"'; } ?>><?php _e('Left of content', 'plaintxtblog'); ?> </option>
						<option value="right" <?php if ( get_option('plaintxtblog_sidebarposition') == "right" ) { echo 'selected="selected"'; } ?>><?php _e('Right of content', 'plaintxtblog'); ?> </option>
					</select>
					<p class="info"><?php _e('The sidebar can be positioned to the left or the right of the main content column. Default is <span>left of content</span>.', 'plaintxtblog'); ?></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="ptb_sidebartextalignment" class="dropdown"><?php _e('Sidebar text alignment', 'plaintxtblog'); ?></label></th> 
				<td>
					<select id="ptb_sidebartextalignment" name="ptb_sidebartextalignment" tabindex="25" class="dropdown">
						<option value="center" <?php if ( get_option('plaintxtblog_sidebartextalignment') == "center" ) { echo 'selected="selected"'; } ?>><?php _e('Centered', 'plaintxtblog'); ?> </option>
						<option value="left" <?php if ( get_option('plaintxtblog_sidebartextalignment') == "left" ) { echo 'selected="selected"'; } ?>><?php _e('Left', 'plaintxtblog'); ?> </option>
						<option value="right" <?php if ( ( get_option('plaintxtblog_sidebartextalignment') == "") || ( get_option('plaintxtblog_sidebartextalignment') == "right") ) { echo 'selected="selected"'; } ?>><?php _e('Right', 'plaintxtblog'); ?> </option>
					</select>
					<p class="info"><?php _e('Choose one of the options for the alignment of the sidebar text. Default is <span>right</span>.', 'plaintxtblog'); ?></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="ptb_singlelayout"><?php _e('Single post layout', 'plaintxtblog'); ?></label></th> 
				<td>
					<select id="ptb_singlelayout" name="ptb_singlelayout" tabindex="26" class="dropdown">
						<option value="normalsingle" <?php if ( ( get_option('plaintxtblog_singlelayout') == "") || ( get_option('plaintxtblog_singlelayout') == "normalsingle") ) { echo 'selected="selected"'; } ?>><?php _e('Normal layout (3 columns)', 'plaintxtblog'); ?> </option>
						<option value="singlesingle" <?php if ( get_option('plaintxtblog_singlelayout') == "singlesingle" ) { echo 'selected="selected"'; } ?>><?php _e('Minimal layout (1 column)', 'plaintxtblog'); ?> </option>
					</select>
					<p class="info"><?php _e('The single <em>post</em> layout can either be three column (normal) or one column (minimal). Default is <span>normal layout (3 columns)</span>. ', 'plaintxtblog'); ?></p>
				</td>
			</tr>
		</table>
		<h3><?php _e('Content', 'plaintxtblog'); ?></h3>
		<table class="form-table" summary="PlaintxtBlog content options">
			<tr valign="top">
				<th scope="row"><label for="ptb_avatarsize"><?php _e('Avatar size', 'plaintxtblog'); ?></label></th> 
				<td>
					<input id="ptb_avatarsize" name="ptb_avatarsize" type="text" class="text" value="<?php if ( get_option('plaintxtblog_avatarsize') == "" ) { echo "24"; } else { echo attribute_escape( get_option('plaintxtblog_avatarsize') ); } ?>" size="6" />
					<p class="info"><?php _e('Sets the avatar size in pixels, if avatars are enabled. Default is <span>24</span>.', 'plaintxtblog'); ?></p>
				</td>
			</tr>
		</table>
		<p class="submit">
			<input name="save" type="submit" value="<?php _e('Save Options', 'plaintxtblog'); ?>" tabindex="27" accesskey="S" />  
			<input name="action" type="hidden" value="save" />
			<input name="page_options" type="hidden" value="ptb_basefontsize,ptb_basefontfamily,ptb_headingfontfamily,ptb_posttextalignment,ptb_sidebarposition,ptb_sidebartextalignment,ptb_singlelayout,ptb_avatarsize" />
		</p>
	</form>
	<h3 id="reset"><?php _e('Reset Options', 'plaintxtblog'); ?></h3>
	<p><?php _e('Resetting deletes all stored plaintxtBlog options from your database. After resetting, default options are loaded but are not stored until you click <i>Save Options</i>. A reset does not affect the actual theme files in any way. If you are uninstalling plaintxtBlog, please reset before removing the theme files to clear your databse.', 'plaintxtblog'); ?></p>
	<form action="<?php echo wp_specialchars( $_SERVER['REQUEST_URI'] ) ?>" method="post">
		<?php wp_nonce_field('plaintxtblog_reset_options'); echo "\n"; ?>
		<p class="submit">
			<input name="reset" type="submit" value="<?php _e('Reset Options', 'plaintxtblog'); ?>" onclick="return confirm('<?php _e('Click OK to reset. Any changes to these theme options will be lost!', 'plaintxtblog'); ?>');" tabindex="44" accesskey="R" />
			<input name="action" type="hidden" value="reset" />
			<input name="page_options" type="hidden" value="ptb_basefontsize,ptb_basefontfamily,ptb_headingfontfamily,ptb_posttextalignment,ptb_sidebarposition,ptb_sidebartextalignment,ptb_singlelayout,ptb_avatarsize" />
		</p>
	</form>
</div>
<?php
}

// Loads settings for the theme options to use
function plaintxtblog_wp_head() {
	if ( get_option('plaintxtblog_basefontsize') == "" ) {
		$basefontsize = '70%';
		} else {
			$basefontsize = attribute_escape( stripslashes( get_option('plaintxtblog_basefontsize') ) ); 
	};
	if ( get_option('plaintxtblog_basefontfamily') == "" ) {
		$basefontfamily = 'verdana, geneva, sans-serif';
		} else {
			$basefontfamily = wp_specialchars( stripslashes( get_option('plaintxtblog_basefontfamily') ) ); 
	};
	if ( get_option('plaintxtblog_headingfontfamily') == "" ) {
		$headingfontfamily = 'verdana, geneva, sans-serif';
		} else {
			$headingfontfamily = wp_specialchars( stripslashes( get_option('plaintxtblog_headingfontfamily') ) ); 
	};
	if ( get_option('plaintxtblog_posttextalignment') == "" ) {
		$posttextalignment = 'left';
		} else {
			$posttextalignment = attribute_escape( stripslashes( get_option('plaintxtblog_posttextalignment') ) ); 
	};
	if ( get_option('plaintxtblog_sidebarposition') == "" ) {
		$sidebarposition = 'body div#container{float:right;margin:0 0 0 -320px;}
body div#content{margin:0 0 0 320px;}
body div#primary{float:left;}
body div#secondary{float:right;margin-right:20px;}
body div.sidebar{border-right:5px solid #ddd;padding-right:15px;}';
		} elseif ( get_option('plaintxtblog_sidebarposition') =="left" ) {
			$sidebarposition = 'body div#container{float:right;margin:0 0 0 -320px;}
body div#content{margin:0 0 0 320px;}
body div#primary{float:left;}
body div#secondary{float:right;margin-right:20px;}
body div.sidebar{border-right:5px solid #ddd;padding-right:15px;}';
		} elseif ( get_option('plaintxtblog_sidebarposition') =="right" ) {
			$sidebarposition = 'body div#container{float:left;margin:0 -320px 0 0;}
body div#content{margin:0 320px 0 0;}
body div#primary{float:right;}
body div#secondary{float:left;margin-left:20px;}
body div.sidebar{border-left:5px solid #ddd;padding-left:15px;}';
	};
	if ( get_option('plaintxtblog_sidebartextalignment') == "" ) {
		$sidebartextalignment = 'right';
		} else {
			$sidebartextalignment = attribute_escape( stripslashes( get_option('plaintxtblog_sidebartextalignment') ) ); 
	};
	if ( get_option('plaintxtblog_singlelayout') == "" ) {
		$singlelayout = '';
		} elseif ( get_option('plaintxtblog_singlelayout') =="normalsingle" ) {
			$singlelayout = '';
		} elseif ( get_option('plaintxtblog_singlelayout') =="singlesingle" ) {
			$singlelayout = 'body.single div#container{float:none;margin:0 auto;width:75%}
body.single div#content{margin:0;}
body.single div.sidebar{display:none;}
';
	};
?>

<style type="text/css" media="screen,projection">
/*<![CDATA[*/
/* CSS inserted by plaintxtBlog theme options */
body{font-family:<?php echo $basefontfamily; ?>;font-size:<?php echo $basefontsize; ?>;}
body div#content div.hentry{text-align:<?php echo $posttextalignment; ?>;}
body div#content h2,div#content h3,div#content h4,div#content h5,div#content h6{font-family:<?php echo $headingfontfamily; ?>;}
body div.sidebar{text-align:<?php echo $sidebartextalignment; ?>;}
<?php echo $singlelayout; ?>
<?php echo $sidebarposition; ?>

/*]]>*/
</style>
<?php // Checks that everything has loaded properly
}

add_action('admin_menu', 'plaintxtblog_add_admin');
add_action('wp_head', 'plaintxtblog_wp_head');
add_action('init', 'plaintxtblog_widgets_init');

add_filter('archive_meta', 'wptexturize');
add_filter('archive_meta', 'convert_smilies');
add_filter('archive_meta', 'convert_chars');
add_filter('archive_meta', 'wpautop');

add_shortcode('gallery', 'plaintxtblog_gallery', $attr);

// Readies for translation.
load_theme_textdomain('plaintxtblog');
?>