<?php

// Theme data
	$theme_data = get_theme_data(TEMPLATEPATH . '/style.css');

// Get all category slugs for use
	$all_cat_slugs_arr = hybrid_all_cat_slugs();

// Get all category names for use
	$all_cats_arr = hybrid_all_cats();

// Get all tags for use
	$all_tags_arr = hybrid_all_tags();
?>

<div id="poststuff" class="dlm">

	<form name="form0" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>" style="border:none;background:transparent;">

	<?php
		include(CFCT_PATH.'_hybrid/admin/about.php');
		include(CFCT_PATH.'_hybrid/admin/general.php');
		hybrid_child_settings(); // Hook for child settings
	?>

	</form>

</div>

</div>