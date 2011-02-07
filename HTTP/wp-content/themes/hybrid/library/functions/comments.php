<?php

/**
* Better display of avatars in comments
* Should only be used in comment sections (may update in future)
* Checks for false empty commenter URLs 'http://' w/registered users
* Adds the class 'photo' to the image
* Adds a call to HYBRID_IMAGES . '/trackback.jpg' for trackbacks
* Adds a call to HYBRID_IMAGES . '/pingback.jpg' for pingbacks
*
* Filters should only return a string for an image URL for the avatar with class $avatar
* They should not get the avatar as this is done after the filter
*
* @since 0.2
* @filter
*/
function hybrid_avatar() {
	global $comment, $hybrid_settings;

	$url = get_comment_author_url();

	$comment_type = get_comment_type();

	if($comment_type == 'trackback')
		$avatar = HYBRID_IMAGES . '/trackback.jpg';

	elseif($comment_type == 'pingback')
		$avatar = HYBRID_IMAGES . '/pingback.jpg';

	elseif($hybrid_settings['default_avatar'])
		$avatar = $hybrid_settings['default_avatar'];

	$avatar = apply_filters('hybrid_avatar', $avatar);

	if($url == true && $url != 'http://')
		echo '<a href="' . $url . '" rel="external nofollow" title="' . get_comment_author() . '">';

	echo str_replace("class='avatar", "class='photo avatar", get_avatar(get_comment_author_email(), '80', $avatar));

	if($url == true && $url != 'http://')
		echo '</a>';
}

/**
* Displays individual comments
* Uses the callback parameter for wp_list_comments
* Overwrites the default display of comments
*
* @since 0.2.3
*
* @param $comment The comment variable
* @param $args Array of arguments passed from wp_list_comments
* @param $depth What level the particular comment is
*/
function hybrid_comments_callback($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	$GLOBALS['comment_depth'] = $depth;
?>

	<li id="comment-<?php comment_ID(); ?>" class="<?php hybrid_comment_class(); ?>">

		<?php hybrid_avatar(); // Avatar filter ?><div class="comment-meta-data">

			<div class="comment-author vcard">
				<?php hybrid_comment_author(); ?>
			</div>

			<abbr class="comment-time" title="<?php comment_date(__('F jS, Y, g:i a (P - e)','hybrid')); ?>">
				<?php printf(__('%1$s at %2$s','hybrid'), get_comment_date(), get_comment_time()); ?>
			</abbr> 

			<span class="separator">|</span> 
			<a class="permalink" href="#comment-<?php comment_ID(); ?>" title="<?php _e('Permalink to comment','hybrid'); ?>"><?php _e('Permalink','hybrid'); ?></a>

			<?php
				if((get_option('thread_comments')) && ($args['type'] == 'all' || get_comment_type() == 'comment')) :
					$max_depth = get_option('thread_comments_depth');
					echo comment_reply_link(array(
						'reply_text' => __('Reply','hybrid'), 
						'login_text' => __('Log in to reply.','hybrid'),
						'depth' => $depth,
						'max_depth' => $max_depth, 
						'before' => '<span class="separator">|</span> <span class="comment-reply-link">', 
						'after' => '</span>'
					));
				endif;
			?>

			<?php edit_comment_link('<span class="edit">'.__('Edit','hybrid').'</span>',' <span class="separator">|</span> ',''); ?> 

			<?php if($comment->comment_approved == '0') : ?>
				<em><?php _e('Your comment is awaiting moderation.','hybrid'); ?></em>
			<?php endif; ?>

		</div>

		<div class="comment-text">
			<?php comment_text(); ?>
		</div>
<?php
}

/**
* Ends the display of individual comments
* Uses the callback parameter for wp_list_comments
* Needs to be used in conjunction with hybrid_comments_callback
* Not needed but used just in case something is changed
*
* @since 0.2.3
*/
function hybrid_comments_end_callback() {
	echo '</li>';
}

/**
* Sets a class for each comment
* Sets alt, odd/even, and author/user classes
* Adds author, user, and reader classes
*
* @since 0.2
*/
function hybrid_comment_class() {
	global $comment;
	static $comment_alt;
	$classes = array();

	if(function_exists('get_comment_class'))
		$classes = get_comment_class();

	$classes[] = get_comment_type();;

	/*
	* User classes
	*/
	if($comment->user_id > 0 && $user = get_userdata($comment->user_id)) :

		$classes[] = 'user user-' . $user->user_nicename;

		if($post = get_post($post_id)) :
			if($comment->user_id === $post->post_author)
				$classes[] = 'author author-' . $user->user_nicename;
		endif;
	else :
		$classes[] = 'reader';
	endif;

	/*
	* Alt classes
	*/
	if($comment_alt++ % 2) :
		$classes[] = 'even';
		$classes[] = 'alt';
	else :
		$classes[] = 'odd';
	endif;

	/*
	* http://microid.org
	*/
	$email = get_comment_author_email();
	$url = get_comment_author_url();
	if(!empty($email) && !empty($url)) {
		$microid = 'microid-mailto+http:sha1:' . sha1(sha1('mailto:'.$email).sha1($url));
		$classes[] = $microid;
	}


	$classes = join(' ', $classes);

	echo $classes;
}

/**
* Properly displays comment author name/link
* bbPress and other external systems sometimes don't set a display name for registrations
* WP has problems if no display name is set
* WP gives registered users URL of 'http://' if none is set
*
* @since 0.2.2
*/
function hybrid_comment_author() {
	global $comment;

	$author = get_comment_author();
	$url = get_comment_author_url();

	/*
	* Registered members w/o URL defaults to 'http://'
	*/
	if($url == 'http://')
		$url = false;

	/*
	* Registered through bbPress sometimes leaves no display name
	* Bug with bbPress 0.9 series and WP 2.5 (no later testing)
	*/
	if(!$author && $comment->user_id > 0) :
		$user = get_userdata($comment->user_id);
		if($user->display_name !== '')
			$author = $user->display_name;
		elseif($user->user_nickname !== '')
			$author = $user->nickname;
		elseif($user->user_nicename !== '')
			$author = $user->user_nicename;
		else
			$author = $user->user_login;
	endif;

	/*
	* Display link and cite if URL is set
	* Also properly cites trackbacks/pingbacks
	*/
	if($url) :
		$output = '<cite title="' . $url . '">';
		$output .= '<a href="' . $url . '" title="' . $author . '" class="external nofollow">' . $author . '</a>';
		$output .= '</cite>';
	else :
		$output = '<cite>';
		$output .= $author;
		$output .= '</cite>';
	endif;

	echo $output;
}
?>