<?php
/**
* Set of functions to gather video by custom field
* Output in XHTML-compliant <object> element
*
* @package Hybrid
* @subpackage Media
* @since 0.2
*/

/**
* get_the_video()
* Catchall function for getting videos
*
* @since 0.2
*/
function get_the_video($arr = false, $default = false) {
	global $post;
	$cf_array = load_the_video($arr, $post, $default);
	$video = display_the_video($cf_array);
	return $video;
}

/**
* load_the_video()
* Function for loading a video
*
* @since 0.2
*/
function load_the_video($custom_fields = false, $post = false, $default = false) {

// If custom fields and default video are set to false
if($custom_fields == false && $default == false) :
	$video = false;

// If custom fields are set
elseif($custom_fields == true) :
// Checks only if there are custom fields to check for
	if(isset($custom_fields)) :
	// Loop through the custom fields, checking for a video
		$i = 0;
		while(strcmp($video[0],'') == 0 && $i <= sizeof($custom_fields)) :
			$video = get_post_custom_values($key = $custom_fields[$i]);
		$i++;
		endwhile;
	endif;

// If a default is set or no custom field videos are found
elseif($default == true) :
	$video[] = $default;
endif;

// Return array with video (make array in case we need to add values later)
	return array($video);
}

/**
* display_the_video()
* Function for displaying a video
*
* @since 0.2
*/
function display_the_video($cf_array) {

// Set video nicename
	$video = $cf_array[0];

// If there's an imported video associated with this post
	if(isset($video[0]) && strcmp($video[0],'') != 0) :
		$output = "
		<object type='application/x-shockwave-flash' data='$video[0]' width='298' height='250'>
			<param name='movie' value='$video[0]' />
			<param name='allowfullscreen' value='true' />
			<param name='wmode' value='transparent' />
		</object>";
// If there's no video
	else :
		$output = false;
	endif;

// Return the video
	return $output;
}
?>