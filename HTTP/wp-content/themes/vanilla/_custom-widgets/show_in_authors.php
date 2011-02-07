<?php 

$url .= '&amp;opt='. $_GET['opt'] . '&amp;author_pag=' . ( $_GET['author_pag']  = ( !empty($_GET['author_pag']) ? $_GET['author_pag'] : 0 ) );

if(!empty($_GET['delete_author']) && isset($this->widgets[$_GET['id']]['authors'][$_GET['delete_author']])){
	
	unset($this->widgets[$_GET['id']]['authors'][$_GET['delete_author']]);
	
	update_option('slayer_widgets', $this->widgets);
	
	}

echo '<table class="slayer_main_table">';
	
	echo '<tr>';
	
		echo '<td style="width:50%;" valign="top">';
		
			echo '<h2>Show in posts with the folowing authors</h2>';
			
			echo '<ul class="slayer_post_list">';
				
				if(empty($this->widgets[$_GET['id']]['authors']))
					echo '<li>all</li>';
				else
					{
					
					foreach($this->widgets[$_GET['id']]['authors'] as $id => $title){
						
						echo '<li><a onclick="if(!confirm(\'Are you sure you want to remove this author from the list?\')) return false;" href="', $url , '&amp;delete_author=' , $id ,'">', $title ,'</a></li>';
						
						}
					
					}
			
			echo '</ul>';
			
			echo 'Click a author to remove it.';
		
		echo '</td>';
		
		
		echo '<td valign="top">';
			echo '<form action="', $url ,'" method="post">';
			echo '<table class="widefat" style="width:100%;">';
				echo '<thead>';
					echo '<tr>';
						echo '<th class="check-column check-column-controller" scope="col"><input type="checkbox"/></th>';
						echo '<th scope="col">Post title</th>';
					echo '</tr>';
				echo '</thead>';
				
				echo '<tbody>';
					
					$authors = get_users_of_blog();
					
					$alternative = true;
					
					foreach($authors as $author){
						
						if($alternative)	$alternative = false;
						else				$alternative = true;
						
						echo '<tr class="', $alternative ? 'alternate':false ,' author-self status-publish">';
							
							echo '<th class="check-column"><input name="authors[]" ', isset($this->widgets[$_GET['id']]['authors'][$author->user_id]) ? 'checked="checked"' : false ,' type="checkbox" value="', $author->user_id ,'_', $author->display_name ,'" /></th>';
							
							echo '<td>', $author->display_name ,'</td>';
						
						echo '</tr>';
						
						}
				echo '</tbody>';
			
			echo '</table>';
			
			echo '<p class="submit" style="clear:both;margin-top:25px;">';
				echo '<input type="submit" value="&laquo; Add selected authors" />';
			echo '</p>';
			echo '</form>';
		echo '</td>';
	
	echo '</tr>';

echo '</table>';

?>