<?php

/*
+----------------------------------------------------------------+
+	TiltViewer-XML V1.00
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

$ngg_options = get_option('ngg_options');
$siteurl	 = get_option('siteurl');

// get the gallery id
$galleryID = (int) attribute_escape($_GET['gid']);

// get the pictures
if ($galleryID == 0) {
	$thepictures = $wpdb->get_results("SELECT t.*, tt.* FROM $wpdb->nggallery AS t INNER JOIN $wpdb->nggpictures AS tt ON t.gid = tt.galleryid WHERE tt.exclude != 1 ORDER BY tt.$ngg_options[galSort] $ngg_options[galSortDir] ");
} else {
	$thepictures = $wpdb->get_results("SELECT t.*, tt.* FROM $wpdb->nggallery AS t INNER JOIN $wpdb->nggpictures AS tt ON t.gid = tt.galleryid WHERE t.gid = '$galleryID' AND tt.exclude != 1 ORDER BY tt.$ngg_options[galSort] $ngg_options[galSortDir] ");
}
// no images, no output
if (!is_array($thepictures)) die;

// Create XML output
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("content-type:text/xml;charset=utf-8");

echo '<?xml version="1.0" encoding="UTF-8" ?>';
echo "<tiltviewergallery>\n";
echo "<photos>\n";

if (is_array ($thepictures)){
	foreach ($thepictures as $picture) {

		echo '<photo imageurl="'.$siteurl.'/'.$picture->path.'/'.$picture->filename.'">';
		if (!empty($picture->alttext))	
		echo '<title>'.strip_tags(nggflash::internationalize($picture->alttext)).'</title>';
		else 
		echo '<title>'.$picture->filename.'</title>';
		echo '<description><![CDATA['.nggflash::internationalize($picture->description).']]></description>';
		echo "</photo>\n";
	}
}

echo "</photos>\n";
echo "</tiltviewergallery>\n";
?>

