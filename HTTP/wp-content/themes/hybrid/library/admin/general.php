<div class="postbox open">

<h3><?php _e('Select your theme settings','hybrid'); ?></h3>

<div class="inside">

	<table class="form-table">

	<tr>
		<th>
			<label for="<?php echo $data['primary_inserts_default']; ?>"><?php _e('Widget Inserts:','hybrid'); ?></label>
		</th>
		<td>
			<input id="<?php echo $data['primary_inserts_default']; ?>" name="<?php echo $data['primary_inserts_default']; ?>" type="checkbox" <?php if($val['primary_inserts_default']) echo 'checked="checked"'; ?> value="true" /> 
			<label for="<?php echo $data['primary_inserts_default']; ?>">
				<?php _e('Select this if you want your primary widget inserts to default to the home insert when nothing else is selected.','hybrid'); ?>
			</label>
			<br />
			<input id="<?php echo $data['secondary_inserts_default']; ?>" name="<?php echo $data['secondary_inserts_default']; ?>" type="checkbox" <?php if($val['secondary_inserts_default']) echo 'checked="checked"'; ?> value="true" /> 
			<label for="<?php echo $data['secondary_inserts_default']; ?>">
				<?php _e('Select this if you want your secondary widget inserts to default to the home insert when nothing else is selected.','hybrid'); ?>
			</label>
		</td>
	</tr>

	<tr>
		<th>
			<label for="<?php echo $data['print_style']; ?>"><?php _e('Stylesheets:','hybrid'); ?></label>
		</th>
		<td>
			<input id="<?php echo $data['print_style']; ?>" name="<?php echo $data['print_style']; ?>" type="checkbox" <?php if($val['print_style']) echo 'checked="checked"'; ?> value="true" /> 
			<label for="<?php echo $data['print_style']; ?>">
				<?php _e('Select this to have the theme automatically include a print stylesheet.','hybrid'); ?>
			</label>
		</td>
	</tr>

	<tr>
		<th>
			<label for="<?php echo $data['pullquotes_js']; ?>"><?php _e('JavaScript:','hybrid'); ?></label>
		</th>
		<td>
			<input id="<?php echo $data['pullquotes_js']; ?>" name="<?php echo $data['pullquotes_js']; ?>" type="checkbox" <?php if($val['pullquotes_js']) echo 'checked="checked"'; ?> value="true" /> 
			<label for="<?php echo $data['pullquotes_js']; ?>">
				<?php _e('Include the pull quote JavaScript.','hybrid'); ?>
			</label>
		</td>
	</tr>

	<tr>
		<th>
			<label for="<?php echo $data['feed_url']; ?>"><?php _e('Feeds:','hybrid'); ?></label>
		</th>
		<td>
			<input id="<?php echo $data['feed_url']; ?>" name="<?php echo $data['feed_url']; ?>" value="<?php echo $val['feed_url']; ?>" size="30" />
			<br />
			<?php _e('If you have a an alternate feed address, such as one from <a href="http://feedburner.com" title="Feedburner">Feedburner</a>, you can enter it here to have the theme set your feed URL link.  If blank, the theme will default to your WordPress RSS feed.','hybrid'); ?>
		</td>
	</tr>

	<tr>
		<th>
			<label for="<?php echo $data['seo_cats']; ?>"><?php _e('Title &amp; Meta:','hybrid'); ?></label>
		</th>
		<td>
			<input id="<?php echo $data['seo_cats']; ?>" name="<?php echo $data['seo_cats']; ?>" type="checkbox" <?php if($val['seo_cats']) echo 'checked="checked"'; ?> value="true" />
			<label for="<?php echo $data['seo_cats']; ?>">
				<?php _e('Use category slugs on single posts for your meta keywords?','hybrid'); ?>
			</label>
			<br />
			<input id="<?php echo $data['seo_tags']; ?>" name="<?php echo $data['seo_tags']; ?>" type="checkbox" <?php if($val['seo_tags']) echo 'checked="checked"'; ?> value="true" /> 
			<label for="<?php echo $data['seo_tags']; ?>">
				<?php _e('Use tag slugs on single posts for your meta keywords?','hybrid'); ?>
			</label>
			<br />
			<input id="<?php echo $data['seo_single_excerpts']; ?>" name="<?php echo $data['seo_single_excerpts']; ?>" type="checkbox" <?php if($val['seo_single_excerpts']) echo 'checked="checked"'; ?> value="true" /> 
			<label for="<?php echo $data['seo_single_excerpts']; ?>">
				<?php _e('Use the excerpt on single posts for your meta description?','hybrid'); ?>
			</label>
			<br />
			<input id="<?php echo $data['seo_author']; ?>" name="<?php echo $data['seo_author']; ?>" type="checkbox" <?php if($val['seo_author']) echo 'checked="checked"'; ?> value="true" /> 
			<label for="<?php echo $data['seo_author']; ?>">
				<?php _e('Use the author bio on author archives for your meta description?','hybrid'); ?>
			</label>
			<br />
			<input id="<?php echo $data['seo_category']; ?>" name="<?php echo $data['seo_category']; ?>" type="checkbox" <?php if($val['seo_category']) echo 'checked="checked"'; ?> value="true" /> 
			<label for="<?php echo $data['seo_category']; ?>">
				<?php _e('Use the category description on category archives for your meta description?','hybrid'); ?>
			</label>
			<br />
			<input id="<?php echo $data['seo_blog_title']; ?>" name="<?php echo $data['seo_blog_title']; ?>" type="checkbox" <?php if($val['seo_blog_title']) echo 'checked="checked"'; ?> value="true" /> 
			<label for="<?php echo $data['seo_blog_title']; ?>">
				<?php _e('Append site title to the end of the page name?','hybrid'); ?>
			</label>
			<p>
				<?php _e('You can change these settings in the box labeled <em>Hybrid Settings</em> when writing a post or page.','hybrid'); ?> <?php printf(__('The <a href="%1$s" title="All-In-One SEO Pack">All-In-One SEO Pack</a> and <a href="%2$s" title="Headspace2">Headspace2</a> plugins will override these settings and the Indexing settings.','hybrid'), 'http://wordpress.org/extend/plugins/all-in-one-seo-pack', 'http://wordpress.org/extend/plugins/headspace2'); ?>
			</p>
		</td>
	</tr>

	<tr>
		<th>
			<label for="<?php echo $data['robots_home']; ?>"><?php _e('Indexing:','hybrid'); ?></label>
		</th>
		<td>
			<?php _e('Choose which pages of your blog get indexed by the search engines. Only selected pages will be indexed.  If not selected, those pages will be blocked.','hybrid'); ?> <em><?php _e('Note: Some of these settings will render the Title &amp; Meta settings moot.  Also, setting your site to privacy mode will override these controls.','hybrid'); ?></em>
			<p style="width:30%;float:left;">
				<input id="<?php echo $data['robots_home']; ?>" name="<?php echo $data['robots_home']; ?>" type="checkbox" <?php if($val['robots_home']) echo 'checked="checked"'; ?> value="true" />
				<label for="<?php echo $data['robots_home']; ?>"><?php _e('Home page','hybrid'); ?></label>
			<br />
				<input id="<?php echo $data['robots_single']; ?>" name="<?php echo $data['robots_single']; ?>" type="checkbox" <?php if($val['robots_single']) echo 'checked="checked"'; ?> value="true" /> 
				<label for="<?php echo $data['robots_single']; ?>"><?php _e('Single posts','hybrid'); ?></label>
			<br />
				<input id="<?php echo $data['robots_attachment']; ?>" name="<?php echo $data['robots_attachment']; ?>" type="checkbox" <?php if($val['robots_attachment']) echo 'checked="checked"'; ?> value="true" /> 
				<label for="<?php echo $data['robots_attachment']; ?>"><?php _e('Attachments','hybrid'); ?></label>
			<br />
				<input id="<?php echo $data['robots_page']; ?>" name="<?php echo $data['robots_page']; ?>" type="checkbox" <?php if($val['robots_page']) echo 'checked="checked"'; ?> value="true" /> 
				<label for="<?php echo $data['robots_page']; ?>"><?php _e('Pages','hybrid'); ?></label>
			</p>
			<p style="width:30%;float:left;">
				<input id="<?php echo $data['robots_date']; ?>" name="<?php echo $data['robots_date']; ?>" type="checkbox" <?php if($val['robots_date']) echo 'checked="checked"'; ?> value="true" />
				<label for="<?php echo $data['robots_date']; ?>"><?php _e('Date-based archives','hybrid'); ?></label>
			<br />
				<input id="<?php echo $data['robots_category']; ?>" name="<?php echo $data['robots_category']; ?>" type="checkbox" <?php if($val['robots_category']) echo 'checked="checked"'; ?> value="true" />
				<label for="<?php echo $data['robots_category']; ?>"><?php _e('Category archives','hybrid'); ?></label>
			<br />
				<input id="<?php echo $data['robots_tag']; ?>" name="<?php echo $data['robots_tag']; ?>" type="checkbox" <?php if($val['robots_tag']) echo 'checked="checked"'; ?> value="true" />
				<label for="<?php echo $data['robots_tag']; ?>"><?php _e('Tag archives','hybrid'); ?></label>
			<br />
				<input id="<?php echo $data['robots_author']; ?>" name="<?php echo $data['robots_author']; ?>" type="checkbox" <?php if($val['robots_author']) echo 'checked="checked"'; ?> value="true" />
				<label for="<?php echo $data['robots_author']; ?>"><?php _e('Author archives','hybrid'); ?></label>
			</p>
			<p style="width:30%;float:left;">
				<input id="<?php echo $data['robots_search']; ?>" name="<?php echo $data['robots_search']; ?>" type="checkbox" <?php if($val['robots_search']) echo 'checked="checked"'; ?> value="true" />
				<label for="<?php echo $data['robots_search']; ?>"><?php _e('Search','hybrid'); ?></label>
			<br />
				<input id="<?php echo $data['robots_404']; ?>" name="<?php echo $data['robots_404']; ?>" type="checkbox" <?php if($val['robots_404']) echo 'checked="checked"'; ?> value="true" />
				<label for="<?php echo $data['robots_404']; ?>"><?php _e('404','hybrid'); ?></label>
			</p>
		</td>
	</tr>

	<tr>
		<th>
			<label for="<?php echo $data['default_avatar']; ?>"><?php _e('Avatars:','hybrid'); ?></label>
		</th>
		<td>
			<input id="<?php echo $data['default_avatar']; ?>" name="<?php echo $data['default_avatar']; ?>" value="<?php echo $val['default_avatar']; ?>" size="30" />
			<br />
			<?php _e('You can set a default avatar for users without one if you don\'t like the choices WordPress offers you. Simply add the full path to the image file.','hybrid'); ?>
		</td>
	</tr>

	<tr>
		<th>
			<label for="<?php echo $data['comments_popup']; ?>"><?php _e('Comments:','hybrid'); ?></label>
		</th>
		<td>
			<input id="<?php echo $data['comments_popup']; ?>" name="<?php echo $data['comments_popup']; ?>" type="checkbox" <?php if($val['comments_popup']) echo 'checked="checked"'; ?> value="true" /> 
			<label for="<?php echo $data['comments_popup']; ?>">
				<?php _e('Check to use the comments popup window instead of regular comments.','hybrid'); ?> <em><?php _e('WP 2.7+ only.','hybrid'); ?></em>
			</label>
		</td>
	</tr>

	<tr>
		<th>
			<label for="<?php echo $data['footer_insert']; ?>"><?php _e('Footer Insert:','hybrid'); ?></label>
		</th>
		<td>
			<textarea id="<?php echo $data['footer_insert']; ?>" name="<?php echo $data['footer_insert']; ?>" cols="60" rows="5" style="width: 95%;"><?php echo str_replace('<','&lt;',stripslashes($val['footer_insert'])); ?></textarea>
			<br />
			<?php _e('You can place XHTML and JavaScript here to have it inserted automatically into your theme.  If you have a script, such as one from Google Analytics, this could be useful.','hybrid'); ?>
		</td>
	</tr>

	<tr>
		<th>
			<label for="<?php echo $data['copyright']; ?>"><?php _e('Footer Settings:', 'hybrid'); ?></label>
		</th>
		<td>
			<input id="<?php echo $data['copyright']; ?>" name="<?php echo $data['copyright']; ?>" type="checkbox" <?php if($val['copyright']) echo 'checked="checked"'; ?> value="true" /> 
			<label for="<?php echo $data['copyright']; ?>">
				<?php _e('Check this if you want the theme to auto-generate your site\'s copyright and title in the footer.','hybrid'); ?>
			</label>
			<br />
			<input id="<?php echo $data['wp_credit']; ?>" name="<?php echo $data['wp_credit']; ?>" type="checkbox" <?php if($val['wp_credit']) echo 'checked="checked"'; ?> value="true" /> 
			<label for="<?php echo $data['wp_credit']; ?>">
				<?php _e('Want to show your love of WordPress?  Check this and a link will be added to your footer back to WordPress.org.','hybrid'); ?>
			</label>
			<br />
			<input id="<?php echo $data['th_credit']; ?>" name="<?php echo $data['th_credit']; ?>" type="checkbox" <?php if($val['th_credit']) echo 'checked="checked"'; ?> value="true" /> 
			<label for="<?php echo $data['th_credit']; ?>">
				<?php _e('Check this to have a link back to Theme Hybrid automatically appended to your footer.  This is totally optional.  Really.','hybrid'); ?>
			</label>
			<br />
			<input id="<?php echo $data['query_counter']; ?>" name="<?php echo $data['query_counter']; ?>" type="checkbox" <?php if($val['query_counter']) echo 'checked="checked"'; ?> value="true" /> 
			<label for="<?php echo $data['query_counter']; ?>">
				<?php _e('For testing purposes, this will append a database query counter and page load timer to your footer.','hybrid'); ?>
			</label>
		</td>
	</tr>

	</table>

	<p class="submit">
		<input type="submit" name="Submit"  class="button-primary" value="<?php _e('Save Changes', 'hybrid' ) ?>" />
		<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y" />
	</p>

</div>
</div>