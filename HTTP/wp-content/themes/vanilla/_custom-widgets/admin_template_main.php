
<h2>Custom widgets</h2>
<table class="form-table">
	<tr>
		<th scope="row" style="width:200px;">
			<h3>Widgets</h3>
			<div style="font-weight:normal;margin-bottom:20px;">Select a widget from the list that you want to customize.</div>
			
			<h4>Legend</h4>
			<div style="font-weight:normal;margin-top:10px;">
				Blue text - normal widget <br/>
				Red  text - customized widget
			</div>
			
			<br/><br/>
			
			<a class="button" onclick="if(!confirm('Are you sure you want to reset all widgets?')) return false;" href="<?php echo $this->info['admin_url'] ?>&amp;reset_widgets">Reset all widgets</a>
		</th>
		<td>
			<?php
/*			
<div id="postexcerpt" class="postbox " >
<div class='handlediv'><br /></div><h3 class='hndle'><span>Excerpt</span></h3>
<div class="inside">
<label class="hidden" for="excerpt">Excerpt</label><textarea rows="1" cols="40" name="excerpt" tabindex="6" id="excerpt"></textarea>
<p>Excerpts are optional hand-crafted summaries of your content. You can <a href="http://codex.wordpress.org/Template_Tags/the_excerpt" target="_blank">use them in your template</a></p>
</div>
</div>
*/
			
			
			
				
				global $wp_registered_sidebars, $wp_registered_widgets, $wp_registered_widget_controls;
				
				$sidebars = wp_get_sidebars_widgets();
				
				if(!$sidebars)
					echo '<div class="slayer_list">No widgets registered. Please setup at least one widget via wordpress <a href="widgets.php">widgets control panel</a>(found under the Design tab)</div>';
				else
					{
					echo '<ul class="metabox-holder">';
					
						foreach($sidebars as $sidebar_id => $widgets){
							
							echo '<li style="float:left; margin-right:2em;"><div class="postbox">';
							
								echo '<h3 class="hndle ', !empty($wp_registered_sidebars[$sidebar_id]['name']) ? false : 'not_registered' ,'"><span>',!empty($wp_registered_sidebars[$sidebar_id]['name']) ? $wp_registered_sidebars[$sidebar_id]['name'] : 'Not registered','</span></h3>';
								
								echo '<div class="inside" style="padding: 0 1em;"><ul>';
									
									foreach($widgets as $widget_id){
										
										$has_limit = false;
										if(!empty($this->widgets[$widget_id]))
											foreach($this->widgets[$widget_id] as $group => $data )
												if(!empty($data))
													if($group != 'opts'){
														$has_limit = true;
														break;
														}
													else
														foreach($data as $opt)
															if(!empty($opt)){
																$has_limit = true;
																break;
																}
										
										echo '<li><a style="', $has_limit ? 'color:red;' : false ,'" href="',$this->info['admin_url'],'&amp;act=edit&amp;id=',$wp_registered_widgets[$widget_id]['id'],'">';
										
											echo !empty($wp_registered_widgets[$widget_id]['name']) ? $wp_registered_widgets[$widget_id]['name'] : $wp_registered_widgets[$widget_id]['id'];
										
										echo '</a></li>';
									
										}
								echo '</ul></div>';
								
							echo '</div></li>';
							
							
							}
						
					echo '</ul>';
					}
			?>
			
		</td>
	</tr>
</table>
