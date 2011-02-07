<?php
/*
Description:  This plugin enables you to select which widgets appear on specific posts, pages, categories,author's posts and tag pages. By default, all widgets appear wherever the sidebar is loaded within your theme. With this plugin, you can configure where widgets are displayed on a per post or per <a href="http://codex.wordpress.org/Conditional_Tags" target ="_blank">WP Template</a>(Using conditional Tags) basis.
Author: ThaSlayer
Version: 1.2
Author URI: http://www.thaslayer.com/
*/



	
	/*
	 * 
	 * PHP Code by mucenica.bogdan@yahoo.com for ThaSlayer | Romania 2008
	 *
	 *
	 * Creation date: October 14, 2008
	 * Revision date: October 30, 2008
	 *
	*/

class slayer_Custom_widgets{
	
	
	/*
	 * Contains information regarding the plugin
	 * 
	 * access public
	 * type: array
	 *
	*/
	var $info;
	
	
	
	/*
	 * Object constructor
	 *
	*/
	function slayer_Custom_widgets(){
		
		// Initialization
		
		
		// Main plugin options
		$this->info = array(
			'admin_url'			=> '?page=' . (!empty($_GET['page']) ? $_GET['page'] : false),
			'dir'				=> array_pop(explode("/", str_replace("\\", "/", dirname(__FILE__)))),
			'posts_per_page'	=> 10,
			'blank'				=> array(
									'posts'			=> array(),
									'pages'			=> array(),
									'categories'	=> array(),
									'tags'			=> array(),
									'authors'		=> array(),
									'opts'			=> array()
								)
			);
		
		if(isset($_GET['reset_widgets']))
			update_option(slayer_widgets,array());
		
		// Compute option page link
		$this->info['url'] =  get_bloginfo('template_directory') . '/' . $this->info['dir'];
		
		
		// Compute plugin images link
		$this->info['images'] = $this->info['url'] . '/images';
		
		$this->widgets = get_option('slayer_widgets');
		$this->widgets = $this->widgets ? $this->widgets : array();
		
		add_action('get_header',	array(&$this, 'init'));
		add_action('admin_head', 	array(&$this, 'add_admin_css'));
		add_action('admin_menu', 	array(&$this, 'add_admin_menu'));
		
		}
	
	
	/*
	 * Style admin panel page through CSS head inseriton
	 * 
	*/
	function add_admin_css(){
		
		echo '<style type="text/css">';
			require( dirname(__FILE__) .'/admin_css.php');
		echo '</style>';
		
		}
	
	
	/*
	 * Add new submeniu under the admin settings page
	 * 
	*/
	function add_admin_menu() {
	    
	    //add_options_page('Custom widgets', 'Custom widgets', 8, __FILE__ , array(&$this, 'admin_page'));
		add_theme_page("Custom Widgets", "Custom Widgets", 8, basename(__FILE__), array(&$this, 'admin_page'));
	}

	
	/*
	 * Render admin page controllers
	 * 
	*/
	function admin_page() {
		// If data was sent through POST, process it
		if(!empty($_POST))
			require(dirname(__FILE__) . '/admin_actions.php');
			
		// Compute current admin sub page
		$_GET['act'] = !empty($_GET['act']) ? $_GET['act'] : 'main';
		
		// Find current page
		if(!file_exists( $f = dirname(__FILE__) . '/admin_template_' . $_GET['act'] . '.php' ))	{
			$_GET['act'] = 'main';
			$f = dirname(__FILE__) . '/admin_template_' . $_GET['act'] . '.php';
			}
		
		//Render current page
		
		echo '<div class="wrap">';
		
			require($f);
		
		echo '</div>';

		}

	
	/*
	 * Initialize the plugin
	 * 
	*/
	function init(){
		
		global $wp_registered_widgets;
		
		foreach($this->widgets as $id => $data){
			
			$keep = false;
			
			if(!empty($data['opts']))
				foreach($data['opts'] as $opt => $bool)
					if($bool && $opt())
						$keep = true;
			
			
			if(is_single()){
				
				global $post;
				
				$categories = get_the_category($post->ID);
				if($categories)
					foreach( $categories as $category )
						if(isset($data['categories'][$category->term_id]))
							$keep = true;
				
				if(!empty($data['authors'][$post->post_author]))
					$keep = true;
				
				$tags = get_the_tags($post->ID);
				if($tags)
					foreach( $tags as $tag )
						if(isset($data['tags'][$tag->term_id]))
							$keep = true;
				
				if(isset($data['posts'][$post->ID]))
					$keep = true;
				
				}
				
			if(is_page()){
				
				global $post;
				
				if(isset($data['pages'][$post->ID]))
					$keep = true;
				}
			
			if(is_category()){
				
				if(isset($data['categories'][get_query_var('cat')]))
					$keep = true;
				
				}
			
			if(is_tag()){
				
				if(is_array($data['tags']) && in_array(get_query_var('tag'), $data['tags']))
					$keep = true;
				
				}
			
			if(!$keep)
				unset($wp_registered_widgets[$id]);
			
			}
		
		}
	
		
	}


new slayer_Custom_widgets;



// I'm done :)



?>