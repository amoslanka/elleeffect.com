<?php

/**
* hybrid_theme_page()
* Handles the main theme settings
*
* @since 0.2
*/
function hybrid_theme_page() {

// Some variables
	$theme_name = __('Hybrid','hybrid');
	$settings_page_title = __('Hybrid Theme Settings','hybrid');
	$hidden_field_name = 'hybrid_submit_hidden';
	$theme_data = get_theme_data(TEMPLATEPATH . '/style.css');

// Add all options to a single array
// This makes one entry in the database
	$settings_arr = array(
		'feed_url' => get_bloginfo('rss2_url'), // General settings
		'print_style' => true,
		'page_nav' => array(),

		'common_js' => false, // JavaScript settings
		'pullquotes_js' => false,
		// 'comment_tabs' => false,

		'primary_inserts_default' => true, // Widget settings
		'secondary_inserts_default' => false,

		'robots_home' => true, // Indexing
		'robots_single' => true,
		'robots_attachment' => true,
		'robots_page' => true,
		'robots_date' => true,
		'robots_category' => true,
		'robots_tag' => true,
		'robots_author' => true,
		'robots_search' => true,
		'robots_404' => true,

		'seo_cats' => true, // SEO
		'seo_tags' => true,
		'seo_single_excerpts' => true,
		'seo_author' => true,
		'seo_category' => true,
		'seo_blog_title' => false,

		'default_avatar' => false, // Avatars

		'separate_comments' => 'false',
		'comments_popup' => false, // Comments popup
		// 'comments_popup_width' => false,
		// 'comments_popup_height' => false,
		// 'comments_pagination' => __('Previous/Next Links','hybrid'),

		'footer_insert' => false, // Footer settings
		'copyright' => true,
		'wp_credit' => true,
		'th_credit' => true,
		'query_counter' => false,
	);

// Add theme settings to database
	add_option('hybrid_theme_settings', $settings_arr);

// Set form data IDs the same as settings keys
// Loop through each
	$settings_keys = array_keys($settings_arr);
	foreach($settings_keys as $key) :
		$data[$key] = $key;
	endforeach;

// Get existing options from database
	$settings = get_option('hybrid_theme_settings');

	foreach($settings_arr as $key => $value) :
		$val[$key] = $settings[$key];
	endforeach;

// See if information has been posted
	if($_POST[$hidden_field_name] == 'Y') :

	// Loop through values and set them if posted
		foreach($settings_arr as $key => $value) :
			$settings[$key] = $val[$key] = $_POST[$data[$key]];
		endforeach;

	// Update theme settings
		update_option('hybrid_theme_settings', $settings);

	?>

		<div class="wrap">
			<h2><?php echo $settings_page_title; ?></h2>

		<div class="updated" style="margin: 15px 0;">
			<p><strong><?php _e('Settings saved.', 'hybrid'); ?></strong></p>
		</div>

	<?php else : ?>

		<div class="wrap">
			<h2><?php echo $settings_page_title; ?></h2>
	<?php
	endif;

	// Alister override this checking...
	//if($theme_data['URI'] !== 'http://themehybrid.com/themes/hybrid') : hybrid_error();
	//elseif($theme_data['Name'] !== 'Hybrid') : hybrid_error();
	//else : include(HYBRID_ADMIN . '/theme-settings-xhtml.php');
	//endif;
	include(CFCT_PATH.'_hybrid/admin/theme-settings-xhtml.php');

}

?>