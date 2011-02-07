<?php

/**
* Gets legacy functions if needed
* For versions pre-2.7
*
* @since 0.3
*/
function hybrid_legacy_functions() {
	if(!function_exists('wp_list_comments'))
		require_once(HYBRID_LEGACY . '/legacy.functions.php');
}

/**
* Checks if the template exists and returns appropriate link
* Useful for log in, publish, and registration templates and functions
*
* @since 0.3
* @return link
*/
function hybrid_template_in_use($template = false) {
	$link = false;
	if($template) :
		$pages = get_pages(array(
			'title_li' => '',
			'meta_key' => '_wp_page_template',
			'meta_value' => $template,
			'echo' => 0
		));
		if($pages[0]->ID) :
			$link = get_permalink($pages[0]->ID);
		else :
			if($template == 'log-in.php') :
				$link = get_option('siteurl') . '/wp-login.php?redirect_to=' . urlencode(get_permalink());
			elseif($template == 'register.php') :
				$link = get_option('siteurl') . '/wp-register.php';
			endif;
		endif;
	endif;
	return $link;
}

/**
* Checks for capabilities assigned to current user
* Capability is pulled by use of the custom field key Capability or capability
* Multiple capabilities can be set as values with a single custom field key
* Users can also directly input a single capability into the function
* If no custom field is set or capability added, defaults to is_user_logged_in()
*
* @since 0.2.3
*
* @param array Optional
* Input an array of custom field keys (on posts/pages) to check for values (capabilities)
* Input an array of capabilities to check
* Can set $logged_in to false if checking for capabilities only (default: true)
* Else, the script simply checks for logged in users failing any input capabilities
*
* @return true/false
* @reference http://codex.wordpress.org/Roles_and_Capabilities
*/
function hybrid_capability_check($args = array()) {

	/*
	* Set up defaults and mix with $args
	*/
	$defaults = array(
		'custom_key' => array('Capability','capability'),
		'capability' => array(),
		'logged_in' => true,
	);

	$args = wp_parse_args($args, $defaults);
	extract($args);

	/*
	* If is post/page, check for custom fields
	*/
	if(is_single() || is_page()) :
		global $post;
		foreach($custom_key as $key) :
			$caps = get_post_meta($post->ID, $key, false);
			if(!empty($caps))
				break;
		endforeach;
	endif;

	/*
	* Check if there are any arguments set for capabilities
	*/
	if(!empty($capability)) :
		foreach($capability as $cap) :
			$caps[] = $cap;
		endforeach;
	endif;

	/*
	* Loop through each capability
	* Check if the currently logged in user has permission
	* If there are no capabilities set, check if the user is logged in
	*/
	if(!empty($caps)) :
		foreach($caps as $cap) :
			if(current_user_can($cap)) :
				$capable = true;
				break;
			else :
				$capable = false;
			endif;
		endforeach;
		return $capable;
	else :
		/*
		* If $logged_in is set to true, check
		*/
		if($logged_in) :
			if(is_user_logged_in())
				return true;
			else
				return false;
		else :
			return false;
		endif;
	endif;
}

/**
* Error output message
* Shouldn't be used much, but just in case, it's here
*
* @since 0.2
* @echo string
*/
function hybrid_error() {
	_e('You have encountered an error. This is usually because you\'ve changed something in the core Hybrid theme files. Try undoing your last edit to correct this issue. If this doesn\'t resolve it, head over to the support forums for help.','hybrid');
}

/**
* Display footnotes at the bottom of posts or pages
* Collects data from custom field key Footnote
* Only show footnotes on single posts and pages
*
* @since 0.3
* return Footnotes in an ordered list appended to bottom of post
*/
function hybrid_footnote() {
	if(is_single() || is_page()) :
		global $post;
		$footnotes = get_post_meta($post->ID, 'Footnote', false);
		if(!empty($footnotes)) :
			$content = '<ol class="footnotes">';
			$i = 1;
			foreach($footnotes as $note) :
				$content .= '<li id="footnote-' . $i . '" class="footnote-' . $i . '">' . $note . ' <a href="#f' . $i . '" class="return">&#8617;</a></li>';
				$i++;
			endforeach;
			$content .= '</ol>';
		endif;
	endif;
	//return $content;
	echo $content;
}

/**
* Function to load SimplePie correctly
* Checks for the existence of the '/cache/' folder
* Creates the folder if none exists
* Chmods the '/cache/' folder
*
* Not loaded by default (only added for use with plugins/child themes)
*
* @since 0.2.3
* @reference http://simplepie.org
*/
function hybrid_load_SimplePie() {
	if(!class_exists('SimplePie')) :
		include_once(HYBRID_EXTENSIONS . '/simplepie.inc');
		if(!file_exists(HYBRID_EXTENSIONS . '/cache/')) :
			mkdir(HYBRID_EXTENSIONS . '/cache/', 0777);	
			chmod(HYBRID_EXTENSIONS . '/cache/', 0777);
		endif;
	endif;
}

/**
* Uses SimplePie to display feeds
* Must load SimplePie before using
* Load SimplePie with hybrid_load_SimplePie()
*
* @since 0.2.3
*
* @param array $args
* Not Optional: $feed can be a single feed or an array of feeds
* All other arguments are optional
* $class = CSS class for each item, which is also iterated
* $limit = How many items to display
* $format = XHTML element to wrap around each item
* $date = How to format the date
* $cache = Cache feeds for (mins)
* $echo = echo the feeds (true) or return for use in an array (false)
*
* @reference http://simplepie.org
*/
function hybrid_lifestream($args = array()) {

	if(!$args['feed'])
		return;

	$defaults = array(
		'feed' => false, // Can be multiple feeds input by array
		'class' => 'lifestream',
		'limit' => 10,
		'format' => 'li',
		'date' => __('F jS, Y','hybrid'),
		'cache' => 60,
		'echo' => true
	);

	$r = wp_parse_args($args, $defaults);

	extract($r);

// Throw the feeds into SimplePie
	$feeds = new SimplePie($feed, HYBRID_EXTENSIONS . '/cache', 60 * $cache);
 
// Iterator
	$count = 1;

// Loop through each feed item
	foreach($feeds->get_items(0,$limit) as $item) :

	// Date
		$item_date = $item->get_date($date);
		if($stored_date != $item_date)
			$stored_date = $item_date;

	// Put together the feed item
		$output = '<' . $format . ' class="' . $class . ' '. $class . '-' . $count . '">';
		$output .= '<abbr class="published time date" title="' . $stored_date . '>' . $stored_date . '</span>: <a href="' . $item->get_permalink() . '" title="' . $item->get_title() . '">';
		$output .= $item->get_title();
		$output .= '</a></' . $format . '>';

	// Echo
		if($echo)
			echo $output;
		else
			$output_arr[] = $output;

	// Iterate
		$count++;
	endforeach;

	if(!$echo)
		return $output_arr;
}

/**
* Displays query count and load time
* Appended to the footer if set
* Option to add this from the theme settings page
*
* @since 0.2.1
* @hook wp_footer()
*/
function hybrid_query_counter() {
	global $hybrid_settings;
	if($hybrid_settings['query_counter']) :
		echo '<p class="query-count">';
		printf(__('This page loaded in %1$s seconds with %2$s database queries.', 'hybrid'), timer_stop(0,3), get_num_queries());
		echo '</p>';
	endif;
}

/**
* Returns an array of available categories
* Returns categories by name
* Most calls should use hybrid_all_cat_slugs() if possible when using query_posts()
* Addition of 'none' category for use on the theme settings page
*
* @since 0.2
* @return array
*/
function hybrid_all_cats() {
	$all_cats = get_all_category_ids();
	foreach($all_cats as $key => $value) :
		$all_cats[$key] = get_cat_name($all_cats[$key]);
		$all_cats[$key] = str_replace("&#038;", "&", $all_cats[$key]);
		$all_cats[$key] = str_replace("&amp;","&", $all_cats[$key]);
	endforeach;
	$all_cats['none'] = false;
	return $all_cats;
}

/**
* Returns an array of available category slugs
* Better for use when eventually using query_posts() by category_name
* query_posts() doesn't like non-matching names/slugs
* Addition of 'none' category for use on the theme settings page
*
* @since 0.2
* @return array
*/
function hybrid_all_cat_slugs() {
	$cats = get_categories("hierarchical=0");
	foreach($cats as $key) :
		$all_cats[] = $key->category_nicename;
	endforeach;
	$all_cats['none'] = false;
	return $all_cats;
}

/**
* Returns an array of the available tags (slugs)
* Addition of 'none' tag for use on the theme settings page
*
* @since 0.2
* @renamed 0.2.3
* @return array
*/
function hybrid_all_tag_slugs() {
	$all_tags = wp_tag_cloud('number=0&format=array');
	if($all_tags) :
		foreach($all_tags as $key => $value) :
			$value = strip_tags(stripslashes($value));
			$value = strtolower($value);
			$value = str_replace(array("&nbsp;", " "), "-", $value);
			$all_tags[$key] = $value;
		endforeach;
	endif;
	$all_tags['none'] = false;
	return $all_tags;
}

/**
* Function for handling what the browser/search engine title should be
* Tries to handle every situation to make for the best SEO
* Check for All-in-One SEO and HeadSpace2 for compatibility
*
* @since 0.1
* @plugin Optional http://wordpress.org/extend/plugins/all-in-one-seo-pack
* @plugin Optional http://wordpress.org/extend/plugins/headspace2
* @echo string
*/
function hybrid_document_title() {
	global $post, $wp_query, $hybrid_settings;
	
	/*
	* Make compatible with plugins
	* All-in-One SEO Pack
	* HeadSpace2
	*/
	if(class_exists('All_in_One_SEO_Pack') || class_exists('HeadSpace2_Admin')) :
		if(is_front_page() || is_home()) :
			echo get_bloginfo('name') . ': ' . get_bloginfo('description');
		else :
			wp_title('');
		endif;
	else :

	/*
	* Custom field Title replaces title on posts, pages
	* Custom field Subtitle appended to title on posts, pages
	*/
		if(is_single() || is_page()) :
			$title = get_post_meta($post->ID, 'Title', $single = true);
			if($title) :
				echo str_replace('"', '&quot;', stripslashes($title));
			else :
				single_post_title();
				$subtitle = get_post_meta($post->ID, 'Subtitle', $single = true);
				if($subtitle) echo ': '. str_replace('"', '&quot;', stripslashes($subtitle));
			endif;

		elseif(is_front_page() || is_home()) :
			echo bloginfo('name'); echo ": "; echo bloginfo('description');
		elseif(is_attachment()) :
			single_post_title();
		elseif(is_single()) :
			single_post_title();
		elseif(is_page()) :
			single_post_title();
		elseif(is_category()) :
			single_cat_title();
		elseif(is_tag()) :
			single_tag_title();
		elseif(is_search()) :
			echo __('Search results for','hybrid') . ' &quot;' . attribute_escape(get_search_query()) . '&quot;';
		elseif(is_day()) :
			printf(__('Archive for %1$s','hybrid'), get_the_time(__('F jS, Y','hybrid')));
		elseif(is_month()) :
			printf(__('Archive for %1$s','hybrid'), single_month_title(' ', false));
		elseif(is_year()) :
			printf(__('Archive for %1$s','hybrid'), get_the_time(__('Y','hybrid')));
		elseif(is_comments_popup()) :
			printf(__('Comment on &quot;%1$s&quot;','hybrid'), single_post_title(false,false));
		elseif(is_404()) :
			_e('404 Not Found','hybrid');
		else :
			echo wp_title('');

		endif;

	// Append blog title if set in theme settings
		if(($hybrid_settings['seo_blog_title']) && (!is_home() || !is_front_page())) :
			echo ': ' . get_bloginfo('name');
		endif;

	endif;
}

/**
* Easily create dynamic tables w/PHP
* Put strings into function for th/td
* Current functionality only allows for <th> and <td> within <tr> elements
* Needs to be updated to accomodate more uses
* Should use an array of arguments, then be parsed with wp_parse_args()
*
* @since 0.1
* @echo XHTML
*/
function tabular_data($tabular_data_header = false, $tabular_data = false) {

	echo '<table>';
		if($tabular_data_header) echo '<tr>';

			foreach($tabular_data_header as $header) :
				echo '<th>' . $header . '</th>';
			endforeach;

		if($tabular_data_header) echo '</tr>';

			$tr_class = 'odd';

			foreach($tabular_data as $data) :

				echo '<tr class="' . $tr_class . '">';
					foreach($data as $value) :
						echo '<td>' . $value . '</td>';
					endforeach;
				echo '</tr>';

				if($tr_class == 'odd') $tr_class = 'even alt';
				else $tr_class = 'odd';

			endforeach;
	echo '</table>';
}

/**
* Returns all authors with posts
* Needed for use with the Authors page template
*
* @since 0.2.2
*
* @param array $args Mixed arguments (currently can only change order_by)
* @return array Authors with posts
*/
function hybrid_get_authors($args = array()) {
	global $wpdb;

	/*
	* Set up defaults and mix with $args
	*/
	$defaults = array(
		'order_by' => 'display_name',
	);

	$args = wp_parse_args($args, $defaults);
	extract($args);

	$user_ids = $wpdb->get_results("SELECT COUNT(b.ID) AS postsperuser, a.ID as post_id, display_name, user_nicename, b.ID as ID FROM wp_posts AS a LEFT join wp_users AS b ON a.post_author = b.ID GROUP BY b.ID ORDER BY $order_by");
	return $user_ids;
}
?>