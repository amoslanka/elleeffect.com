<?php get_sidebar(); ?>
	</div><!-- end columns_wrapper -->

	<div id="footer">

		<p>Theme by <a href="http://www.webminimalist.com/">Minimalist Web Design</a> | 
© <?php echo date('Y');?> <a href="<?php bloginfo('siteurl');?>/" title="<?php bloginfo('name');?>" ><?php bloginfo('name');?></a>
<br />
<?php echo $wpdb->num_queries; ?> queries. <?php timer_stop(1); ?> seconds. | <a href="feed:<?php bloginfo('rss2_url'); ?>">Entries (RSS)</a> and <a href="feed:<?php bloginfo('comments_rss2_url'); ?>">Comments (RSS)</a>
</p>

	</div> <!-- end footer -->


</div> <!-- end page -->

<?php wp_footer(); ?>

</div>
</body>
</html>