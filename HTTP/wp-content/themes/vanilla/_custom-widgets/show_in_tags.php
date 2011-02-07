<?php

$url .= '&amp;opt='. $_GET['opt'] . '&amp;tags_pag=' . ( $_GET['tags_pag']  = ( !empty($_GET['tags_pag']) ? $_GET['tags_pag'] : 0 ) );

if(!empty($_GET['delete_tag']) && isset($this->widgets[$_GET['id']]['tags'][$_GET['delete_tag']])){
	
	
	unset($this->widgets[$_GET['id']]['tags'][$_GET['delete_tag']]);
	
	update_option('slayer_widgets', $this->widgets);
	
	}


echo '<table class="slayer_main_table">';
	
	echo '<tr>';
	
		echo '<td style="width:50%;" valign="top">';
		
			echo '<h2>Show in posts with tags</h2>';
			
			echo '<ul class="slayer_post_list">';
				
				if(empty($this->widgets[$_GET['id']]['tags']))
					echo '<li>all</li>';
				else
					{
					
					foreach($this->widgets[$_GET['id']]['tags'] as $id => $title){
						
						echo '<li><a onclick="if(!confirm(\'Are you sure you want to remove this tag from the list?\')) return false;" href="', $url , '&amp;delete_tag=' , $id ,'">', $title ,'</a></li>';
						
						}
					
					}
			
			echo '</ul>';
			
			echo 'Click a tag to remove it.';
		
		echo '</td>';
		
		
		echo '<td valign="top">';
			echo '<form action="', $url ,'" method="post">';
			echo '<table class="widefat" style="width:100%;">';
				echo '<thead>';
					echo '<tr>';
						echo '<th class="check-column check-column-controller" scope="col"><input type="checkbox"/></th>';
						echo '<th scope="col">Tag name</th>';
					echo '</tr>';
				echo '</thead>';
				
				echo '<tbody>';
					
					
					$alternative = true;
					
					$tags = get_tags(array('hide_empty'=>false));
					
					$offset = $_GET['tags_pag'] * $this->info['posts_per_page'];
					$limit = $offset + $this->info['posts_per_page'];
					$count = count($tags);
					
					for($i = $offset ; $i < $limit && $i < $count ;  $i++){
						
						$tag = $tags[$i];
						
						if($alternative)	$alternative = false;
						else				$alternative = true;
						
						echo '<tr class="', $alternative ? 'alternate':false ,' author-self status-publish">';
							
							echo '<th class="check-column"><input name="tags[]" ', isset($this->widgets[$_GET['id']]['tags'][$tag->term_id]) ? 'checked="checked"' : false ,' type="checkbox" value="', $tag->term_id ,'_', $tag->name ,'" /></th>';
							
							echo '<td>',$tag->name,'</td>';
						
						echo '</tr>';
						
						}
				echo '</tbody>';
			
			echo '</table>';
			
			if( $_GET['tags_pag'] + 1 < ($count / $this->info['posts_per_page']) )
				echo '<a style="float:left;" href="', str_replace( '&amp;tags_pag='.$_GET['tags_pag'],'&amp;tags_pag='.($_GET['tags_pag']+1),$url) ,'">&laquo; Next</a>';
			
			if($_GET['tags_pag'])
				echo '<a style="float:right;" href="', str_replace('&amp;tags_pag='.$_GET['tags_pag'],'&amp;tags_pag='.($_GET['tags_pag']-1),$url) ,'">Previous &raquo;</a>';
			
			echo '<p class="submit" style="clear:both;margin-top:25px;">';
				echo '<input type="submit" value="&laquo; Add selected categories" />';
			echo '</p>';
			echo '</form>';
		echo '</td>';
	
	echo '</tr>';

echo '</table>';





?>