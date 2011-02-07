<?php
if ( function_exists('register_sidebar') )
    register_sidebars(2);

define('HEADER_TEXTCOLOR', '');
define('HEADER_IMAGE', '%s/images/header.jpg'); // %s is theme dir uri
define('HEADER_IMAGE_WIDTH', 340);
define('HEADER_IMAGE_HEIGHT', 200);
define( 'NO_HEADER_TEXT', true );

function effi_header_style() {

?>

<style type="text/css">
#headerimg {
	float: left;
	margin: 0;
	width: <?php echo HEADER_IMAGE_WIDTH; ?>px;
	height: <?php echo HEADER_IMAGE_HEIGHT; ?>px;
	background: url(<?php header_image(); ?>) no-repeat;
	display: inline;
}

#headerimg h1, #headerimg #desc {
	display: none;
}

</style>

<?php

}

function effi_admin_header_style() {

?>

<style type="text/css">
#headimg {
	width: <?php echo HEADER_IMAGE_WIDTH; ?>px;
	height: <?php echo HEADER_IMAGE_HEIGHT; ?>px;
	background: url(<?php header_image(); ?>) no-repeat;
}

#headimg h1, #headimg #desc {
	display: none;
}

</style>

<?php

}

add_custom_image_header('effi_header_style', 'effi_admin_header_style');

add_filter('comments_template', 'legacy_comments');
function legacy_comments($file) {
	if(!function_exists('wp_list_comments')) 	$file = TEMPLATEPATH . '/legacy.comments.php';
	return $file;
}
?>