<?php


global $wp_registered_sidebars, $wp_registered_widgets, $wp_registered_widget_controls;



if(!isset($_GET['id']) || empty($wp_registered_widgets[$_GET['id']]))
	
	echo '<div class="error"><p><strong>Error! Could not find widget.</strong></p></div>';
	
else {
	
	if(isset($_GET['reset_widget'])){
		
		$this->widgets[$_GET['id']] = $this->info['blank'];
		
		update_option(slayer_widgets,$this->widgets);
		
		}
	
	$url = $this->info['admin_url'] . '&amp;act=edit&amp;id=' . $_GET['id'];
	
	$widget = &$wp_registered_widgets[$_GET['id']];
	
	if(!empty($_GET['opt'])){
	
		echo '<h2><a href="', $this->info['admin_url'] ,'">Custom widgets</a> &raquo; <a href="',$url,'">', $widget['name'], '</a> &raquo; ' , $_GET['opt'] ,'</h2>';
		
		require(dirname(__FILE__) . '/show_in_' . $_GET['opt'] . '.php');
		
		}
		
	else
		{
		
		echo '<h2><a href="', $this->info['admin_url'] ,'">Custom widgets</a> &raquo; ', $widget['name'],'</h2>';
		
		echo '<table class="form-table">';
			echo '<tr>';
				echo '<th scope="row" style="width:200px;">';
					echo '<h3>Options</h3>';
					echo '<div style="font-weight:normal;margin-bottom:20px;">Select where do you want this specific widget to show:</div>';
					
					echo '<ul style="margin:0px;padding:0px;font-weight:normal;list-style-position:inside;">';
						echo '<li><strong>Posts</strong>: will only show if the user is viewing one of the posts in the list</li>';
						echo '<li><strong>Pages</strong>: will only show if the user is viewing one of the pages in the list</li>';
						echo '<li><strong>Categories</strong>: will only show if the user is viewing one of the categories in the list or a post that was filed under one of the specified categories.</li>';
						echo '<li><strong>Tags</strong>: will only show if the user is viewing the specified tags page.</li>';
echo '<li><strong>Authors</strong>: will only show if the user is viewing a page or post which was written by the specified author.</li>';
					echo '</ul>';
					
					echo '<br /><a class="button" onclick="if(!confirm(\'Are you sure you want to reset this widget?\')) return false;" href="',$url,'&amp;reset_widget">Reset this widget</a>';
					
				echo '</th>';
				echo '<td>';
					echo '<ul class="metabox-holder">';
						
						if(empty($this->widgets[$_GET['id']]))	
							$this->widgets[$_GET['id']] = $this->info['blank'];
						
						$has_limit = false;
						
						foreach($this->widgets[$_GET['id']] as $group => $data )
							if(!empty($data))
								if($group != 'opts')
									$has_limit = true;
								else
									foreach($data as $opt)
										if(!empty($opt)){
											$has_limit = true;
											break;
											}
						
						foreach($this->info['blank'] as $group => $data )
							if($group != 'opts') {
							
							$data = $this->widgets[$_GET['id']][$group];
							
							echo '<li style="float:left; margin-right:2em;"><div class="postbox">';
							
								echo '<h3 class="hndle">', $group ,' (<a href="',$url,'&amp;opt=', $group ,'">Edit</a>)</h3>';
								
								echo '<div class="inside" style="padding: 0 1em;"><ul>';
									
									$i = 0;
									
									if(!$data)
										echo '<li>', $has_limit ? 'none' : 'all' ,'</li>';
									else
										foreach($data as $name){
										
											echo '<li><strong>' , ++$i , '.</strong> ' ;
											
												echo $name;
											
											echo '</li>';
										
											}
								echo '</ul></div>';
								
							echo '</div></li>';
							
							}
					
					echo '</ul>';
					
							
					echo '<form action="" method="post" style="clear:both;" class="metabox-holder"><div id="rbet_extended" class="postbox">';
						
						echo '<h3 class="hndle" style="margin:0;">Extended features (assign a widget to a specific WP template)';
							
							echo '<span class="rbet_tip_img">';
								echo '<a class="link" onclick="return false;" href="', $v['url'] ,'"></a>';
								echo '<span class="rbet_tip">';
										echo 'The Conditional Tags can be used in your Template files to change what content is displayed and how that content is displayed on a particular page.';
									echo '</span>';
							echo '</span>';
							
						echo '</h3>';
						
						
						$data = array(
								
							'is_home' => array(
									'title' => 'Show Widget Only on Homepage',
									'url' => 'http://codex.wordpress.org/Conditional_Tags#The_Main_Page',
									'tip' => 'The widget is shown only on your blog\'s homepage using the <a onclick="window.open(this.href); return false;" href="http://codex.wordpress.org/Conditional_Tags#The_Main_Page">is_home()</a> tag',
									),
							'is_single' => array(
									'title' => 'Show Widget on all posts',
									'url' => 'http://codex.wordpress.org/Conditional_Tags#A_Single_Post_Page',
									'tip' => 'The widget is shown when any post is displayed using the <a onclick="window.open(this.href); return false;" href="http://codex.wordpress.org/Conditional_Tags#A_Single_Post_Page">is_single()</a> tag',
									),
							'is_sticky' => array(
									'title' => 'Show Widget only on Sticky posts',
									'url' => 'http://codex.wordpress.org/Conditional_Tags#A_Sticky_Post',
									'tip' => 'The widget is shown when any stickied page is displayed using the <a onclick="window.open(this.href); return false;" href="http://codex.wordpress.org/Conditional_Tags#A_Sticky_Post">is_sticky()</a> tag'
									),
							'comments_open' => array(
									'title' => 'Show Widget on Posts/pages Where commenting is open',
									'url' => 'http://codex.wordpress.org/Conditional_Tags#Any_Page_Containing_Posts',
									'tip' => 'The widget is shown when any post is displayed where commenting is possible using the <a onclick="window.open(this.href); return false;" href="http://codex.wordpress.org/Conditional_Tags#Any_Page_Containing_Posts">comments_open()</a> tag'
									),
							'is_page' => array(
									'title' => 'Show widget on all pages',
									'url' => 'http://codex.wordpress.org/Conditional_Tags#A_PAGE_Page',
									'tip' => 'The widget is shown when any page is displayed using the <a onclick="window.open(this.href); return false;" href="http://codex.wordpress.org/Conditional_Tags#A_PAGE_Page">is_page()</a> tag'
									),
						
							'is_category' => array(
									'title' => 'Show widget on all Categories',
									'url' => 'http://codex.wordpress.org/Conditional_Tags#A_Category_Page',
									'tip' => 'The widget is shown when any category is displayed using the <a onclick="window.open(this.href); return false;" href="http://codex.wordpress.org/Conditional_Tags#A_Category_Page">is_category()</a> tag'
									),
							'is_tag' => array(
									'title' => 'Show widget on all Tag Pages',
									'url' => 'http://codex.wordpress.org/Conditional_Tags#A_Tag_Page',
									'tip' => 'The widget is shown when any Tag page is displayed using the <a onclick="window.open(this.href); return false;" href="http://codex.wordpress.org/Conditional_Tags#A_Tag_Page">is_tag()</a> tag'
									),
							'is_archive' => array(
									'title' => 'Show widget on all Archive pages',
									'url' => 'http://codex.wordpress.org/Conditional_Tags#Any_Archive_Page',
									'tip' => 'The widget is shown when any type of Archive page is displayed using the <a onclick="window.open(this.href); return false;" href="http://codex.wordpress.org/Conditional_Tags#Any_Archive_Page">is_archive()</a> tag'
									),
							'is_search' => array(
									'title' => 'Show widget on Search results',
									'url' => 'http://codex.wordpress.org/Conditional_Tags#A_Search_Result_Page',
									'tip' => 'The widget is shown on all search results using the <a onclick="window.open(this.href); return false;" href="http://codex.wordpress.org/Conditional_Tags#A_Search_Result_Page">is_search()</a> tag'
									),
							'is_404' => array(
									'title' => 'Show widget on the 404 - Not found Error Page',
									'url' => 'http://codex.wordpress.org/Conditional_Tags#A_404_Not_Found_Page',
									'tip' => 'The widget is shown on the 404 - Not found error page using the <a onclick="window.open(this.href); return false;" href="http://codex.wordpress.org/Conditional_Tags#A_404_Not_Found_Page">is_404()</a> tag'
									),
							'is_preview' => array(
									'title' => 'Show Widget for admin previews',
									'url' => 'http://codex.wordpress.org/Conditional_Tags#A_Preview',
									'tip' => 'The widget is shown when a single post being displayed is viewed in Draft mode using the <a onclick="window.open(this.href); return false;" href="http://codex.wordpress.org/Conditional_Tags#A_Preview">is_preview()</a>  tag'
									)
							);
						
						
						echo '<table class="rbet_checkbox">';
						
							$i = 1 ;
							echo '<tr>';
							
							foreach($data as $id => $v){
								
								//if($i === true)	echo '</tr><tr>';
								
								echo '<tr><td><label>';
									echo '<input ', !empty($this->widgets[$_GET['id']]['opts'][$id]) ? 'checked="checked"' : false ,' type="checkbox" name="opt[',$id,']" value="1" /> ', $v['title'];
									echo '<span class="rbet_tip_img">';
										echo '<a class="link" onclick="return false;" href="', $v['url'] ,'"></a>';
										echo '<span class="rbet_tip">';
											echo $v['tip'];
										echo '</span>';
									echo '</span>';
								echo '</label></td></tr>';
								
								//$i = $i ? false : true;
								
								}/*
							if($i)	echo '<td></td>';
							echo '</tr>';
							*/
						echo '</table>';
						
						echo '<input type="hidden" name="act" value="save_ext" />';
						
						echo '<p class="submit" style="padding:1em 2em;"><input type="submit" value="Save Changes" class="button-primary" /></p>';
						
					echo '</div></form>';
					
				echo '</td>';
			
			echo '</tr>';
		
		echo '</table>';
		
		} 
	
	echo '<script type="text/javascript">//<!--' , "\n" , file_get_contents(dirname(__FILE__) . '/javascript.js') , '//--></script>';
	
	} 
	

?>