<?php
// Theme options adapted from "A Theme Tip For WordPress Theme Authors"
// http://literalbarrage.org/blog/archives/2007/05/03/a-theme-tip-for-wordpress-theme-authors/

if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) { die(); }

$themename = "Vanilla";
$shortname = "vnl";

// Create theme options

$options = array (

				array(  "name" => "Template Set",
						"id" => $shortname."_tpl_set",
						"std" => array('blog', 'Blog (default)'),
						"type" => "select",
						"options" => array(
							array('blog', 'Blog (default)'),
							array('photoblog', 'Photoblog'),
							array('corporate', 'Corporate'),
							array('magazine', 'Magazine'))),

				array(  "name" => "Page Width",
						"id" => $shortname."_grid_width",
						"std" => array('yui-d1', '750 pixels, centered'),
						"type" => "select",
						"options" => array(
							array('yui-d1', '750 pixels, centered'),
							array('yui-d2', '950 pixels, centered'),
							array('yui-d3', '974 pixels, centered'),
							array('yui-d0', '100%, 10 pixel margins'))),
							
				array(	"name" => "Custom Width",
						"desc" => "pixels or percentage",
						"id" => $shortname."_custom_width",
						"std" => "1000",
						"type" => "text"),
				
				array(  "name" => "Outer Column (fixed width)",
						"id" => $shortname."_grid_template",
						"std" => array('yui-t7', 'none'),
						"type" => "select",
						"options" => array(
							array('yui-t7', 'none'),
							array('yui-t1', '160 pixels, to the left'),
							array('yui-t2', '180 pixels, to the left'),
							array('yui-t3', '300 pixels, to the left'),
							array('yui-t4', '180 pixels, to the right'),
							array('yui-t5', '240 pixels, to the right'),
							array('yui-t6', '300 pixels, to the right'))),
				
				array(  "name" => "Inner Column (relative width)",
						"id" => $shortname."_grid_nesting",
						"std" => array('yui-g', 'none'),
						"type" => "select",
						"options" => array(
							array('yui-g', 'none'),
							array('yui-gc', 'wide (33%), to the right'),
							array('yui-gd', 'wide (33%), to the left'),
							array('yui-ge', 'narrow (25%), to the right'),
							array('yui-gf', 'narrow (25%), to the left'))),
				
				array(  "name" => "Utility Columns (relative widths)",
						"id" => $shortname."_utility_nesting",
						"std" => array('yui-ga', 'none'),
						"type" => "select",
						"options" => array(
							array('yui-ga', 'none'),
							array('yui-g', '2 cols, 50/50'),
							array('yui-gf', '2 cols, 25/75'),
							array('yui-ge', '2 cols 75/25'),
							array('yui-gd', '2 cols, 33/67'),
							array('yui-gc', '2 cols, 67/33'),
							array('yui-gb', '3 cols, 33/33/33'),
							array('yui-gg', '4 cols, 25/25/25/25'))),
										
				array(	"name" => "Index Insert Position",
						"desc" => "The widgetized Index Insert will follow after this post number.",
						"id" => $shortname."_insert_position",
						"std" => "2",
						"type" => "text"),

				array(	"name" => "Info on Author Page",
						"desc" => "Display a <a href=\"http://microformats.org/wiki/hcard\" target=\"_blank\">microformatted vCard</a>Ñwith the author's avatar, bio and emailÑon the author page.",
						"id" => $shortname."_authorinfo",
						"std" => "false",
						"type" => "checkbox"),

				array(	"name" => "Text in Footer",
						"desc" => "Enter the HTML text that will appear in the bottom of your footer. Feel free to remove or change any links. <strong>Hint:</strong> <a href=\"http://www.w3schools.com/HTML/html_links.asp\" target=\"_blank\">how to write a link</a>.",
						"id" => $shortname."_footertext",
						"std" => "<span id=\"generator-link\">You are enjoying the taste by <span id=\"designer-link\"><a href=\"http://www.alistercameron.com/vanilla-theme-for-wordpress\" title=\"Vanilla Theme\" rel=\"designer\">Vanilla flavored</a> <a href=\"http://WordPress.org/\" title=\"WordPress\" rel=\"generator\">WordPress</a></span></span><span class=\"meta-sep\">.</span>",
						"type" => "textarea",
						"options" => array(	"rows" => "5",
											"cols" => "94") )

		  );

function vanilla_add_admin_grid_page() {

    global $themename, $shortname, $options;

    if (isset($_GET['page'])) {
	    if ( $_GET['page'] == basename(__FILE__) ) {
	        if ( 'save' == $_REQUEST['action'] ) {
	
	                foreach ($options as $value) {
	                    update_option( $value['id'], $_REQUEST[ $value['id'] ] ); }
	
	                foreach ($options as $value) {
	                    if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); } else { delete_option( $value['id'] ); } }
	
	                header("Location: themes.php?page=grid.php&saved=true");
	                die;
	
	        } else if( 'reset' == $_REQUEST['action'] ) {
	
	            foreach ($options as $value) {
	                delete_option( $value['id'] ); }
	
	            header("Location: themes.php?page=grid.php&reset=true");
	            die;
	
	        }
	    }
    }

    add_theme_page($themename." Layout", "Vanilla Layout", 'edit_themes', basename(__FILE__), 'vanilla_admin_grid_page');

}

function vanilla_admin_grid_page() {

    global $themename, $shortname, $options;

    if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings saved.</strong></p></div>';
    if ( $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings reset.</strong></p></div>';
    
?>
<div class="wrap">
<h2><?php echo $themename; ?> Grid (Layout) Options</h2>

<form method="post">

<table class="form-table">

<?php foreach ($options as $value) { 
	
	switch ( $value['type'] ) {
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
			    <?php echo $value['desc']; ?>
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

<script type="text/javascript">
jQuery(document).ready(function($){
		$('input#vnl_custom_width').focus();
		
		//alert("Need to add the slider etc here...");
	});

</script>

<p><?php _e('For more information about this theme, visit <a href="http://www.vanillatheme.com/">Vanilla Theme</a>. Brought to you by <a href="http://www.alistercameron.com/">Alister Cameron // Blogologist</a>.', 'vanilla'); ?></p>

<?php
}

add_action('admin_menu' , 'vanilla_add_admin_grid_page'); 
?>