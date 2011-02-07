<?php
if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) { die(); }

function widget_navigation() {
	global $tpl, $user_ID;
	
	$tpl["widget"]["navigation"] = array(
		"user_id" => ($user_ID) ? 1 : 0
	);
}

function widget_navigation_control() {}

//vanilla_register_widget(function name, description);
vanilla_register_widget('widget_navigation', 'Main menu/navigation');

?>