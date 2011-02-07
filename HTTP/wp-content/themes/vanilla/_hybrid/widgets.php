<?php

/**
* Call the widget init function
* Run each set of inserts through the function
*/

hybrid_widget_init(hybrid_primary_inserts());
hybrid_widget_init(hybrid_secondary_inserts());
hybrid_widget_init(hybrid_subsidiary_inserts());

/**
* Add widget inserts to array
* Filterable to add/remove inserts in child themes
*
* @since 0.1
* @filter
*/
function hybrid_primary_inserts() {
	$inserts = array(
		__('Primary Home','hybrid'),
		__('Primary Author','hybrid'),
		__('Primary Category','hybrid'),
		__('Primary Date','hybrid'),
		__('Primary Page','hybrid'),
		__('Primary Tag','hybrid'),
		__('Primary Search','hybrid'),
		__('Primary Single','hybrid'),
		__('Primary 404','hybrid'),
	);

	return apply_filters('hybrid_primary_inserts', $inserts);
}

/**
* Add widget inserts to array
* Filterable to add/remove inserts in child themes
*
* @since 0.2
* @filter
*/
function hybrid_secondary_inserts() {
	$inserts = array(
		__('Secondary Home','hybrid'),
		__('Secondary Author','hybrid'),
		__('Secondary Category','hybrid'),
		__('Secondary Date','hybrid'),
		__('Secondary Page','hybrid'),
		__('Secondary Single','hybrid'),
		__('Secondary Tag','hybrid'),
		__('Secondary Search','hybrid'),
		__('Secondary 404','hybrid'),
	);

	return apply_filters('hybrid_secondary_inserts', $inserts);
}

/**
* Function for additional widget inserts
* These inserts should not fall under the Primary/Secondary domain
*
* @since 0.3
* @filter
*/
function hybrid_subsidiary_inserts() {
	$inserts = array(
		__('Widget Template','hybrid')
	);

	return apply_filters('hybrid_subsidiary_inserts', $inserts);
}

/**
* Loop through inserts array
* Creates individual widget displays
*
* @since 0.2.1
*/
function hybrid_widget_init($insert_id = false) {

	return; // alister shutting this down for now!

	if($insert_id) :
		foreach($insert_id as $insert) :

		// Register the widget section
			register_sidebar(array(
				'name' => $insert,
				'before_widget' => '<div id="%1$s" class="' . hybrid_widget_class() . '"><div class="widget-inside">',
				'after_widget' => '</div></div>',
				'before_title' => '<h3 class="widget-title widget-header">',
				'after_title' => '</h3>',
				)
			);
		endforeach;
	endif;
}

/**
* Check for widgets in widget-ready sections
* Allows user to completely collapse widget-ready sections
* Even if there are no widgets added
*
* Checks widget areas by name instead of ID
* Using WP functionality from /wp-includes/widgets.php
* From function dynamic_sidebar()
*
* Idea from:
* http://wordpress.org/support/topic/190184?replies=7#post-808787
* http://themeshaper.com/collapsing-wordpress-widget-ready-areas-sidebars
* Thanks to Chaos Kaizer http://blog.kaizeku.com
* Ian Stewart http://themeshaper.com
*
* @since 0.2
* @return true/false
*/
function is_sidebar_active($index = 1) {
	global $wp_registered_sidebars, $wp_registered_widgets;

	if(is_int($index)) :
		$index = "sidebar-$index";
	else :
		$index = sanitize_title($index);
		foreach((array) $wp_registered_sidebars as $key => $value) :
			if(sanitize_title($value['name']) == $index) :
				$index = $key;
				break;
			endif;
		endforeach;
	endif;

	$sidebars_widgets = wp_get_sidebars_widgets();

	if(empty($wp_registered_sidebars[$index]) || !array_key_exists($index, $sidebars_widgets) || !is_array($sidebars_widgets[$index]) || empty($sidebars_widgets[$index]))
		return false;
	else return true;
}

/**
* Defines the classes for widgets
* Currently trying to add alt classes, but can't get it to work
*
* @since 0.2.2
*/
function hybrid_widget_class() {

	global $widget_num;

// Widget class
	$class = array();
	$class[] = 'widget';
	$class[] = '%2$s';
	$class[] = 'widget-%2$s';

// Iterated class
//	$widget_num++;
//	$class[] = 'widget-' . $widget_num;

// Alt class
//	if($widget_num % 2) :
//		$class[] = 'widget-even';
//		$class[] = 'widget-alt';
//	else :
//		$class[] = 'widget-odd';
//	endif;

// Join the classes in an array
	$class = join(' ', $class);

// Return the widget class
	return $class;
}

?>