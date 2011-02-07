<?php
if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) { die(); }

function widget_search_form() {
	global $tpl;
	$tpl["widget"]["search_form"] = array(
		"action" => get_bloginfo('home'),
		"submit_text" => __('Search', 'carrington'),
		"query" => wp_specialchars(stripslashes($_GET['s']), true)
	);
}

function widget_search_form_control() {}

//vanilla_register_widget(function name, description);
vanilla_register_widget('widget_search_form', 'Search Form');

?>