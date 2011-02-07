<?php
$themename = "Vigilance";
$shortname = "V";
$options = array (

        array(	"name" => "Layout and Colors",
						"type" => "subhead"),
            
        array(	"name" => "Customize layout and colors",
						"desc" => "If enabled the theme will use the layouts and colors you choose below.",
					    "id" => $shortname."_background_css",
					    "std" => "Disabled",
					    "type" => "select",
					    "options" => array("Disabled","Enabled")),
              
        array(	"name" => "Background color",
					    "id" => $shortname."_background_color",
						"desc" => "Your background color. Use Hex values and leave out the leading #.",
					    "std" => "dcdfc2",
					    "type" => "text"),
        
        array(	"name" => "Border color",
					    "id" => $shortname."_border_color",
						"desc" => "Your border color. Use Hex values and leave out the leading #.",
					    "std" => "d7dab9",
					    "type" => "text"),
        
        array(	"name" => "Link color",
					    "id" => $shortname."_link_color",
						"desc" => "Your link color. Use Hex values and leave out the leading #.",
					    "std" => "772124",
					    "type" => "text"),
        
        array(	"name" => "Link hover color",
					    "id" => $shortname."_hover_color",
						"desc" => "Your link hover color. Use Hex values and leave out the leading #.",
					    "std" => "58181b",
					    "type" => "text"),
              
        array(  "name" => "Exclude pages from header",
              "id" => $shortname."_pages_to_exclude",
              "desc" => "Page ID's you don't want displayed in your header navigation. Use a comma-delimited list, eg. 1,2,3",
              "std" => "",
              "type" => "text"),
         
        array(	"name" => "Disable hover images",
					    "id" => $shortname."_image_hover",
						"desc" => "This is useful if you use custom link colors and don't want the default red showing when a user hovers over the comments bubble or the sidebar menu items.",
					    "std" => "false",
					    "type" => "checkbox"),
              
				array(	"name" => "Top Banner Image",
						"type" => "subhead"),

				array(	"name" => "Banner state",
						"desc" => "Place your images in the <code>/wp-content/themes/vigilance/images/top-banner</code> subdirectory and they will be added to the rotation. <br /><a href=\"http://themes.jestro.com/vigilance/tutorials/#options-banner\">Read this for page and post specific images.</a>",
			    		"id" => $shortname."_banner_state",
			    		"std" => "Rotating images",
			    		"type" => "select",
			    		"options" => array("Rotating images", "Static image", "Page and post specific", "Custom code", "Do not show an image")),
        
        array(	"name" => "Banner height",
					    "id" => $shortname."_banner_height",
						"desc" => "The height of your image. The width is fixed at 596px.",
					    "std" => "125",
					    "type" => "text"),
        
        array(	"name" => "Banner alt tag",
					    "id" => $shortname."_banner_alt",
						"desc" => "The alt tag for your banner image(s). Will default to your blog title if left blank.",
					    "std" => "",
					    "type" => "textarea",
              "options" => array("rows" => "2",
										   "cols" => "40") ),
        
        array(	"name" => "Static image",
					    "id" => $shortname."_banner_url",
						"desc" => "Replace your top banner with a static image.<br /><strong>Note:</strong> You must upload this image to <code>/wp-content/themes/vigilance/images/top-banner</code> <strong>and</strong> the <em>Banner State</em> must be set to 'Static Image' for this to work.",
					    "std" => "",
					    "type" => "text"),
              
        array(	"name" => "Home image",
					    "id" => $shortname."_banner_home",
						"desc" => "Replace your home top banner with a specific image.<br /><strong>Note:</strong> You must upload this image to <code>/wp-content/themes/vigilance/images/top-banner</code> <strong>and</strong> the <em>Banner State</em> must be set to 'Post and page specific' for this to work.",
					    "std" => "",
					    "type" => "text"),
        
        array(	"name" => "Custom code",
					    "id" => $shortname."_banner_custom",
						"desc" => "Replace your top banner with custom code.<br /><strong>Note:</strong> The <em>Banner State</em> must be set to 'Custom code' for this to work.",
					    "std" => "",
					    "type" => "textarea",
              "options" => array("rows" => "5",
										   "cols" => "40") ),
                       
        array(	"name" => "Alert Box",
						"type" => "subhead"),
            
        array(	"name" => "Alert Box On/Off",
						"desc" => "Toggle the alert box.",
			    		"id" => $shortname."_alertbox_state",
			    		"std" => "Off",
			    		"type" => "select",
			    		"options" => array("Off", "On")),
              
        array(	"name" => "Alert Title",
					    "id" => $shortname."_alertbox_title",
              "desc" => "The title of your alert.",
					    "std" => "",
					    "type" => "text"),
        
        array(	"name" => "Alert Message",
						"id" => $shortname."_alertbox_content",
						"desc" => "Must use HTML in the message including <code>&#60;p&#62;</code> tags.",
						"std" => "",
						"type" => "textarea",
						"options" => array("rows" => "8",
										   "cols" => "70") ),
              
        
        array(	"name" => "Sidebar Image",
						"type" => "subhead"),

				array(	"name" => "Image state",
						"desc" => "Place your images in the <code>/wp-content/themes/vigilance/images/sidebar</code> subdirectory and they will be added to the rotation. <br /><a href=\"http://themes.jestro.com/vigilance/tutorials/#options-banner\">Read this for page and post specific images.</a>",
			    		"id" => $shortname."_sideimg_state",
			    		"std" => "Rotating images",
			    		"type" => "select",
			    		"options" => array("Rotating images", "Static image", "Page and post specific", "Custom code", "Do not show an image")),
        
        array(	"name" => "Image height",
					    "id" => $shortname."_sideimg_height",
              "desc" => "The height of your image. The width is fixed at 300px.",
					    "std" => "250",
					    "type" => "text"),
        
        array(	"name" => "Image alt tag",
					    "id" => $shortname."_sideimg_alt",
              "desc" => "The alt tag for your sidebar image(s). Will default to your blog title if left blank.",
					    "std" => "",
					    "type" => "textarea",
              "options" => array("rows" => "2",
										   "cols" => "40") ),
        
        array(	"name" => "Static image",
					    "id" => $shortname."_sideimg_url",
              "desc" => "Replace your sidebar image with a static image.<br /><strong>Note:</strong> You must upload this image to <code>/wp-content/themes/vigilance/images/sidebar</code> <strong>and</strong> the <em>Image State</em> must be set to 'Static Image' for this to work.",
					    "std" => "",
					    "type" => "text"),
        
        array(	"name" => "Image link",
					    "id" => $shortname."_sideimg_link",
              "desc" => "Define a hyperlink for your sidebar image. If left empty the anchor tags will not be included.",
					    "std" => "",
					    "type" => "textarea",
              "options" => array("rows" => "2",
										   "cols" => "40") ),
              
        array(	"name" => "Custom code",
					    "id" => $shortname."_sideimg_custom",
						"desc" => "Replace your sidebar image with custom code.<br /><strong>Note:</strong> The <em>Image State</em> must be set to 'Custom code' for this to work.",
					    "std" => "",
					    "type" => "textarea",
              "options" => array("rows" => "5",
										   "cols" => "40") ),
     
        array(	"name" => "Sidebar Feed Box",
              "type" => "subhead"),
        
        array(	"name" => "Feed box state",
              "desc" => "Enable or disable the feed box in the sidebar.",
					    "id" => $shortname."_feed_state",
					    "std" => "Enabled",
					    "type" => "select",
					    "options" => array("Enabled","Disabled")),
              
        array(	"name" => "Feed box title text",
					    "id" => $shortname."_feed_title",
              "desc" => "Title of your feed box.",
					    "std" => "Get Free Updates",
					    "type" => "text"),
            
        array(	"name" => "Feed box intro text",
						"id" => $shortname."_feed_intro",
						"desc" => "Enter your feed intro text here.",
						"std" => "Get the latest and the greatest news delivered for free to your reader or your inbox:",
						"type" => "textarea",
						"options" => array("rows" => "5",
										   "cols" => "40") ),
        
        array(	"name" => "<a href=\"http://www.feedburner.com\">Feedburner</a> email updates link",
						"id" => $shortname."_feed_email",
						"desc" => "Enter your feed email link here. <strong>Do not paste the entire link code, just the URL.</strong><br /><del>&#60;a href=&#34;</del> <code>http://www.feedburner.com/fb/a/emailverifySubmit?feedId=000000&amp;loc=en_US</code> <del>&#34;&#62;Subscribe to Your Feed by Email&#60;/a&#62;</del>",
						"std" => "http://www.feedburner.com/fb/a/emailverifySubmit?feedId=YOURFEEDID&loc=en_US",
						"type" => "textarea",
						"options" => array("rows" => "2",
										   "cols" => "80") ),
				
        array(	"name" => "Footer",
						"type" => "subhead"),

				array(	"name" => "Copyright notice",
					    "id" => $shortname."_copyright_name",
              "desc" => "Enter your copyright info above.",
					    "std" => "Your Name Here",
					    "type" => "text"),			
				
				array(	"name" => "Stats code",
						"id" => $shortname."_stats_code",
						"desc" => "If you use Google Analytics or need any other tracking script in your footer just copy and paste it here.<br /> The script will be inserted before the closing <code>&#60;/body&#62;</code> tag.",
						"std" => "",
						"type" => "textarea",
						"options" => array("rows" => "5",
										   "cols" => "40") ),
		  );

function mytheme_add_admin() {

    global $themename, $shortname, $options;

    if ( $_GET['page'] == basename(__FILE__) ) {
    
        if ( 'save' == $_REQUEST['action'] ) {

                foreach ($options as $value) {
                    update_option( $value['id'], $_REQUEST[ $value['id'] ] ); }

                foreach ($options as $value) {
                    if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); } else { delete_option( $value['id'] ); } }

                header("Location: themes.php?page=vigilance-admin.php&saved=true");
                die;

        } else if( 'reset' == $_REQUEST['action'] ) {

            foreach ($options as $value) {
                delete_option( $value['id'] ); }

            header("Location: themes.php?page=vigilance-admin.php&reset=true");
            die;

        }
    }

    add_theme_page($themename." Options", "$themename Options", 'edit_themes', basename(__FILE__), 'mytheme_admin');

}

//add_theme_page($themename . 'Header Options', 'Header Options', 'edit_themes', basename(__FILE__), 'headimage_admin');

function headimage_admin(){
	
}

function mytheme_admin() {

    global $themename, $shortname, $options;

    if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings saved.</strong></p></div>';
    if ( $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings reset.</strong></p></div>';
    
?>
<div class="wrap">
<h2 class="updatehook" style=" padding-top: 20px; font-size: 2.8em;"><?php echo $themename; ?> Options</h2>
<p style="line-height: 1.6em; font-size: 1.2em; width: 75%;">Welcome to the Vigilance Options menu. If you have any questions head on over to the <a href="http://themes.jestro.com/vigilance/">Vigilance Blog</a> and poke around. You can also check out the <a href="http://themes.jestro.com/vigilance/tutorials/">tutorials page</a> for an overview on how to use this menu. Vigilance was hand coded and brought to you by <a href="http://www.jestro.com/">Jestro</a>.</p>
<form method="post">

<table class="form-table">

<?php foreach ($options as $value) { 
	
	switch ( $value['type'] ) {
		case 'subhead':
		?>
			</table>
			
			<h3><?php echo $value['name']; ?></h3>
			
			<table class="form-table">
		<?php
		break;
		case 'text':
		option_wrapper_header($value);
		?>
		        <input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" />
		<?php
		option_wrapper_footer($value);
		break;
		
		case 'select':
		option_wrapper_header($value);
		?>
	            <select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
	                <?php foreach ($value['options'] as $option) { ?>
	                <option <?php if ( get_settings( $value['id'] ) == $option) { echo ' selected="selected"'; } elseif ($option == $value['std']) { echo ' selected="selected"'; } ?>><?php echo $option; ?></option>
	                <?php } ?>
	            </select>
		<?php
		option_wrapper_footer($value);
		break;
		
		case 'textarea':
		$ta_options = $value['options'];
		option_wrapper_header($value);
		?>
				<textarea name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" cols="<?php echo $ta_options['cols']; ?>" rows="<?php echo $ta_options['rows']; ?>"><?php 
				if( get_settings($value['id']) != "") {
						echo stripslashes(get_settings($value['id']));
					}else{
						echo stripslashes($value['std']);
				}?></textarea>
		<?php
		option_wrapper_footer($value);
		break;

		case "radio":
		option_wrapper_header($value);
		
 		foreach ($value['options'] as $key=>$option) { 
				$radio_setting = get_settings($value['id']);
				if($radio_setting != ''){
		    		if ($key == get_settings($value['id']) ) {
						$checked = "checked=\"checked\"";
						} else {
							$checked = "";
						}
				}else{
					if($key == $value['std']){
						$checked = "checked=\"checked\"";
					}else{
						$checked = "";
					}
				}?>
	            <input type="radio" name="<?php echo $value['id']; ?>" value="<?php echo $key; ?>" <?php echo $checked; ?> /><?php echo $option; ?><br />
		<?php 
		}
		 
		option_wrapper_footer($value);
		break;
		
		case "checkbox":
		option_wrapper_header($value);
						if(get_settings($value['id'])){
							$checked = "checked=\"checked\"";
						}else{
							$checked = "";
						}
					?>
		            <input type="checkbox" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="true" <?php echo $checked; ?> />
		<?php
		option_wrapper_footer($value);
		break;

		default:

		break;
	}
}
?>

</table>

<p class="submit">
<input name="save" type="submit" value="Save changes" />    
<input type="hidden" name="action" value="save" />
</p>
</form>
<form method="post">
<p class="submit">
<input name="reset" type="submit" value="Reset" />
<input type="hidden" name="action" value="reset" />
</p>
</form>
<?php
}

function option_wrapper_header($values){
	?>
	<tr valign="top"> 
	    <th scope="row"><?php echo $values['name']; ?>:</th>
	    <td>
	<?php
}
function option_wrapper_footer($values){
	?>
		<br /><br />
		<?php echo $values['desc']; ?>
	    </td>
	</tr>
	<?php 
}
add_action('admin_menu', 'mytheme_add_admin'); 
?>