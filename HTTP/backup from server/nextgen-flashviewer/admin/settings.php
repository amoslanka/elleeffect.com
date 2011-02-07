<?php  
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); }

function showFlashViewerPage() {
	
	global $wpdb, $wp_version, $nggRewrite, $nggflash;
	
	// same as $_SERVER['REQUEST_URI'], but should work under IIS 6.0
	$filepath    = admin_url() . 'admin.php?page='.$_GET['page'];

	if ( isset($_POST['updateoption']) ) {	
		check_admin_referer('ngg_settings');
		// get the hidden option fields, taken from WP core
		if ( $_POST['page_options'] )	
			$options = explode(',', stripslashes($_POST['page_options']));
		if ($options) {
			foreach ($options as $option) {
				$option = trim($option);
				$value = trim($_POST[$option]);
		//		$value = sanitize_option($option, $value); // This does stripslashes on those that need it
				$nggflash->options[$option] = $value;
			}
		}
		// Save options
		update_option('ngg_fv_options', $nggflash->options);
	 	nggGallery::show_message(__('Update Successfully','nggallery'));
	}

	if (isset($_POST['resetdefault'])) {	
		check_admin_referer('ngg_uninstall');

			include_once ( dirname (__FILE__).  '/install.php');
			
			ngg_fv_default_options();
			$nggflash->load_options();

			nggGallery::show_message(__('Reset all settings to default parameter','nggallery'));
	}

	if (isset($_POST['uninstall'])) {	
		check_admin_referer('ngg_uninstall');

			include_once ( dirname (__FILE__).  '/install.php');
			nggflash_uninstall();

		 	nggGallery::show_message(__('Uninstall sucessfull ! Now delete the plugin and enjoy your life ! Good luck !','nggallery'));
	}
	
	// message windows
	if(!empty($messagetext)) { echo '<!-- Last Action --><div id="message" class="updated fade"><p>'.$messagetext.'</p></div>'; }

	?>

	<script type="text/javascript">
		jQuery(function() {
			jQuery('#slider').tabs({ fxFade: true, fxSpeed: 'fast' });	
		});
		
		function setcolor(fileid,color) {
			jQuery(fileid).css("background", color );
		};
	</script>
	
	<div id="slider" class="wrap">
	
		<ul id="tabs">
			<li><a href="#fv_general"><?php _e('General Settings', 'nggflash') ;?></a></li>
			<li><a href="#simpleviewer"><?php _e('SimpleViewer', 'nggflash') ;?></a></li>
			<li><a href="#tiltviewer"><?php _e('TiltViewer', 'nggflash') ;?></a></li>
			<li><a href="#autoviewer"><?php _e('AutoViewer', 'nggflash') ;?></a></li>
			<li><a href="#pcviewer"><?php _e('PostcardViewer', 'nggflash') ;?></a></li>
			<li><a href="#fv_setup"><?php _e('Setup', 'nggflash') ;?></a></li>
			<li><a href="#fv_credits"><?php _e('Credits', 'nggflash') ;?></a></li>
			<li><a href="#fv_donation"><?php _e('Donate', 'nggflash') ;?></a></li>
		</ul>

		<!-- General settings -->
		
		<div id="fv_general">
            <form name="general" method="post" action="<?php echo $filepath.'#fv_general'; ?>" >
                <?php wp_nonce_field('ngg_settings') ?>
                <input type="hidden" name="page_options" value="ngg_fv_viewerURL,ngg_fv_effects,ngg_fv_enable_right_click_open,ngg_fv_langAbout,ngg_fv_irBackcolor,ngg_fv_langOpenImage" />
                <h2><?php _e('General Settings','nggflash'); ?></h2>
                    <table class="form-table">
                        <tr>
                            <th><?php _e('Effects','nggflash') ?>:</th>
                            <td>
                            <p><?php _e('Please note that none of these effects work out of the box, so the effect of your choice needs to be already installed before you activate the option here.','nggflash') ?></p>
                            <select size="1" id="ngg_fv_effects" name="ngg_fv_effects">
                                <option value="thickbox" <?php selected('thickbox', $nggflash->options['ngg_fv_effects']); ?> ><?php _e('Thickbox', 'nggflash') ;?></option>
                                <option value="highslide" <?php selected('highslide', $nggflash->options['ngg_fv_effects']); ?> ><?php _e('Highslide', 'nggflash') ;?></option>
                                <option value="lightview" <?php selected('lightview', $nggflash->options['ngg_fv_effects']); ?> ><?php _e('Lightview', 'nggflash') ;?></option>
                                <option value="shadowbox" <?php selected('shadowbox', $nggflash->options['ngg_fv_effects']); ?> ><?php _e('Shadowbox', 'nggflash') ;?></option>
                            </select> <small>(<?php _e('Different JS-Effects to open Simpleviewer/TiltViewer/Auto/PostcardViewer in.', 'nggflash'); ?>)</small></td>
                        </tr>
                        <tr>
                            <th><?php _e('Enable Right Click Open','nggflash') ?>:</th>
                            <td>
                            <select size="1" id="ngg_fv_enable_right_click_open" name="ngg_fv_enable_right_click_open">
                                <option value="true" <?php selected('true', $nggflash->options['ngg_fv_enable_right_click_open']); ?> ><?php _e('true', 'nggflash') ;?></option>
                                <option value="false" <?php selected('false', $nggflash->options['ngg_fv_enable_right_click_open']); ?> ><?php _e('false', 'nggflash') ;?></option>
                            </select> <small>(<?php _e('Whether to display a *Open In new Window...* dialog when right-clicking on an image.', 'nggflash'); ?>)</small></td>
                        </tr>
                        <tr>
                            <th><?php _e('Background Color','nggflash') ?>:</th>
                            <td>#<input type="text" size="6" maxlength="6" id="ngg_fv_irBackcolor" name="ngg_fv_irBackcolor" onchange="setcolor('#previewBack', this.value)" value="<?php echo $nggflash->options['ngg_fv_irBackcolor']; ?>" />
                            <input type="text" size="1" readonly="readonly" id="previewBack" style="background-color: #<?php echo $nggflash->options['ngg_fv_irBackcolor']; ?>" /> <small>(<?php _e('Color of SWFObject background (hexidecimal color value e.g ff00ff).', 'nggflash'); ?>)</small></td>
                        </tr>
                        <tr>
                            <th><?php _e('About Text','nggflash') ?>:</th>
                            <td><input type="text" size="50" id="ngg_tv_lang_about" name="ngg_fv_langAbout" value="<?php echo $nggflash->options['ngg_fv_langAbout']; ?>" /> <small>(<?php _e('The text displayed for the right-click *About* menu option.', 'nggflash'); ?>)</small></td>
                        </tr>
                        <tr>
                            <th><?php _e('Open Image Text','nggflash') ?>:</th>
                            <td><input type="text" size="50" id="ngg_fv_langOpenImage" name="ngg_fv_langOpenImage" value="<?php echo $nggflash->options['ngg_fv_langOpenImage']; ?>" /> <small>(<?php _e('The text displayed for the right-click *Open Image in New Window* menu option.', 'nggflash'); ?>)</small></td>
                        </tr>
                    </table>				
                    <div class="clear"> &nbsp; </div>
                    <div class="submit"><input type="submit" name="updateoption" value="<?php _e('Update') ;?> &raquo;"/></div>
            </form>
		</div>


		<!-- SimpleViewer settings-->

		<div id="simpleviewer">
            <form name="simpleviewersettings" method="POST" action="<?php echo $filepath.'#simpleviewer'; ?>" >
                <?php wp_nonce_field('ngg_settings') ?>
                <input type="hidden" name="page_options" value="ngg_sv_preloader_color,ngg_sv_max_image_width,ngg_sv_max_image_height,ngg_sv_text_color,ngg_sv_frame_color,ngg_sv_frame_width,ngg_sv_stage_padding,ngg_sv_thumbnail_columns,ngg_sv_thumbnail_rows,ngg_sv_nav_position,ngg_sv_background_image_path,ngg_sv_navPadding,ngg_sv_hAlign,ngg_sv_vAlign" />
                <h2><?php _e('SimpleViewer Settings','nggflash'); ?></h2>
                <?php if (!SIMPLEVIEWER_EXIST) { ?><p><div id="message" class="error fade"><p><?php _e('The viewer.swf is not in the .../plugins/nggflash-swf/ folder. SimpleViewer will not work.','nggflash') ?></p></div></p><?php } else {?>
                    <table  class="form-table">
                        <tr>
                            <th><?php _e('Maximum Image Width','nggflash') ?>:</th>
                            <td><input type="text" size="3" maxlength="4" id="ngg_sv_max_image_width" name="ngg_sv_max_image_width" value="<?php echo $nggflash->options['ngg_sv_max_image_width']; ?>" /> px <small>(<?php _e('Width of your largest image in pixels. Used to determine the best layout for your gallery.', 'nggflash'); ?>)</small></td>
                        </tr>
                        <tr>
                            <th><?php _e('Maximum Image Height','nggflash') ?>:</th>
                            <td><input type="text" size="3" maxlength="4" id="ngg_sv_max_image_height" name="ngg_sv_max_image_height" value="<?php echo $nggflash->options['ngg_sv_max_image_height']; ?>" />  px <small>(<?php _e('Height of your largest image in pixels. Used to determine the best layout for your gallery.', 'nggflash'); ?>)</small></td>
                        </tr>
                        <tr>
                            <th><?php _e('Text Color','nggflash') ?>:</th>
                            <td>#<input type="text" size="6" maxlength="6" id="ngg_sv_text_color" name="ngg_sv_text_color" onchange="setcolor('#previewBack', this.value)" value="<?php echo $nggflash->options['ngg_sv_text_color']; ?>" />
                            <input type="text" size="1" readonly="readonly" id="previewBack" style="background-color: #<?php echo $nggflash->options['ngg_sv_text_color']; ?>" /> <small>(<?php _e('Color of title and caption text (hexidecimal color value e.g ff00ff).', 'nggflash'); ?>)</small></td>
                        </tr>
                        <tr>
                            <th><?php _e('Preloader Color','nggflash') ?>:</th>
                            <td>#<input type="text" size="6" maxlength="6" id="ngg_sv_preloader_color" name="ngg_sv_preloader_color" onchange="setcolor('#previewBack', this.value)" value="<?php echo $nggflash->options['ngg_sv_preloader_color']; ?>" />
                            <input type="text" size="1" readonly="readonly" id="previewBack" style="background-color: #<?php echo $nggflash->options['ngg_sv_preloader_color']; ?>" /> <small>(<?php _e('Color of the loader (hexidecimal color value e.g ff00ff).', 'nggflash'); ?>)</small></td>
                        </tr>
                        <tr>
                            <th><?php _e('Frame Color','nggflash') ?>:</th>
                            <td>#<input type="text" size="6" maxlength="6" id="ngg_sv_frame_color" name="ngg_sv_frame_color" onchange="setcolor('#previewBack', this.value)" value="<?php echo $nggflash->options['ngg_sv_frame_color']; ?>" />
                            <input type="text" size="1" readonly="readonly" id="previewBack" style="background-color: #<?php echo $nggflash->options['ngg_sv_frame_color']; ?>" /> <small>(<?php _e('Color of image frame, navigation buttons and thumbnail frame (hexidecimal color value e.g ff00ff).', 'nggflash'); ?>)</small></td>
                        </tr>
                        <tr>
                            <th><?php _e('Frame Width','nggflash') ?>:</th>
                            <td><input type="text" size="3" maxlength="4" id="ngg_sv_frame_width" name="ngg_sv_frame_width" value="<?php echo $nggflash->options['ngg_sv_frame_width']; ?>" /> px <small>(<?php _e('Width of image frame in pixels.', 'nggflash'); ?>)</small></td>
                        </tr>
                        <tr>
                            <th><?php _e('Stage Padding','nggflash') ?>:</th>
                            <td><input type="text" size="3" maxlength="4" id="ngg_sv_stage_padding" name="ngg_sv_stage_padding" value="<?php echo $nggflash->options['ngg_sv_stage_padding']; ?>" /> px <small>(<?php _e('Distance between image and thumbnails and around gallery edge.', 'nggflash'); ?>)</small></td>
                        </tr>
                        <tr>
                            <th><?php _e('Nav Padding','nggflash') ?>:</th>
                            <td><input type="text" size="3" maxlength="4" id="ngg_sv_navPadding" name="ngg_sv_navPadding" value="<?php echo $nggflash->options['ngg_sv_navPadding']; ?>" /> px <small>(<?php _e('Distance between image and thumbnails (pixels).', 'nggflash'); ?>)</small></td>
                        </tr>
    
                        <tr>
                            <th><?php _e('Thumbnail Columns','nggflash') ?>:</th>
                            <td><input type="text" size="3" maxlength="2" id="ngg_sv_thumbnail_columns" name="ngg_sv_thumbnail_columns" value="<?php echo $nggflash->options['ngg_sv_thumbnail_columns']; ?>" /> <small>(<?php _e('Number of thumbnail columns. (To disable thumbnails completely set this value to 0.)', 'nggflash'); ?>)</small></td>
                        </tr>
                        <tr>
                            <th><?php _e('Thumbnail Rows','nggflash') ?>:</th>
                            <td><input type="text" size="3" maxlength="2" id="ngg_sv_thumbnail_rows" name="ngg_sv_thumbnail_rows" value="<?php echo $nggflash->options['ngg_sv_thumbnail_rows']; ?>" /> <small>(<?php _e('Number of thumbnail rows. (To disable thumbnails completely set this value to 0.)', 'nggflash'); ?>)</small></td>
                        </tr>
                        <tr>
                            <th><?php _e('Navigation Position','nggflash') ?>:</th>
                            <td>
                            <select size="1" id="ngg_sv_nav_position" name="ngg_sv_nav_position">
                                <option value="top" <?php selected('top', $nggflash->options['ngg_sv_nav_position']); ?> ><?php _e('top', 'nggflash') ;?></option>
                                <option value="bottom" <?php selected('bottom', $nggflash->options['ngg_sv_nav_position']); ?> ><?php _e('bottom', 'nggflash') ;?></option>
                                <option value="left" <?php selected('left', $nggflash->options['ngg_sv_nav_position']); ?> ><?php _e('left', 'nggflash') ;?></option>
                                <option value="right" <?php selected('right', $nggflash->options['ngg_sv_nav_position']); ?> ><?php _e('right', 'nggflash') ;?></option>
                            </select> <small>(<?php _e('Position of thumbnails relative to image.', 'nggflash'); ?>)</small></td>
                        </tr>
                        <tr>
                            <th><?php _e('Horizontal Align','nggflash') ?>:</th>
                            <td>
                            <select size="1" id="ngg_sv_hAlign" name="ngg_sv_hAlign">
                                <option value="center" <?php selected('center', $nggflash->options['ngg_sv_hAlign']); ?> ><?php _e('center', 'nggflash') ;?></option>
                                <option value="left" <?php selected('left', $nggflash->options['ngg_sv_hAlign']); ?> ><?php _e('left', 'nggflash') ;?></option>
                                <option value="right" <?php selected('right', $nggflash->options['ngg_sv_hAlign']); ?> ><?php _e('right', 'nggflash') ;?></option>
                            </select> <small>(<?php _e('Horizontal placment of the image and thumbnails within the SWF.', 'nggflash'); ?>)</small></td>
                        </tr>
                        <tr>
                            <th><?php _e('Vertical Align','nggflash') ?>:</th>
                            <td>
                            <select size="1" id="ngg_sv_vAlign" name="ngg_sv_vAlign">
                                <option value="center" <?php selected('center', $nggflash->options['ngg_sv_vAlign']); ?> ><?php _e('center', 'nggflash') ;?></option>
                                <option value="top" <?php selected('top', $nggflash->options['ngg_sv_vAlign']); ?> ><?php _e('top', 'nggflash') ;?></option>
                                <option value="bottom" <?php selected('bottom', $nggflash->options['ngg_sv_vAlign']); ?> ><?php _e('bottom', 'nggflash') ;?></option>
                            </select> <small>(<?php _e('Vertical placment of the image and thumbnails within the SWF.', 'nggflash'); ?>)</small></td>
                        </tr>
                        <tr>
                            <th><?php _e('Background Image Path (URL)','nggflash') ?>:</th>
                            <td><input type="text" size="50" id="ngg_sv_background_image_path" name="ngg_sv_background_image_path" value="<?php echo $nggflash->options['ngg_sv_background_image_path']; ?>" /> <small>(<?php _e('Relative or absolute path to a JPG or SWF to load as the gallery background.', 'nggflash'); ?>)</small></td>
                        </tr>				
                    </table>
                    <div class="clear"> &nbsp; </div>
                    <div class="submit"><input type="submit" name="updateoption" value="<?php _e('Update') ;?> &raquo;"/></div>
                <?php } ?>
            </form>
		</div>	
		
		<!-- TiltViewer settings -->
		
		<div id="tiltviewer">
            <form name="tiltviewersettings" method="POST" action="<?php echo $filepath.'#tiltviewer'; ?>" >
                <?php wp_nonce_field('ngg_settings') ?>
                <input type="hidden" name="page_options" value="ngg_tv_max_jpg_size,ngg_tv_use_reload_button,ngg_tv_show_flip_button,ngg_tv_columns,ngg_tv_rows,ngg_tv_frame_color,ngg_tv_back_color,ngg_tv_bkgnd_inner_color,ngg_tv_bkgnd_outer_color,ngg_tv_lang_go_full,ngg_tv_lang_exit_full,ngg_tv_lang_about,have_pro_tv,ngg_tv_pro_bkgndTransparent,ngg_tv_pro_showFullscreenOption,ngg_tv_pro_frameWidth,ngg_tv_pro_zoomedInDistance,ngg_tv_pro_zoomedOutDistance,ngg_tv_pro_fontName,ngg_tv_pro_titleFontSize,ngg_tv_pro_descriptionFontSize,ngg_tv_pro_navButtonColor,ngg_tv_pro_flipButtonColor,ngg_tv_pro_textColor,ngg_tv_user_id,ngg_tv_tag_mode,ngg_tv_showTakenByText,ngg_tv_pro_linkTextColor,ngg_tv_pro_linkBkgndColor,ngg_tv_pro_linkFontSize,ngg_tv_pro_linkTarget,ngg_tv_showLinkButton,ngg_tv_linkLabel" />
                <h2><?php _e('TiltViewer Settings','nggflash'); ?></h2>
                <?php if (!TILTVIEWER_EXIST) { ?><p><div id="message" class="error fade"><p><?php _e('The TiltViewer.swf is not in the .../plugins/nggflash-swf/ folder. TiltViewer will not work.','nggflash') ?></p></div></p><?php } else { ?>
                    <table  class="form-table">	
                        <tr>
                            <th><?php _e('Maximum JPG Size','nggflash') ?>:</th>
                            <td><input type="text" size="3" maxlength="4" id="ngg_tv_max_jpg_size" name="ngg_tv_max_jpg_size" value="<?php echo $nggflash->options['ngg_tv_max_jpg_size']; ?>" /> px <small>(<?php _e('Set this value to the largest dimension (width or height) of your largest image. TiltViewer uses this value to proportionately scale your images to fit.', 'nggflash'); ?>)</small></td>
                        </tr>
                        <tr>
                            <th><?php _e('Use Reload Button','nggflash') ?>:</th>
                            <td><select size="1" id="ngg_tv_use_reload_button" name="ngg_tv_use_reload_button">
                                <option value="true" <?php selected('true', $nggflash->options['ngg_tv_use_reload_button']); ?> ><?php _e('true', 'nggflash') ;?></option>
                                <option value="false" <?php selected('false', $nggflash->options['ngg_tv_use_reload_button']); ?> ><?php _e('false', 'nggflash') ;?></option>
                            </select> <small>(<?php _e('Defines whether to use the circular reload button under the images, or to use next/back arrow buttons for gallery paging.', 'nggflash'); ?>)</small></td>
                        </tr>
                        <tr>
                            <th><?php _e('Show Flip Button','nggflash') ?>:</th>
                            <td><select size="1" id="ngg_tv_show_flip_button" name="ngg_tv_show_flip_button">
                                <option value="true" <?php selected('true', $nggflash->options['ngg_tv_show_flip_button']); ?> ><?php _e('true', 'nggflash') ;?></option>
                                <option value="false" <?php selected('false', $nggflash->options['ngg_tv_show_flip_button']); ?> ><?php _e('false', 'nggflash') ;?></option>
                            </select> <small>(<?php _e('Defines whether to display the *flip* button at the bottom-right of a zoomed in image. Affects all images.', 'nggflash'); ?>)</small></td>
                        </tr>
                        <tr>
                            <th><?php _e('Show Link Button','nggflash') ?>:</th>
                            <td><select size="1" id="ngg_tv_showLinkButton" name="ngg_tv_showLinkButton">
                                <option value="true" <?php selected('true', $nggflash->options['ngg_tv_showLinkButton']); ?> ><?php _e('true', 'nggflash') ;?></option>
                                <option value="false" <?php selected('false', $nggflash->options['ngg_tv_showLinkButton']); ?> ><?php _e('false', 'nggflash') ;?></option>
                            </select> <small>(<?php _e('Defines whether to display the *go to Flickr page* button on the image flipside. Affects all images.', 'nggflash'); ?>)</small></td>
                        </tr>
                        <tr>
                            <th><?php _e('Link Label','nggflash') ?>:</th>
                            <td><input type="text" size="50" id="ngg_tv_linkLabel" name="ngg_tv_linkLabel" value="<?php echo $nggflash->options['ngg_tv_linkLabel']; ?>" /> <small>(<?php _e('Text to display as the flipside link button label.', 'nggflash'); ?>)</small></td>
                        </tr>
                        <tr>
                            <th><?php _e('Columns','nggflash') ?>:</th>
                            <td><input type="text" size="3" maxlength="2" id="ngg_tv_columns" name="ngg_tv_columns" value="<?php echo $nggflash->options['ngg_tv_columns']; ?>" /> <small>(<?php _e('Number of columns of images to display.', 'nggflash'); ?>)</small></td>
                        </tr>
                        <tr>
                            <th><?php _e('Rows','nggflash') ?>:</th>
                            <td><input type="text" size="3" maxlength="2" id="ngg_tv_rows" name="ngg_tv_rows" value="<?php echo $nggflash->options['ngg_tv_rows']; ?>" /> <small>(<?php _e('Number of rows of images to display.', 'nggflash'); ?>)</small></td>
                        </tr>
                        <tr>
                            <th><?php _e('Frame Color','nggflash') ?>:</th>
                            <td>#<input type="text" size="6" maxlength="6" id="ngg_tv_frame_color" name="ngg_tv_frame_color" onchange="setcolor('#previewBack', this.value)" value="<?php echo $nggflash->options['ngg_tv_frame_color']; ?>" />
                            <input type="text" size="1" readonly="readonly" id="previewBack" style="background-color: #<?php echo $nggflash->options['ngg_tv_frame_color']; ?>" /> <small>(<?php _e('Hexadecimal color value of the image frame.', 'nggflash'); ?>)</small></td>
                        </tr>
                        <tr>
                            <th><?php _e('Backside Color','nggflash') ?>:</th>
                            <td>#<input type="text" size="6" maxlength="6" id="ngg_tv_back_color" name="ngg_tv_back_color" onchange="setcolor('#previewBack', this.value)" value="<?php echo $nggflash->options['ngg_tv_back_color']; ?>" />
                            <input type="text" size="1" readonly="readonly" id="previewBack" style="background-color: #<?php echo $nggflash->options['ngg_tv_back_color']; ?>" /> <small>(<?php _e('Hexadecimal color value of the flipside background.', 'nggflash'); ?>)</small></td>
                        </tr>
                        <tr>
                            <th><?php _e('Background Inner Color','nggflash') ?>:</th>
                            <td>#<input type="text" size="6" maxlength="6" id="ngg_tv_bkgnd_inner_color" name="ngg_tv_bkgnd_inner_color" onchange="setcolor('#previewBack', this.value)" value="<?php echo $nggflash->options['ngg_tv_bkgnd_inner_color']; ?>" />
                            <input type="text" size="1" readonly="readonly" id="previewBack" style="background-color: #<?php echo $nggflash->options['ngg_tv_bkgnd_inner_color']; ?>" /> <small>(<?php _e('Hexadecimal color value of the stage background gradient center.', 'nggflash'); ?>)</small></td>
                        </tr>
                        <tr>
                            <th><?php _e('Background Outer Color','nggflash') ?>:</th>
                            <td>#<input type="text" size="6" maxlength="6" id="ngg_tv_bkgnd_outer_color" name="ngg_tv_bkgnd_outer_color" onchange="setcolor('#previewBack', this.value)" value="<?php echo $nggflash->options['ngg_tv_bkgnd_outer_color']; ?>" />
                            <input type="text" size="1" readonly="readonly" id="previewBack" style="background-color: #<?php echo $nggflash->options['ngg_tv_bkgnd_outer_color']; ?>" /> <small>(<?php _e('Hexadecimal color value of the stage background gradient edge.', 'nggflash'); ?>)</small></td>
                        </tr>
                        <tr>
                            <th><?php _e('Go Fullscreen Text','nggflash') ?>:</th>
                            <td><input type="text" size="50" id="ngg_tv_lang_go_full" name="ngg_tv_lang_go_full" value="<?php echo $nggflash->options['ngg_tv_lang_go_full']; ?>" /> <small>(<?php _e('The text displayed for the right-click *Go Fullscreen* menu option.', 'nggflash'); ?>)</small></td>
                        </tr>
                        <tr>
                            <th><?php _e('Exit Fullscreen Text','nggflash') ?>:</th>
                            <td><input type="text" size="50" id="ngg_tv_lang_exit_full" name="ngg_tv_lang_exit_full" value="<?php echo $nggflash->options['ngg_tv_lang_exit_full']; ?>" /> <small>(<?php _e('The text displayed for the right-click *Exit Fullscreen* menu option.', 'nggflash'); ?>)</small></td>
                        </tr>
                        <tr>
                            <th><?php _e('Flickr User ID','nggflash') ?>:</th>
                            <td><input type="text" size="50" id="ngg_tv_user_id" name="ngg_tv_user_id" value="<?php echo $nggflash->options['ngg_tv_user_id']; ?>" /> <small>(<?php _e('User ID of your Flickr account, which you can find <a href="http://www.flickr.com/services/api/explore/?method=flickr.people.findByUsername">here</a>.', 'nggflash'); ?>)</small></td>
                        </tr>
                            <th><?php _e('Tag Mode','nggflash') ?>:</th>
                            <td><select size="1" id="ngg_tv_tag_mode" name="ngg_tv_tag_mode">
                                <option value="any" <?php selected('any', $nggflash->options['ngg_tv_tag_mode']); ?> ><?php _e('any', 'nggflash') ;?></option>
                                <option value="all" <?php selected('all', $nggflash->options['ngg_tv_tag_mode']); ?> ><?php _e('all', 'nggflash') ;?></option>
                            </select> <small>(<?php _e(' Use "any" for an OR combination of tags (image can have 1 or more tags to be displayed) or "all" for an AND combination (image must have all tags to be displayed).', 'nggflash'); ?>)</small></td>
                        </tr>
                        <tr>						
                            <th><?php _e('Show Taken By Text','nggflash') ?>:</th>
                            <td><select size="1" id="ngg_tv_showTakenByText" name="ngg_tv_showTakenByText">
                                <option value="true" <?php selected('true', $nggflash->options['ngg_tv_showTakenByText']); ?> ><?php _e('true', 'nggflash') ;?></option>
                                <option value="false" <?php selected('false', $nggflash->options['ngg_tv_showTakenByText']); ?> ><?php _e('false', 'nggflash') ;?></option>
                            </select> <small>(<?php _e('Defines whether to display the \'taken by X on Y\' text on the image flipside.', 'nggflash'); ?>)</small></td>
                        </tr>
            
                    </table><br />
    
                <h2><?php _e('TiltViewer Pro Settings','nggflash'); ?></h2>		
    
                    <table  class="form-table">
                        <tr>						
                            <th><?php _e('Are you using TiltViewer Pro?','nggflash') ?>:</th>
                            <td><select size="1" id="have_pro_tv" name="have_pro_tv">
                                <option value="true" <?php selected('true', $nggflash->options['have_pro_tv']); ?> ><?php _e('yes', 'nggflash') ;?></option>
                                <option value="false" <?php selected('false', $nggflash->options['have_pro_tv']); ?> ><?php _e('no', 'nggflash') ;?></option>
                            </select> <small>(<?php _e('<font color="red">IMPORTANT:</font> The Pro options will only be available to you if you actually have the Pro version and if you answered yes!', 'nggflash'); ?>)</small></td>
                        </tr>
                        <tr>
                            <th><?php _e('Transparent Background','nggflash') ?>:</th>
                            <td><select size="1" id="ngg_tv_pro_bkgndTransparent" name="ngg_tv_pro_bkgndTransparent">
                                <option value="true" <?php selected('true', $nggflash->options['ngg_tv_pro_bkgndTransparent']); ?> ><?php _e('true', 'nggflash') ;?></option>
                                <option value="false" <?php selected('false', $nggflash->options['ngg_tv_pro_bkgndTransparent']); ?> ><?php _e('false', 'nggflash') ;?></option>
                            </select> <small>(<?php _e('Defines whether to hide the radial gradient background behind the image grid.', 'nggflash'); ?>)</small></td>
                        </tr>
                        <tr>
                            <th><?php _e('Show Fullscreen Option','nggflash') ?>:</th>
                            <td><select size="1" id="ngg_tv_pro_showFullscreenOption" name="ngg_tv_pro_showFullscreenOption">
                                <option value="true" <?php selected('true', $nggflash->options['ngg_tv_pro_showFullscreenOption']); ?> ><?php _e('true', 'nggflash') ;?></option>
                                <option value="false" <?php selected('false', $nggflash->options['ngg_tv_pro_showFullscreenOption']); ?> ><?php _e('false', 'nggflash') ;?></option>
                            </select> <small>(<?php _e('Defines whether to show the *Go Fullscreen* right-click menu option.', 'nggflash'); ?>)</small></td>
                        </tr>
                        <tr>
                            <th><?php _e('Frame Width','nggflash') ?>:</th>
                            <td><input type="text" size="3" maxlength="4" id="ngg_tv_pro_frameWidth" name="ngg_tv_pro_frameWidth" value="<?php echo $nggflash->options['ngg_tv_pro_frameWidth']; ?>" /> px <small>(<?php _e('Width of the image frames. To remove frames completely set this to -5.', 'nggflash'); ?>)</small></td>
                        </tr>
                        <tr>
                            <th><?php _e('Zoomed-in Distance','nggflash') ?>:</th>
                            <td><input type="text" size="4" maxlength="4" id="ngg_tv_pro_zoomedInDistance" name="ngg_tv_pro_zoomedInDistance" value="<?php echo $nggflash->options['ngg_tv_pro_zoomedInDistance']; ?>" /> <small>(<?php _e('Camera distance from image when zoomed in to an image. Increasing this value makes the image smaller.', 'nggflash'); ?>)</small></td>
                        </tr>
                        <tr>
                            <th><?php _e('Zoomed-out Distance','nggflash') ?>:</th>
                            <td><input type="text" size="4" maxlength="4" id="ngg_tv_pro_zoomedOutDistance" name="ngg_tv_pro_zoomedOutDistance" value="<?php echo $nggflash->options['ngg_tv_pro_zoomedOutDistance']; ?>" /> <small>(<?php _e('Camera distance from image-grid when zoomed out. Increasing this value makes the image-grid smaller.', 'nggflash'); ?>)</small></td>
                        </tr>
                        <tr>
                            <th><?php _e('Font Name','nggflash') ?>:</th>
                            <td><input type="text" size="50" id="ngg_tv_pro_fontName" name="ngg_tv_pro_fontName" value="<?php echo $nggflash->options['ngg_tv_pro_fontName']; ?>" /> <small>(<?php _e('Font style used by the flipside text. Note: this font is not embedded in the swf, so the user must have the specified font on their machine to view the font. If they don\'t have the specified font, they will see the default system font (usually \'sans\')', 'nggflash'); ?>)</small></td>
                        </tr>
                        <tr>
                            <th><?php _e('Title Font Size','nggflash') ?>:</th>
                            <td><input type="text" size="3" maxlength="3" id="ngg_tv_pro_titleFontSize" name="ngg_tv_pro_titleFontSize" value="<?php echo $nggflash->options['ngg_tv_pro_titleFontSize']; ?>" /> <small>(<?php _e('The font size of the title on the flipside', 'nggflash'); ?>)</small></td>
                        </tr>
                        <tr>
                            <th><?php _e('Description Font Size','nggflash') ?>:</th>
                            <td><input type="text" size="3" maxlength="3" id="ngg_tv_pro_descriptionFontSize" name="ngg_tv_pro_descriptionFontSize" value="<?php echo $nggflash->options['ngg_tv_pro_descriptionFontSize']; ?>" /> <small>(<?php _e('The font size of the description on the flipside', 'nggflash'); ?>)</small></td>
                        </tr>
                        <tr>
                            <th><?php _e('Nav Button Color','nggflash') ?>:</th>
                            <td>#<input type="text" size="6" maxlength="6" id="ngg_tv_pro_navButtonColor" name="ngg_tv_pro_navButtonColor" onchange="setcolor('#previewBack', this.value)" value="<?php echo $nggflash->options['ngg_tv_pro_navButtonColor']; ?>" />
                            <input type="text" size="1" readonly="readonly" id="previewBack" style="background-color: #<?php echo $nggflash->options['ngg_tv_pro_navButtonColor']; ?>" /> <small>(<?php _e('Hexadecimal color value of the navigation arrows.', 'nggflash'); ?>)</small></td>
                        </tr>
                        <tr>
                            <th><?php _e('Flip Button Color','nggflash') ?>:</th>
                            <td>#<input type="text" size="6" maxlength="6" id="ngg_tv_pro_flipButtonColor" name="ngg_tv_pro_flipButtonColor" onchange="setcolor('#previewBack', this.value)" value="<?php echo $nggflash->options['ngg_tv_pro_flipButtonColor']; ?>" />
                            <input type="text" size="1" readonly="readonly" id="previewBack" style="background-color: #<?php echo $nggflash->options['ngg_tv_pro_flipButtonColor']; ?>" /> <small>(<?php _e('Hexadecimal color value of the flip button.', 'nggflash'); ?>)</small></td>
                        </tr>
                        <tr>
                            <th><?php _e('Text Color','nggflash') ?>:</th>
                            <td>#<input type="text" size="6" maxlength="6" id="ngg_tv_pro_textColor" name="ngg_tv_pro_textColor" onchange="setcolor('#previewBack', this.value)" value="<?php echo $nggflash->options['ngg_tv_pro_textColor']; ?>" />
                            <input type="text" size="1" readonly="readonly" id="previewBack" style="background-color: #<?php echo $nggflash->options['ngg_tv_pro_textColor']; ?>" /> <small>(<?php _e('Hexadecimal color value of the text color.', 'nggflash'); ?>)</small></td>
                        </tr>
                        <tr>
                            <th><?php _e('Link Text Color','nggflash') ?>:</th>
                            <td>#<input type="text" size="6" maxlength="6" id="ngg_tv_pro_linkTextColor" name="ngg_tv_pro_linkTextColor" onchange="setcolor('#previewBack', this.value)" value="<?php echo $nggflash->options['ngg_tv_pro_linkTextColor']; ?>" />
                            <input type="text" size="1" readonly="readonly" id="previewBack" style="background-color: #<?php echo $nggflash->options['ngg_tv_pro_linkTextColor']; ?>" /> <small>(<?php _e('Hexadecimal color value of the flipside link text.', 'nggflash'); ?>)</small></td>
                        </tr>
                        <tr>
                            <th><?php _e('Link Background Color','nggflash') ?>:</th>
                            <td>#<input type="text" size="6" maxlength="6" id="ngg_tv_pro_linkBkgndColor" name="ngg_tv_pro_linkBkgndColor" onchange="setcolor('#previewBack', this.value)" value="<?php echo $nggflash->options['ngg_tv_pro_linkBkgndColor']; ?>" />
                            <input type="text" size="1" readonly="readonly" id="previewBack" style="background-color: #<?php echo $nggflash->options['ngg_tv_pro_linkBkgndColor']; ?>" /> <small>(<?php _e('Hexadecimal color value of the flipside link text background.', 'nggflash'); ?>)</small></td>
                        </tr>
                        <tr>
                            <th><?php _e('Link Font Size','nggflash') ?>:</th>
                            <td><input type="text" size="3" maxlength="3" id="ngg_tv_pro_linkFontSize" name="ngg_tv_pro_linkFontSize" value="<?php echo $nggflash->options['ngg_tv_pro_linkFontSize']; ?>" /> <small>(<?php _e('Font size of flipside link text.', 'nggflash'); ?>)</small></td>
                        </tr>
                        <tr>
                            <th><?php _e('Link Target','nggflash') ?>:</th>
                            <td><select size="1" id="ngg_tv_pro_linkTarget" name="ngg_tv_pro_linkTarget">
                                <option value="_self" <?php selected('_self', $nggflash->options['ngg_tv_pro_linkTarget']); ?> ><?php _e('_self', 'nggflash') ;?></option>
                                <option value="_blank" <?php selected('_blank', $nggflash->options['ngg_tv_pro_linkTarget']); ?> ><?php _e('_blank', 'nggflash') ;?></option>
                                <option value="_parent" <?php selected('_parent', $nggflash->options['ngg_tv_pro_linkTarget']); ?> ><?php _e('_parent', 'nggflash') ;?></option>
                                <option value="_top" <?php selected('_top', $nggflash->options['ngg_tv_pro_linkTarget']); ?> ><?php _e('_top', 'nggflash') ;?></option>
                                </select> <small>(<?php _e('"_self" specifies the current frame in the current window; "_blank" specifies a new window; "_parent" specifies the parent of the current frame; "_top" specifies the top-level frame in the current window.', 'nggflash'); ?>)</small></td>
                        </tr>
                    </table>
                    <div class="clear"> &nbsp; </div>
                    <div class="submit"><input type="submit" name="updateoption" value="<?php _e('Update') ;?> &raquo;"/></div>
                <?php } ?>
            </form>
		</div>
		
		<!-- AutoViewer settings -->
		
		<div id="autoviewer">
            <form name="autoviewersettings" method="POST" action="<?php echo $filepath.'#autoviewer'; ?>" >
                <?php wp_nonce_field('ngg_settings') ?>
                <input type="hidden" name="page_options" value="ngg_av_absolutepath,ngg_av_frame_color,ngg_av_frame_width,ngg_av_image_padding,ngg_av_display_time" />
                <h2><?php _e('AutoViewer Settings','nggflash'); ?></h2>
                <?php if (!AUTOVIEWER_EXIST) { ?><p><div id="message" class="error fade"><p><?php _e('The autoviewer.swf is not in the .../plugins/nggflash-swf/ folder. AutoViewer will not work.','nggflash') ?></p></div></p><?php } else { ?>
                    <table class="form-table">
                        <tr>
                            <th><?php _e('Frame Color','nggflash') ?>:</th>
                            <td>#<input type="text" size="6" maxlength="6" id="ngg_av_frame_color" name="ngg_av_frame_color" onchange="setcolor('#previewBack', this.value)" value="<?php echo $nggflash->options['ngg_av_frame_color']; ?>" />
                            <input type="text" size="1" readonly="readonly" id="previewBack" style="background-color: #<?php echo $nggflash->options['ngg_av_frame_color']; ?>" /> <small>(<?php _e('Hexadecimal color value of the image frame (e.g ff00ff).', 'nggflash'); ?>)</small></td>
                        </tr>
                        <tr>
                            <th><?php _e('Frame Width','nggflash') ?>:</th>
                            <td><input type="text" size="3" maxlength="4" id="ngg_av_frame_width" name="ngg_av_frame_width" value="<?php echo $nggflash->options['ngg_av_frame_width']; ?>" /> px <small>(<?php _e('Width of image frame in pixels.', 'nggflash'); ?>)</small></td>
                        </tr>
                        <tr>
                            <th><?php _e('Image Padding','nggflash') ?>:</th>
                            <td><input type="text" size="3" maxlength="4" id="ngg_av_image_padding" name="ngg_av_image_padding" value="<?php echo $nggflash->options['ngg_av_image_padding']; ?>" /> px <small>(<?php _e('Padding in pixels.', 'nggflash'); ?>)</small></td>
                        </tr>
                        <tr>
                            <th><?php _e('Display Time','nggflash') ?>:</th>
                            <td><input type="text" size="3" maxlength="2" id="ngg_av_display_time" name="ngg_av_display_time" value="<?php echo $nggflash->options['ngg_av_display_time']; ?>" /> <?php _e('seconds', 'nggflash'); ?> <small>(<?php _e('Time to display image in seconds', 'nggflash'); ?>)</small></td>
                        </tr>
    
                    </table>
                    <div class="clear"> &nbsp; </div>
                    <div class="submit"><input type="submit" name="updateoption" value="<?php _e('Update') ;?> &raquo;"/></div>
                <?php } ?>
            </form>
		</div>

		<div id="pcviewer">
            <form name="postcardviewersettings" method="POST" action="<?php echo $filepath.'#pcviewer'; ?>" >
                <?php wp_nonce_field('ngg_settings') ?>
                <input type="hidden" name="page_options" value="ngg_pv_cellDimension,ngg_pv_columns,ngg_pv_zoomOutPerc,ngg_pv_zoomInPerc,ngg_pv_frameWidth,ngg_pv_frameColor,ngg_pv_captionColor" />
                <h2><?php _e('PostcardViewer Settings','nggflash'); ?></h2>
                <?php if (!PCVIEWER_EXIST) { ?><p><div id="message" class="error fade"><p><?php _e('The pcviewer.swf is not in the .../plugins/nggflash-swf/ folder. PostcardViewer will not work.','nggflash') ?></p></div></p><?php } else { ?>
                    <table class="form-table">
                        <tr>
                            <th><?php _e('Cell Dimension','nggflash') ?>:</th>
                            <td><input type="text" size="3" maxlength="4" id="ngg_pv_cellDimension" name="ngg_pv_cellDimension" value="<?php echo $nggflash->options['ngg_pv_cellDimension']; ?>" /> px <small>(<?php _e('The size of the square *cell* that contains each image (pixels). Make this at least as big as your biggest image to avoid the images overlapping.', 'nggflash'); ?>)</small></td>
                        </tr>
                        <tr>
                            <th><?php _e('Columns','nggflash') ?>:</th>
                            <td><input type="text" size="3" maxlength="2" id="ngg_pv_columns" name="ngg_pv_columns" value="<?php echo $nggflash->options['ngg_pv_columns']; ?>" /> <small>(<?php _e('Number of columns of images. Rows are calculated automatically from the number of images in the gallery.', 'nggflash'); ?>)</small></td>
                        </tr>
                        <tr>
                            <th><?php _e('Zoomed-in Percentage','nggflash') ?>:</th>
                            <td><input type="text" size="4" maxlength="3" id="ngg_pv_zoomOutPerc" name="ngg_pv_zoomOutPerc" value="<?php echo $nggflash->options['ngg_pv_zoomOutPerc']; ?>" /> <small>(<?php _e('The amout of scale when zoomed out (percentage).', 'nggflash'); ?>)</small></td>
                        </tr>
                        <tr>
                            <th><?php _e('Zoomed-out Percentage','nggflash') ?>:</th>
                            <td><input type="text" size="4" maxlength="3" id="ngg_pv_zoomInPerc" name="ngg_pv_zoomInPerc" value="<?php echo $nggflash->options['ngg_pv_zoomInPerc']; ?>" /> <small>(<?php _e('The amout of scale when zoomed in (percentage).', 'nggflash'); ?>)</small></td>
                        </tr>
                        <tr>
                            <th><?php _e('Frame Color','nggflash') ?>:</th>
                            <td>#<input type="text" size="6" maxlength="6" id="ngg_pv_frameColor" name="ngg_pv_frameColor" onchange="setcolor('#previewBack', this.value)" value="<?php echo $nggflash->options['ngg_pv_frameColor']; ?>" />
                            <input type="text" size="1" readonly="readonly" id="previewBack" style="background-color: #<?php echo $nggflash->options['ngg_pv_frameColor']; ?>" /> <small>(<?php _e('Color of image frame (hexidecimal color value).', 'nggflash'); ?>)</small></td>
                        </tr>
                        <tr>
                            <th><?php _e('Frame Width','nggflash') ?>:</th>
                            <td><input type="text" size="3" maxlength="4" id="ngg_pv_frameWidth" name="ngg_pv_frameWidth" value="<?php echo $nggflash->options['ngg_pv_frameWidth']; ?>" /> px <small>(<?php _e('Width of image frame in pixels.', 'nggflash'); ?>)</small></td>
                        </tr>
                        <tr>
                            <th><?php _e('Caption Color','nggflash') ?>:</th>
                            <td>#<input type="text" size="6" maxlength="6" id="ngg_pv_captionColor" name="ngg_pv_captionColor" onchange="setcolor('#previewBack', this.value)" value="<?php echo $nggflash->options['ngg_pv_captionColor']; ?>" />
                            <input type="text" size="1" readonly="readonly" id="previewBack" style="background-color: #<?php echo $nggflash->options['ngg_pv_captionColor']; ?>" /> <small>(<?php _e('Color of captions (hexidecimal color value).', 'nggflash'); ?>)</small></td>
                        </tr>
                    </table>
                    <div class="clear"> &nbsp; </div>
                    <div class="submit"><input type="submit" name="updateoption" value="<?php _e('Update') ;?> &raquo;"/></div>
                <?php } ?>
            </form>
		</div>
		
		<!-- Setup -->
		<div id="fv_setup">
            <div class="wrap">
                <h2><?php _e('Reset options', 'nggallery') ;?></h2>
                    <form name="resetsettings" method="post">
                        <?php wp_nonce_field('ngg_uninstall') ?>
                        <p><?php _e('Reset all options/settings to the default installation.', 'nggallery') ;?></p>
                        <div align="center"><input type="submit" class="button" name="resetdefault" value="<?php _e('Reset settings', 'nggallery') ;?>" onclick="javascript:check=confirm('<?php _e('Reset all options to default settings ?\n\nChoose [Cancel] to Stop, [OK] to proceed.\n','nggallery'); ?>');if(check==false) return false;" /></div>
                    </form>
            </div>
    
            <div class="wrap">
            <h2><?php _e('Uninstall options from the database', 'nggflash') ;?></h2>
            
                <form name="resetsettings" method="post">
                    <?php wp_nonce_field('ngg_uninstall') ?>
                    <p><?php _e('You don\'t like NextGEN FlashViewer ?', 'nggflash') ;?></p>
                    <p><?php _e('No problem, before you deactivate this plugin press the Uninstall Button, because deactivating NextGEN FlashViewer does not remove any data that may have been created. ', 'nggflash') ;?></p>
                    <div align="center"><input type="submit" name="uninstall" class="button delete" value="<?php _e('Uninstall plugin', 'nggallery') ?>" onclick="javascript:check=confirm('<?php _e('You are about to Uninstall this plugin from WordPress.\nThis action is not reversible.\n\nChoose [Cancel] to Stop, [OK] to Uninstall.\n','nggallery'); ?>');if(check==false) return false;"/></div>
                </form>
            </div>
		</div>

		<!-- Credits -->
		<div id="fv_credits">
			<h2><?php _e('Credits','nggflash'); ?></h2>
			<p><?php _e('As always, when something has been created there are people to thank. This is that list:','nggflash'); ?></p>
			<p><a href="http://alexrabe.boelinger.com/" title="<?php _e('for the great NextGEN Gallery, the initial version of this plugin and general help.','nggflow'); ?>">Alex Rabe</a>, <a href="http://www.airtightinteractive.com/" title="<?php _e('for all the wonderful viewers','nggflow'); ?>">Airtight Interactive</a>, <a href="http://es-xchange.com/" title="<?php _e('for the Spanish language files','nggflow'); ?>">Karin</a>, <a href="http://gidibao.net/" title="<?php _e('for the Italian language files','nggflow'); ?>">Gianni Diurno</a>, <a href="http://www.maiermartin.de/" title="<?php _e('Idea to add PostcardViewer','nggflow'); ?>">Martin Maier</a>, Antonio,  Fabian</p>
		</div>

		<!-- Donate -->
		<div id="fv_donation">
			<h2><?php _e('Donate','nggflash'); ?></h2>
			<p><?php _e('We spend a lot of time and effort on implementing new features and on the maintenance of this plugin, so if you feel generous and have a few bucks to spare, then please consider to donate.','nggflash'); ?></p>
			<p><?php _e('Click on the button below and you will be redirected to the PayPal site where you can make a safe donation','nggflash'); ?></p>
			<p>
				<form action="https://www.paypal.com/cgi-bin/webscr" method="post" >
                    <input type="hidden" name="cmd" value="_xclick"/><input type="hidden" name="business" value="bo@travel-junkie.com"/>
                    <input type="hidden" name="item_name" value="<?php _e('NextGEN FlashViewer Plugin @ http://shabushabu-webdesign.com','nggflash'); ?>"/>
                    <input type="hidden" name="no_shipping" value="1"/><input type="hidden" name="return" value="http://shabushabu-webdesign.com/" />
                    <input type="hidden" name="cancel_return" value="http://shabushabu-webdesign.com/"/>
                    <input type="hidden" name="lc" value="US" /> 
                    <input type="hidden" name="currency_code" value="USD"/>
                    <input type="hidden" name="tax" value="0"/>
                    <input type="hidden" name="bn" value="PP-DonationsBF"/>
                    <input type="image" src="https://www.paypal.com/en_US/i/btn/x-click-but21.gif" name="submit" alt="<?php _e('Make payments with PayPal - it\'s fast, free and secure!','nggflash'); ?>" style="border: none;"/>
				</form>
			</p>
			<p><?php _e('Thank you and all the best!','nggflash'); ?><br />ShabuShabu Webdesign team</p>
		</div>

	</div>	
	<?php
}
?>