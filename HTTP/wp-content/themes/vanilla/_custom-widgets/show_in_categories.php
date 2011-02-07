<?php 


$url .= '&amp;opt='. $_GET['opt'] . '&amp;cat_pag=' . ( $_GET['cat_pag']  = ( !empty($_GET['cat_pag']) ? $_GET['cat_pag'] : 0 ) );


if(!empty($_GET['delete_cat']) && isset($this->widgets[$_GET['id']]['categories'][$_GET['delete_cat']])){
	
	
	unset($this->widgets[$_GET['id']]['categories'][$_GET['delete_cat']]);
	
	update_option('slayer_widgets', $this->widgets);
	
	}



echo '<table class="slayer_main_table">';
	
	echo '<tr>';
	
		echo '<td style="width:50%;" valign="top">';
		
			echo '<h2>Show in Category</h2>';
			
			echo '<ul class="slayer_post_list">';
				
				if(empty($this->widgets[$_GET['id']]['categories']))
					echo '<li>all</li>';
				else
					{
					
					foreach($this->widgets[$_GET['id']]['categories'] as $id => $title){
						
						echo '<li><a onclick="if(!confirm(\'Are you sure you want to remove this category from the list?\')) return false;" href="', $url , '&amp;delete_cat=' , $id ,'">', $title ,'</a></li>';
						
						}
					
					}
			
			echo '</ul>';
			
			echo 'Click a category to remove it.';
		
		echo '</td>';
		
		
		echo '<td valign="top">';
			echo '<form action="', $url ,'" method="post">';
			echo '<table class="widefat" style="width:100%;">';
				echo '<thead>';
					echo '<tr>';
						echo '<th class="check-column check-column-controller" scope="col"><input type="checkbox"/></th>';
						echo '<th scope="col">Category name</th>';
					echo '</tr>';
				echo '</thead>';
				
				echo '<tbody>';
					
					$data = get_categories(array('hide_empty'=>false));
					$categories = array();
					
					foreach($data as $category)
						$categories[] = $category;
					
					$alternative = true;
					
					$offset = $_GET['cat_pag'] * $this->info['posts_per_page'];
					$limit = $offset + $this->info['posts_per_page'];
					$count = count($categories);
					
					for($i = $offset ; $i < $limit && $i < $count ;  $i++){
						
						$category = $categories[$i];
						
						if($alternative)	$alternative = false;
						else				$alternative = true;
						
						echo '<tr class="', $alternative ? 'alternate':false ,' author-self status-publish">';
							
							echo '<th class="check-column"><input name="categories[]" ', isset($this->widgets[$_GET['id']]['categories'][$category->term_id]) ? 'checked="checked"' : false ,' type="checkbox" value="', $category->term_id ,'_', $category->name ,'" /></th>';
							
							echo '<td>',$category->name,'</td>';
						
						echo '</tr>';
						
						}
				echo '</tbody>';
			
			echo '</table>';
			
			if( $_GET['cat_pag']+1 < ($count / $this->info['posts_per_page']) )
				echo '<a style="float:left;" href="', str_replace( '&amp;cat_pag='.$_GET['cat_pag'],'&amp;cat_pag='.($_GET['cat_pag']+1),$url) ,'">&laquo; Next</a>';
			
			if($_GET['cat_pag'])
				echo '<a style="float:right;" href="', str_replace('&amp;cat_pag='.$_GET['cat_pag'],'&amp;cat_pag='.($_GET['cat_pag']-1),$url) ,'">Previous &raquo;</a>';
			
			echo '<p class="submit" style="clear:both;margin-top:25px;">';
				echo '<input type="submit" value="&laquo; Add selected categories" />';
			echo '</p>';
			echo '</form>';
		echo '</td>';
	
	echo '</tr>';

echo '</table>';






?>