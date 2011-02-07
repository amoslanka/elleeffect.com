<?php
/**
 *	@package WordPress
 *	@subpackage Grid_Focus
 */
?>
<div class="navStripWrapper">
	
	<ul class="nav fix">
		<li><a href="<?php echo get_settings('home'); ?>/" title="Return to the the frontpage">Frontpage<br /><span>Return home</span></a></li>
		<li><a id="triggerCatID" href="#" title="Show categories">Browse<br /><span>By topic</span></a></li>
		<li class="last"><a href="<?php bloginfo('rss2_url'); ?>" title="Subscribe to the main feed via RSS">Subscribe<br /><span>RSS feed</span></a></li>
		<li id="searchBar1" class="searchField">
			<div>
				<form method="get" id="searchForm1" action="<?php bloginfo('home'); ?>/">
				<span><input type="text" value="Search the archives..." onfocus="if (this.value == 'Search the archives...') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Search the archives...';}" name="s" id="s1" /></span>
				</form>
			</div>
		</li>
	</ul>

	<div id="headerStrip" class="toggleCategories fix" style="display: none;"> 
		<ul class="fix">
		<?php wp_list_cats('sort_column=name&optioncount=0&exclude=10, 15'); ?>
		</ul>
	</div>
	
</div>