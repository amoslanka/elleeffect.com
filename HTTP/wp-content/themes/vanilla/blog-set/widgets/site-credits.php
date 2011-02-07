<?php
if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) { die(); }

function widget_site_credits() {
	global $tpl;
	$tpl["widget"]["site_credits"] = array(
		"generator_link" => __('Proudly powered by <a href="http://wordpress.org/" title="WordPress" rel="generator">WordPress</a></span> and <span id="theme-link"><a href="http://carringtontheme.com" title="Carrington theme for WordPress">Carrington</a></span>.', 'carrington'),
		"developer_link" => sprintf(__('<a href="http://crowdfavorite.com" title="Custom WordPress development, design and backup services." rel="developer designer">%s</a>', 'carrington'), 'Carrington Theme by Crowd Favorite')
	);
}

function widget_site_credits_control() {}

//vanilla_register_widget(function name, description);
vanilla_register_widget('widget_site_credits', 'Site Credits (footer)');

?>