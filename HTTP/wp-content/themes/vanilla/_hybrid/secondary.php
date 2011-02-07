<?php

/**
* Runs through a list of secondary inserts according to page
* Let users filter through the child theme if necessary
*
* @since 0.1
* @filter
*/
function hybrid_secondary_var() {

	if(is_front_page() || is_home())
		$hybrid_insert_id = __('Secondary Home','hybrid');
	elseif(is_author())
		$hybrid_insert_id = __('Secondary Author','hybrid');
	elseif(is_category())
		$hybrid_insert_id = __('Secondary Category','hybrid');
	elseif(is_date())
		$hybrid_insert_id = __('Secondary Date','hybrid');
	elseif(is_page_template('no-widgets.php'))
		$hybrid_insert_id = false;
	elseif(is_page())
		$hybrid_insert_id = __('Secondary Page','hybrid');
	elseif(is_search())
		$hybrid_insert_id = __('Secondary Search','hybrid');
	elseif(is_single())
		$hybrid_insert_id = __('Secondary Single','hybrid');
	elseif(is_tag())
		$hybrid_insert_id = __('Secondary Tag','hybrid');
	elseif(is_404())
		$hybrid_insert_id = __('Secondary 404','hybrid');
	else
		$hybrid_insert_id = __('Secondary Home','hybrid');

	return apply_filters('hybrid_secondary_var', $hybrid_insert_id);
}

/**
* Displays the secondary widget area
* Check if the widget area is active or if the default is set to home
* If neither is true, don't display the XHTML
*
* @since 0.2.2
*/
function hybrid_get_secondary() {

	global $hybrid_settings;

	if(
		($hybrid_settings['secondary_inserts_default'] && is_sidebar_active(__('Secondary Home','hybrid')) && !is_page_template('no-widgets.php')) || 
		(is_sidebar_active(hybrid_secondary_var()) && !is_page_template('no-widgets.php'))
	) : ?>

		<div id="secondary">
		<?php
			hybrid_before_secondary(); // Before secondary hook

			if(dynamic_sidebar(hybrid_secondary_var())) :
			else :
				if($hybrid_settings['secondary_inserts_default']) :
					if(dynamic_sidebar(__('Secondary Home','hybrid'))) :
					endif;
				endif;
			endif;

			hybrid_after_secondary(); // After secondary hook
		?>
		</div>

	<?php endif;
}
?>