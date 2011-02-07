<?php
/*
Plugin Name: NextGEN FlashViewer
Plugin URI: http://shabushabu-webdesign.com/wp-plugin-nextgen-flashviewer/
Description: The famous Adobe Flash Plugins (SimpleViewer, TiltViewer, AutoViewer, PostcardViewer) from <a href="http://www.airtightinteractive.com/">Airtight Interactive</a> for NextGEN Gallery. Go to <a href="admin.php?page=nggallery-flashviewer">Gallery->FlashViewer</a> to change the options.
Author: ShabuShabu Webdesign
Author URI: http://shabushabu-webdesign.com/
Version: 1.3

Copyright 2008 by ShabuShabu Webdesign & Alex Rabe & Airtight Interactive

This script is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

SimpleViewer/TiltViewer/Autoviewer may be used in any kinds of personal and/or commercial projects. 
Please ensure that the SimpleViewer/TiltViewer/AutoViewer/PostcardViewer download link in the bottom
right corner is clearly visible. SimpleViewer/TiltViewer may not be redistributed or resold to other
companies or third parties. Specifically, SimpleViewer/TiltViewer/Autoviewer/PostcardViewer may not
be redistributed as part of a content management system or online hosting solution.

See more at http://www.airtightinteractive.com/ 
****************************************************************************
***************************************************************************/

// Stop direct call
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die(__('You are not allowed to call this page directly.', 'nggflash')); }

if (!class_exists('nggflash')) {
	class nggflash {
		
		function nggflash() {
	
			// Get some constants first
			$this->define_constants();
			$this->load_options();
			$this->load_dependencies();
					
			// Init options & tables during activation & deregister init option
			register_activation_hook( dirname(__FILE__) . '/nggflashviewer.php', array(&$this, 'activate') );

			if ( function_exists('register_uninstall_hook') )
				register_uninstall_hook( dirname(__FILE__) . '/admin/install.php', 'nggflash_uninstall' );

			// make it multilingual
			add_action('init', array(&$this, 'load_textdomain') );

			// load scripts into the head
			add_action('wp_print_scripts', array(&$this, 'load_scripts') );
		}
	
		function define_constants() {
			// Pre-2.6 compatibility
			if ( !defined('WP_CONTENT_URL') )
				define( 'WP_CONTENT_URL', get_option('siteurl') . '/wp-content');
			// define URL
			define('NGGFLASHVIEWER_URLPATH', WP_CONTENT_URL.'/plugins/'.plugin_basename( dirname(__FILE__)).'/' );
			define('NGGFLASH_SWF_PATH', WP_PLUGIN_URL.'/nggflash-swf/');			
			// look for viewers
			define('SIMPLEVIEWER_EXIST', file_exists (dirname(dirname(__FILE__)).'/nggflash-swf/viewer.swf'));
			define('TILTVIEWER_EXIST', file_exists (dirname(dirname(__FILE__)).'/nggflash-swf/TiltViewer.swf'));
			define('AUTOVIEWER_EXIST', file_exists (dirname(dirname(__FILE__)).'/nggflash-swf/autoviewer.swf'));
			define('PCVIEWER_EXIST', file_exists (dirname(dirname(__FILE__)).'/nggflash-swf/pcviewer.swf'));
		}
		
		function load_dependencies() {
			if ( is_admin() ) {	
				require_once (dirname (__FILE__) . '/admin/admin.php');
				$this->nggflashAdminPanel = new nggflashAdminPanel();
			} else {
				require_once (dirname (__FILE__).'/lib/shortcodes.php');
				require_once (dirname (__FILE__).'/lib/functions.php');
			}			
		}
		
		function load_textdomain() {
			if (function_exists('load_plugin_textdomain')) {
				load_plugin_textdomain('nggflash','wp-content/plugins/'.dirname(plugin_basename(__FILE__)).'/langs');
			}
		}

		function load_options() {
			// Load the options
			$this->options = get_option('ngg_fv_options');
		}

		function activate() {
			include_once (dirname (__FILE__) . '/admin/install.php');
			ngg_fv_default_options();
		}

		function load_scripts() {
			wp_enqueue_script('swfobject', NGGFLASHVIEWER_URLPATH .'js/swfobject.js', false, '2.1');
		}

		function internationalize($in) {
			if ( function_exists( 'langswitch_filter_langs_with_message' ) ) {
				$in = langswitch_filter_langs_with_message($in);
			}
			if ( function_exists( 'polyglot_filter' )) {
				$in = polyglot_filter($in);
			}
			if ( function_exists( 'qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage' )) {
				$in = qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage($in);
			}
			$in = apply_filters( 'localization', $in );
			return $in;
		}

	}
	// Let's get the show on the road
	global $nggflash;
	$nggflash = new nggflash();
}
?>