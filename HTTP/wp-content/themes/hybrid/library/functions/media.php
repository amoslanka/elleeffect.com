<?php

/**
* Media API
*
* Loads media styles and scripts for the theme
* Handles attachment files
* See (get-the-image.php, get-the-video.php) for other media
*
* @package Hybrid
* @subpackage Media
* @since 0.1
*/

/**
* Filter to load CSS appropriately
*
* @since 0.1
* @filter
* @hook wp_head()
*/
function hybrid_enqueue_style() {
	global $hybrid_settings;

	$css = false;

	if($hybrid_settings['print_style']) :

	// WP 2.6+
		if(function_exists('wp_enqueue_style')) :
			wp_enqueue_style('hybrid_print', HYBRID_CSS . '/print.css', false, '0.2', 'print');
			wp_print_styles(array('hybrid_print'));
		else :
			$css = '<link rel="stylesheet" href="' . HYBRID_CSS . '/print.css" type="text/css" media="print" />';
		endif;

	endif;

	echo apply_filters('hybrid_enqueue_style', $css);
}

/**
* Filter to load JavaScript at appropriate time
*
* @since 0.1
* @filter
* @hook hybrid_head()
*/
function hybrid_enqueue_script() {

	global $hybrid_settings;

	/*
	* Common JS files
	* jQuery pullquotes
	*/
	if($hybrid_settings['common_js']) :
		wp_enqueue_script('hybrid_common', HYBRID_JS . '/common.js', array('jquery'), 0.3);
	else :
		if($hybrid_settings['pullquotes_js'])
			wp_enqueue_script('hybrid_pullquotes', HYBRID_JS . '/pullquotes.js', array('jquery'), 0.3);
	endif;

	/*
	* Comment reply (WP 2.7)
	*/
	if(function_exists('is_singular')) :
		if(is_singular()) :
			if(get_option('thread_comments')) wp_enqueue_script('comment-reply');
		endif;
	endif;

	/*
	* Comments popup script if selected
	*/
	if($hybrid_settings['comments_popup'] && is_page_template('blog.php')) :
		comments_popup_script(620, 400);

	elseif(($hybrid_settings['comments_popup']) && (is_archive() || is_search() || is_home() || is_front_page())) :
		comments_popup_script(620, 400);
	endif;

	/*
	* Flash video embed
	*/
	if(is_attachment() && get_post_mime_type() == 'application/octet-stream') :
		if(preg_match('/\.flv$/', wp_get_attachment_url()))
			wp_enqueue_script('flash_embed', HYBRID_JS . '/flash-embed.js', false, 0.1);
	endif;

	$script = false;
	echo apply_filters('hybrid_enqueue_script', $script);
}

/**
* Checks the mime type and attachment extension
* Calls a function, if needed, to handle the output
*
* @since 0.2.2
*/
function hybrid_handle_attachment($mime = false, $file = false) {

	if(!$mime || !$file) :
		return;

	elseif($mime == 'video/asf' || $mime == 'video/quicktime') :
		hybrid_video_attachment($mime, $file);

	elseif($mime == 'application/octet-stream' && preg_match('/\.flv$/', $file)) :
		hybrid_video_attachment($mime, $file);

	elseif($mime == 'audio/mpeg' || $mime == 'audio/wma') :
		hybrid_audio_attachment($mime, $file);

	elseif($mime == 'text/plain' || $mime == 'text/css' || $mime == 'text/html') :
		hybrid_text_attachment($mime, $file);

	elseif($mime == 'application/pdf' || $mime == 'application/javascript' || $mime == 'application/rtf' || $mime == 'application/msword') :
		hybrid_application_attachment($mime, $file);

	endif;
}

/**
* Handles application attachments on their attachment pages
* Uses the <object> tag to embed media on those pages
*
* @since 0.3
*/
function hybrid_application_attachment($mime = false, $file = false) {

	echo '<object class="text" type="' . $mime . '" data="' . $file . '" width="400">';
	echo '<param name="src" value="' . $file . '" />';
	echo '</object>';
}

/**
* Handles text attachments on their attachment pages
* Uses the <object> element to show embed media in the pages
*
* @since 0.3
*/
function hybrid_text_attachment($mime = false, $file = false) {

	echo '<object class="text" type="' . $mime . '" data="' . $file . '" width="400">';
	echo '<param name="src" value="' . $file . '" />';
	echo '</object>';
}

/**
* Handles audio attachments on their attachment pages
* Puts audio/mpeg and audio/wma files into an <object> element
*
* @since 0.2.2
*/
function hybrid_audio_attachment($mime = false, $file = false) {

	if($mime == false || $file == false) :
		return;

	elseif($mime == 'audio/mpeg' || $mime == 'audio/wma') :

		echo '<object type="' . $mime . '" class="audio" data="' . $file . '" width="400" height="50">';
			echo '<param name="src" value="' . $file . '" />';
			echo '<param name="autostart" value="false" />';
			echo '<param name="controller" value="true" />';
		echo '</object>';

	endif;

}

/**
* Handles video attachments on attachment pages
* Also handles application/octet-stream attachments if video (flv)
* FLV files are loaded with Flowplayer (see hybrid_enqueue_script() for JS)
* Add other video types to the <object> element
*
* @since 0.2.2
*/
function hybrid_video_attachment($mime = false, $file = false) {

	if($mime == false || $file == false) :
		return;

	elseif($mime == 'video/asf') :

		echo '<object type="video/x-ms-wmv" class="video" data="' . $file . '" width="400" height="320">';
			echo '<param name="src" value="' . $file . '" />';
			echo '<param name="autostart" value="false" />';
			echo '<param name="allowfullscreen" value="true" />';
			echo '<param name="controller" value="true" />';
		echo '</object>';

	elseif($mime == 'video/quicktime') :

		echo '<object type="video/quicktime" class="video" data="' . $file . '">';
			echo '<param name="autoplay" value="false" />';
			echo '<param name="allowfullscreen" value="true" />';
			echo '<param name="controller" value="true" />';
		echo '</object>';

	elseif($mime == 'application/octet-stream') :

		if(preg_match('/\.flv$/', $file)) :

		echo '<div id="flash-video" class="video"></div>';
		?>
		<script type="text/javascript">
			flashembed("flash-video", "<?php echo HYBRID_SWF; ?>/FlowPlayerDark.swf", {
				config: { 
  					videoFile: '<?php echo $file; ?>', 
					initialScale: 'scale',
					autoPlay: false,
					loop: false,
					showVolumeSlider: false,
					controlsOverVideo: 'ease',
					controlBarBackgroundColor: -1,
					controlBarGloss: 'low'
				}
			});
		</script>

<?php
		endif;

	else :
		return;

	endif;

}

/**
* Pulls an image for the particular mime type
* Currently, just passes variables to hybrid_attachment_icon
* Need to update and work with wp_mime_type_icon()
*
* @since 0.2.3
* @param $mime, $file
*/
function hybrid_mime_type_icon($mime = false, $file = false) {

	if($mime && $file)
		hybrid_attachment_icon($mime, $file);

	// global $post;
	// echo '<img src="' . wp_mime_type_icon($post->ID) . '" class="mime-type-icon" alt="' . __('Mime-type icon','hybrid') . '" />';
}

/**
* Displays icons for attachments
*
* @since 0.2.2
*/
function hybrid_attachment_icon($mime = false, $file = false) {

	$img = false;

	if(!$mime || !$file) :
		return;

// Video
	elseif($mime == 'video/asf') :
		$img = HYBRID_IMAGES . '/video.png';

	elseif($mime == 'video/quicktime') :
		$img = HYBRID_IMAGES . '/video.png';

// Audio
	elseif($mime == 'audio/mpeg' || $mime == 'audio/wma') :
		$img = HYBRID_IMAGES . '/audio.png';

// Application
	elseif($mime == 'application/octet-stream' && preg_match('/\.flv$/', $file)) :
		$img = HYBRID_IMAGES . '/video.png';

	elseif($mime == 'application/javascript') :
		$img = HYBRID_IMAGES . '/js.png';

	elseif($mime == 'application/octet-stream') :
		$img = HYBRID_IMAGES . '/default.png';

	elseif($mime == 'application/zip') :
		$img = HYBRID_IMAGES . '/zip.png';

	elseif($mime == 'application/x-tar') :
		$img = HYBRID_IMAGES . '/tar.png';

	elseif($mime == 'application/pdf') :
		$img = HYBRID_IMAGES . '/pdf.png';

	elseif($mime == 'application/msword') :
		$img = HYBRID_IMAGES . '/doc.png';

	elseif($mime == 'application/rtf') :
		$img = HYBRID_IMAGES . '/doc.png';

	elseif($mime == 'application/x-msdownload') :
		$img = HYBRID_IMAGES . '/exe.png';

	elseif($mime == 'application/x-shockwave-flash') :
		$img = HYBRID_IMAGES . '/swf.png';

// Text
	elseif($mime == 'text/plain') :
		$img = HYBRID_IMAGES . '/text.png';

	elseif($mime == 'text/html') :
		$img = HYBRID_IMAGES . '/html.png';

	elseif($mime == 'text/css') :
		$img = HYBRID_IMAGES . '/css.png';

	else :
		$img = HYBRID_IMAGES . '/default.png';

	endif;

	if($img)
		echo '<img class="attachment-icon" src="' . $img . '" alt="' . $mime . '" title="' . $mime . '" />';

}
?>