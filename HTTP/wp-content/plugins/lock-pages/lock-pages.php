<?php
/*
Plugin Name: Lock Pages
Plugin URI: http://wordpress.org/extend/plugins/lock-pages/
Description: Allows admins to lock page slugs and parent page setting in order to prevent breakage of important URLs.
Author: Steve Taylor
Version: 0.1.6
Author URI: http://sltaylor.co.uk
Based on: http://pressography.com/plugins/wordpress-plugin-template/
*/

/*  Copyright 2009

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/**
* Guess the wp-content and plugin urls/paths
*/
// Pre-2.6 compatibility
if ( ! defined( 'WP_CONTENT_URL' ) )
	define( 'WP_CONTENT_URL', get_option( 'siteurl' ) . '/wp-content' );
if ( ! defined( 'WP_CONTENT_DIR' ) )
	define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' );
if ( ! defined( 'WP_PLUGIN_URL' ) )
	define( 'WP_PLUGIN_URL', WP_CONTENT_URL. '/plugins' );
if ( ! defined( 'WP_PLUGIN_DIR' ) )
	define( 'WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins' );


if ( !class_exists('SLT_LockPages') ) {

	class SLT_LockPages {

		/**
		* @var	string	$prefix	The prefix for any form fields etc.
		* Note that this has had to be hard-coded into lock-pages.js
		*/
		var $prefix = 'slt_lockpages_';
		/**
		* @var	string	$optionsName	The options string name for this plugin
		*/
		var $optionsName = 'SLT_LockPages_options';
		/**
		* @var	string	$localizationDomain	Domain used for localization
		*/
		var $localizationDomain = "SLT_LockPages";
		/**
		* @var	string	$pluginurl	The path to this plugin
		*/
		var $thispluginurl = '';
		/**
		* @var	string	$pluginurlpath	The path to this plugin
		*/
		var $thispluginpath = '';
		/**
		* @var	array		$options	Stores the options for this plugin
		*/
		var $options = array();

		/**
		* PHP 4 Compatible Constructor
		*/
		function SLT_LockPages() { $this->__construct(); }

		/**
		* PHP 5 Constructor
		*/
		function __construct() {

			// Language Setup
			$locale = get_locale();
			$mo = dirname(__FILE__) . "/languages/" . $this->localizationDomain . "-".$locale.".mo";
			load_textdomain($this->localizationDomain, $mo);

			// "Constants" setup
			$this->thispluginurl = PLUGIN_URL . '/' . dirname(plugin_basename(__FILE__)).'/';
			$this->thispluginpath = PLUGIN_PATH . '/' . dirname(plugin_basename(__FILE__)).'/';

			// Initialize the options
			// This is REQUIRED to initialize the options when the plugin is loaded!
			$this->getOptions();

			// Actions
			add_action( 'admin_menu', array( &$this, 'admin_menu_link' ) );
			add_action( 'edit_page_form', array( &$this, 'oldValueFields' ) );
			add_action( 'admin_notices', array( &$this, 'outputPageLockedNotice' ) );

			// We only need the meta box on the edit screen if scope isn't set to lock all pages
			if ( $this->options[$this->prefix.'scope'] != "all" ) {
				add_action( 'admin_menu', array( &$this, 'createMetaBox' ) );
				//add_action( 'quick_edit_custom_box', array( &$this, 'outputQuickEdit' ), 1, 2 );
				add_action( 'save_post', array( &$this, 'saveMeta' ), 1, 2 );
			}

			// Filters
			add_filter( 'name_save_pre', array( &$this, 'lockSlug' ), 0 );
			add_filter( 'parent_save_pre', array( &$this, 'lockParent' ), 0 );
			add_filter( 'user_has_cap', array( &$this, 'lockDeletion' ), 0, 3 );
			add_filter( 'page_row_actions', array( &$this, 'removeQuickEdit' ), 10, 2 );

			// Page list management
			add_filter( 'manage_pages_columns', array( &$this, 'pagesListCol' ) );
			add_action( 'manage_pages_custom_column', array( &$this, 'pagesListColValue' ), 10, 2 );
			add_filter( 'admin_head', array( &$this, 'adminHeader' ) );
			//add_filter( 'admin_footer', array( &$this, 'adminFooter' ) );

		}

		/**
		* Remove Quick Edit link from locked pages.
		*
		* @since		0.1.5
		* @param		array		$cols		The columns
		* @return	array
		*/
		function removeQuickEdit( $actions, $page ) {
			if ( array_key_exists( "inline", $actions ) && !$this->userCanEdit( $page->ID ) )
				unset ( $actions["inline"] );
			return $actions;	
		}

		/**
		* Add lock column to admin pages list.
		*
		* @since		0.1.2
		* @param		array		$cols		The columns
		* @return	array
		*/
		function pagesListCol( $cols ) {
			$cols["page-locked"] = "Lock";
			return $cols;
		}

		/**
		* Add lock indicator to admin pages list.
		*
		* @since		0.1.2
		* @param		string		$column_name		The column name
		* @param		int			$id					Page ID
		*/
		function pagesListColValue( $column_name, $id ) {
			if ( $column_name == "page-locked" ) {
				if ( $this->isPageLocked( $id ) ) {
					echo '<img src="' . WP_PLUGIN_URL . '/lock-pages/lock.png" width="16" height="16" alt="Locked" />';
				} else {
					echo '&nbsp;';
				}
			}
		}

		/**
		* Extra stuff for admin header
		*
		* @since		0.1.5
		*/
		function adminHeader() {
			echo '<link rel="stylesheet" type="text/css" href="' . WP_PLUGIN_URL . '/lock-pages/lock-pages.css" />';
		}

		/**
		* Extra stuff for admin footer
		*
		* @since		0.1.5
		*/
		function adminFooter() {
			/*echo '<script type="text/javascript" src="' . WP_PLUGIN_URL . '/lock-pages/lock-pages.js"></script>';*/
		}

		/**
		* Prevents unauthorized users saving a new slug.
		*
		* @since		0.1
		* @return	string
		*/
		function lockSlug( $slug ) {
			// Can user edit this page?
			if ( $this->userCanEdit( $_POST['post_ID'] ) ) {
				return $slug;
			} else {
				// Keep old slug, user can't change it
				return $_POST[$this->prefix.'old_slug'];
			}
		}

		/**
		* Prevents unauthorized users saving a new parent.
		*
		* @since		0.1
		* @return	string
		*/
		function lockParent( $parent ) {
			// Make sure this isn't an uploaded attachment
			if ( !isset( $_POST["attachments"] ) && !isset( $_POST["html-upload"] ) ) {
				// Can user edit this page?
				if ( $this->userCanEdit( $_POST['post_ID'] ) ) {
					return $parent;
				} else {
					// Keep old parent, user can't change it
					return $_POST[$this->prefix.'old_parent'];
				}
			} else {
				return $parent;
			}
		}

		/**
		* Prevents unauthorized users deleting a locked page.
		*
		* @since		0.1.1
		* @param		array		$allcaps		Capabilities granted to user
		* @param		array		$caps			Capabilities being checked
		* @param		array		$args			Optional arguments being passed
		* @return	array
		*/
		function lockDeletion( $allcaps, $caps, $args ) {
			$capCheck = $args[0];
			$userID = $args[1];
			$postID = $args[2];
			// Is the check for deleting a page?
			if ( $capCheck == "delete_page" && $postID ) {
				// Basic check for "edit locked page" capability
				$userCan = $allcaps[ $this->options[$this->prefix.'capability'] ];
				// Override it if page isn't locked and scope isn't all pages
				if ( $this->options[$this->prefix.'scope'] != "all" && !$this->isPageLocked( $postID ) )
					$userCan = true;
				// If user isn't able to touch this page, remove delete capabilities
				if ( !$userCan ) {
					foreach( $allcaps as $cap => $value ) {
						if ( strpos( $cap, "delete" )!==false && strpos( $cap, "pages" )!==false ) {
							unset( $allcaps[$cap] );
						}
					}
				}
			}
			return $allcaps;
		}

		/**
		* Stores old values for locked fields in hidden fields on the page edit form.
		*
		* @since		0.1
		* @global	WP_Query		$post
		*/
		function oldValueFields() {
			global $post;
			echo '<input type="hidden" name="' . $this->prefix . 'old_slug" value="' . $post->post_name . '" />';
			echo '<input type="hidden" name="' . $this->prefix . 'old_parent" value="' . $post->post_parent . '" />';
		}

		/**
		* Outputs warning to users who won't be able to change page elements when editing.
		*
		* @since		0.1
		*/
		function outputPageLockedNotice() {
			if ( basename( $_SERVER["SCRIPT_NAME"] ) == "page.php" &&
				$_GET["action"] == "edit" &&
				!$this->userCanEdit( $_GET["post"] ) )
				echo '<div class="updated"><p>' . __( 'Please note that this page is currently locked, and you won\'t be able to change the slug or parent.', $this->localizationDomain ) . '</p></div>';
		}


		/**
 		* Adds the meta box to the page edit screen if the current scope isn't to lock all pages.
 		* Only outputs box for users who have the capability to edit locked pages.
 		*
 		* @since		0.1
 		* @uses		add_meta_box() Creates an additional meta box.
 		*/
		function createMetaBox() {
			if ( current_user_can( $this->options[$this->prefix.'capability'] ) ) {
				add_meta_box( $this->prefix.'_meta-box', 'Page locking', array( &$this, 'outputMetaBox' ), 'page', 'side', 'high' );
			}
		}

		/**
 		* Controls the display of the page locking meta box.
 		*
 		* @since		0.1
 		* @global	$post
 		*/
		function outputMetaBox() {
			if ( current_user_can( $this->options[$this->prefix.'capability'] ) ) {
				global $post; ?>

				<input type="hidden" name="<?php echo $this->prefix; ?>meta_nonce" value="<?php echo wp_create_nonce(plugin_basename(__FILE__)); ?>" />
				<label for="<?php echo $this->prefix; ?>locked">
					<input type="checkbox" name="<?php echo $this->prefix; ?>locked" id="<?php echo $this->prefix; ?>locked"<?php if ( $this->isPageLocked( $post->ID ) ) echo ' checked="checked"'; ?> value="true" />
					<?php _e( 'Lock the slug, parent and deletion of this page', $this->localizationDomain ); ?>
				</label>

				<?php
			}
		}
        
		/**
 		* Outputs stuff for quick edit.
 		* Having trouble finding how to populate value with JS
 		* Still needed for now to include old slug / parent
 		*
 		* @since		0.1.5
 		* @global	$post
 		*/
		function outputQuickEdit( $column_name, $type ) {
			if ( $type == "page" ) {
				/*if ( current_user_can( $this->options[$this->prefix.'capability'] ) ) { ?>
				
				<fieldset class="inline-edit-col-left"><div class="inline-edit-col">
					<label>
						<span class="title"><?php _e( 'Lock', $this->localizationDomain ); ?></span>
						<input type="checkbox" name="<?php echo $this->prefix; ?>locked" id="<?php echo $this->prefix; ?>locked" value="true" />
					</label>
				</div></fieldset>
			
				<?php }*/ ?>
				
				<input type="hidden" name="<?php echo $this->prefix; ?>old_slug" value="" />
				<input type="hidden" name="<?php echo $this->prefix; ?>old_parent" value="" />
				
				<?php
			}
		}

		/**
 		* Saves the page locking metabox data to a custom field.
 		*
 		* @since	0.1
 		* @uses	current_user_can()
 		*/
		function saveMeta( $postID, $post ) {

			/* Block:
			- Users who can't change locked pages
			- Users who can't edit pages
			- Revisions, autoupdates, quick edits, posts etc.
			*/
			if (
					( !current_user_can( $this->options[$this->prefix.'capability'] ) ) ||
					( !current_user_can( 'edit_pages', $postID ) ) ||
					( $post->post_type != 'page' ) ||
					isset( $_POST["_inline_edit"] )
			)
				return;

			// Get list of locked pages
			$lockedPages = $this->options[$this->prefix.'locked_pages'];
			$lockedPages = explode( ',', $lockedPages );
			$update = false;

			if ( $_POST[$this->prefix.'locked'] ) {
				// Box was checked, make sure page is added to list of locked pages
				if ( !in_array( $postID, $lockedPages ) ) {
					$lockedPages[] = $postID;
					$update = true;
				}
			} else {
				// Box not checked, make sure page isn't in list of locked pages
				$IDPosition = array_search( $postID, $lockedPages );
				if ( $IDPosition !== false ) {
					unset( $lockedPages[$IDPosition] );
					$update = true;
				}
			}

			// Need to update?
			if ( $update ) {
				$lockedPages = implode( ',', $lockedPages );
				$this->options[$this->prefix.'locked_pages'] = $lockedPages;
				$this->saveAdminOptions();
			}

		}

		/**
		* Checks whether current user can edit page elements according to plugin settings
		* (and maybe page being edited).
		*
		* @since		0.1
		* @param		int	$postID		Optional ID of post being edited
		* @uses		current_user_can()
		* @return	bool
		*/
		function userCanEdit( $postID = 0 ) {
			// Basic check for "edit locked page" capability
			$userCan = current_user_can( $this->options[$this->prefix.'capability'] );
			// Override it if page isn't locked, a specific page is being edited, and scope isn't all pages
			if ( $this->options[$this->prefix.'scope'] != "all" && $postID && !$this->isPageLocked( $postID ) )
				$userCan = true;
			return $userCan;
		}

		/**
		* Checks if a specified page is currently locked (irrespective of the scope setting).
		* @return	bool
		*/
		function isPageLocked( $postID ) {
			if ( $postID ) {
				$lockedPages = $this->options[$this->prefix.'locked_pages'];
				$lockedPages = explode( ',', $lockedPages );
				return in_array( $postID, $lockedPages );
			} else {
				return false;
			}
		}

		/**
		* Retrieves the plugin options from the database.
		* @return	array
		*/
		function getOptions() {
			// Don't forget to set up the default options
			if ( !$theOptions = get_option( $this->optionsName ) ) {
				$theOptions = array(
					$this->prefix.'capability' => 'manage_options',
					$this->prefix.'scope' => 'locked',
					$this->prefix.'locked_pages' => ''
				);
				update_option($this->optionsName, $theOptions);
			}
			$this->options = $theOptions;

			//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
			// There is no return here, because you should use the $this->options variable!!!
			//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
		}

		/**
		* Saves the admin options to the database.
		*/
		function saveAdminOptions(){
			return update_option( $this->optionsName, $this->options );
		}

		/**
		* @desc Adds the options subpanel
		*/
		function admin_menu_link() {
			// If you change this from add_options_page, MAKE SURE you change the filter_plugin_actions function (below) to
			// reflect the page filename (ie - options-general.php) of the page your plugin is under!
			add_options_page('Lock Pages', 'Lock Pages', $this->options[$this->prefix.'capability'], basename(__FILE__), array(&$this,'admin_options_page'));
			add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), array(&$this, 'filter_plugin_actions'), 10, 2 );
		}

		/**
		* @desc Adds the Settings link to the plugin activate/deactivate page
		*/
		function filter_plugin_actions($links, $file) {
			// If your plugin is under a different top-level menu than Settiongs (IE - you changed the function above to something other than add_options_page)
			// Then you're going to want to change options-general.php below to the name of your top-level page
			$settings_link = '<a href="options-general.php?page=' . basename(__FILE__) . '">' . __('Settings') . '</a>';
			array_unshift( $links, $settings_link ); // before other links

			return $links;
		}

		/**
		* Adds settings/options page
		*/
		function admin_options_page() {

			if ($_POST['SLT_LockPages_save']) {
				if (! wp_verify_nonce($_POST['_wpnonce'], 'SLT_LockPages-update-options') ) {
					die( __( 'Whoops! There was a problem with the data you posted. Please go back and try again.', $this->localizationDomain ) );
				}

				$this->options[$this->prefix.'capability'] = $_POST[$this->prefix.'capability'];
				$this->options[$this->prefix.'scope'] = $_POST[$this->prefix.'scope'];
				$this->saveAdminOptions();

				echo '<div class="updated"><p>'.__( 'Your changes were sucessfully saved.', $this->localizationDomain ).'</p></div>';
			}

			/**
			* @todo	Check against capabilities from roles that have active users
			*/
			// Need to check if the capability entered actually exists
			if ( function_exists( 'members_get_capabilities' ) ) {
				// Use Members plugin function
				$currentCaps = members_get_capabilities();
			} else {
				// Just get capabilities from all current roles
				// Code based on Members plugin function members_get_role_capabilities()
				global $wp_roles;
				$currentCaps = array();
				/* Loop through each role object because we need to get the caps. */
				foreach ( $wp_roles->role_objects as $key => $role ) {
					/* Roles without capabilities will cause an error,
					so we need to check if $role->capabilities is an array. */
					if ( is_array( $role->capabilities ) ) {
						/* Loop through the role's capabilities and add them to the $currentCaps array. */
						foreach ( $role->capabilities as $cap => $grant )
							$currentCaps[$cap] = $cap;
					}
				}
			}

			// Set alert if necessary
			$capAlert = "";
			if ( !in_array( $this->options[$this->prefix.'capability'], $currentCaps ) ) {
				$capAlert = __( "Warning! The capability you have entered isn't currently granted to any roles in this installation.", $this->localizationDomain );
			}

			?>
			<div class="wrap">
				<h2>Lock Pages</h2>
				<form method="post" id="SLT_LockPages_options">
					<?php wp_nonce_field('SLT_LockPages-update-options'); ?>
					<table width="100%" cellspacing="2" cellpadding="5" class="form-table">
						<?php
						if ( $capAlert ) {
							echo '<div class="error"><p>' . $capAlert . '</p></div>';
						}
						?>
						<tr valign="top">
							<th width="33%" scope="row"><label for="<?php echo $this->prefix; ?>capability"><?php _e( 'WP capability needed to edit locked page elements', $this->localizationDomain ); ?></label></th>
							<td><input name="<?php echo $this->prefix; ?>capability" type="text" id="<?php echo $this->prefix; ?>capability" size="45" value="<?php echo $this->options[$this->prefix.'capability']; ?>"/></td>
						</tr>
						<tr valign="top">
							<th width="33%" scope="row"><?php _e( 'Scope for locking', $this->localizationDomain ); ?></th>
							<td>
								<input name="<?php echo $this->prefix; ?>scope" type="radio" id="<?php echo $this->prefix; ?>scope_locked" value="locked"<?php if ( $this->options[$this->prefix.'scope']=="locked" ) echo ' checked="checked"'; ?> /> <label for="<?php echo $this->prefix; ?>scope_locked"><?php _e( 'Lock only specified pages', $this->localizationDomain ); ?></label><br />
								<input name="<?php echo $this->prefix; ?>scope" type="radio" id="<?php echo $this->prefix; ?>scope_locked" value="all"<?php if ( $this->options[$this->prefix.'scope']=="all" ) echo ' checked="checked"'; ?> /> <label for="<?php echo $this->prefix; ?>scope_all"><?php _e( 'Lock all pages', $this->localizationDomain ); ?></label>
							</td>
						</tr>
					</table>
					<p class="submit"><input type="submit" value="Save Changes" class="button-primary" name="SLT_LockPages_save" /></p>
				</form>
			<?php
		}


	} // End Class

} // End if class exists statement

// Instantiate the class
if ( class_exists('SLT_LockPages') ) {
	$SLT_LockPages_var = new SLT_LockPages();
}

?>