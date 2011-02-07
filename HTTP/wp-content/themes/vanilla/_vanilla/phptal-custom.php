<?php
if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) { die(); }

// Using ugly filter to get a return, not echo.
$comments_number = "";
function redir_comments_number($out){
	global $comments_number;
	$comments_number = $out;
	return "";
}
add_filter('comments_number', 'redir_comments_number');

// no filter here so have to redo the function using return, not echo.
function vanilla_comments_popup_link( $zero = 'No Comments', $one = '1 Comment', $more = '% Comments', $css_class = '', $none = 'Comments Off' ) {
	global $id, $wpcommentspopupfile, $wpcommentsjavascript, $post, $comments_number;
	
	$output = false;

	if ( is_single() || is_page() )
		return $output;

	$number = get_comments_number( $id );

	if ( 0 == $number && 'closed' == $post->comment_status && 'closed' == $post->ping_status ) {
		return '<span' . ((!empty($css_class)) ? ' class="' . $css_class . '"' : '') . '>' . $none . '</span>';
	}

	if ( post_password_required() ) {
		return __('Enter your password to view comments');
	}

	$output .= '<a href="';
	if ( $wpcommentsjavascript ) {
		if ( empty( $wpcommentspopupfile ) )
			$home = get_option('home');
		else
			$home = get_option('siteurl');
		$output .= $home . '/' . $wpcommentspopupfile . '?comments_popup=' . $id;
		$output .= '" onclick="wpopen(this.href); return false"';
	} else { // if comments_popup_script() is not in the template, display simple comment link
		if ( 0 == $number )
			$output .= get_permalink() . '#respond';
		else
			$output .= get_comments_link();
		$output .= '"';
	}

	if ( !empty( $css_class ) ) {
		$output .= ' class="'.$css_class.'" ';
	}
	$title = attribute_escape( get_the_title() );

	$output .= apply_filters( 'comments_popup_link_attributes', '' );

	$output .= ' title="' . sprintf( __('Comment on %s'), $title ) . '">';
	comments_number( $zero, $one, $more, $number );
	$output .= $comments_number . '</a>';
	
	return $output;
}
?>