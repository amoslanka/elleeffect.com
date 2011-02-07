<?php

/*
+----------------------------------------------------------------+
+	SimpleViewer-XML V1.00
+	by Alex Rabe
+   	required for NextGEN Gallery FlashViewer
+----------------------------------------------------------------+
*/

$wpconfig = realpath("../../../../wp-config.php");
if (!file_exists($wpconfig)) die; // stop when wp-config is not there

require_once($wpconfig);

function get_out_now() { exit; }
add_action('shutdown', 'get_out_now', -1);

global $wpdb;

$ngg_options    = get_option('ngg_options');
$ngg_fv_options = get_option('ngg_fv_options');
$siteurl	    = get_option('siteurl');

// get the gallery id
$galleryID = (int) attribute_escape($_GET['gid']);

// get the pictures
$thepictures = $wpdb->get_results("SELECT t.*, tt.* FROM $wpdb->nggallery AS t INNER JOIN $wpdb->nggpictures AS tt ON t.gid = tt.galleryid WHERE t.gid = '$galleryID' AND tt.exclude != 1 ORDER BY tt.$ngg_options[galSort] $ngg_options[galSortDir] ");
// no images, no output
if (!is_array($thepictures)) die;

// Create XML output
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("content-type:text/xml;charset=utf-8");

echo '<?xml version="1.0" encoding="UTF-8" ?>';
echo '<simpleviewerGallery maxImageWidth="'.$ngg_fv_options['ngg_sv_max_image_width'].'" maxImageHeight="'.$ngg_fv_options['ngg_sv_max_image_height'].'" textColor="0x'.$ngg_fv_options['ngg_sv_text_color'].'" frameColor="0x'.$ngg_fv_options['ngg_sv_frame_color'].'" frameWidth="'.$ngg_fv_options['ngg_sv_frame_width'].'" stagePadding="'.$ngg_fv_options['ngg_sv_stage_padding'].'" navPadding="'.$ngg_fv_options['ngg_sv_navPadding'].'" thumbnailColumns="'.$ngg_fv_options['ngg_sv_thumbnail_columns'].'" thumbnailRows="'.$ngg_fv_options['ngg_sv_thumbnail_rows'].'" navPosition="'.$ngg_fv_options['ngg_sv_nav_position'].'"  vAlign="'.$ngg_fv_options['ngg_sv_vAlign'].'" hAlign="'.$ngg_fv_options['ngg_sv_hAlign'].'"  title="'.nggflash::internationalize($thepictures[0]->title).'" enableRightClickOpen="'.$ngg_fv_options['ngg_fv_enable_right_click_open'].'" backgroundImagePath="'.$ngg_fv_options['ngg_sv_background_image_path'].'" imagePath="'.$siteurl.'/'.$thepictures[0]->path.'/'.'" thumbPath="'.$siteurl.'/'.$thepictures[0]->path.'/'.'">';

if (is_array ($thepictures)){
	foreach ($thepictures as $picture) {

		echo "<image>";
		echo '<filename>'.$picture->filename.'</filename>';
		if (!empty($picture->description))	
		echo '<caption>'.strip_tags(nggflash::internationalize($picture->description)).'</caption>';
		else if (!empty($picture->alttext))	
		echo '<caption>'.nggflash::internationalize($picture->alttext).'</caption>';
		else 
		echo '<caption>'.$picture->filename.'</caption>';
		echo "</image>\n";
	}
}

echo "</simpleviewerGallery>\n";
?>

