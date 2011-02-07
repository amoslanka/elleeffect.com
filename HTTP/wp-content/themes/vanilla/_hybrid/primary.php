<?php

/**
* Runs through a list of primary inserts according to page
* Let users filter through the child theme if necessary
*
* @since 0.1
* @filter
*/
function hybrid_primary_var() {

	if(is_front_page() || is_home())
		$hybrid_insert_id = __('Primary Home','hybrid');
	elseif(is_author())
		$hybrid_insert_id = __('Primary Author','hybrid');
	elseif(is_category())
		$hybrid_insert_id = __('Primary Category','hybrid');
	elseif(is_date())
		$hybrid_insert_id = __('Primary Date','hybrid');
	elseif(is_page_template('no-widgets.php'))
		$hybrid_insert_id = false;
	elseif(is_page())
		$hybrid_insert_id = __('Primary Page','hybrid');
	elseif(is_search())
		$hybrid_insert_id = __('Primary Search','hybrid');
	elseif(is_single())
		$hybrid_insert_id = __('Primary Single','hybrid');
	elseif(is_tag())
		$hybrid_insert_id = __('Primary Tag','hybrid');
	elseif(is_404())
		$hybrid_insert_id = __('Primary 404','hybrid');
	else
		$hybrid_insert_id = __('Primary Home','hybrid');

	return apply_filters('hybrid_primary_var', $hybrid_insert_id);
}

/**
* Displays the primary widget area
* Check if the widget area is active or if the default is set to home
* If neither is true, don't display the XHTML
*
* @since 0.2.2
*/
function hybrid_get_primary() {

	global $hybrid_settings;

	if(
		($hybrid_settings['primary_inserts_default'] && is_sidebar_active(__('Primary Home','hybrid')) && !is_page_template('no-widgets.php')) || 
		(is_sidebar_active(hybrid_primary_var()) && !is_page_template('no-widgets.php'))
	) : ?>

		<div id="primary">
		<?php
			hybrid_before_primary(); // Before primary hook

			if(dynamic_sidebar(hybrid_primary_var())) :
			else :
				if($hybrid_settings['primary_inserts_default']) :
					if(dynamic_sidebar(__('Primary Home','hybrid'))) :
					endif;
				endif;
			endif;

			hybrid_after_primary(); // After primary hook
		?>
		</div>

	<?php endif;
}
?>