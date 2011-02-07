	<!-- </div> -->
	<!-- main END -->

	<?php
		// $options = get_option('inove_options');
		// global $inove_nosidebar;
		// if(!$options['nosidebar'] && !$inove_nosidebar) {
		// 	get_sidebar();
		// }
	?>
	
	<!-- <div class="fixed"></div> -->
<!-- </div> -->
<!-- content END -->

<!-- footer START -->
<!-- <div id="footer">

</div> -->
<!-- footer END -->

</div>
<!-- container END -->
</div>
<!-- wrap END -->

<?php
	wp_footer();

	$options = get_option('inove_options');
	if ($options['analytics']) {
		echo($options['analytics_content']);
	}
?>

</body>
</html>

