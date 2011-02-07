<?php

// Theme options adapted from "A Theme Tip For WordPress Theme Authors"
// http://literalbarrage.org/blog/archives/2007/05/03/a-theme-tip-for-wordpress-theme-authors/

if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) { die(); }

$themename = "Vanilla";
$shortname = "vnl";

// Create theme options

$blocks = array (

/* --------------------------------------------------
   Layout/grid befores and afters
   -------------------------------------------------- */
   
				array(	"name" => "1. Before div#doc",
						"desc" => "Between the opening body tag and the opening div#doc tag.<br />(Pair with No. 14 for correctly nested tags.)",
						"id" => $shortname."_before_doc",
						"std" => "",
						"type" => "textarea",
						"options" => array(	"rows" => "5",
											"cols" => "94")),
						
				array(	"name" => "2. Before div#page",
						"desc" => "Between the opening div#doc tag and the opening div#page tag.<br />(Pair with No. 13 for correctly nested tags.)",
						"id" => $shortname."_before_page",
						"std" => "",
						"type" => "textarea",
						"options" => array(	"rows" => "5",
											"cols" => "94")),
						
				array(	"name" => "3. Before div#hd",
						"desc" => "Between the opening div#page tag and the opening div#hd tag.<br />(Pair with No. 12 for correctly nested tags.)",
						"id" => $shortname."_before_hd",
						"std" => "",
						"type" => "textarea",
						"options" => array(	"rows" => "5",
											"cols" => "94")),
											
				array(	"name" => "4. Before div#bd",
						"desc" => "Between the closing div#access tag and the opening div#bd tag.<br />(Pair with No. 11 for correctly nested tags.)",
						"id" => $shortname."_before_bd",
						"std" => "",
						"type" => "textarea",
						"options" => array(	"rows" => "5",
											"cols" => "94")),
											
				array(	"name" => "5. Top of div#bd",
						"desc" => "Immediately after (below) the opening div#bd tag.<br />(Pair with No. 10 for correctly nested tags.)",
						"id" => $shortname."_before_top_grid",
						"std" => "",
						"type" => "textarea",
						"options" => array(	"rows" => "5",
											"cols" => "94")),

				array(	"name" => "6. Top of div#content",
						"desc" => "Immediately after (below) the opening div#content tag.<br />(Pair with No. 9 for correctly nested tags.)",
						"id" => $shortname."_after_top_grid",
						"std" => "",
						"type" => "textarea",
						"options" => array(	"rows" => "5",
											"cols" => "94")),
						
				array(	"name" => "7. Bottom of div#content",
						"desc" => "Immediately before (above) the closing div#content tag.<br />(Pair with No. 8 for correctly nested tags.)",
						"id" => $shortname."_before_bottom_grid",
						"std" => "",
						"type" => "textarea",
						"options" => array(	"rows" => "5",
											"cols" => "94")),
						
				array(	"name" => "8. Bottom of div#bd",
						"desc" => "Immediately before (above) the closing div#bd tag.<br />(Pair with No. 7 for correctly nested tags.)",
						"id" => $shortname."_after_bottom_grid",
						"std" => "",
						"type" => "textarea",
						"options" => array(	"rows" => "5",
											"cols" => "94")),
						
				array(	"name" => "9. After div#bd",
						"desc" => "Between the closing div#bd tag the opening div#ft tag.<br />(Pair with No. 6 for correctly nested tags.)",
						"id" => $shortname."_before_ft",
						"std" => "",
						"type" => "textarea",
						"options" => array(	"rows" => "5",
											"cols" => "94")),
											
				array(	"name" => "10. Before div#utility",
						"desc" => "Between the opening div#ft tag and the opening div#utility tag.<br />(Pair with No. 5 for correctly nested tags.)",
						"id" => $shortname."_before_utility_grid",
						"std" => "",
						"type" => "textarea",
						"options" => array(	"rows" => "5",
											"cols" => "94")),
						
				array(	"name" => "11. After div#utility",
						"desc" => "Immediately after (below) the closing div#utility tag.<br />(Pair with No. 4 for correctly nested tags.)",
						"id" => $shortname."_after_utility_grid",
						"std" => "",
						"type" => "textarea",
						"options" => array(	"rows" => "5",
											"cols" => "94")),
				
				array(	"name" => "12. After div#ft",
						"desc" => "Between the closing div#ft tag and the closing div#page tag.<br />(Pair with No. 3 for correctly nested tags.)",
						"id" => $shortname."_after_ft",
						"std" => "",
						"type" => "textarea",
						"options" => array(	"rows" => "5",
											"cols" => "94")),
											
				array(	"name" => "13. After div#page",
						"desc" => "Between the closing div#page tag and the closing div#doc tag.<br />(Pair with No. 2 for correctly nested tags.)",
						"id" => $shortname."_after_page",
						"std" => "",
						"type" => "textarea",
						"options" => array(	"rows" => "5",
											"cols" => "94")),
						
				array(	"name" => "14. After div#doc",
						"desc" => "Between the closing div#doc tag and the closing body tag.<br />(Pair with No. 1 for correctly nested tags.)",
						"id" => $shortname."_after_doc",
						"std" => "",
						"type" => "textarea",
						"options" => array(	"rows" => "5",
											"cols" => "94")),
											
				array(	"name" => "Widget Blocks",
						"desc" => "Vanilla allows you to add code/markup before and after each widget block. This is, of course, entirely optional. If you wish to customise this on a per-child-theme basis, then you should use the child theme&rsquo;s functions.php file for this purpose. Note that code added before or after a widget block will display whether or not a widget block contains any active widgets.",
						"id" => "",
						"std" => "",
						"type" => "heading"),

/* --------------------------------------------------
   Before and after Header Nav widget block
   -------------------------------------------------- */
   
				array(	"name" => "15. Before Header Nav widget block",
						"desc" => "Before (above) the opening div#header-nav tag",
						"id" => $shortname."_widget_header_nav_before",
						"std" => "",
						"type" => "textarea",
						"options" => array(	"rows" => "5",
											"cols" => "94")),
						
				array(	"name" => "16. After Header Nav widget block",
						"desc" => "After (below) the closing div#header-nav tag",
						"id" => $shortname."_widget_header_nav_after",
						"std" => "",
						"type" => "textarea",
						"options" => array(	"rows" => "5",
											"cols" => "94")),

/* --------------------------------------------------
   Before and after Header widget block
   -------------------------------------------------- */
   
				array(	"name" => "17. Before Header widget block",
						"desc" => "Before (above) the opening div#header tag",
						"id" => $shortname."_widget_header_before",
						"std" => "",
						"type" => "textarea",
						"options" => array(	"rows" => "5",
											"cols" => "94")),
						
				array(	"name" => "18. After Header widget block",
						"desc" => "After (below) the closing div#header tag",
						"id" => $shortname."_widget_header_after",
						"std" => "",
						"type" => "textarea",
						"options" => array(	"rows" => "5",
											"cols" => "94")),

/* --------------------------------------------------
   Before and after Main Menu widget block
   -------------------------------------------------- */
   
				array(	"name" => "19. Before Main Menu widget block",
						"desc" => "Before (above) the opening div#main-menu tag",
						"id" => $shortname."_widget_main_menu_before",
						"std" => "",
						"type" => "textarea",
						"options" => array(	"rows" => "5",
											"cols" => "94")),
						
				array(	"name" => "20. After Main Menu widget block",
						"desc" => "After (below) the closing div#main-menu tag",
						"id" => $shortname."_widget_main_menu_after",
						"std" => "",
						"type" => "textarea",
						"options" => array(	"rows" => "5",
											"cols" => "94")),

/* --------------------------------------------------
   Before and after Sub Menu widget block
   -------------------------------------------------- */
   
				array(	"name" => "21. Before Sub Menu widget block",
						"desc" => "Before (above) the opening div#sub-menu tag",
						"id" => $shortname."_widget_sub_menu_before",
						"std" => "",
						"type" => "textarea",
						"options" => array(	"rows" => "5",
											"cols" => "94")),
						
				array(	"name" => "22. After Sub Menu widget block",
						"desc" => "After (below) the closing div#sub-menu tag",
						"id" => $shortname."_widget_sub_menu_after",
						"std" => "",
						"type" => "textarea",
						"options" => array(	"rows" => "5",
											"cols" => "94")),

/* --------------------------------------------------
   Before and after Breadcrumbs widget block
   -------------------------------------------------- */
   
				array(	"name" => "23. Before Breadcrumbs widget block",
						"desc" => "Before (above) the opening div#breadcrumbs tag",
						"id" => $shortname."_widget_breadcrumbs_before",
						"std" => "",
						"type" => "textarea",
						"options" => array(	"rows" => "5",
											"cols" => "94")),
						
				array(	"name" => "24. After Breadcrumbs widget block",
						"desc" => "After (below) the closing div#breadcrumbs tag",
						"id" => $shortname."_widget_breadcrumbs_after",
						"std" => "",
						"type" => "textarea",
						"options" => array(	"rows" => "5",
											"cols" => "94")),

/* --------------------------------------------------
   Before and after Content Top widget block
   -------------------------------------------------- */
   
				array(	"name" => "25. Before Content Top widget block",
						"desc" => "Before (above) the opening div#content-top tag",
						"id" => $shortname."_widget_content_top_before",
						"std" => "",
						"type" => "textarea",
						"options" => array(	"rows" => "5",
											"cols" => "94")),
						
				array(	"name" => "26. After Content Top widget block",
						"desc" => "After (below) the closing div#content-top tag",
						"id" => $shortname."_widget_content_top_after",
						"std" => "",
						"type" => "textarea",
						"options" => array(	"rows" => "5",
											"cols" => "94")),

/* --------------------------------------------------
   Before and after Content Middle widget block
   -------------------------------------------------- */
   
				array(	"name" => "27. Before Content Middle widget block",
						"desc" => "Before (above) the opening div#content-middle tag",
						"id" => $shortname."_widget_content_middle_before",
						"std" => "",
						"type" => "textarea",
						"options" => array(	"rows" => "5",
											"cols" => "94")),
						
				array(	"name" => "28. After Content Middle widget block",
						"desc" => "After (below) the closing div#content-middle tag",
						"id" => $shortname."_widget_content_middle_after",
						"std" => "",
						"type" => "textarea",
						"options" => array(	"rows" => "5",
											"cols" => "94")),

/* --------------------------------------------------
   Before and after Content Bottom widget block
   -------------------------------------------------- */
   
				array(	"name" => "29. Before Content Bottom widget block",
						"desc" => "Before (above) the opening div#content-bottom tag",
						"id" => $shortname."_widget_content_bottom_before",
						"std" => "",
						"type" => "textarea",
						"options" => array(	"rows" => "5",
											"cols" => "94")),
						
				array(	"name" => "30. After Content Bottom widget block",
						"desc" => "After (below) the closing div#content-bottom tag",
						"id" => $shortname."_widget_content_bottom_after",
						"std" => "",
						"type" => "textarea",
						"options" => array(	"rows" => "5",
											"cols" => "94")),

/* --------------------------------------------------
   Before and after Primary Sidebar widget block
   -------------------------------------------------- */
   
				array(	"name" => "31. Before Primary Sidebar widget block",
						"desc" => "Before (above) the opening div#primary-sidebar tag",
						"id" => $shortname."_widget_primary_sidebar_before",
						"std" => "",
						"type" => "textarea",
						"options" => array(	"rows" => "5",
											"cols" => "94")),
						
				array(	"name" => "32. After Primary Sidebar widget block",
						"desc" => "After (below) the closing div#primary-sidebar tag",
						"id" => $shortname."_widget_primary_sidebar_after",
						"std" => "",
						"type" => "textarea",
						"options" => array(	"rows" => "5",
											"cols" => "94")),

/* --------------------------------------------------
   Before and after Secondary Sidebar widget block
   -------------------------------------------------- */
   
				array(	"name" => "33. Before Secondary Sidebar widget block",
						"desc" => "Before (above) the opening div#secondary-sidebar tag",
						"id" => $shortname."_widget_secondary_sidebar_before",
						"std" => "",
						"type" => "textarea",
						"options" => array(	"rows" => "5",
											"cols" => "94")),
						
				array(	"name" => "34. After Secondary Sidebar widget block",
						"desc" => "After (below) the closing div#secondary-sidebar tag",
						"id" => $shortname."_widget_secondary_sidebar_after",
						"std" => "",
						"type" => "textarea",
						"options" => array(	"rows" => "5",
											"cols" => "94")),

/* --------------------------------------------------
   Before and after 1st Utility widget block
   -------------------------------------------------- */
   
				array(	"name" => "35. Before 1st Utility widget block",
						"desc" => "Before (above) the opening div#utility-1 tag",
						"id" => $shortname."_widget_utility_1_before",
						"std" => "",
						"type" => "textarea",
						"options" => array(	"rows" => "5",
											"cols" => "94")),
						
				array(	"name" => "36. After 1st Utility widget block",
						"desc" => "After (below) the closing div#utility-1 tag",
						"id" => $shortname."_widget_utility_1_after",
						"std" => "",
						"type" => "textarea",
						"options" => array(	"rows" => "5",
											"cols" => "94")),

/* --------------------------------------------------
   Before and after 2nd Utility widget block
   -------------------------------------------------- */
   
				array(	"name" => "37. Before 2nd Utility widget block",
						"desc" => "Before (above) the opening div#utility-2 tag",
						"id" => $shortname."_widget_utility_2_before",
						"std" => "",
						"type" => "textarea",
						"options" => array(	"rows" => "5",
											"cols" => "94")),
						
				array(	"name" => "38. After 2nd Utility widget block",
						"desc" => "After (below) the closing div#utility-2 tag",
						"id" => $shortname."_widget_utility_2_after",
						"std" => "",
						"type" => "textarea",
						"options" => array(	"rows" => "5",
											"cols" => "94")),

/* --------------------------------------------------
   Before and after 3rd Utility widget block
   -------------------------------------------------- */
   
				array(	"name" => "39. Before 3rd Utility widget block",
						"desc" => "Before (above) the opening div#utility-3 tag",
						"id" => $shortname."_widget_utility_3_before",
						"std" => "",
						"type" => "textarea",
						"options" => array(	"rows" => "5",
											"cols" => "94")),
						
				array(	"name" => "40. After 3rd Utility widget block",
						"desc" => "After (below) the closing div#utility-3 tag",
						"id" => $shortname."_widget_utility_3_after",
						"std" => "",
						"type" => "textarea",
						"options" => array(	"rows" => "5",
											"cols" => "94")),

/* --------------------------------------------------
   Before and after 4th Utility widget block
   -------------------------------------------------- */
   
				array(	"name" => "41. Before 4th Utility widget block",
						"desc" => "Before (above) the opening div#utility-4 tag",
						"id" => $shortname."_widget_utility_4_before",
						"std" => "",
						"type" => "textarea",
						"options" => array(	"rows" => "5",
											"cols" => "94")),
						
				array(	"name" => "42. After 4th Utility widget block",
						"desc" => "After (below) the closing div#utility-4 tag",
						"id" => $shortname."_widget_utility_4_after",
						"std" => "",
						"type" => "textarea",
						"options" => array(	"rows" => "5",
											"cols" => "94")),

/* --------------------------------------------------
   Before and after Footer Nav widget block
   -------------------------------------------------- */
   
				array(	"name" => "43. Before Footer Nav widget block",
						"desc" => "Before (above) the opening div#footer-nav tag",
						"id" => $shortname."_widget_footer_nav_before",
						"std" => "",
						"type" => "textarea",
						"options" => array(	"rows" => "5",
											"cols" => "94")),
						
				array(	"name" => "44. After Footer Nav widget block",
						"desc" => "After (below) the closing div#footer-nav tag",
						"id" => $shortname."_widget_footer_nav_after",
						"std" => "",
						"type" => "textarea",
						"options" => array(	"rows" => "5",
											"cols" => "94")),

/* --------------------------------------------------
   Before and after Footer widget block
   -------------------------------------------------- */
   
				array(	"name" => "45. Before Footer widget block",
						"desc" => "Before (above) the opening div#footer tag",
						"id" => $shortname."_widget_footer_before",
						"std" => "",
						"type" => "textarea",
						"options" => array(	"rows" => "5",
											"cols" => "94")),
						
				array(	"name" => "46. After Footer widget block",
						"desc" => "After (below) the closing div#footer tag",
						"id" => $shortname."_widget_footer_after",
						"std" => "",
						"type" => "textarea",
						"options" => array(	"rows" => "5",
											"cols" => "94")),

/* --------------------------------------------------
   Before and after Front Page 1 widget block
   -------------------------------------------------- */
   
				array(	"name" => "47. Before 1st Front Page widget block",
						"desc" => "Before (above) the opening div#front-page-1 tag",
						"id" => $shortname."_widget_front_page_1_before",
						"std" => "",
						"type" => "textarea",
						"options" => array(	"rows" => "5",
											"cols" => "94")),
						
				array(	"name" => "48. After 1st Front Page widget block",
						"desc" => "After (below) the closing div#front-page-1 tag",
						"id" => $shortname."_widget_front_page_1_after",
						"std" => "",
						"type" => "textarea",
						"options" => array(	"rows" => "5",
											"cols" => "94")),

/* --------------------------------------------------
   Before and after Front Page 2 widget block
   -------------------------------------------------- */
   
				array(	"name" => "49. Before 2nd Front Page widget block",
						"desc" => "Before (above) the opening div#front-page-2 tag",
						"id" => $shortname."_widget_front_page_2_before",
						"std" => "",
						"type" => "textarea",
						"options" => array(	"rows" => "5",
											"cols" => "94")),
				
				array(	"name" => "50. After 2nd Front Page widget block",
						"desc" => "After (below) the closing div#front-page-2 tag",
						"id" => $shortname."_widget_front_page_2_after",
						"std" => "",
						"type" => "textarea",
						"options" => array(	"rows" => "5",
											"cols" => "94"))
		  );

function vanilla_add_admin_blocks_page() {

    global $themename, $shortname, $blocks;

    if (isset($_GET['page'])) {
	    if ( $_GET['page'] == basename(__FILE__) ) {
	        if ( 'save' == $_REQUEST['action'] ) {
	
	                foreach ($blocks as $value) {
	                    if ( $value['type'] != 'heading') {
	                    update_option( $value['id'], $_REQUEST[ $value['id'] ] ); }
	                }
	                foreach ($blocks as $value) {
	                    if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); } else { delete_option( $value['id'] ); } }
	
	                header("Location: themes.php?page=blocks.php&saved=true");
	                die;
	
	        } else if( 'reset' == $_REQUEST['action'] ) {
	
	            foreach ($blocks as $value) {
	                delete_option( $value['id'] ); }
	
	            header("Location: themes.php?page=blocks.php&reset=true");
	            die;
	
	        }
	    }
    }

    add_theme_page($themename." Blocks", "Vanilla Blocks", 'edit_themes', basename(__FILE__), 'vanilla_admin_blocks_page');

}

function vanilla_admin_blocks_page() {

    global $themename, $shortname, $blocks;

    if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings saved.</strong></p></div>';
    if ( $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings reset.</strong></p></div>';
    
?>
<div class="wrap">
<h2><?php echo $themename; ?> Blocks</h2>

<p>Vanilla gives you an amazing level of control of your theme's HTML code and content, without making you access the PHP template files.</p>

<p>Each of the text-boxes below corresponds to an area of the page where you may wish to add extra code/markup.</p>

<p>You may enter any client-side code here (i.e. HTML/JS/Flash/etc), but no PHP. If you wish to add PHP, you should use the custom/functions.php file in your theme folder, where a function has been included which corresponds to each of the text-boxes below.</p>

<form method="post">

<table class="form-table">

<?php foreach ($blocks as $value) { 
	
	switch ( $value['type'] ) {
		case 'heading':
		?>
	</table>
	
	<h3><br /><?php echo $value['name']; ?></h3>
	<p><?php echo $value['desc']; ?></p>
	
	<table class="form-table">
		<?php
		break;
		case 'text':
		?>
		<tr valign="top"> 
		    <th scope="row"><?php echo $value['name']; ?>:</th>
		    <td>
		        <input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" />
			    <?php echo $value['desc']; ?>
		    </td>
		</tr>
		<?php
		break;
		
		case 'select':
		?>
		<tr valign="top">
			<th scope="row"><?php echo $value['name']; ?>:</th>
			<td>
				<select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
					<?php foreach ($value['options'] as $option) { ?>
					<option<?php if ( get_option( $value['id'] ) == $option[0]) { echo ' selected="selected"'; } elseif ($option[0] == $value['std'][0]) { echo ' selected="selected"'; } ?> value="<?php echo $option[0]; ?>"><?php echo $option[1]; ?></option>
					<?php } ?>
				</select>
			</td>
		</tr>
		<?php
		break;
		
		case 'textarea':
		$ta_options = $value['options'];
		?>
		<tr valign="top"> 
	        <th scope="row"><?php echo $value['name']; ?>:</th>
	        <td>
			    <?php echo $value['desc']; ?><br />
				<textarea name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" cols="<?php echo $ta_options['cols']; ?>" rows="<?php echo $ta_options['rows']; ?>"><?php 
				if( get_settings($value['id']) != "") {
						echo stripslashes(get_settings($value['id']));
					}else{
						echo $value['std'];
				}?></textarea>
	        </td>
	    </tr>
		<?php
		break;

		case "radio":
		?>
		<tr valign="top"> 
	        <th scope="row"><?php echo $value['name']; ?>:</th>
	        <td>
	            <?php foreach ($value['options'] as $key=>$option) { 
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
	            <?php } ?>
	        </td>
	    </tr>
		<?php
		break;
		
		case "checkbox":
		?>
			<tr valign="top"> 
		        <th scope="row"><?php echo $value['name']; ?>:</th>
		        <td>
		           <?php
						if(get_settings($value['id'])){
							$checked = "checked=\"checked\"";
						}else{
							$checked = "";
						}
					?>
		            <input type="checkbox" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="true" <?php echo $checked; ?> />
		            <?php  ?>
			    <?php echo $value['desc']; ?>
		        </td>
		    </tr>
			<?php
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

<p><?php _e('For more information about this theme, visit <a href="http://www.vanillatheme.com/">Vanilla Theme</a>. Brought to you by <a href="http://www.alistercameron.com/">Alister Cameron // Blogologist</a>.', 'vanilla'); ?></p>

<?php
}

add_action('admin_menu' , 'vanilla_add_admin_blocks_page');
?>