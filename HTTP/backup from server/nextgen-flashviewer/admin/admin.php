<?php
/**
 * nggflashAdminPanel - Admin Section for NextGEN FlashViewer
 * 
 * @package NextGEN FlashViewer
 * @author Boris Glumpler
 * @copyright 2008
 * @since 1.0.0
 */

if (!class_exists('nggflashAdminPanel')) {
	class nggflashAdminPanel{
		
		// constructor
		function nggflashAdminPanel() {
	
			// Add the admin menu
			add_action( 'plugins_loaded', array (&$this, 'checkNGGallery') );
			
			// Add the script and style files
			add_action('admin_print_scripts', array(&$this, 'load_scripts') );
			add_action('admin_print_styles', array(&$this, 'load_styles') );

			add_filter('contextual_help', array(&$this, 'show_help'), 10, 2);
		
		}
	
		// Check for NextGEN Gallery
		function checkNGGallery() {
			if (!class_exists('nggLoader') ) {
				add_action('admin_notices', create_function('', 'echo \'<div id="message" class="error fade"><p><strong>' . __('Sorry, NextGEN FlashViewer works only in combination with NextGEN Gallery.','nggflash') . '</strong></p></div>\';'));
				return;
			}
			add_action('admin_menu',array (&$this, 'add_menu'));
		}
	
		// integrate the menu	
		function add_menu()  {
			add_submenu_page( NGGFOLDER , __('FlashViewer', 'nggflash'), __('FlashViewer', 'nggflash'), 'NextGEN Change options', 'nggallery-flashviewer', array (&$this, 'show_menu'));
		}
	
		// load the script for the defined page and load only this code	
		function show_menu() {
			 // reduce footprint
			 if ($_GET["page"] == "nggallery-flashviewer") {
				include_once (dirname (__FILE__). '/settings.php');		// nggallery_admin_options
				showFlashViewerPage();
			}
		}
		
		function load_scripts() {
			if ($_GET["page"] == "nggallery-flashviewer")
				wp_enqueue_script('tabs', NGGALLERY_URLPATH .'admin/js/jquery.ui.tabs.pack.js', array('jquery'), '2.7.4');
		}		
		
		function load_styles() {
			if ($_GET["page"] == "nggallery-flashviewer") {
				wp_enqueue_style( 'nggadmin', NGGALLERY_URLPATH .'admin/css/nggadmin.css', false, '2.5.0', 'screen' );
				wp_enqueue_style( 'nggtabs', NGGALLERY_URLPATH .'admin/css/jquery.ui.tabs.css', false, '2.5.0', 'screen' );
			}
		}

		function show_help($help, $screen) {
	
			$link = '';
	
			switch ($screen) {
				case 'gallery_page_nggallery-flashviewer' :
					$link = __('<a href="http://travel-junkie.com/geeky-stuff/wp-plugin-nextgen-fashviewer/" target="_blank">Support</a>', 'nggflash');
				break;
			}
			
			if ( !empty($link) ) {
				$help  = '<h5>' . __('Get help with NextGEN FlashViewer', 'nggflash') . '</h5>';
				$help .= '<div class="metabox-prefs">';
				$help .= $link;
				$help .= "</div>\n";
				$help .= '<h5>' . __('More Help & Info', 'nggflash') . '</h5>';
				$help .= '<div class="metabox-prefs">';
				$help .= __('<a href="http://wordpress.org/extend/plugins/nextgen-flashviewer" target="_blank">Download a new version</a>', 'nggflash');
				$help .= "</div>\n";
			} 
			
			return $help;
		}

	}
}
?>