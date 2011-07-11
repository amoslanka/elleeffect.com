<?php
// Create XML output
//header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
//header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("content-type:text/xml;charset=utf-8");

echo '<?xml version="1.0" encoding="UTF-8" ?>';
echo '<elleviewer>';

/*
+----------------------------------------------------------------+
+	Elle Effect.com all galleries feed
+----------------------------------------------------------------+
*/

$wpconfig = realpath("../../../wp-config.php");
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
// $thepictures = $wpdb->get_results("SELECT t.*, tt.* FROM $wpdb->nggallery AS t INNER JOIN $wpdb->nggpictures AS tt ON t.gid = tt.galleryid WHERE t.gid = '$galleryID' AND tt.exclude != 1 ORDER BY tt.$ngg_options[galSort] $ngg_options[galSortDir] ");
$thepictures = $wpdb->get_results("SELECT t.title as galleryTitle, t.name as gallerySlug, t.*, tt.* FROM $wpdb->nggallery AS t INNER JOIN $wpdb->nggpictures AS tt ON t.gid = tt.galleryid WHERE  tt.exclude != 1 ORDER BY gallerySlug, tt.$ngg_options[galSort] $ngg_options[galSortDir] ");

include_once('dBug.php');


// no images, no output
if (!is_array($thepictures)) die;


// echo "<pre>";
// var_dump($thepictures);
// echo "<pre>";
// object(stdClass)#84 (18) {
//     ["gid"]=>string(1) "4"
//     ["name"]=>string(8) "travel-1"
//     ["path"]=>string(27) "wp-content/gallery/travel-1"
//     ["title"]=>string(8) "Travel-1"
//     ["galdesc"]=>NULL
//     ["pageid"]=>string(1) "0"
//     ["previewpic"]=>string(2) "18"
//     ["author"]=>string(1) "1"
//     ["pid"]=>string(1) "6"
//     ["post_id"]=>string(1) "0"
//     ["galleryid"]=>string(1) "4"
//     ["filename"]=>string(17) "dsc_0037-copy.jpg"
//     ["description"]=>string(0) ""
//     ["alttext"]=>string(13) "dsc_0037-copy"
//     ["imagedate"]=>string(19) "2008-11-21 18:19:14"
//     ["exclude"]=>string(1) "0"
//     ["sortorder"]=>string(1) "0"
//     ["meta_data"]=>string(431) "a:17:{i:0;b:0;s:8:"aperture";s:5:"F 2.8";s:6:"credit";b:0;s:6:"camera";s:9:"NIKON D80";s:7:"caption";b:0;s:17:"created_timestamp";s:25:"November 21, 2008 3:19 pm";s:9:"copyright";b:0;s:12:"focal_length";s:5:"70 mm";s:3:"iso";i:125;s:13:"shutter_speed";s:8:"1/20 sec";s:5:"flash";b:0;s:5:"title";b:0;s:8:"keywords";b:0;s:5:"width";i:3872;s:6:"height";i:2592;s:5:"saved";b:1;s:9:"thumbnail";a:2:{s:5:"width";i:75;s:6:"height";i:75;}}"



// imagePath="'.$siteurl.'/'.$thepictures[0]->path.'/'.'" thumbPath="'.$siteurl.'/'.$thepictures[0]->path.'/thumbs/'.'"



if (is_array ($thepictures)){
	
	$galleries = array();
	// $gallery_group = array();
	$g = '';
	
	foreach ($thepictures as $picture) {
	
		
		if ($g != $picture->gallerySlug)
		{
			// echo $picture->galleryTitle;
			// echo "...";
			
			// echo " >> " . $g;
			
			
			if (count($gallery_group) > 0)
			{
				// this happens to the previous 
				array_push($galleries, $gallery_group);
			}
			// 
			$gallery_group = array();

			// array_push($galleries, $gallery_group);
			
			$g = $picture->gallerySlug;
		}
		
		array_push($gallery_group, $picture);
		
	}

	if (count($gallery_group) > 0)
	{
		// this happens to the previous 
		array_push($galleries, $gallery_group);
	}
	
	// new dBug($galleries);
	// echo "..........................................";
	
	// foreach ($galleries as $gallery_group) {
	// 	echo ".....";
	// 	echo $gallery_group[0]->galleryTitle;
	// }
	// 
	// return;
	
	foreach ($galleries as $gallery_group) {
		echo "<gallery>\n";
		echo "\t<title>".$gallery_group[0]->galleryTitle."</title>\n";
		echo "\t<permalink>".$gallery_group[0]->gallerySlug."</permalink>\n";
		echo "\t<images>\n";
		
		$imagePath = $siteurl.'/'.$gallery_group[0]->path.'/';
		$thumbPath = $siteurl.'/'.$gallery_group[0]->path.'/thumbs/thumbs_';

		foreach ($gallery_group as $picture) {
			
			// new dBug($picture);
			
			echo "\t\t<image>\n";
			echo "\t\t\t<permalink><![CDATA[".$picture->pid."]]></permalink>\n";
			// echo "\t\t\t<name><![CDATA[".$picture->name."]]></name>\n";
			echo "\t\t\t<title><![CDATA[".$picture->alttext."]]></title>\n";
			echo "\t\t\t<imageUrl><![CDATA[".$imagePath.$picture->filename."]]></imageUrl>\n";
			echo "\t\t\t<thumbUrl><![CDATA[".$thumbPath.$picture->filename."]]></thumbUrl>\n";
			echo "\t\t\t<description><![CDATA[".strip_tags($picture->description)."]]></description>\n";
			echo "\t\t</image>\n";
		}
		echo "\t</images>\n";
		echo "</gallery>\n";
	}
	
	
	
}

echo "</elleviewer>\n";
?>

