<?php
if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) { die(); }

function widget_branding() {
	// Nothing here - the TAL template does everything.
}

function widget_branding_control() {}

//vanilla_register_widget(function name, description);
vanilla_register_widget('widget_branding', 'Site-wide branding elements');

?>