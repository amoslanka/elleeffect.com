<?php
/**
 * Functions File
 *
 * This is your child theme's functions.php file. Use this to write any custom functions 
 * you may need. You can use this to hook into the Hybrid theme (could also create a 
 * plugin to do the same).
 *
 * @package Skeleton
 * @subpackage Functions
 */

/**
 * Make sure to localize all your text if you plan on releasing this publicly
 *
 * @link http://themehybrid.com/themes/hybrid/translating
 * @link http://codex.wordpress.org/Translating_WordPress
 */
//load_child_theme_textdomain( 'skeleton', get_stylesheet_directory() . '/languages' );

/**
 * Add actions
 *
 * @link http://themehybrid.com/themes/hybrid/hooks
 * @link http://themehybrid.com/themes/hybrid/hooks/actions
 * @link http://codex.wordpress.org/Plugin_API/Action_Reference
 */ 
// add_action( 'action_hook_name','custom_function_name' );

/**
 * Add filters
 *
 * @link http://themehybrid.com/themes/hybrid/hooks
 * @link http://themehybrid.com/themes/hybrid/hooks/filters
 * @link http://codex.wordpress.org/Plugin_API/Filter_Reference
 */
// add_filter( 'filter_hook_name', 'custom_function_name' );

/**
 * Basic "Hello World" function
 *
 * @link http://en.wikibooks.org/wiki/Transwiki:List_of_hello_world_programs
 * @since 0.1
 */
function skeleton_hello_world() {
	echo 'Hello World!';
}

?>