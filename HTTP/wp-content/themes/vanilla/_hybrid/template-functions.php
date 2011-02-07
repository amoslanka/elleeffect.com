<?php

/**
* Calls up several theme functions to get meta info
* hybrid_meta_keywords()
* hybrid_meta_description()
* hybrid_meta_robots()
* hybrid_meta_other()
* Once all functions are loaded output data into header
* Check for All in One SEO and HeadSpace2
* If in use, only load hybrid_meta_other()
*
* @since 0.1
* @hook wp_head()
*/
function hybrid_theme_meta() {
	if(!class_exists('All_in_One_SEO_Pack') && !class_exists('HeadSpace2_Admin')) :
		hybrid_meta_robots();
		hybrid_meta_description();
		hybrid_meta_keywords();
	endif;
	hybrid_meta_other();
}

/**
* Allows/disallows indexing by search engines
* Calls theme settings to check for data
* Check options 'blog_public' for privacy mode
* If private, don't send meta info to header
*
* @since 0.2.3
*/
function hybrid_meta_robots() {
	global $post, $hybrid_settings, $wp_query;

	if(!get_option('blog_public'))
		return;

	/*
	* Indexing/Robots
	*/
	if((is_home() || is_front_page()) && ($hybrid_settings['robots_home'])) :
		$follow = true;
	elseif(is_attachment() && $hybrid_settings['robots_attachment']) :
		$follow = true;
	elseif(is_single() && !is_attachment() && $hybrid_settings['robots_single']) :
		$follow = true;
	elseif(is_page() && !is_attachment() && $hybrid_settings['robots_page']) :
		$follow = true;
	elseif(is_date() && $hybrid_settings['robots_date']) :
		$follow = true;
	elseif(is_category() && $hybrid_settings['robots_category']) :
		$follow = true;
	elseif(is_tag() && $hybrid_settings['robots_tag']) :
		$follow = true;
	elseif(is_search() && $hybrid_settings['robots_search']) :
		$follow = true;
	elseif(is_author() && $hybrid_settings['robots_author']) :
		$follow = true;
	elseif(is_404() && $hybrid_settings['robots_404']) :
		$follow = true;
	else :
		$follow = false;
	endif;

	if($follow) :
		echo '<meta name="robots" content="index,follow" />' . "\n";
	else :
		echo '<meta name="robots" content="noindex,follow" />' . "\n";
	endif;
}

/**
* Generates the meta description
* Checks theme settings for indexing, title, and meta settings
*
* @since 0.2.3
*/
function hybrid_meta_description() {
	global $post, $hybrid_settings, $wp_query;

	/*
	* Get meta description
	* Check for custom fields on posts/pages
	*/
	// If on home page
	if(is_home() || is_front_page()) :
		$meta_desc = get_bloginfo('description');
	elseif(is_single() || is_page()) :
		$meta_desc = get_post_meta($post->ID, 'Description', $single = true);
		if(!$meta_desc && $hybrid_settings['seo_single_excerpts']) :
			$meta_desc = get_the_excerpt();
		endif;
	elseif(is_category()) :
		$meta_desc = stripslashes(strip_tags(category_description()));
	elseif(is_author()) :
		$meta_auth = get_userdata(get_query_var('author'));
		$meta_desc = str_replace(array('"'), '&quot;', $meta_auth->description);
	endif;

	/*
	* Meta description
	*/
	if($meta_desc && strlen($meta_desc) > 1) :
		$meta_desc = str_replace(array('"'), '&quot;', $meta_desc);
		$meta_desc = strip_tags(stripslashes($meta_desc));
		echo '<meta name="description" content="' . $meta_desc . '" />' . "\n";
	endif;
}

/**
* Generates meta keywords/tags for the site
* Checks theme settings
* Checks indexing settings
*
* @since 0.2.3
*
*/
function hybrid_meta_keywords() {
	global $post, $hybrid_settings, $wp_query;

	$keywords = array();

	// If on a single post
	// Check for custom fields
	// Check for SEO settings
	if(is_single()) :
		$post_keywords = get_post_meta($post->ID, 'Keywords', true);
		if($post_keywords) $keywords[] = $post_keywords;

		 if($hybrid_settings['seo_cats'] && !$post_keywords) :
			$cats = get_the_category();
			foreach($cats as $cat) :
				$keywords[] = $cat->name;
			endforeach;
		endif;
		if($hybrid_settings['seo_tags'] && !$post_keywords) :
			$wp_query->in_the_loop = true;
			$tags = get_the_tags();
			if($tags) :
				foreach($tags as $tag) :
					$keywords[] = $tag->slug;
				endforeach;
			endif;
			$wp_query->in_the_loop = false;
		endif;

	// If on a page
	// Check for custom fields
	elseif(is_page()) :
		$post_keywords = get_post_meta($post->ID, 'Keywords', true);
		if($post_keywords) :
			$keywords[] = $post_keywords;
		endif;
	endif;

	if(!empty($keywords)) :
		$keywords = join(', ', $keywords);
		echo "<meta name='keywords' content='" . stripslashes($keywords) . "' />\n";
	endif;
}

/**
* Generates other relevant meta info
*
* @since 0.2.3
*/
function hybrid_meta_other() {
	global $hybrid_settings;

	/*
	* Theme name/version
	*/
	$data = get_theme_data(TEMPLATEPATH . '/style.css');
	echo "\n<meta name='wordpress_theme' content='" . $data['Title'] . " " . $data['Version'] . "' />\n";

	/*
	* Feed and pingback display
	*/
	if($hybrid_settings['feed_url']) $feed = $hybrid_settings['feed_url'];
	else $feed = get_bloginfo('rss2_url');

	echo "\n<link rel='alternate' type='application/rss+xml' title='" . __('RSS 2.0','hybrid') . "' href='" . $feed . "' />\n";
	echo "<link rel='alternate' type='text/xml' title='" . __('RSS .92','hybrid') . "' href='" . get_bloginfo('rss_url') . "' />\n";
	echo "<link rel='alternate' type='application/atom+xml' title='" . __('Atom 0.3','hybrid') . "' href='" . get_bloginfo('atom_url') . "' />\n";
	echo "<link rel='pingback' href='" . get_bloginfo('pingback_url') . "' />\n\n";
}

/**
* Dynamic body class based on page
*
* @since 0.1
*/
function hybrid_body_class() {
	global $wp_query, $hybrid_settings;

	$class = array();

	if(is_front_page() || is_home()) :
		$class[] = 'home';
		$class[] = 'front-page';
	elseif(is_attachment()) :
		global $post;
		$class[] = 'attachment';
		if(wp_attachment_is_image($post->ID)) :
			$class[] = 'attachment-image';
		endif;
		$mime = get_post_mime_type($post->ID);
		$class[] = 'attachment-' . str_replace('/', '-', $mime);
	elseif(is_single()) :
		$class[] = 'single';
		$class[] = 'single-' . $wp_query->post->ID;
		if(function_exists('is_sticky')) :
			if(is_sticky($wp_query->post->ID))
				$class[] = 'single-sticky';
		endif;
	elseif(is_page()) :
		$class[] = 'page page-' . $wp_query->post->ID;
		if(is_page_template()) :
			$class[] = 'page-template';
			$class[] = 'page-template-' . str_replace('.php', '', get_post_meta($wp_query->post->ID, '_wp_page_template', true));
		endif;
	elseif (is_category()) :
		$cat = $wp_query->get_queried_object();
		$class[] = 'category';
		$class[] = 'category-' . $cat->slug;
	elseif(is_tag()) :
		$tags = $wp_query->get_queried_object();
		$class[] = 'tag';
		$class[] = 'tag-' . $tags->slug;
	elseif(is_search()) :
		$class[] = 'search';
	elseif (is_404()) :
		$class[] = 'error-404';
	elseif(is_year()) :
		$class[] = 'year';
	elseif(is_month()) :
		$class[] = 'month';
	elseif(is_day()) :
		$class[] = 'day';
	elseif(is_time()) :
		$class[] = 'time';
	elseif(is_author()) :
		$author = $wp_query->get_queried_object();
		$class[] = 'author';
		$class[] = ' author-' . $author->user_nicename;
	endif;

	if(is_user_logged_in())
		$class[] = 'logged-in';
	else
		$class[] = 'not-logged-in';
	if(is_date())
		$class[] = 'date';
	if(is_archive())
		$class[] = 'archive';
	if(is_paged())
		$class[] = 'paged';
	if((($page = $wp_query->get('paged')) || ($page = $wp_query->get('page'))) && $page > 1) :

		$class[] = 'paged';
		$class[] = 'paged-' . $page;

		if(is_home() || is_front_page())
			$class[] = 'home-paged-' . $page;
		elseif(is_attachment())
			$class[] = 'attachment-paged-' . $page;
		elseif(is_single())
			$class[] = 'single-paged-' . $page;
		elseif(is_page())
			$class[] = 'page-paged-' . $page;
		elseif(is_category())
			$class[] = 'category-paged-' . $page;
		elseif(is_tag())
			$class[] = 'tag-paged-' . $page;
		elseif(is_date())
			$class[] = 'date-paged-' . $page;
		elseif(is_author())
			$class[] = 'author-paged-' . $page;
		elseif(is_search())
			$class[] = 'search-paged-' . $page;
	endif;
	if(is_comments_popup())
		$class[] = 'comments-popup';

	if($hybrid_settings['primary_inserts_default']) :
		if(!is_sidebar_active(__('Primary Home','hybrid')) && !is_sidebar_active(hybrid_primary_var())) :
			$class[] = 'no-primary-widgets';
			$no_primary_widgets = true;
		endif;
	else :
		if(!is_sidebar_active(hybrid_primary_var())) :
			$class[] = 'no-primary-widgets';
			$no_primary_widgets = true;
		endif;
	endif;

	if($hybrid_settings['secondary_inserts_default']) :
		if(!is_sidebar_active(__('Secondary Home','hybrid')) && !is_sidebar_active(hybrid_secondary_var())) :
			$class[] = 'no-secondary-widgets';
			$no_secondary_widgets = true;
		endif;
	else :
		if(!is_sidebar_active(hybrid_secondary_var())) :
			$class[] = 'no-secondary-widgets';
			$no_secondary_widgets = true;
		endif;
	endif;

	 if(is_page_template('no-widgets.php')) :
		$class[] = 'no-widgets';
		$no_widgets = true;
	endif;

	if(($no_widgets) || ($no_primary_widgets && $no_secondary_widgets))
		$class[] = 'no-default-widgets';
	else
		$class[] = 'has-widgets';

	$class = join(' ', $class);
	echo $class;
}

/**
* Sets alternating classes for posts
* Gives class of odd/even and post-#
*
* @since 0.2
*/
function hybrid_post_class() {
	global $post, $hybrid_post_alt, $hybrid_post_num;

// Add class 'post' if attachment
	if(is_attachment() || is_search() || is_404() || is_page())
		$class[] = 'post';

// Iterated class
	$hybrid_post_num++;
	$class[] = 'post-' . $hybrid_post_num;
// Alt class
	if($hybrid_post_alt++ % 2) :
		$class[] = 'even';
		$class[] = 'alt';
	else :
		$class[] = 'odd';
	endif;

	/*
	* WP 2.7 get_post_class()
	* Only call if available
	*/
	if(function_exists('get_post_class')) :
		$class = join( ' ', get_post_class( $class, $post_id ) );
	else :
		$class[] = 'post';
		$class = join(' ', $class);
	endif;

// Echo class
	echo $class;
}

/**
* Archived navigation links
* Always use except on pages and posts
* Check for WP PageNavi plugin first
*
* @since 0.2
* @hook hybrid_after_content
* @plugin http://wordpress.org/extend/plugins/wp-pagenavi
*/
function hybrid_navigation_links() {

	if(is_home() || is_front_page() || is_archive() || is_search() || is_page_template('blog.php')) :

		if(function_exists('wp_pagenavi')) :
			wp_pagenavi();
		else : ?>
			<div class="navigation-links section">
				<?php posts_nav_link('',
					'<span class="previous">&laquo; '.__('Previous Page','options').'</span>',
					'<span class="next">'.__('Next Page','options').' &raquo;</span>'
				); ?>
			</div>

		<?php endif;
	endif;
}

/**
* Shows related posts by plugin
* Only show if plugin is active
*
* @since 0.2.2
*
* @plugin - http://wasabi.pbwiki.com/Related%20Entries
* @plugin - http://rmarsh.com/plugins/similar-posts
* @plugin - http://wordpress.org/extend/plugins/wordpress-23-related-posts-plugin
***********************************************************/
function hybrid_related_posts() {
	if(
		function_exists('related_posts') || 
		function_exists('similar_posts') || 
		function_exists('wp_related_posts')
	) :
		echo '<div class="related-posts">';
		echo '<h3>' . __('Related Posts','options') . '</h3>';

		if(function_exists('related_posts')) :
			echo '<ul class="related">'; related_posts(); echo '</ul>';

		elseif(function_exists('similar_posts')) :
			similar_posts();

		elseif(function_exists('wp_related_posts')) :
			wp_related_posts();

		endif;

		echo '</div>';

	endif;
}

/**
* Footer insert from the theme settings page
* Uses stripslashes() for proper output of code
*
* @since 0.2.1
*/
function hybrid_footer_insert() {
	global $hybrid_settings;
	if($hybrid_settings['footer_insert']) :
		echo stripslashes($hybrid_settings['footer_insert']);
	endif;
}
?>