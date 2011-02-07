<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); }
/**
 * nggShowSimpleViewer()
 * 
 * @param integer $galleryID
 * @param integer $irWidth
 * @param integer $irHeight
 * @param string $link
 * @return the content
 */

function nggShowSimpleViewer($galleryID,$irWidth,$irHeight, $link = false) {
	
	global $wpdb, $nggflash;

	$ngg_options = get_option('ngg_options');

	$obj = 'so'.$galleryID;
	
	if (empty($irWidth) ) $irWidth = (int) $ngg_options['irWidth'];
	if (empty($irHeight)) $irHeight = (int) $ngg_options['irHeight'];

	if ($nggflash->options['ngg_fv_effects'] == "highslide" && !empty($link)) {
	} else {
		require_once (dirname (__FILE__).'/swfobject.php');
		// init the flash output
		$swfobject = new swfobject( NGGFLASH_SWF_PATH.'viewer.swf', $obj, $irWidth, $irHeight, '7.0.0', 'false');
		// adding the flash parameter	
		$swfobject->message = '<p>'. __('The <a href="http://www.macromedia.com/go/getflashplayer">Flash Player</a> and <a href="http://www.mozilla.com/firefox/">a browser with Javascript support</a> are needed..', 'nggallery').'</p>';
		$swfobject->add_params('wmode', 'opaque');
		$swfobject->add_params('allowFullScreen', 'true');
		$swfobject->add_params('bgcolor', '#'.$nggflash->options['ngg_fv_irBackcolor'].'');
		$swfobject->add_attributes('styleclass', 'simpleviewer');
		$swfobject->add_flashvars( 'preloaderColor', '0x'.$nggflash->options['ngg_sv_preloader_color'] );
		$swfobject->add_flashvars( 'langOpenImage', $nggflash->internationalize($nggflash->options['ngg_fv_langOpenImage']) );
		$swfobject->add_flashvars( 'langAbout', $nggflash->internationalize($nggflash->options['ngg_fv_langAbout']) );
		$swfobject->add_flashvars( 'xmlDataPath', NGGFLASHVIEWER_URLPATH.'xml/simpleviewer.php?gid='.$galleryID );
	}
	// create the output
	if (!empty($link)) {
		if ($nggflash->options['ngg_fv_effects'] == "thickbox")
				$out = '<a href="#TB_inline?height='.($irHeight+10).'&width='.$irWidth.'&inlineId=ngg_simpleviewer'.$galleryID.'" class="thickbox">'.$link.'</a>';
		if ($nggflash->options['ngg_fv_effects'] == "highslide")
				$out =  '<a href="'.NGGFLASH_SWF_PATH.'viewer.swf" onclick="return hs.htmlExpand(this, '.$obj.' )" class="highslide">'.$link.'</a>';
		if ($nggflash->options['ngg_fv_effects'] == "lightview")
				$out =  '<a href="#ngg_simpleviewer'.$galleryID.'" class="lightview" title=":: :: autosize: true">'.$link.'</a>';
		if ($nggflash->options['ngg_fv_effects'] == "shadowbox")
				$out =  '<a href="#ngg_simpleviewer'.$galleryID.'" rel="shadowbox;width='.($irWidth+1).';height='.$irHeight.'">'.$link.'</a>';
		if ($nggflash->options['ngg_fv_effects'] != "highslide") {
			$out .= "\n".'<div class="simpleviewer" id="ngg_simpleviewer'.$galleryID.'" style="display:none;">';
			$out .= $swfobject->output();
			$out .= "\n".'</div>';
		}
	} else {
		$out = "\n".'<div class="simpleviewer" id="ngg_simpleviewer'.$galleryID.'">';
		$out .= $swfobject->output();
		$out .= "\n".'</div>';
	}
	if ($nggflash->options['ngg_fv_effects'] == "highslide" && !empty($link)) {
		$out .= "\n".'<script type="text/javascript">';
		$out .= "\n\t".'var '.$obj.' = {';
		$out .= "\n\t\t".'objectType: \'swf\',';
		$out .= "\n\t\t".'objectWidth: '.$irWidth.',';
		$out .= "\n\t\t".'minWidth: '.$irWidth.',';
		$out .= "\n\t\t".'allowSizeReduction: \'false\',';
		$out .= "\n\t\t".'objectHeight: '.$irHeight.',';
		$out .= "\n\t\t".'maincontentText: \'<p>'. __('The <a href="http://www.macromedia.com/go/getflashplayer">Flash Player</a> and <a href="http://www.mozilla.com/firefox/">a browser with Javascript support</a> are needed..', 'nggallery').'</p>\',';
		$out .= "\n\t\t".'version: \'7\',';
		$out .= "\n\t\t".'swfOptions: {';
		$out .= "\n\t\t\t".'flashvars: {';
		$out .= "\n\t\t\t\t".'preloaderColor: \'0x'.$nggflash->options['ngg_sv_preloader_color'].'\',';
		$out .= "\n\t\t\t\t".'langOpenImage: \''.$nggflash->internationalize($nggflash->options['ngg_fv_langOpenImage']).'\',';
		$out .= "\n\t\t\t\t".'langAbout: \''.$nggflash->internationalize($nggflash->options['ngg_fv_langAbout']).'\',';
		$out .= "\n\t\t\t\t".'xmlDataPath: \''.NGGFLASHVIEWER_URLPATH.'xml/simpleviewer.php?gid='.$galleryID.'\'';
		$out .= "\n\t\t\t".'},';
		$out .= "\n\t\t\t".'params: {';
		$out .= "\n\t\t\t\t".'wmode: \'opaque\',';
		$out .= "\n\t\t\t\t".'allowFullScreen: \'true\',';
		$out .= "\n\t\t\t\t".'bgcolor: \'#'.$nggflash->options['ngg_fv_irBackcolor'].'\'';
		$out .= "\n\t\t\t".'}';
		$out .= "\n\t\t".'}';
		$out .= "\n\t".'};';
		$out .= "\n".'</script>';
	} else {
		// add now the script code
		$out .= "\n".'<script type="text/javascript" defer="defer">';
		if ($ngg_options['irXHTMLvalid']) $out .= "\n".'<!--';
		if ($ngg_options['irXHTMLvalid']) $out .= "\n".'//<![CDATA[';
		$out .= $swfobject->javascript();
		if ($ngg_options['irXHTMLvalid']) $out .= "\n".'//]]>';
		if ($ngg_options['irXHTMLvalid']) $out .= "\n".'-->';
		$out .= "\n".'</script>';
	}
	return $out;
}

/**
 * nggShowTiltViewer()
 * 
 * @param integer $galleryID
 * @param integer $irWidth
 * @param integer $irHeight
 * @param string $link
 * @param string $flickrtags
 * @return the content
 */

function nggShowTiltViewer($galleryID,$irWidth,$irHeight, $link = false, $flickrtags = false) {
	
	global $wpdb, $nggflash;

	$ngg_options 	= get_option('ngg_options');
	if($galleryID == "flickr") {
		$obj = 'fo';
		$flickr = "true";
	 } else {
		$obj = 'so'.$galleryID;
		$flickr = "false";
	}
	$gallerycontent = $wpdb->get_row("SELECT * FROM $wpdb->nggallery WHERE gid = '$galleryID' ");
	
	if (empty($irWidth) ) $irWidth = (int) $ngg_options['irWidth'];
	if (empty($irHeight)) $irHeight = (int) $ngg_options['irHeight'];

	if ($nggflash->options['ngg_fv_effects'] == "highslide" && !empty($link)) {
	} else {
		require_once (dirname (__FILE__).'/swfobject.php');

		// init the flash output
		$swfobject = new swfobject( NGGFLASH_SWF_PATH.'TiltViewer.swf', $obj, $irWidth, $irHeight, '7.0.0', 'false');
		
		$swfobject->message = '<p>'. __('The <a href="http://www.macromedia.com/go/getflashplayer">Flash Player</a> and <a href="http://www.mozilla.com/firefox/">a browser with Javascript support</a> are needed..', 'nggallery').'</p>';
		$swfobject->add_params('wmode', 'opaque');
		$swfobject->add_params('allowfullscreen', 'true');
		$swfobject->add_params('bgcolor', '#'.$nggflash->options['ngg_fv_irBackcolor'].'');
		$swfobject->add_attributes('styleclass', 'tiltviewer');
	
		// adding the flash parameter	
		$swfobject->add_flashvars( 'useFlickr', $flickr );
		if ($flickr == "true") {
			$swfobject->add_flashvars( 'user_id', $nggflash->options['ngg_tv_user_id'] ); 
			$swfobject->add_flashvars( 'tags', $flickrtags ); 
			$swfobject->add_flashvars( 'tag_mode', $nggflash->options['ngg_tv_tag_mode'] );
			$swfobject->add_flashvars( 'showTakenByText', $nggflash->options['ngg_tv_showTakenByText'] );
			$swfobject->add_flashvars( 'showLinkButton', $nggflash->options['ngg_tv_showLinkButton'] );
			$swfobject->add_flashvars( 'linkLabel', $nggflash->internationalize($nggflash->options['ngg_tv_linkLabel']) );
		}
		if ($flickr == "false") $swfobject->add_flashvars( 'maxJPGSize', $nggflash->options['ngg_tv_max_jpg_size'] );
		$swfobject->add_flashvars( 'useReloadButton', $nggflash->options['ngg_tv_use_reload_button'] );	
		$swfobject->add_flashvars( 'showFlipButton', $nggflash->options['ngg_tv_show_flip_button'] );
		$swfobject->add_flashvars( 'columns', $nggflash->options['ngg_tv_columns'] );
		$swfobject->add_flashvars( 'rows', $nggflash->options['ngg_tv_rows'] );
		$swfobject->add_flashvars( 'frameColor', '0x'.$nggflash->options['ngg_tv_frame_color'] );
		$swfobject->add_flashvars( 'backColor', '0x'.$nggflash->options['ngg_tv_back_color'] );
		$swfobject->add_flashvars( 'bkgndInnerColor', '0x'.$nggflash->options['ngg_tv_bkgnd_inner_color'] );
		$swfobject->add_flashvars( 'bkgndOuterColor', '0x'.$nggflash->options['ngg_tv_bkgnd_outer_color'] );
		$swfobject->add_flashvars( 'langGoFull', $nggflash->internationalize($nggflash->options['ngg_tv_lang_go_full']) );
		$swfobject->add_flashvars( 'langExitFull', $nggflash->internationalize($nggflash->options['ngg_tv_lang_exit_full']) );	
		$swfobject->add_flashvars( 'langAbout', $nggflash->internationalize($nggflash->options['ngg_fv_langAbout']) );
		if ($nggflash->options['have_pro_tv'] == "true") {
			$swfobject->add_flashvars( 'bkgndTransparent', $nggflash->options['ngg_tv_pro_bkgndTransparent'] );
			$swfobject->add_flashvars( 'showFullscreenOption', $nggflash->options['ngg_tv_pro_showFullscreenOption'] );
			$swfobject->add_flashvars( 'frameWidth', $nggflash->options['ngg_tv_pro_frameWidth'] );
			$swfobject->add_flashvars( 'zoomedInDistance', $nggflash->options['ngg_tv_pro_zoomedInDistance'] );
			$swfobject->add_flashvars( 'zoomedOutDistance', $nggflash->options['ngg_tv_pro_zoomedOutDistance'] );
			$swfobject->add_flashvars( 'fontName', $nggflash->options['ngg_tv_pro_fontName'] );
			$swfobject->add_flashvars( 'titleFontSize', $nggflash->options['ngg_tv_pro_titleFontSize'] );
			$swfobject->add_flashvars( 'descriptionFontSize', $nggflash->options['ngg_tv_pro_descriptionFontSize'] );
			$swfobject->add_flashvars( 'navButtonColor', '0x'.$nggflash->options['ngg_tv_pro_navButtonColor'] );
			$swfobject->add_flashvars( 'flipButtonColor', '0x'.$nggflash->options['ngg_tv_pro_flipButtonColor'] );
			$swfobject->add_flashvars( 'textColor', '0x'.$nggflash->options['ngg_tv_pro_textColor'] );
			if ($flickr == "true") {
				$swfobject->add_flashvars( 'linkTextColor', '0x'.$nggflash->options['ngg_tv_pro_linkTextColor'] );
				$swfobject->add_flashvars( 'linkBkgndColor', '0x'.$nggflash->options['ngg_tv_pro_linkBkgndColor'] );
				$swfobject->add_flashvars( 'linkFontSize', $nggflash->options['ngg_tv_pro_linkFontSize'] );
				$swfobject->add_flashvars( 'linkTarget', $nggflash->options['ngg_tv_pro_linkTarget'] );
			}
		}
		if ($flickr == "false") $swfobject->add_flashvars( 'xmlURL', NGGFLASHVIEWER_URLPATH.'xml/tiltviewer.php?gid='.$galleryID);
	}
	// create the output
	if (!empty($link)) {
		if ($nggflash->options['ngg_fv_effects'] == "thickbox")
				$out = '<a href="#TB_inline?height='.($irHeight+10).'&width='.$irWidth.'&inlineId=ngg_tiltviewer'.$galleryID.'" title="'.$nggflash->internationalize($gallerycontent->title).'" class="thickbox">'.$link.'</a>';
		if ($nggflash->options['ngg_fv_effects'] == "highslide")
				$out =  '<a href="'.NGGFLASH_SWF_PATH.'TiltViewer.swf" onclick="return hs.htmlExpand(this, '.$obj.')" class="highslide">'.$link.'</a>';
		if ($nggflash->options['ngg_fv_effects'] == "lightview")
				$out =  '<a href="#ngg_tiltviewer'.$galleryID.'" class="lightview" title="'.$nggflash->internationalize($gallerycontent->title).':: :: autosize: true">'.$link.'</a>';
		if ($nggflash->options['ngg_fv_effects'] == "shadowbox")
				$out =  '<a href="#ngg_tiltviewer'.$galleryID.'" title="'.$nggflash->internationalize($gallerycontent->title).'" rel="shadowbox;width='.($irWidth+1).';height='.$irHeight.'">'.$link.'</a>';
		if ($nggflash->options['ngg_fv_effects'] != "highslide") {
			$out .= "\n".'<div class="tiltviewer" id="ngg_tiltviewer'.$galleryID.'" style="display: none;">';
			$out .= $swfobject->output();
			$out .= "\n".'</div>';
		}
	} else {
		$out = "\n".'<div class="tiltviewer" id="ngg_tiltviewer'.$galleryID.'">';
		$out .= $swfobject->output();
		$out .= "\n".'</div>';
	}
	if ($nggflash->options['ngg_fv_effects'] == "highslide" && !empty($link)) {
		$out .= "\n".'<script type="text/javascript">';
		$out .= "\n\t".'var '.$obj.' = {';
		$out .= "\n\t\t".'objectType: \'swf\',';
		$out .= "\n\t\t".'objectWidth: '.$irWidth.',';
		$out .= "\n\t\t".'minWidth: '.$irWidth.',';
		$out .= "\n\t\t".'allowSizeReduction: \'false\',';
		$out .= "\n\t\t".'objectHeight: '.$irHeight.',';
		$out .= "\n\t\t".'maincontentText: \'<p>'. __('The <a href="http://www.macromedia.com/go/getflashplayer">Flash Player</a> and <a href="http://www.mozilla.com/firefox/">a browser with Javascript support</a> are needed..', 'nggallery').'</p>\',';
		$out .= "\n\t\t".'version: \'7\',';
		$out .= "\n\t\t".'swfOptions: {';
		$out .= "\n\t\t\t".'flashvars: {';
		$out .= "\n\t\t\t\t".'useFlickr: \''.$flickr.'\',';
		if ($flickr == "true") {
			$out .= "\n\t\t\t\t".'user_id: \''.$nggflash->options['ngg_tv_user_id'].'\',';
			$out .= "\n\t\t\t\t".'tags: \''.$flickrtags.'\',';
			$out .= "\n\t\t\t\t".'tag_mode: \''.$nggflash->options['ngg_tv_tag_mode'].'\',';
			$out .= "\n\t\t\t\t".'showTakenByText: \''.$nggflash->options['ngg_tv_showTakenByText'].'\',';
			$out .= "\n\t\t\t\t".'showLinkButton: \''.$nggflash->options['ngg_tv_showLinkButton'].'\',';
			$out .= "\n\t\t\t\t".'linkLabel: \''.$nggflash->internationalize($nggflash->options['ngg_tv_linkLabel']).'\',';
		}
		if ($flickr == "false") $out .= "\n\t\t\t\t".'maxJPGSize: \''.$nggflash->options['ngg_tv_max_jpg_size'].'\',';
		$out .= "\n\t\t\t\t".'useReloadButton: \''.$nggflash->options['ngg_tv_use_reload_button'].'\',';
		$out .= "\n\t\t\t\t".'showFlipButton: \''.$nggflash->options['ngg_tv_show_flip_button'].'\',';
		$out .= "\n\t\t\t\t".'columns: \''.$nggflash->options['ngg_tv_columns'].'\',';
		$out .= "\n\t\t\t\t".'rows: \''.$nggflash->options['ngg_tv_rows'].'\',';
		$out .= "\n\t\t\t\t".'frameColor: \'0x'.$nggflash->options['ngg_tv_frame_color'].'\',';
		$out .= "\n\t\t\t\t".'backColor: \'0x'.$nggflash->options['ngg_tv_back_color'].'\',';
		$out .= "\n\t\t\t\t".'bkgndInnerColor: \'0x'.$nggflash->options['ngg_tv_bkgnd_inner_color'].'\',';
		$out .= "\n\t\t\t\t".'bkgndOuterColor: \'0x'.$nggflash->options['ngg_tv_bkgnd_outer_color'].'\',';
		$out .= "\n\t\t\t\t".'langGoFull: \''.$nggflash->internationalize($nggflash->options['ngg_tv_lang_go_full']).'\',';
		$out .= "\n\t\t\t\t".'langExitFull: \''.$nggflash->internationalize($nggflash->options['ngg_tv_lang_exit_full']).'\',';
		$out .= "\n\t\t\t\t".'langAbout: \''.$nggflash->internationalize($nggflash->options['ngg_fv_langAbout']).'\',';
		if ($nggflash->options['have_pro_tv'] == "true") {
			$out .= "\n\t\t\t\t".'bkgndTransparent: \''.$nggflash->options['ngg_tv_pro_bkgndTransparent'].'\',';
			$out .= "\n\t\t\t\t".'showFullscreenOption: \''.$nggflash->options['ngg_tv_pro_showFullscreenOption'].'\',';
			$out .= "\n\t\t\t\t".'frameWidth: \''.$nggflash->options['ngg_tv_pro_frameWidth'].'\',';
			$out .= "\n\t\t\t\t".'zoomedInDistance: \''.$nggflash->options['ngg_tv_pro_zoomedInDistance'].'\',';
			$out .= "\n\t\t\t\t".'zoomedOutDistance: \''.$nggflash->options['ngg_tv_pro_zoomedOutDistance'].'\',';
			$out .= "\n\t\t\t\t".'fontName: \''.$nggflash->options['ngg_tv_pro_fontName'].'\',';
			$out .= "\n\t\t\t\t".'titleFontSize: \''.$nggflash->options['ngg_tv_pro_titleFontSize'].'\',';
			$out .= "\n\t\t\t\t".'descriptionFontSize: \''.$nggflash->options['ngg_tv_pro_descriptionFontSize'].'\',';
			$out .= "\n\t\t\t\t".'navButtonColor: \'0x'.$nggflash->options['ngg_tv_pro_navButtonColor'].'\',';
			$out .= "\n\t\t\t\t".'flipButtonColor: \'0x'.$nggflash->options['ngg_tv_pro_flipButtonColor'].'\',';
			$out .= "\n\t\t\t\t".'textColor: \''.$nggflash->options['ngg_tv_pro_textColor'].'\',';
			if ($flickr == "true") {
				$out .= "\n\t\t\t\t".'linkTextColor: \'0x'.$nggflash->options['ngg_tv_pro_linkTextColor'].'\',';
				$out .= "\n\t\t\t\t".'linkBkgndColor: \'0x'.$nggflash->options['ngg_tv_pro_linkBkgndColor'].'\',';
				$out .= "\n\t\t\t\t".'linkFontSize: \''.$nggflash->options['ngg_tv_pro_linkFontSize'].'\',';
				$out .= "\n\t\t\t\t".'linkTarget: \''.$nggflash->options['ngg_tv_pro_linkTarget'].'\',';
			}
		}
		if ($flickr == "false") $out .= "\n\t\t\t\t".'xmlURL: \''.NGGFLASHVIEWER_URLPATH.'xml/tiltviewer.php?gid='.$galleryID.'\'';
		$out .= "\n\t\t\t".'},';
		$out .= "\n\t\t\t".'params: {';
		$out .= "\n\t\t\t\t".'wmode: \'opaque\',';
		$out .= "\n\t\t\t\t".'allowFullScreen: \'true\',';
		$out .= "\n\t\t\t\t".'bgcolor: \'#'.$nggflash->options['ngg_fv_irBackcolor'].'\'';
		$out .= "\n\t\t\t".'}';
		$out .= "\n\t\t".'}';
		$out .= "\n\t".'};';
		$out .= "\n".'</script>';
	} else {
		// add now the script code
		$out .= "\n".'<script type="text/javascript" defer="defer">';
		if ($ngg_options['irXHTMLvalid']) $out .= "\n".'<!--';
		if ($ngg_options['irXHTMLvalid']) $out .= "\n".'//<![CDATA[';
		$out .= $swfobject->javascript();
		if ($ngg_options['irXHTMLvalid']) $out .= "\n".'//]]>';
		if ($ngg_options['irXHTMLvalid']) $out .= "\n".'-->';
		$out .= "\n".'</script>';
	}
	return $out;
}

/**
 * nggShowAutoViewer()
 * 
 * @param integer $galleryID
 * @param integer $irWidth
 * @param integer $irHeight
 * @param string $link
 * @return the content
 */

function nggShowAutoViewer($galleryID,$irWidth,$irHeight, $link = false) {
	
	global $wpdb, $nggflash;

	$ngg_options 	= get_option('ngg_options');
	$gallerycontent = $wpdb->get_row("SELECT * FROM $wpdb->nggallery WHERE gid = '$galleryID' ");

	$obj = 'fo'.$galleryID;
	
	if (empty($irWidth) ) $irWidth = (int) $ngg_options['irWidth'];
	if (empty($irHeight)) $irHeight = (int) $ngg_options['irHeight'];

	if ($nggflash->options['ngg_fv_effects'] == "highslide" && !empty($link)) {
	} else {
		require_once (dirname (__FILE__).'/swfobject.php');

		// init the flash output
		$swfobject = new swfobject( NGGFLASH_SWF_PATH.'autoviewer.swf', $obj, $irWidth, $irHeight, '7.0.0', 'false');
		
		$swfobject->message = '<p>'. __('The <a href="http://www.macromedia.com/go/getflashplayer">Flash Player</a> and <a href="http://www.mozilla.com/firefox/">a browser with Javascript support</a> are needed..', 'nggallery').'</p>';
		$swfobject->add_params('wmode', 'opaque');
		$swfobject->add_params('allowfullscreen', 'true');
		$swfobject->add_params('bgcolor', '#'.$nggflash->options['ngg_fv_irBackcolor'].'');
		$swfobject->add_attributes('styleclass', 'autoviewer');
	
		// adding the flash parameter
		$swfobject->add_flashvars( 'langOpenImage', $nggflash->internationalize($nggflash->options['ngg_fv_langOpenImage']) );
		$swfobject->add_flashvars( 'langAbout', $nggflash->internationalize($nggflash->options['ngg_fv_langAbout']) );
		$swfobject->add_flashvars( 'xmlURL', NGGFLASHVIEWER_URLPATH.'xml/autoviewer.php?gid='.$galleryID );
	}
	// create the output
	if (!empty($link)) {
		if ($nggflash->options['ngg_fv_effects'] == "thickbox")
				$out = '<a href="#TB_inline?height='.($irHeight+10).'&width='.$irWidth.'&inlineId=ngg_autoviewer'.$galleryID.'" title="'.$nggflash->internationalize($gallerycontent->title).'" class="thickbox">'.$link.'</a>';
		if ($nggflash->options['ngg_fv_effects'] == "highslide")
				$out =  '<a href="'.NGGFLASH_SWF_PATH.'autoviewer.swf" onclick="return hs.htmlExpand(this, '.$obj.' )" class="highslide">'.$link.'</a>';
		if ($nggflash->options['ngg_fv_effects'] == "lightview")
				$out =  '<a href="#ngg_autoviewer'.$galleryID.'" class="lightview" title="'.$nggflash->internationalize($gallerycontent->title).':: :: autosize: true">'.$link.'</a>';
		if ($nggflash->options['ngg_fv_effects'] == "shadowbox")
				$out =  '<a href="#ngg_autoviewer'.$galleryID.'" title="'.$nggflash->internationalize($gallerycontent->title).'" rel="shadowbox;width='.($irWidth+1).';height='.$irHeight.'">'.$link.'</a>';
		if ($nggflash->options['ngg_fv_effects'] != "highslide") {	
			$out .= "\n".'<div class="autoviewer" id="ngg_autoviewer'.$galleryID.'" style="display: none;">';
			$out .= $swfobject->output();
			$out .= "\n".'</div>';
		}
	} else {
		$out = "\n".'<div class="autoviewer" id="ngg_autoviewer'.$galleryID.'">';
		$out .= $swfobject->output();
		$out .= "\n".'</div>';
	}

	if ($nggflash->options['ngg_fv_effects'] == "highslide" && !empty($link)) {
		$out .= "\n".'<script type="text/javascript">';
		$out .= "\n\t".'var '.$obj.' = {';
		$out .= "\n\t\t".'objectType: \'swf\',';
		$out .= "\n\t\t".'objectWidth: '.$irWidth.',';
		$out .= "\n\t\t".'minWidth: '.$irWidth.',';
		$out .= "\n\t\t".'allowSizeReduction: \'false\',';
		$out .= "\n\t\t".'objectHeight: '.$irHeight.',';
		$out .= "\n\t\t".'maincontentText: \'<p>'. __('The <a href="http://www.macromedia.com/go/getflashplayer">Flash Player</a> and <a href="http://www.mozilla.com/firefox/">a browser with Javascript support</a> are needed..', 'nggallery').'</p>\',';
		$out .= "\n\t\t".'version: \'7\',';
		$out .= "\n\t\t".'swfOptions: {';
		$out .= "\n\t\t\t".'flashvars: {';
		$out .= "\n\t\t\t\t".'langOpenImage: \''.$nggflash->internationalize($nggflash->options['ngg_fv_langOpenImage']).'\',';
		$out .= "\n\t\t\t\t".'langAbout: \''.$nggflash->internationalize($nggflash->options['ngg_fv_langAbout']).'\',';
		$out .= "\n\t\t\t\t".'xmlURL: \''.NGGFLASHVIEWER_URLPATH.'xml/autoviewer.php?gid='.$galleryID.'\'';
		$out .= "\n\t\t\t".'},';
		$out .= "\n\t\t\t".'params: {';
		$out .= "\n\t\t\t\t".'wmode: \'opaque\',';
		$out .= "\n\t\t\t\t".'allowFullScreen: \'true\',';
		$out .= "\n\t\t\t\t".'bgcolor: \'#'.$nggflash->options['ngg_fv_irBackcolor'].'\'';
		$out .= "\n\t\t\t".'}';
		$out .= "\n\t\t".'}';
		$out .= "\n\t".'};';
		$out .= "\n".'</script>';
	} else {
		// add now the script code
		$out .= "\n".'<script type="text/javascript" defer="defer">';
		if ($ngg_options['irXHTMLvalid']) $out .= "\n".'<!--';
		if ($ngg_options['irXHTMLvalid']) $out .= "\n".'//<![CDATA[';
		$out .= $swfobject->javascript();
		if ($ngg_options['irXHTMLvalid']) $out .= "\n".'//]]>';
		if ($ngg_options['irXHTMLvalid']) $out .= "\n".'-->';
		$out .= "\n".'</script>';
	}
	return $out;
}

/**
 * nggShowPcViewer()
 * 
 * @param integer $galleryID
 * @param integer $irWidth
 * @param integer $irHeight
 * @param string $link
 * @return the content
 */

function nggShowPcViewer($galleryID,$irWidth,$irHeight, $link = false) {
	
	global $wpdb, $nggflash;

	$ngg_options 	= get_option('ngg_options');
	$gallerycontent = $wpdb->get_row("SELECT * FROM $wpdb->nggallery WHERE gid = '$galleryID' ");

	$obj = 'fo'.$galleryID;
	
	if (empty($irWidth) ) $irWidth = (int) $ngg_options['irWidth'];
	if (empty($irHeight)) $irHeight = (int) $ngg_options['irHeight'];

	if ($nggflash->options['ngg_fv_effects'] == "highslide" && !empty($link)) {
	} else {
		require_once (dirname (__FILE__).'/swfobject.php');

		// init the flash output
		$swfobject = new swfobject( NGGFLASH_SWF_PATH.'pcviewer.swf', $obj, $irWidth, $irHeight, '7.0.0', 'false');
		
		$swfobject->message = '<p>'. __('The <a href="http://www.macromedia.com/go/getflashplayer">Flash Player</a> and <a href="http://www.mozilla.com/firefox/">a browser with Javascript support</a> are needed..', 'nggallery').'</p>';
		$swfobject->add_params('wmode', 'opaque');
		$swfobject->add_params('allowfullscreen', 'true');
		$swfobject->add_params('bgcolor', '#'.$nggflash->options['ngg_fv_irBackcolor'].'');
		$swfobject->add_attributes('styleclass', 'pcviewer');
	
		// adding the flash parameter
		$swfobject->add_flashvars( 'langOpenImage', $nggflash->internationalize($nggflash->options['ngg_fv_langOpenImage']) );
		$swfobject->add_flashvars( 'langAbout', $nggflash->internationalize($nggflash->options['ngg_fv_langAbout']) );
		$swfobject->add_flashvars( 'xmlURL', NGGFLASHVIEWER_URLPATH.'xml/postcardviewer.php?gid='.$galleryID );
	}
	// create the output
	if (!empty($link)) {
		if ($nggflash->options['ngg_fv_effects'] == "thickbox")
				$out = '<a href="#TB_inline?height='.($irHeight+10).'&width='.$irWidth.'&inlineId=ngg_pcviewer'.$galleryID.'" title="'.$nggflash->internationalize($gallerycontent->title).'" class="thickbox">'.$link.'</a>';
		if ($nggflash->options['ngg_fv_effects'] == "highslide")
				$out =  '<a href="'.NGGFLASH_SWF_PATH.'pcviewer.swf" onclick="return hs.htmlExpand(this, '.$obj.' )" class="highslide">'.$link.'</a>';
		if ($nggflash->options['ngg_fv_effects'] == "lightview")
				$out =  '<a href="#ngg_pcviewer'.$galleryID.'" class="lightview" title="'.$nggflash->internationalize($gallerycontent->title).':: :: autosize: true">'.$link.'</a>';
		if ($nggflash->options['ngg_fv_effects'] == "shadowbox")
				$out =  '<a href="#ngg_pcviewer'.$galleryID.'" title="'.$nggflash->internationalize($gallerycontent->title).'" rel="shadowbox;width='.($irWidth+1).';height='.$irHeight.'">'.$link.'</a>';
		if ($nggflash->options['ngg_fv_effects'] != "highslide") {
			$out .= "\n".'<div class="pcviewer" id="ngg_pcviewer'.$galleryID.'" style="display: none;">';
			$out .= $swfobject->output();
			$out .= "\n".'</div>';
		}
	} else {
		$out = "\n".'<div class="pcviewer" id="ngg_pcviewer'.$galleryID.'">';
		$out .= $swfobject->output();
		$out .= "\n".'</div>';
	}
	if ($nggflash->options['ngg_fv_effects'] == "highslide" && !empty($link)) {
		$out .= "\n".'<script type="text/javascript">';
		$out .= "\n\t".'var '.$obj.' = {';
		$out .= "\n\t\t".'objectType: \'swf\',';
		$out .= "\n\t\t".'objectWidth: '.$irWidth.',';
		$out .= "\n\t\t".'minWidth: '.$irWidth.',';
		$out .= "\n\t\t".'allowSizeReduction: \'false\',';
		$out .= "\n\t\t".'objectHeight: '.$irHeight.',';
		$out .= "\n\t\t".'maincontentText: \'<p>'. __('The <a href="http://www.macromedia.com/go/getflashplayer">Flash Player</a> and <a href="http://www.mozilla.com/firefox/">a browser with Javascript support</a> are needed..', 'nggallery').'</p>\',';
		$out .= "\n\t\t".'version: \'7\',';
		$out .= "\n\t\t".'swfOptions: {';
		$out .= "\n\t\t\t".'flashvars: {';
		$out .= "\n\t\t\t\t".'langOpenImage: \''.$nggflash->internationalize($nggflash->options['ngg_fv_langOpenImage']).'\',';
		$out .= "\n\t\t\t\t".'langAbout: \''.$nggflash->internationalize($nggflash->options['ngg_fv_langAbout']).'\',';
		$out .= "\n\t\t\t\t".'xmlURL: \''.NGGFLASHVIEWER_URLPATH.'xml/postcardviewer.php?gid='.$galleryID.'\'';
		$out .= "\n\t\t\t".'},';
		$out .= "\n\t\t\t".'params: {';
		$out .= "\n\t\t\t\t".'wmode: \'opaque\',';
		$out .= "\n\t\t\t\t".'allowFullScreen: \'true\',';
		$out .= "\n\t\t\t\t".'bgcolor: \'#'.$nggflash->options['ngg_fv_irBackcolor'].'\'';
		$out .= "\n\t\t\t".'}';
		$out .= "\n\t\t".'}';
		$out .= "\n\t".'};';
		$out .= "\n".'</script>';
	} else {
		// add now the script code
		$out .= "\n".'<script type="text/javascript" defer="defer">';
		if ($ngg_options['irXHTMLvalid']) $out .= "\n".'<!--';
		if ($ngg_options['irXHTMLvalid']) $out .= "\n".'//<![CDATA[';
		$out .= $swfobject->javascript();
		if ($ngg_options['irXHTMLvalid']) $out .= "\n".'//]]>';
		if ($ngg_options['irXHTMLvalid']) $out .= "\n".'-->';
		$out .= "\n".'</script>';
	}
	return $out;
}
?>