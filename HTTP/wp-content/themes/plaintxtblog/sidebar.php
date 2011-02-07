		<div id="primary" class="sidebar">
			<ul>
<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar(1) ) : // Begin Widgets for Sidebar 1; displays widgets or default contents below ?>
<?php if ( !is_home() || is_paged() ) { // Displays a home link everywhere except the home page ?>
				<li id="home-link">
					<h3><a href="<?php bloginfo('home') ?>" title="<?php echo wp_specialchars(get_bloginfo('name'), 1) ?>"><?php _e('&laquo; Home', 'plaintxtblog') ?></a></h3>
				</li>
<?php } ?>
<?php wp_list_pages('title_li=<h3>'.__('Pages').'</h3>&sort_column=post_title' ) ?>

		<?php if ( is_home() || is_paged() ) { ?>
				<li id="meta">
					<h3><?php _e('Meta', 'plaintxtblog') ?></h3>
					<ul>
						<?php wp_register() ?>
						<li><?php wp_loginout() ?></li>
						<?php wp_meta() // Do not remove; helps plugins work ?>
					</ul>
				</li>
		<?php } ?>
				<li id="rss-links">
					<h3><?php _e('RSS Feeds', 'plaintxtblog') ?></h3>
					<ul>
						<li><a href="<?php bloginfo('rss2_url') ?>" title="<?php echo wp_specialchars(get_bloginfo('name'), 1) ?> RSS 2.0 Feed" rel="alternate" type="application/rss+xml"><?php _e('All posts', 'plaintxtblog') ?></a></li>
						<li><a href="<?php bloginfo('comments_rss2_url') ?>" title="<?php echo wp_specialchars(bloginfo('name'), 1) ?> Comments RSS 2.0 Feed" rel="alternate" type="application/rss+xml"><?php _e('All comments', 'plaintxtblog') ?></a></li>
					</ul>
				</li>
				<li id="search">
					<h3><label for="s"><?php _e('Search', 'plaintxtblog') ?></label></h3>
					<form id="searchform" method="get" action="<?php bloginfo('home') ?>">
						<div>
							<input id="s" name="s" type="text" value="<?php the_search_query() ?>" size="10" />
							<input id="searchsubmit" name="searchsubmit" type="submit" value="<?php _e('Find', 'plaintxtblog') ?>" />
						</div>
					</form>
				</li>
<?php endif; // End Widgets ?>

			</ul>
	</div><!-- #primary .sidebar -->

		<div id="secondary" class="sidebar">
			<ul>
<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar(2) ) : // Begin Widgets for Sidebar 2; displays widgets or default contents below ?>
<?php if ( wp_list_pages("child_of=".$post->ID."&echo=0") ) { // Shows subpages when subpages for the current page exist ?>
				<li id="subpagenav">
					<h3><?php _e('Subpages', 'plaintxtblog') ?></h3>
					<ul>
<?php wp_list_pages("title_li=&child_of=".$post->ID."&sort_column=menu_order&show_date=modified&date_format=$date_format"); ?>

					</ul>
				</li>
<?php } ?>
				<li id="categories">
					<h3><?php _e('Categories', 'plaintxtblog'); ?></h3>
					<ul>
<?php wp_list_categories('title_li=&orderby=name&use_desc_for_title=1&hierarchical=1') ?>

					</ul>
				</li>
				<li id="tag-cloud">
					<h3><?php _e('Tags', 'plaintxtblog'); ?></h3>
					<p><?php wp_tag_cloud() ?></p>
				</li>
				<li id="archives">
					<h3><?php _e('Archives', 'plaintxtblog') ?></h3>
					<ul>
<?php wp_get_archives('type=monthly') ?>

					</ul>
				</li>
<?php endif; // End Widgets ?>

			</ul>
	</div><!-- #secondary .sidebar -->
