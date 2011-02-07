<?php
if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) { die(); }

function widget_all_categories() {
	// Nothing here - the TAL template does everything.
}

function widget_all_categories_control() {}

//vanilla_register_widget(function name, description);
vanilla_register_widget('widget_all_categories', 'Categories Menu');

?>