<?php
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); }

function ngg_fv_default_options() {

	/* Settings for SimpleViewer */
    $ngg_fv_options['ngg_sv_max_image_width'] 			= 640;				// Width of your largest image in pixels. Used to determine the best layout for your gallery
    $ngg_fv_options['ngg_sv_max_image_height']			= 480;				// Height of your largest image in pixels. Used to determine the best layout for your gallery.
    $ngg_fv_options['ngg_sv_text_color'] 				= "999999";			// Color of title and caption text (hexidecimal color value e.g 0xff00ff).
	$ngg_fv_options['ngg_sv_preloader_color'] 			= '999999';			// Color of the loading bar (hexidecimal color value e.g 0xff00ff).
    $ngg_fv_options['ngg_sv_frame_color'] 				= "999999";			// Color of image frame, navigation buttons and thumbnail frame (hexidecimal color value e.g 0xff00ff).
    $ngg_fv_options['ngg_sv_frame_width'] 				= 1;				// Width of image frame in pixels.
	$ngg_fv_options['ngg_sv_stage_padding'] 			= 40;				// Distance between image and thumbnails and around gallery edge in pixels.
	$ngg_fv_options['ngg_sv_navPadding'] 				= 40;				// Distance between image and thumbnails (pixels).
    $ngg_fv_options['ngg_sv_thumbnail_columns'] 		= 5;				// Number of thumbnail rows. (To disable thumbnails completely set this value to 0.)
    $ngg_fv_options['ngg_sv_thumbnail_rows'] 			= 2;				// Number of thumbnail columns. (To disable thumbnails completely set this value to 0.)
	$ngg_fv_options['ngg_sv_nav_position'] 				= "top";			// Position of thumbnails relative to image. Can be "top", "bottom","left" or "right".
    $ngg_fv_options['ngg_sv_vAlign'] 					= "center";			// Vertical placment of the image and thumbnails within the SWF. Can be "center", "top" or "bottom". For large format galleries this is best set to "center". For small format galleries setting this to "top" or "bottom" can help get the image flush to the edge of the swf.
    $ngg_fv_options['ngg_sv_hAlign'] 					= "center";			// Horizontal placement of the image and thumbnails within the SWF. Can be "center", "left" or "right". For large format galleries this is best set to "center". For small format galleries setting this to "left" or "right" can help get the image flush to the edge of the swf.
    $ngg_fv_options['ngg_sv_background_image_path'] 	= "";				// Relative or absolute path to a JPG or SWF to load as the gallery background.

	/* Settings for TiltViewer */
    $ngg_fv_options['ngg_tv_max_jpg_size'] 				= 640;				// Set this value to the largest dimension (width or height) of your largest image. TiltViewer uses this value to proportionately scale your images to fit.
    $ngg_fv_options['ngg_tv_use_reload_button'] 		= "false";			// Defines whether to use the circular reload button under the images, or to use next/back arrow buttons for gallery paging.
    $ngg_fv_options['ngg_tv_show_flip_button'] 			= "true";			// Defines whether to display the 'flip' button at the bottom-right of a zoomed in image. Affects all images.
    $ngg_fv_options['ngg_tv_showLinkButton'] 			= "true";			// Defines whether to display the 'go to Flickr page' button on the image flipside. Affects all images.
    $ngg_fv_options['ngg_tv_linkLabel'] 				= "go to Flickr page";			// Text to display as the flipside link button label.
	$ngg_fv_options['ngg_tv_columns'] 					= 5;				// Number of columns of images to display
    $ngg_fv_options['ngg_tv_rows'] 						= 5;				// Number of rows of images to display.
    $ngg_fv_options['ngg_tv_frame_color'] 				= "999999";			// Hexadecimal color value of the image frame.
    $ngg_fv_options['ngg_tv_back_color'] 				= "FFFFFF";			// Hexadecimal color value of the flipside background.
    $ngg_fv_options['ngg_tv_bkgnd_inner_color'] 		= "FFFFFF";			// Hexadecimal color value of the stage background gradient center.
    $ngg_fv_options['ngg_tv_bkgnd_outer_color'] 		= "FFFFFF";			// Hexadecimal color value of the stage background gradient edge.
    $ngg_fv_options['ngg_tv_lang_go_full'] 				= "Go Fullscreen";	// The text displayed for the right-click 'Go Fullscreen' menu option.
    $ngg_fv_options['ngg_tv_lang_exit_full'] 			= "Exit Fullscreen";// The text displayed for the right-click 'Exit Fullscreen' menu option.
    $ngg_fv_options['ngg_tv_lang_about'] 				= "About";			// The text displayed for the right-click 'About' menu option.
	$ngg_fv_options['ngg_tv_user_id']					= "";				// User ID of your Flickr account
	$ngg_fv_options['ngg_tv_tag_mode']					= "any";			// "any" for an OR combination of tags (image can have 1 or more tags to be displayed) "all" for an AND combination (image must have all tags to be displayed) 
	$ngg_fv_options['ngg_tv_showTakenByText']			= "true";			// Defines whether to display the 'taken by X on Y' text on the image flipside.

	/* Additional Settings for TiltViewer (Pro version only)*/
	$ngg_fv_options['have_pro_tv']						= "false";			// Set to true if you have TiltViewer Pro
    $ngg_fv_options['ngg_tv_pro_bkgndTransparent'] 		= "true";			// Defines whether to hide the radial gradient background behind the image grid.
    $ngg_fv_options['ngg_tv_pro_showFullscreenOption'] 	= "true";			// Defines whether to show the 'Go Fullscreen' right-click menu option.
    $ngg_fv_options['ngg_tv_pro_frameWidth'] 			= 10;				// Width of the image frames. To remove frames completely set this to -5.
    $ngg_fv_options['ngg_tv_pro_zoomedInDistance'] 		= 1400;				// Camera distance from image when zoomed in to an image. Increasing this value makes the image smaller.
    $ngg_fv_options['ngg_tv_pro_zoomedOutDistance'] 	= 7500;				// Camera distance from image-grid when zoomed out. Increasing this value makes the image-grid smaller.
    $ngg_fv_options['ngg_tv_pro_fontName'] 				= "Arial";			// Font style used by the flipside text. Note: this font is not embedded in the swf, so the user must have the specified font on their machine to view the font. If they don't have the specified font, they will see the default system font (usually 'sans')
    $ngg_fv_options['ngg_tv_pro_titleFontSize'] 		= 90;				// Font size of flipside title text.
    $ngg_fv_options['ngg_tv_pro_descriptionFontSize'] 	= 32;				// Font size of flipside description text.
    $ngg_fv_options['ngg_tv_pro_navButtonColor'] 		= "CCCCCC";			// Hexadecimal color of the reload or next/back buttons. Default color is white.
    $ngg_fv_options['ngg_tv_pro_flipButtonColor'] 		= "999999";			// Hexadecimal color of the flip buttons. Default color is white.
    $ngg_fv_options['ngg_tv_pro_textColor'] 			= "999999";			// Hexadecimal color value of the flipside text.
    $ngg_fv_options['ngg_tv_pro_linkTextColor'] 		= "523FFE";			// Hexadecimal color value of the flipside link text.
    $ngg_fv_options['ngg_tv_pro_linkBkgndColor'] 		= "FFFFFF";			// Hexadecimal color value of the flipside link text background.
    $ngg_fv_options['ngg_tv_pro_linkFontSize'] 			= 41;				// Font size of flipside link text.
    $ngg_fv_options['ngg_tv_pro_linkTarget'] 			= "_self";			// "_self" specifies the current frame in the current window;"_blank" specifies a new window;"_parent" specifies the parent of the current frame; "_top" specifies the top-level frame in the current window.

	/* Settings for AutoViewer */
    $ngg_fv_options['ngg_av_frame_color'] 				= "999999";			// Hexadecimal color value of the image frame.
    $ngg_fv_options['ngg_av_frame_width'] 				= 1;				// Width of image frame in pixels.
    $ngg_fv_options['ngg_av_image_padding'] 			= 2;				// Padding in pixels.
    $ngg_fv_options['ngg_av_display_time'] 				= 6;				// Time to display image in seconds

	/* Settings for PostcardViewer */
    $ngg_fv_options['ngg_pv_cellDimension'] 			= 800;				// The size of the square 'cell' that contains each image (pixels). Make this at least as big as your biggest image to avoid the images overlapping.
    $ngg_fv_options['ngg_pv_columns'] 					= 4;				// Number of columns of images. Rows are calculated automatically from the number of images in the gallery.
    $ngg_fv_options['ngg_pv_zoomOutPerc'] 				= 15;				// The amout of scale when zoomed out (percentage).
    $ngg_fv_options['ngg_pv_zoomInPerc'] 				= 75;				// The amout of scale when zoomed in (percentage).
    $ngg_fv_options['ngg_pv_frameWidth'] 				= 20;				// Width of image frame (pixels).
 	$ngg_fv_options['ngg_pv_frameColor'] 				= "999999";			// Color of image frame (hexidecimal color value).
    $ngg_fv_options['ngg_pv_captionColor'] 				= "FFFFFF";			// Color of captions (hexidecimal color value).

	/*General Settings*/
    $ngg_fv_options['ngg_fv_effects'] 					= "thickbox";		//Javascript effect for all viewers. Can be "thickbox" or "highslide"
	$ngg_fv_options['ngg_fv_irBackcolor']				= "FFFFFF";			// Background color
    $ngg_fv_options['ngg_fv_enable_right_click_open'] 	= "false";			// Whether to display a 'Open In new Window...' dialog when right-clicking on an image. Can be "true" or "false"
    $ngg_fv_options['ngg_fv_langOpenImage'] 			= "Open Image in New Window";			// The text displayed for the right-click 'Open Image in New Window' menu option.
    $ngg_fv_options['ngg_fv_langAbout'] 				= "About";			// The text displayed for the right-click 'About' menu option.

	update_option('ngg_fv_options', $ngg_fv_options);
}

function nggflash_uninstall() {

		delete_option( "ngg_fv_options" );

}

?>