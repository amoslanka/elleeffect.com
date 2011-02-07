<?php
/**
 * @author Alex Rabe, Vincent Prat, adjusted by Boris Glumpler
 * @copyright 2008
 * @since 1.0.0
 * @description Use WordPress Shortcode API for more features
 * @Docs http://codex.wordpress.org/Shortcode_API
 */

class NextGENflash_shortcodes {

	// register the new shortcodes
	function NextGENflash_shortcodes() {
	
		// convert the old shortcode
		add_filter('the_content', array(&$this, 'convert_flash_shortcode'));
		
		add_shortcode( 'simpleviewer', array(&$this, 'show_simpleviewer' ) );
		add_shortcode( 'tiltviewer', array(&$this, 'show_tiltviewer' ) );
		add_shortcode( 'autoviewer', array(&$this, 'show_autoviewer') );
		add_shortcode( 'pcviewer', array(&$this, 'show_pcviewer' ) );

	}

	function convert_flash_shortcode($content) {

		$ngg_fv_options = get_option('ngg_fv_options');

		if ( stristr( $content, '[simpleviewer' )) {
			$search = "@(?:<p>)*\s*\[simpleviewer\s*=\s*(\w+|^\+)(|,(\d+)|,)(|,(\d+))(|,\*(.*?)\*)\]\s*(?:</p>)*@i";
			if (preg_match_all($search, $content, $matches, PREG_SET_ORDER)) {

				foreach ($matches as $match) {
					// remove the comma
					$match[3] = ltrim($match[3],',');
					$match[5] = ltrim($match[5],',');
					$match[7] = ltrim($match[7],',');	
					$replace = "[simpleviewer id=\"{$match[1]}\" width=\"{$match[3]}\" height=\"{$match[5]}\" link=\"{$match[7]}\"]";
					$content = str_replace ($match[0], $replace, $content);
				}
			}
		}

		if ( stristr( $content, '[tiltviewer' )) {
			$search = "@(?:<p>)*\s*\[tiltviewer\s*=\s*(\w+|^\+)(|,(\d+)|,)(|,(\d+))(|,\*(.*?)\*)*(|,\+(.*?)\+)\]\s*(?:</p>)*@i";
			if (preg_match_all($search, $content, $matches, PREG_SET_ORDER)) {

				foreach ($matches as $match) {
					// remove the comma
					$match[3] = ltrim($match[3],',');
					$match[5] = ltrim($match[5],',');
					$match[7] = ltrim($match[7],',');
					$match[9] = ltrim($match[9],',');	
					$replace = "[tiltviewer id=\"{$match[1]}\" width=\"{$match[3]}\" height=\"{$match[5]}\" link=\"{$match[7]}\" flickrtags=\"{$match[9]}\"]";
					$content = str_replace ($match[0], $replace, $content);
				}
			}
		}

		if ( stristr( $content, '[autoviewer' )) {
			$search = "@(?:<p>)*\s*\[autoviewer\s*=\s*(\w+|^\+)(|,(\d+)|,)(|,(\d+))(|,\*(.*?)\*)\]\s*(?:</p>)*@i";
			if (preg_match_all($search, $content, $matches, PREG_SET_ORDER)) {

				foreach ($matches as $match) {
					// remove the comma
					$match[3] = ltrim($match[3],',');
					$match[5] = ltrim($match[5],',');
					$match[7] = ltrim($match[7],',');	
					$replace = "[autoviewer id=\"{$match[1]}\" width=\"{$match[3]}\" height=\"{$match[5]}\" link=\"{$match[7]}\"]";
					$content = str_replace ($match[0], $replace, $content);
				}
			}
		}

		if ( stristr( $content, '[pcviewer' )) {
			$search = "@(?:<p>)*\s*\[pcviewer\s*=\s*(\w+|^\+)(|,(\d+)|,)(|,(\d+))(|,\*(.*?)\*)\]\s*(?:</p>)*@i";
			if (preg_match_all($search, $content, $matches, PREG_SET_ORDER)) {

				foreach ($matches as $match) {
					// remove the comma
					$match[3] = ltrim($match[3],',');
					$match[5] = ltrim($match[5],',');
					$match[7] = ltrim($match[7],',');	
					$replace = "[pcviewer id=\"{$match[1]}\" width=\"{$match[3]}\" height=\"{$match[5]}\" link=\"{$match[7]}\"]";
					$content = str_replace ($match[0], $replace, $content);
				}
			}
		}

		return $content;
	}

	function show_simpleviewer( $atts ) {
		
		global $wpdb;
	
		extract(shortcode_atts(array(
			'id' 		=> 0,
			'width'	 	=> '',
			'height' 	=> '',
			'link'		=> '',

		), $atts ));
		
		$galleryID = $wpdb->get_var("SELECT gid FROM $wpdb->nggallery WHERE gid = '$id' ");
		if(!$galleryID) $galleryID = $wpdb->get_var("SELECT gid FROM $wpdb->nggallery WHERE name = '$id' ");

		if( $galleryID )
			$out = nggShowSimpleViewer($galleryID, $width, $height, $link);
		else 
			$out = __('[Gallery not found]','nggallery');
			
		return $out;
	}

	function show_tiltviewer( $atts ) {
		
		global $wpdb;
	
		extract(shortcode_atts(array(
			'id' 			=> 0,
			'width'			=> '',
			'height' 		=> '',
			'link'			=> '',
			'flickrtags'	=> '',

		), $atts ));

		if($id == "flickr") 
		$galleryID = "flickr";
		else
		$galleryID = $wpdb->get_var("SELECT gid FROM $wpdb->nggallery WHERE gid = '$id' ");
		if(!$galleryID) $galleryID = $wpdb->get_var("SELECT gid FROM $wpdb->nggallery WHERE name = '$id' ");

		if( $galleryID )
			$out = nggShowTiltViewer($galleryID, $width, $height, $link, $flickrtags);
		else 
			$out = __('[Gallery not found]','nggallery');
			
		return $out;
	}

	function show_autoviewer( $atts ) {
		
		global $wpdb;
	
		extract(shortcode_atts(array(
			'id' 		=> 0,
			'width'	 	=> '',
			'height' 	=> '',
			'link'		=> ''

		), $atts ));
		
		$galleryID = $wpdb->get_var("SELECT gid FROM $wpdb->nggallery WHERE gid = '$id' ");
		if(!$galleryID) $galleryID = $wpdb->get_var("SELECT gid FROM $wpdb->nggallery WHERE name = '$id' ");

		if( $galleryID )
			$out = nggShowAutoViewer($galleryID, $width, $height, $link);
		else 
			$out = __('[Gallery not found]','nggallery');
			
		return $out;
	}

	function show_pcviewer( $atts ) {
		
		global $wpdb;
	
		extract(shortcode_atts(array(
			'id' 		=> 0,
			'width'	 	=> '',
			'height' 	=> '',
			'link'		=> ''

		), $atts ));
		
		$galleryID = $wpdb->get_var("SELECT gid FROM $wpdb->nggallery WHERE gid = '$id' ");
		if(!$galleryID) $galleryID = $wpdb->get_var("SELECT gid FROM $wpdb->nggallery WHERE name = '$id' ");

		if( $galleryID )
			$out = nggShowPcViewer($galleryID, $width, $height, $link);
		else 
			$out = __('[Gallery not found]','nggallery');
			
		return $out;
	}

}

// let's use it
$nggFlashShortcodes = new NextGENflash_shortcodes;	

?>