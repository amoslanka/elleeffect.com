<?php

global $wp_registered_sidebars, $wp_registered_widgets, $wp_registered_widget_controls;


// Compute current admin sub-page
$_POST['act'] = !empty($_POST['act']) ? $_POST['act'] : (!empty($_GET['act']) ? $_GET['act'] : false );


// Do action
switch($_POST['act']){
	
	default:
		// Default action | Save main plugin options
		
		echo '<div class="updated"><p><strong>', _e('Options saved.', 'mt_trans_domain' ) ,'</strong></p></div>';
		
			
		break;
	
	case 'save_ext':
		
		if(isset($_GET['id']) && !empty($wp_registered_widgets[$_GET['id']])){
			
			if(empty($this->widgets[$_GET['id']]))	$this->widgets[$_GET['id']] = $this->info['blank'];
			
			$opts = array('is_home', 'is_single', 'is_sticky', 'comments_open', 'is_page', 'is_category', 'is_tag', 'is_archive', 'is_search', 'is_404', 'is_preview');
			
			foreach($opts as $opt)
				$this->widgets[$_GET['id']]['opts'][$opt] = isset($_POST['opt'][$opt]);
			
			update_option('slayer_widgets', $this->widgets);
			
			echo '<div class="updated"><p><strong>', _e('Options saved.', 'mt_trans_domain' ) ,'</strong></p></div>';
			
			}
				
		
		break;
	
	case 'edit':
		
		if(isset($_GET['id']) && !empty($wp_registered_widgets[$_GET['id']])){
			
			if(empty($this->widgets[$_GET['id']]))	$this->widgets[$_GET['id']] = $this->info['blank'];
			
			if(!empty($_POST['posts'])){
				
				foreach($_POST['posts'] as $post){
					
					$title = explode('_', $post);
					$id = array_shift($title);
					$title = implode('_', $title);
					
					$this->widgets[$_GET['id']]['posts'][$id] = $title;
					
					}
				
				}
			
			if(!empty($_POST['authors'])){
				foreach($_POST['authors'] as $author){
					
					$title = explode('_', $author);
					$id = array_shift($title);
					$title = implode('_', $title);
					
					$this->widgets[$_GET['id']]['authors'][$id] = $title;
					
					}
				
				}

			if(!empty($_POST['pages'])){
				
				foreach($_POST['pages'] as $post){
					
					$title = explode('_', $post);
					$id = array_shift($title);
					$title = implode('_', $title);
					
					$this->widgets[$_GET['id']]['pages'][$id] = $title;
					
					}
				
				}
				
				
			if(!empty($_POST['categories'])){
				
				foreach($_POST['categories'] as $post){
					
					$title = explode('_', $post);
					$id = array_shift($title);
					$title = implode('_', $title);
					
					$this->widgets[$_GET['id']]['categories'][$id] = $title;
					
					}
				
				}
				
				
			if(!empty($_POST['tags'])){
				
				foreach($_POST['tags'] as $post){
					
					$title = explode('_', $post);
					$id = array_shift($title);
					$title = implode('_', $title);
					
					$this->widgets[$_GET['id']]['tags'][$id] = $title;
					
					}
				
				}
				
			
			
			update_option('slayer_widgets', $this->widgets);
			
			
			echo '<div class="updated"><p><strong>Widget saved</strong></p></div>';
			
			
			}

		break;
		

	}


?>