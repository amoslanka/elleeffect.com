<?php
if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) { die(); }

/* ========================================
   Master List, Actions & Hooks
   ======================================== */

$bits = array("before_doc", "before_page", "before_hd", "before_bd", "before_ft", "after_ft", "after_page", "after_doc", "before_utility_grid", "after_utility_grid", "widget_header_nav_before", "widget_header_nav_after", "widget_header_before", "widget_header_after", "widget_main_menu_before", "widget_main_menu_after", "widget_sub_menu_before", "widget_sub_menu_after", "widget_breadcrumbs_before", "widget_breadcrumbs_after", "widget_content_top_before", "widget_content_top_after", "widget_content_middle_before", "widget_content_middle_after", "widget_content_bottom_before", "widget_content_bottom_after", "widget_primary_sidebar_before", "widget_primary_sidebar_after", "widget_secondary_sidebar_before", "widget_secondary_sidebar_after", "widget_utility_1_before", "widget_utility_1_after", "widget_utility_2_before", "widget_utility_2_after", "widget_utility_3_before", "widget_utility_3_after", "widget_utility_4_before", "widget_utility_4_after", "widget_footer_nav_before", "widget_footer_nav_after", "widget_footer_before", "widget_footer_after", "widget_front_page_1_before", "widget_front_page_1_after", "widget_front_page_2_before", "widget_front_page_2_after");

foreach ($bits as $bit) {
	$safebit = str_replace("'", '&rsquo;', stripslashes(get_option('vnl_' . $bit)));
	eval("function option_" . $bit . "() { echo('" . $safebit . "'); }");
	
	// action
	eval("add_action('vanilla_" . $bit . "', 'option_" . $bit . "');");
	
	// hook
	eval("function vanilla_" . $bit . "() { do_action('vanilla_" . $bit . "'); }");
}



// Carrington Sidebars Top
function ct_sidebars_top() {
	$set = vanilla_get_option('vnl_tpl_set').'-set/';
	include_once(CFCT_PATH.$set.'carrington-sidebar-top.php');
}
add_action('vanilla_widget_breadcrumbs_after', 'ct_sidebars_top');

// Accessibility
function vanilla_accessibility_link() {
?>
		<p id="top"><a id="to-content" href="#content" title="<?php _e( 'Skip to content', 'sandbox' ) ?>"><?php _e( 'Skip to content', 'carrington' ); ?></a></p>
<?php
}
add_action('vanilla_before_hd' , 'vanilla_accessibility_link');

// Produces a clean list of pages in the header Ñ thanks to Scott Wallick and Andy Skelton.
function sandbox_globalnav() {
	$menu = '<div id="menu"><ul>';
	$menu .= str_replace( array( "\r", "\n", "\t" ), '', wp_list_pages('title_li=&sort_column=menu_order&echo=0') );
	$menu .= "</ul></div>\n";
	echo apply_filters( 'sandbox_menu', $menu ); // Filter to override default globalnav
}

// Information in Post Header
function vanilla_postheader() {
    global $id, $post, $authordata;

    // Create $posteditlink    
    $posteditlink .= '<a href="' . get_bloginfo('wpurl') . '/wp-admin/post.php?action=edit&post=' . $id;
    $posteditlink .= '" title="' . __('Edit post', 'thematic') .'" class="edit-link">';
    $posteditlink .= __('Edit', 'thematic') . '</a>';
    
    if (is_single() || is_page()) {
        $posttitle = '<h1 class="entry-title">' . get_the_title() . "</h1>\n";
    } elseif (is_404()) {    
        $posttitle = '<h1 class="entry-title">' . __('Not Found', 'thematic') . "</h1>\n";
    } else {
        $posttitle = '<h2 class="entry-title"><a href="';
        $posttitle .= get_permalink();
        $posttitle .= '" title="';
        $posttitle .= __('Permalink to ', 'thematic') . the_title_attribute('echo=0');
        $posttitle .= '" rel="bookmark">';
        $posttitle .= get_the_title();   
        $posttitle .= "</a></h2>\n";
    }
    
    $postmeta = '<div class="entry-meta">';
    
    // Display edit link
    if (current_user_can('edit_posts')) {
        $postmeta .= $posteditlink;
    }
    
    $postmeta .= '<em>'. __('by', 'thematic') . '</em> ';
    $postmeta .= '<span class="author vcard"><a class="url fn n" href="';
    $postmeta .= get_author_link(false, $authordata->ID, $authordata->user_nicename);
    $postmeta .= '" title="' . __('View all posts by ', 'thematic') . get_the_author() . '">';
    $postmeta .= get_the_author();
    $postmeta .= "</a></span>\n";
    
    // Display the post category/ies
    if ( !is_category() ) { 
        $postmeta .= '<span class="cat-links"><em>' . __('in', 'thematic') . '</em> ';
        $postmeta .= get_the_category_list(', ') . "</span>\n";
    }
    
    $postmeta .= '<em>'. __('on', 'thematic') . '</em> ';
    $postmeta .= '<span class="entry-date"><abbr class="published" title="';
    $postmeta .= get_the_time('Y-m-d\TH:i:sO') . '">';
    $postmeta .= the_date('', '', '', false);
    $postmeta .= '</abbr></span>';
    
    $postmeta .= "</div><!-- .entry-meta -->\n";
    
    if ($post->post_type == 'page' || is_404()) {
        $postheader = $posttitle;        
    } else {
        $postheader = $posttitle . $postmeta;    
    }
    
    echo apply_filters( 'vanilla_postheader', $postheader ); // Filter to override default post header
}

// Information in Post Footer
function vanilla_postfooter() {
    global $id, $post;
    
    // Display the tags
    if (is_single()) {
        $tagtext = __(' and tagged', 'thematic');
        $posttags = get_the_tag_list("<span class=\"tag-links\"> $tagtext ",', ','</span>');
    } elseif ( is_tag() && $tag_ur_it = sandbox_tag_ur_it(', ') ) { /* Returns tags other than the one queried */
        $posttags = '<span class="tag-links">' . __(' Also tagged ', 'thematic') . $tag_ur_it . '</span> <span class="meta-sep">|</span>';
    } else {
        $tagtext = __('Tagged', 'thematic');
        $posttags = get_the_tag_list("<span class=\"tag-links\"> $tagtext ",', ','</span> <span class="meta-sep">|</span>');
    }
    
    // Display comments link and edit link
    $postcomments = ' <span class="comments-link"><span class="bracket">{</span>';
    
    if (comments_open()) {
        $postcommentnumber = get_comments_number();
        if ($postcommentnumber != '1') {
            $postcomments .= ' <a href="' . get_permalink() . '#comments" title="' . __('Comment on ', 'thematic') . the_title_attribute('echo=0') . '">';
            $postcomments .= '<span>' . get_comments_number() . '</span>' . __(' comments', 'thematic') . '</a>';
        } else {
            $postcomments .= ' <a href="' . get_permalink() . '#comments" title="' . __('Comment on ', 'thematic') . the_title_attribute('echo=0') . '">';
            $postcomments .= '<span>' . get_comments_number() . '</span>' . __(' comment', 'thematic') . '</a>';
        }
    } else {
        $postcomments .= __('Comments closed', 'thematic');
    }
    $postcomments .= ' <span class="bracket">}</span></span>';             
    
    // Display permalink, comments link, and RSS on single posts
    $postconnect .= __('. Bookmark the ', 'thematic') . '<a href="' . get_permalink() . '" title="' . __('Permalink to ', 'thematic') . the_title_attribute('echo=0') . '">';
    $postconnect .= __('permalink', 'thematic') . '</a>.';
    if (('open' == $post-> comment_status) && ('open' == $post->ping_status)) { /* Comments are open */
        $postconnect .= ' <a class="comment-link" href="#respond" title ="' . __('Post a comment', 'thematic') . '">' . __('Post a comment', 'thematic') . '</a>';
        $postconnect .= __(' or leave a trackback: ', 'thematic');
        $postconnect .= '<a class="trackback-link" href="' . trackback_url(FALSE) . '" title ="' . __('Trackback URL for your post', 'thematic') . '" rel="trackback">' . __('Trackback URL', 'thematic') . '</a>.';
    } elseif (!('open' == $post-> comment_status) && ('open' == $post->ping_status)) { /* Only trackbacks are open */
        $postconnect .= __(' Comments are closed, but you can leave a trackback: ', 'thematic');
        $postconnect .= '<a class="trackback-link" href="' . trackback_url(FALSE) . '" title ="' . __('Trackback URL for your post', 'thematic') . '" rel="trackback">' . __('Trackback URL', 'thematic') . '</a>.';
    } elseif (('open' == $post-> comment_status) && !('open' == $post->ping_status)) { /* Only comments open */
        $postconnect .= __(' Trackbacks are closed, but you can ', 'thematic');
        $postconnect .= '<a class="comment-link" href="#respond" title ="' . __('Post a comment', 'thematic') . '">' . __('post a comment', 'thematic') . '</a>.';
    } elseif (!('open' == $post-> comment_status) && !('open' == $post->ping_status)) { /* Comments and trackbacks closed */
        $postconnect .= __(' Both comments and trackbacks are currently closed.', 'thematic');
    }
    // Display edit link on single posts
    if (current_user_can('edit_posts')) {
        $postconnect .= ' ' . $posteditlink;
    }
    
    // Add it all up
    $postfooter = '<div class="entry-utility">';
    if ($post->post_type == 'page' && current_user_can('edit_posts')) { /* For logged-in "page" search results */
        $postfooter .= $posteditlink;    
    } elseif ($post->post_type == 'page') { /* For logged-out "page" search results */
        // nothing
    } else {
        if (is_single()) {
            $postfooter .= $posttags . $postconnect;
        } else {
            $postfooter .= $posttags . $postcomments;
        }
    }
    $postfooter .= "</div><!-- .entry-utility -->\n";
    
    // Put it on the screen
    echo apply_filters( 'vanilla_postfooter', $postfooter ); // Filter to override default post footer
}

?>