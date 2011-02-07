<?php

/**
* This is a highly intuitive script file that gets images
* It first calls for custom field keys
* If no custom field key is set, check for images "attached" to post
* Check for image order if looking for attached images
* Scan the post for images if $image_scan = true
* Check for default image if there is one set
*
* Entirely rewrote the system in 0.2.3
*
* @package Hybrid
* @subpackage Media
*
* @since 0.1
*/
function get_the_image($args = array()) {

	$defaults = array(
		'custom_key' => array('Thumbnail','thumbnail'),
		'post_id' => false, // Build functionality in later
		'default_size' => 'thumbnail',
		'default_image' => false,
		'order_of_image' => 0,
		'link_to_post' => true,
		'image_class' => false,
		'image_scan' => false,
		'show_caption' => false,
		'width' => false,
		'height' => false,
		'echo' => true
	);

	$args = wp_parse_args($args, $defaults);
	extract($args);

	if(!is_array($custom_key)) :
		$custom_key = str_replace(' ', '', $custom_key);
		$custom_key = str_replace(array('+'), ',', $custom_key);
		$custom_key = explode(',', $custom_key);
		$args['custom_key'] = $custom_key;
	endif;

	$image = image_by_custom_field($args);

	if(!$image) $image = image_by_attachment($args);

	if(!$image && $image_scan) $image = image_by_scan($args);

	if(!$image && $default_image) $image = image_by_default($args);

	if($image)
		$image = display_the_image($args, $image);

	else
		$image = '<!-- No images were added to this post. -->';

	if($echo)
		echo $image;
	else
		return $image;
}

/**
* Calls images by custom field key
* Allow looping through multiple custom fields
*
* @since 0.2.3
* @param $args Not Optional
* @return array $image, $classes, $alt
*/
function image_by_custom_field($args = array()) {

	extract($args);

	if(!$post_id)
		global $post;

	if(isset($custom_key)) :
		foreach($custom_key as $custom) :
			$image = get_post_custom_values($key = $custom);
			if($image[0]) :
				$image = $image[0];
				$classes[] = str_replace(' ', '-', strtolower($custom));
				break;
			endif;
		endforeach;
		if(!$image)
			return false;
	endif;

	$classes[] = $default_size;
	$alt = $post->post_title;

	return array('image' => $image, 'classes' => $classes, 'alt' => $alt);
}

/**
* Check for attachment images
* Uses get_children() to check if the post has images attached
*
* @since 0.2.3
* @param $args Not Optional
* @return array $image, $classes, $alt, $caption
*/
function image_by_attachment($args = array()) {

	extract($args);

	global $post;

	$classes[] = str_replace(' ', '-', strtolower($custom_key[0]));
	$classes[] = $default_size;
	$alt = $post->post_title;
	if($default_size == 'thumbnail') $show_caption = false;

	/*
	* Use a WP 2.6 function to check
	*/
	if(function_exists('wp_enqueue_style')) :
		$attachments = get_children(array('post_parent' => $post->ID, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID'));

	/*
	* WP 2.5 compatibility
	*/
	else :
		$attachments = get_children("post_parent=$post->ID&post_type=attachment&post_mime_type=image&orderby=\"menu_order ASC, ID ASC\"");

	endif;

	if(!empty($attachments)) :
		foreach($attachments as $id => $attachment) :
			if($i == $order_of_image) :
				$image = wp_get_attachment_image_src($id, $default_size);
				$image = $image[0];
				if($show_caption) :
					$caption = $attachment->post_excerpt;
					if(!$caption) $caption = $attachment->post_title;
				endif;
				break;
			endif;
			$i++;
		endforeach;
		return array('image' => $image, 'classes' => $classes, 'alt' => $alt, 'caption' => $caption);
	else :
		return false;
	endif;
}

/**
* Scans the post for images within the content
* Not called by default with get_the_image()
* Shouldn't use if using large images within posts, better to use the other options
*
* @since 0.2.3
* @param $args Not Optional
* @return $image, $classes, $alt
*/
function image_by_scan($args = array()) {

	global $post;

	preg_match_all('|<img.*?src=[\'"](.*?)[\'"].*?>|i', $post->post_content, $matches);

	if(isset($matches)) $image = $matches[1][0];

	$classes[] = $default_size;

	if($matches)
		return array('image' => $image, 'classes' => $classes, 'alt' => $post->post_title);
	else
		return false;
}

/**
* Used for setting a default image
* Not used with get_the_image() by default
* Function needed for getting the class and alt text
*
* @since 0.2.3
* @param $args Not Optional
* @return array $image, $classes, $alt
function image_by_default($args = array()) {

	extract($args);
	global $post;

	$image = $default_image;
	$classes[] = $default_size;

	foreach($custom_key as $key) :
		$classes[] = $key;
	endforeach;

	$alt = $post->post_title;

	return array('image' => $image, 'classes' => $classes, 'alt' => $alt);
}

/**
* Formats an image with appropriate alt text and class
* Adds a link to the post if argument is set
* Should only be called if there is an image to display, but will handle it if not
*
* @since 0.1
* @param $args Not Optional
* @param $arr Array of image info ($image, $classes, $alt, $caption)
* @return string Formatted image (w/link to post if the option is set)
*/
function display_the_image($args = array(), $arr = false) {
	global $post;

	extract($arr);

	if($image) :
		extract($args);

		if($width) $width = ' width="' . $width . '"';
		if($height) $height = ' height="' . $height . '"';

		$img = $image;
		$classes[] = $css_class;
		$class = join(' ', $classes);

		if($caption) :
			$image = '<div class="wp-caption ' . $class . '">';

			if($link_to_post) $image .= '<a href="' . get_permalink($post->ID) . '" title="' . the_title_attribute('echo=0') . '">';
			$image .= '<img src="' . $img . '" alt="' . the_title_attribute('echo=0') . '"' . $width . $height . ' />';
			if($link_to_post) $image .= '</a>';
			$image .= '<p class="wp-caption-text">' . $caption . '</p></div>';

		else :
			$image = '';
			if($link_to_post) $image .= '<a href="' . get_permalink($post->ID) . '" title="' . the_title_attribute('echo=0') . '">';
			$image .= '<img src="' . $img . '" alt="' . the_title_attribute('echo=0') . '" class="' . $class . '"' . $width . $height . ' />';
			if($link_to_post) $image .= '</a>';

		endif;

		return $image;

	else :
		return false;

	endif;
}
?>