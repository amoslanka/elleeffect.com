<?php

/**
* Replicates the wp_logout_url() function from 2.7
*
* @since 0.3
*/
if(!function_exists('wp_logout_url')) :

	function wp_logout_url($redirect = false) {
		$log_out = get_option('siteurl') . '/wp-login.php?action=logout';
		if($redirect) $log_out .= '&amp;redirect_to=' . $redirect;
		return $log_out;
	}

endif;

/**
* Replicates the wp_page_menu() function from WP 2.7
*
* @since 0.3
*/
if(!function_exists('wp_page_menu')) :

	function wp_page_menu( $args = array() ) {

		$defaults = array('sort_column' => 'post_title', 'menu_class' => 'menu', 'echo' => true, 'link_before' => '', 'link_after' => '');
		$args = wp_parse_args( $args, $defaults );
		$args = apply_filters( 'wp_page_menu_args', $args );

		$menu = '';

	// Show Home in the menu
		if ( !empty($args['show_home']) ) {
			if ( true === $args['show_home'] || '1' === $args['show_home'] || 1 === $args['show_home'] )
				$text = __('Home');
			else
				$text = $args['show_home'];
			$class = '';
			if ( is_home() && !is_paged() )
				$class = 'class="current_page_item"';
			$menu .= '<li ' . $class . '><a href="' . get_option('home') . '">' . $link_before . $text . $link_after . '</a></li>';
		}

		$list_args = $args;
		$list_args['echo'] = false;
		$list_args['title_li'] = '';
		$menu .= str_replace( array( "\r", "\n", "\t" ), '', wp_list_pages($list_args) );

		if ( $menu )
			$menu = '<ul>' . $menu . '</ul>';

		$menu = '<div id="' . $args['menu_class'] . '">' . $menu . "</div>\n";
		$menu = apply_filters( 'wp_page_menu', $menu, $args ); 
		if ( $args['echo'] )
			echo $menu;
		else
			return $menu;
	}

endif;

?>