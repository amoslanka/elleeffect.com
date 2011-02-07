<?php
if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) { die(); }

function vanilla_get_option($name) {
	$defaults = array(
		'vnl_tpl_set' => array('blog', 'Blog (default)')
		, 'vnl_grid_width' => array('yui-d1', '750 pixels, centered')
		, 'vnl_custom_width' => 1000
		, 'vnl_grid_template' => array('yui-t7', 'none')
		, 'vnl_grid_nesting' => array('yui-g', 'none')
		, 'vnl_utility_nesting' => array('yui-ga', 'none')
		, 'vnl_insert_position' => 2
		, 'vnl_authorinfo' => false
		, 'vnl_footertext' => '<span id="generator-link">You are enjoying the taste by <span id="designer-link"><a href="http://www.alistercameron.com/vanilla-theme-for-wordpress" title="Vanilla Theme" rel="designer">Vanilla flavored</a> <a href="http://WordPress.org/" title="WordPress" rel="generator">WordPress</a></span></span><span class="meta-sep">.</span>'
	);
	$value = get_option($name);
	if ($value == '' && isset($defaults[$name])) {
		$value = $defaults[$name];
		$value = (is_array($value)) ? $value[0] : $value;
	}
	return $value;
}

// Check whether a child theme template file exists, otherwise return the vanilla file.
function vanilla_get_template($path) {
	$set = vanilla_get_option('vnl_tpl_set').'-set/';
	$child_template = STYLESHEETPATH.'/'.$set.$path;
	$parent_template = CFCT_PATH.$set.$path;
	return ( file_exists($child_template) ) ? $child_template : ( file_exists($parent_template) ) ? $parent_template : false;
}

function vanilla_output_page($template) {
	global $tpl;
	
	$template->set('vanilla', $tpl);
	if (!VANILLA_DEBUG) $template->setPostFilter(new Minify_HTML());
	
	try { echo $template->execute(); }
	catch (Exception $e){ echo $e; }
}

function vanilla_widget_block_wrapper($block){
	// called from within a dynamic PHPTAL macro (below) to stop it outputting a '1' to screen.
	if (!dynamic_sidebar($block)) {
		// do nothing;
	}
}

function vanilla_widget_template_markup($block=null) {
	global $wp_registered_sidebars, $wp_registered_widgets;
	
	$tpl_source = "";

	$block = sanitize_title($block);
	foreach ( (array) $wp_registered_sidebars as $key => $value ) {
		if ( sanitize_title($value['name']) == $block ) {
			$block = $key;
			break;
		}
	}

	$sidebars_widgets = wp_get_sidebars_widgets();

	if ( empty($wp_registered_sidebars[$block]) || !array_key_exists($block, $sidebars_widgets) || !is_array($sidebars_widgets[$block]) || empty($sidebars_widgets[$block]) )
		return "";

	$sidebar = $wp_registered_sidebars[$block];

	foreach ( (array) $sidebars_widgets[$block] as $id ) {
		$params = array_merge(
			array( array_merge( $sidebar, array('widget_id' => $id, 'widget_name' => $wp_registered_widgets[$id]['name']) ) ),
			(array) $wp_registered_widgets[$id]['params']
		);

		$params = apply_filters( 'dynamic_sidebar_params', $params );
		$callback = $wp_registered_widgets[$id]['callback'];
		$widget_name = str_replace("widget_", "", strtolower($callback));
		$active_template = vanilla_get_template('widgets/' . str_replace("_", "-", $widget_name) . ".html");
		
		if (!$active_template) return "";
		
		//echo $widget_name . " " . $widget_filename;

		if ( is_callable($callback) ) {
			call_user_func_array($callback, $params);
			
			$tpl_source .= '<span metal:use-macro="'.$active_template.'/loader" />' . "\n" .
					'<span tal:condition="php:VANILLA_DEBUG" class="widget-debug">WIDGET: '.$widget_name.'</span>' . "\n" .
					'<span metal:define-slot="'.$widget_name.'" />' . "\n";	
		}
	}
	return $tpl_source;
}

function vanilla_widget_block($block=null){
	$block = sanitize_title_with_dashes(strtolower($block));
	
	// Apply action
	do_action('vanilla_widget_' . str_replace('-', '_', $block) . '_before');
	
	if ( function_exists('dynamic_sidebar') && is_sidebar_active($block) ) {
		
		$tpl_source = '<metal:block define-macro="'.str_replace("-", "_", $block).'">' . "\n" .
				"<!-- widget block: ".$block." -->\n" .
				'<span tal:condition="php:VANILLA_DEBUG" class="widget-debug">'.$block.'</span>' . "\n";
		$tpl_source .= vanilla_widget_template_markup($block);
		$tpl_source .= '${php:vanilla_widget_block_wrapper(\''.$block.'\')}' . "\n" .
				'</metal:block><metal:block use-macro="'.str_replace("-", "_", $block).'" />'."\n";
		
		//echo $tpl_source;
		
		echo "\t\t<div id=\"" . $block . "\" class=\"block\">\n";
		
		// Load and fire the PHPTAL template!
		$$block = new PHPTAL();
		$set = vanilla_get_option('vnl_tpl_set').'-set/';
		$$block->setSource($tpl_source, $set.$block);
		vanilla_output_page($$block);
		
		echo "</div>\n";
	}
	
	// Apply action
	do_action('vanilla_widget_' . str_replace('-', '_', $block) . '_after');
}

function vanilla_add_debug_css(){
	if (!VANILLA_DEBUG) return;
?>
	<style type="text/css">
	/* Vanilla debugging CSS - set the constant in functions.php to 'false' to remove. */
	.debug, .grid-debug, .widget-debug, .doc-debug { display: block; text-align: left; border: 1px solid #090; background: #cfc; color: #060; padding: 0.2em 0.5em; filter: alpha(opacity=50);-moz-opacity: 0.50; opacity: 0.50; }
	.grid-debug, .doc-debug { color: #900; background: #fcc; border-color: #900; }
	.widget-debug { color: #009; background: #ccf; border-color: #009; }
	</style>
<?php
}
add_action('wp_head', 'vanilla_add_debug_css');
?>