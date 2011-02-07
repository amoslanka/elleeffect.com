	</div>
	<!-- main END -->

	<?php get_sidebar(); ?>
	<div class="fixed"></div>
</div>
<!-- content END -->

<!-- footer START -->
<div id="footer">
	<a id="gotop" href="#" onclick="MGJS.goTop();return false;"><?php _e('Top', 'inove'); ?></a>
	<a id="powered" href="http://wordpress.org/">WordPress</a>
	<div id="copyright">
		<?php
			global $wpdb;
			$post_datetimes = $wpdb->get_results("SELECT YEAR(post_date_gmt) AS year FROM wp_posts WHERE post_date_gmt > 1949 ORDER BY post_date_gmt ASC");
			$firstpost_year = $post_datetimes[0]->year;
			$lastpost_year = $post_datetimes[count($post_datetimes)-1]->year;

			$copyright = __('Copyright &copy; ', 'inove') . $firstpost_year;
			if($firstpost_year != $lastpost_year) {
				$copyright .= '-'. $lastpost_year;
			}

			echo $copyright;
		?>
		<?php bloginfo('name'); ?>
	</div>
	<div id="themeinfo">
		Theme by <a href="http://www.neoease.com/">mg12</a>. Valid <a href="http://validator.w3.org/check?uri=referer">XHTML 1.1</a> and <a href="http://jigsaw.w3.org/css-validator/">CSS 3</a>| Provided by <a href="http://www.themespreview.com">Best Wordpress Themes</a> | <a href="http://www.bluehost.com">Web Hosting</a>
	</div>
</div>
<!-- footer END -->

</div>
<!-- container END -->
</div>
<!-- wrap END -->

</body>
</html>
