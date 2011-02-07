<?php

$url .= '&amp;opt='. $_GET['opt'] . '&amp;page_pag=' . ( $_GET['page_pag']  = ( !empty($_GET['page_pag']) ? $_GET['page_pag'] : 0 ) );
	
if(!empty($_GET['delete_page']) && isset($this->widgets[$_GET['id']]['pages'][$_GET['delete_page']])){
	
	
	unset($this->widgets[$_GET['id']]['pages'][$_GET['delete_page']]);
	
	update_option('slayer_widgets', $this->widgets);
	
	}



echo '<table class="slayer_main_table">';
	
	echo '<tr>';
	
		echo '<td style="width:50%;" valign="top">';
		
			echo '<h2>Show in Pages</h2>';
			
			echo '<ul class="slayer_post_list">';
				
				if(empty($this->widgets[$_GET['id']]['pages']))
					echo '<li>', !empty($this->widgets[$_GET['id']]['posts']) || !empty($this->widgets[$_GET['id']]['cats']) ? 'none' : 'all' ,'</li>';
				else
					{
					foreach($this->widgets[$_GET['id']]['pages'] as $id => $title){
						
						echo '<li><a onclick="if(!confirm(\'Are you sure you want to remove this post from the list?\')) return false;" href="', $url , '&amp;delete_page=' , $id ,'">', $title ,'</a></li>';
						
						}
					
					}
			
			echo '</ul>';
			
			echo 'Click a post to remove it.';
		
		echo '</td>';
		
		
		echo '<td valign="top">';
			echo '<form action="', $url ,'" method="post">';
			echo '<table class="widefat" style="width:100%;">';
				echo '<thead>';
					echo '<tr>';
						echo '<th class="check-column check-column-controller" scope="col"><input type="checkbox"/></th>';
						echo '<th scope="col">Page title</th>';
					echo '</tr>';
				echo '</thead>';
				
				echo '<tbody>';
					
					$posts = get_posts(array(
						'numberposts'	=> $this->info['posts_per_page'],
						'offset'		=> $_GET['page_pag'] * $this->info['posts_per_page'],
						'post_type' 	=> 'page'
						));
					
					//alert($posts);
					
					$alternative = true;
					
					foreach($posts as $post){
						
						//alert($post);
						if($alternative)	$alternative = false;
						else				$alternative = true;
						
						echo '<tr class="', $alternative ? 'alternate':false ,' author-self status-publish">';
							
							echo '<th class="check-column"><input name="pages[]" ', isset($this->widgets[$_GET['id']]['pages'][$post->ID]) ? 'checked="checked"' : false ,' type="checkbox" value="', $post->ID ,'_', $post->post_title ,'" /></th>';
							
							echo '<td>',$post->post_title,'</td>';
						
						echo '</tr>';
						
						}
				echo '</tbody>';
			
			echo '</table>';
			
			$num_posts = wp_count_posts( 'page', 'readable' );
			
			$num_posts = $num_posts->publish;
			
			
			if( $_GET['page_pag']+1 < ($num_posts / $this->info['posts_per_page']) )
				echo '<a style="float:left;" href="', str_replace( '&amp;page_pag='.$_GET['page_pag'],'&amp;page_pag='.($_GET['page_pag']+1),$url) ,'">&laquo; Older Entries</a>';
			
			if($_GET['page_pag'])
				echo '<a style="float:right;" href="', str_replace('&amp;page_pag='.$_GET['page_pag'],'&amp;page_pag='.($_GET['page_pag']-1),$url) ,'">Newer Entries &raquo;</a>';
			
			echo '<p class="submit" style="clear:both;margin-top:25px;">';
				echo '<input type="submit" value="&laquo; Add selected pages" />';
			echo '</p>';
			echo '</form>';
		echo '</td>';
	
	echo '</tr>';

echo '</table>';



?>