	<div id="footer">
		<span id="copyright">&copy; <?php echo( date('Y') ); ?> <?php plaintxtblog_admin_hCard(); ?></span>
		<span class="meta-sep">|</span>
		<span id="generator-link">Powered by <a href="http://wordpress.org/" title="WordPress">WordPress</a></span>
		<span class="meta-sep">|</span>
		<span id="theme-link"><a href="http://www.plaintxt.org/themes/plaintxtblog/" title="plaintxtblog theme for WordPress" rel="follow designer">plaintxtblog</a> theme by <span class="vcard"><a class="url fn n" href="http://scottwallick.com/" title="scottwallick.com" rel="follow designer"><span class="given-name">Scott</span><span class="additional-name"> Allan</span><span class="family-name"> Wallick</span></a></span></span><!-- Theme design credit, that's all -->
		<span class="meta-sep">|</span>
		<span id="web-standards">Valid <a href="http://validator.w3.org/check/referer" title="Valid XHTML">XHTML</a> &amp; <a href="http://jigsaw.w3.org/css-validator/validator?profile=css2&amp;warning=2&amp;uri=<?php bloginfo('stylesheet_url'); ?>" title="Valid CSS">CSS</a></span>
		<span class="meta-sep">|</span>
		<span id="footer-rss"><a href="<?php bloginfo('rss2_url') ?>" title="<?php echo wp_specialchars(get_bloginfo('name'), 1) ?> RSS 2.0 Feed" rel="alternate" type="application/rss+xml"><?php _e('Posts RSS', 'plaintxtblog') ?></a> &amp; <a href="<?php bloginfo('comments_rss2_url') ?>" title="<?php echo wp_specialchars(bloginfo('name'), 1) ?> Comments RSS 2.0 Feed" rel="alternate" type="application/rss+xml"><?php _e('Comments RSS', 'plaintxtblog') ?></a></span>
	</div><!-- #footer -->

</div><!-- #wrapper -->

<?php wp_footer() // Do not remove; helps plugins work ?>

</body><!-- end transmission -->
</html>