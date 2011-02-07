<!-- footer START -->
<div id="footer">
	<a id="gotop" href="#" onclick="MGJS.goTop();return false;"><?php _e('Top', 'inove'); ?></a>
	<a id="powered" href="http://wordpress.org/">WordPress</a>
	<div id="copyright">
		<?php
			global $wpdb;
			$post_datetimes = $wpdb->get_results("SELECT YEAR(post_date_gmt) AS year FROM $wpdb->posts WHERE post_date_gmt > 1970 ORDER BY post_date_gmt ASC");
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
		<?php _e('Theme by <a href="http://www.neoease.com/">mg12</a>. Valid <a href="http://validator.w3.org/check?uri=referer">XHTML 1.1</a> and <a href="http://jigsaw.w3.org/css-validator/">CSS 3</a>.', 'inove'); ?>
	</div>
</div>
<!-- footer END -->

</div>
<!-- container END -->
</div>
<!-- wrap END -->

<?php wp_footer(); ?>

</body>
</html>
