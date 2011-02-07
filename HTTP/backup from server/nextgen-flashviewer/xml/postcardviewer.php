<?php

/*
+----------------------------------------------------------------+
+	AutoViewer-XML V1.00
+	by Boris Glumpler
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
echo '<gallery cellDimension="'.$ngg_fv_options['ngg_pv_cellDimension'].'" columns="'.$ngg_fv_options['ngg_pv_columns'].'" zoomOutPerc="'.$ngg_fv_options['ngg_pv_zoomOutPerc'].'" zoomInPerc="'.$ngg_fv_options['ngg_pv_zoomInPerc'].'" frameWidth="'.$ngg_fv_options['ngg_pv_frameWidth'].'" frameColor="0x'.$ngg_fv_options['ngg_pv_frameColor'].'" captionColor="0x'.$ngg_fv_options['ngg_pv_captionColor'].'" enableRightClickOpen="'.$ngg_fv_options['ngg_fv_enable_right_click_open'].'" >
';

if (is_array ($thepictures)){
	foreach ($thepictures as $picture) {

		$image = $siteurl.'/'.$picture->path.'/'.$picture->filename;

		echo "<image>";
		echo '<url>'.$image.'</url>';
		echo '<caption><![CDATA['.strip_tags(nggflash::internationalize($picture->description)).']]></caption>';
		echo "</image>\n";
	}
}

echo "</gallery>\n";
?>

