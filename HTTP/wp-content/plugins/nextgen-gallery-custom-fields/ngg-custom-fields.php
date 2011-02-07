<?php
/*
Plugin Name: NextGEN Custom Fields
Description: This plugin allows users to add custom fields to images in NextGEN Gallery 
Version: 1.0.2
Author: Shaun Alberts
*/
/*
Copyright 2009  Shaun Alberts  (email : shaunalberts@gmail.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// stop direct call
if(preg_match("#".basename(__FILE__)."#", $_SERVER["PHP_SELF"])) {die("You are not allowed to call this page directly.");}

//{
	define("NGGCF_IMAGES", 1);
	define("NGGCF_GALLERY", 2);
	
	//install funcs{
		register_activation_hook(__FILE__, "nggcf_install");
		
		function nggcf_install($upgrade=false) {
			global $wpdb;
			
			$table_name = $wpdb->prefix."nggcf_fields";
			$sql = "CREATE TABLE ".$table_name." (
				id BIGINT(19) NOT NULL AUTO_INCREMENT,
				field_name TEXT NULL,
				field_type TEXT NULL,
				ngg_type INT NOT NULL DEFAULT 1,
				drop_options TEXT NULL,
				dateadded DATETIME DEFAULT '0000-00-00 00:00:00' NOT NULL,
				UNIQUE KEY id (id)
			);";
			
			require_once(ABSPATH."wp-admin/includes/upgrade.php");
			dbDelta($sql);
			
			$table_name = $wpdb->prefix."nggcf_fields_link";
			$sql = "CREATE TABLE ".$table_name." (
				id BIGINT(19) NOT NULL AUTO_INCREMENT,
				field_id BIGINT(19) NOT NULL DEFAULT 0,
				gid BIGINT(19) NOT NULL DEFAULT 0,
				UNIQUE KEY id (id)
			);";
			
			require_once(ABSPATH."wp-admin/includes/upgrade.php");
			dbDelta($sql);
			
			
			$table_name = $wpdb->prefix."nggcf_field_values";
			$sql = "CREATE TABLE ".$table_name." (
				id BIGINT(19) NOT NULL AUTO_INCREMENT,
				pid bigint(19) DEFAULT '0' NOT NULL,
				fid bigint(19) DEFAULT '0' NOT NULL,
				field_value TEXT NULL,
				ngg_type INT NOT NULL DEFAULT 1,
				dateadded DATETIME DEFAULT '0000-00-00 00:00:00' NOT NULL,
				UNIQUE KEY id (id)
			);";
			
			require_once(ABSPATH."wp-admin/includes/upgrade.php");
			dbDelta($sql);
			
			if($upgrade) {
				$fields = nggcf_get_field_list(NGGCF_IMAGES);				
				global $nggdb;
				$nggGalleries = $nggdb->find_all_galleries();
				
				
				if($fields && $nggGalleries) {
					$linkErr = false;
					foreach ($fields as $key=>$val) {
						if(!nggcf_get_linked_galleries($val->id)) {
							foreach ($nggGalleries as $gal) {
								$qry = "INSERT INTO ".$wpdb->prefix."nggcf_fields_link (`id`, `field_id`, `gid`) VALUES(null, '".$wpdb->escape($val->id)."', '".$wpdb->escape($gal->gid)."')";
								if(!$wpdb->query($qry)) {
									$linkErr = true;
								}
							}
						}
					}
				}

				if($linkErr) {
					_e("Database upgrade done, but there was a problem linking your existing fields to galleries.  You will need to manually link each field", "nggcustomfields");
				}else{
					_e("Database upgrade done", "nggcustomfields");
				}
			}
		}
	//}
	
	//api stuff{
		define("NGGCF_FIELD_TYPE_INPUT", 1);
		define("NGGCF_FIELD_TYPE_TEXTAREA", 2);
		define("NGGCF_FIELD_TYPE_SELECT", 3);
		
		//save custom field values (checks if it needs to insert or update)
		function nggcf_save_pics($gid, $post) {
			global $wpdb;
			if ( is_array($post["nggcf_fields"]) ) {
				foreach ($post["nggcf_fields"] as $pid=>$fields) {
					foreach ((array)$fields as $fid=>$val) {
						if($row = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."nggcf_field_values WHERE fid = '$fid' AND pid = '$pid' AND ngg_type = '".NGGCF_IMAGES."'")) {
							$wpdb->query("UPDATE ".$wpdb->prefix."nggcf_field_values SET field_value = '".$wpdb->escape($val)."' WHERE id = ".$row->id);
						}else{
							if($wpdb->escape($val)) { //only if there is a value, add it to the db 
								$wpdb->query("INSERT INTO ".$wpdb->prefix."nggcf_field_values (id, pid, fid, field_value, dateadded, ngg_type) VALUES (null, '$pid', '$fid', '".$wpdb->escape($val)."', '".date("Y-m-d H:i:s", time())."', '".NGGCF_IMAGES."')");
							}
						}
					}
				}
			}
			
			if(is_array($post["nggcf_gallery"])) {
				$galleryId = $post["nggcf_gallery"]["ngg_gallery_id"];
				unset($post["nggcf_gallery"]["ngg_gallery_id"]);
				
				foreach ($post["nggcf_gallery"] as $fid=>$val) {
					if($row = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."nggcf_field_values WHERE fid='".$fid."' AND pid='".$galleryId."' AND ngg_type = '".NGGCF_GALLERY."'")) {
						$wpdb->query("UPDATE ".$wpdb->prefix."nggcf_field_values SET field_value = '".$wpdb->escape($val)."' WHERE id = ".$row->id);
					}else{
						if($wpdb->escape($val)) { //only if there is a value, add it to the db 
							$wpdb->query("INSERT INTO ".$wpdb->prefix."nggcf_field_values (id, pid, fid, field_value, dateadded, ngg_type) VALUES (null, '".$galleryId."', '$fid', '".$wpdb->escape($val)."', '".date("Y-m-d H:i:s", time())."', '".NGGCF_GALLERY."')");
						}
					}
				}
			}
		}
		
		//api that saves new custom fields
		function nggcf_save_field($config) {
			global $wpdb;
			
			if($wpdb->escape($config["field_name"]) || $wpdb->escape($config["id"])) {
				if($wpdb->escape($config["id"]) && $wpdb->escape($config["drop_options"])) {
					$qry = "UPDATE ".$wpdb->prefix."nggcf_fields SET drop_options = '".$wpdb->escape($config["drop_options"])."' WHERE id = '".$wpdb->escape($config["id"])."'";
					if($wpdb->query($qry) !== false) {
						return true;
					}else{
						return "ERROR: Failed to save field";
					}
				}else if($wpdb->escape($config["id"]) && $wpdb->escape($config["field_name"])) {
					$qry = "UPDATE ".$wpdb->prefix."nggcf_fields SET field_name = '".$wpdb->escape($config["field_name"])."' WHERE id = '".$wpdb->escape($config["id"])."'";
					if($wpdb->query($qry) !== false) {
						return true;
					}else{
						return "ERROR: Failed to save field name";
					}
				}else if($wpdb->escape($config["id"]) && $wpdb->escape($config["linkedit"])) {
					$links = nggcf_get_linked_galleries($config["id"]); //get current links
					
					//loop current links
					foreach ((array)$links as $key=>$val) {
						//delete if not in post list (the link, and any field value)
						if(!$config["galleries"][$val->gid]) {
							$field = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."nggcf_fields WHERE id = ".$val->nggcf_field_id);
							if($field->ngg_type == NGGCF_GALLERY) {
								$wpdb->query("DELETE FROM ".$wpdb->prefix."nggcf_field_values WHERE fid = ".$val->nggcf_field_id." AND pid = ".$val->gid); //remove data from that field in that gallery
							}else if($field->ngg_type == NGGCF_IMAGES) {
								$list = array();
								if($fields = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."ngg_pictures WHERE galleryid = ".$val->gid)) {
									foreach ($fields as $pic) {
										$list[] = $pic->pid;
									}
									if($list) { //meh, if there was $fields the should always be $list, but this pony isnt built for speed :)
										$wpdb->query("DELETE FROM ".$wpdb->prefix."nggcf_field_values WHERE fid = ".$val->nggcf_field_id." AND pid IN (".implode(", ", $list).")"); //remove data from that field in that gallery
									}
								}
							}
							$wpdb->query("DELETE FROM ".$wpdb->prefix."nggcf_fields_link WHERE id = ".$val->link_id); //remove link
							//$wpdb->query("DELETE FROM ".$wpdb->prefix."nggcf_field_values WHERE fid = ".$val->nggcf_field_id); //remove data from that field in that gallery
						}
						
						//remove from post list if in currnt
						if($config["galleries"][$val->gid]) {
							unset($config["galleries"][$val->gid]);
						}
					}
					
					//insert whats left in post list (the new links)
					foreach ((array)$config["galleries"] as $key=>$val) {
						$qry = "INSERT INTO ".$wpdb->prefix."nggcf_fields_link (`id`, `field_id`, `gid`) VALUES(null, '".$wpdb->escape($config["id"])."', '".$wpdb->escape($key)."')";
						$wpdb->query($qry);
					}
					
					return true;
				}else{
					if($wpdb->get_row("SELECT * FROM ".$wpdb->prefix."nggcf_fields WHERE field_name = '".$wpdb->escape($config["field_name"])."' AND ngg_type = '".$wpdb->escape($config["ngg_type"])."'")) {
						return "ERROR: Field name already exists";
					}
					if($config["field_type"] != NGGCF_FIELD_TYPE_SELECT) { //can only have drop opts if it is a drop down
						$config["drop_options"] = "";
					}
					$qry = "INSERT INTO ".$wpdb->prefix."nggcf_fields (`id`, `field_name`, `field_type`, `drop_options`, `ngg_type`) VALUES (null, '".$wpdb->escape($config["field_name"])."', '".$wpdb->escape($config["field_type"])."', '".$wpdb->escape($config["drop_options"])."', '".$wpdb->escape($config["ngg_type"])."')";
					if($wpdb->query($qry)) {
						$linkerr = false;
						$fid = $wpdb->insert_id;
						foreach ((array)$config["galleries"] as $key=>$val) {
							$qry = "INSERT INTO ".$wpdb->prefix."nggcf_fields_link (`id`, `field_id`, `gid`) VALUES(null, '".$wpdb->escape($fid)."', '".$wpdb->escape($key)."')";
							if(!$wpdb->query($qry)) {
								$linkerr = true;
							}
						}
						if($linkerr) {
							return "ERROR: Field was saved successfully, but the system failed to link the field to 1 or more galleries";
						}else{
							return true;
						}
					}else{
						return "ERROR: Failed to save field";
					}
				}
			}else{
				return "ERROR: Bad field name";
			}
		}
		
		//api that deletes a column from the list, and removes all values saved for it
		function nggcf_delete_field($fid) {
			global $wpdb;
			if(is_numeric($fid)) {
				if($wpdb->query("DELETE FROM ".$wpdb->prefix."nggcf_field_values WHERE fid = ".$fid) !== false) {
					if($wpdb->query("DELETE FROM ".$wpdb->prefix."nggcf_fields WHERE id = ".$fid) !== false) {
						return true;
					}
				}
				return false;
			}else{
				return false;
			}
		}

		//get a list of all custom fields
		function nggcf_get_field_list($ngg_type, $gid=null) {
			global $wpdb;
			
			if($gid) {
				$qry = "SELECT field.* FROM ".$wpdb->prefix."nggcf_fields_link AS link LEFT JOIN ".$wpdb->prefix."nggcf_fields AS field ON link.field_id = field.id WHERE field.ngg_type = ".$wpdb->escape($ngg_type)." AND link.gid = '".$wpdb->escape($gid)."'";
			}else{
				$qry = "SELECT * FROM ".$wpdb->prefix."nggcf_fields WHERE ngg_type = ".$wpdb->escape($ngg_type);
			}
			$fields = $wpdb->get_results($qry);
			return $fields;
		}
		
		//get what galleries are linked to a field
		function nggcf_get_linked_galleries($fid) {
			global $wpdb;
			if(is_numeric($fid)) {
				return $wpdb->get_results("SELECT gal.*, link.id AS link_id, link.field_id AS nggcf_field_id FROM ".$wpdb->prefix."nggcf_fields_link AS link LEFT JOIN ".$wpdb->prefix."ngg_gallery AS gal ON link.gid = gal.gid WHERE link.field_id = '".$wpdb->escape($fid)."'");
			}else{
				return false;
			}
		}
		
		function nggcf_hold_field_values($pid) {
			global $wpdb, $nggcf_values;
			
			//only run the select once (store results in mem for access later if func called again with same pid)
			if(!$nggcf_values[$pid]) {
				$value = $wpdb->get_results("SELECT vals.*, cols.field_name, cols.id AS field_id, cols.field_type FROM ".$wpdb->prefix."nggcf_field_values AS vals LEFT JOIN ".$wpdb->prefix."nggcf_fields AS cols ON vals.fid = cols.id WHERE vals.pid = '".$wpdb->escape($pid)."' AND cols.ngg_type = '".NGGCF_IMAGES."'");
				$nggcf_values[$pid] = array();
				foreach ((array)$value as $key=>$val) {
					$nggcf_values[$pid][stripslashes($val->field_name)] = $val;
				}
			}
		}

		function nggcf_hold_gallery_field_values($gid) {
			global $wpdb, $nggcf_field_values;
			
			if(!$nggcf_field_values[$gid]) {
				$value = $wpdb->get_results("SELECT vals.*, cols.field_name, cols.id AS field_id, cols.field_type FROM ".$wpdb->prefix."nggcf_field_values AS vals LEFT JOIN ".$wpdb->prefix."nggcf_fields AS cols ON vals.fid = cols.id WHERE cols.ngg_type = '".NGGCF_GALLERY."' AND vals.pid = '".$wpdb->escape($gid)."'");
				
				foreach ((array)$value as $key=>$val) {
					$nggcf_field_values[$gid][stripslashes($val->field_name)] = stripslashes($val->field_value);
				}
			}
		}
	//}
	
	add_action("admin_menu", "nggcf_admin_menu");
	
	function nggcf_admin_menu() {
		add_menu_page("NextGEN Gallery Custom Fields", "NGG Custom Fields", 8, __FILE__, "nggcf_plugin_options");
		add_submenu_page(__FILE__, "Setup NextGEN Gallery Custom Fields", "Setup Fields", 8, __FILE__, "nggcf_plugin_options");
	}
	
	
	function nggcf_plugin_options() {
		$filepath = admin_url()."admin.php?page=".$_GET["page"];
		?>
		<div class="wrap">
			<?php
			switch($_GET["mode"]) {
			case "gallery"	: nggcf_image_options(NGGCF_GALLERY);	break;
			case "images"		: nggcf_image_options(NGGCF_IMAGES);	break;
			case "upgrade"	:	nggcf_install(true);	break;
			default : 
			?>
			<h2><?php _e("NextGEN Gallery Custom Fields Options", "nggcustomfields"); ?></h2>
			<div id="poststuff">
				<ul>
					<li><a href="<?php echo $filepath."&mode=images"; ?>">Image Custom Fields</a> <em>(Add custom fields to be added to images inside NextGEN Galleries)</em></li>
					<li><a href="<?php echo $filepath."&mode=gallery"; ?>">Gallery Custom Fields</a> <em>(Add custom fields to be added to NextGEN Galleries)</em></li>
				</ul>
			</div>
			<?php
			break;
			}
			?>
		</div> <!-- end .wrap -->
		<?php
	}
	
	add_action("ngg_manage_gallery_custom_column", "nggcf_admin_col", 10 ,2);
	add_filter("ngg_manage_gallery_columns", "nggcf_manage_cols");
	add_action("ngg_update_gallery", "nggcf_save_pics", 10, 2);
	add_filter("ngg_image_object", "nggcf_image_obj", 10, 2); // new in ngg 1.2.1
	add_action("ngg_add_new_gallery_form", "nggcf_new_gallery_form"); //new in ngg 1.4.0a
	add_action("ngg_created_new_gallery", "nggcf_add_new_gallery"); //new in ngg 1.4.0a
	
	function nggcf_image_options($type) {
		if($type == NGGCF_GALLERY) {
			$filepath = admin_url()."admin.php?page=".$_GET["page"]."&mode=gallery";
			$nggtype = NGGCF_GALLERY;
			?>
			<h2><?php _e("Setup Gallery Custom Fields", "nggcustomfields"); ?></h2>
			<?php
		}elseif($type == NGGCF_IMAGES) {
			$filepath = admin_url()."admin.php?page=".$_GET["page"]."&mode=images";
			$nggtype = NGGCF_IMAGES;
			?>
			<h2><?php _e("Setup Image Custom Fields", "nggcustomfields"); ?></h2>
			<?php
		}
		
		if($_POST) {
			$conf = $_POST["conf"];
			//TODO, if save existing drop records, maybe we should make sure none of the options that are currently linked to images have been changed?
			if(($err = nggcf_save_field($conf)) !== true) {
				?>
				<div class="nggcf-error">
				<h3 class="nggcf-error-h3">Error Saving Data</h3>
				The following error was returned when trying to save the custom field:<br />
				<?php echo $err; ?>
				</div>
				<?php
			}
		}
		if(is_numeric($_GET["delete"])) {
			if(!nggcf_delete_field($_GET["delete"])) {
				?>
				<div class="nggcf-error">
				<h3 class="nggcf-error-h3">Error Deleting Data</h3>
				There was an error trying to delete the field and its data.  Please try again in a moment.
				<?php echo $err; ?>
				</div>
				<?php
			}
		}
		?>
		
		<?php
		$fields = nggcf_get_field_list($nggtype);
		global $nggdb;
		$nggGalleries = $nggdb->find_all_galleries();
		if($fields) {
			?>
			<h3><?php _e("Existing Fields", "nggcustomfields");?></h3>
			<table cellspacing="0" class="widefat fixed" id="table-existing">
				<thead>
					<tr>
						<th style="width:250px;"><?php _e("Field Name", "nggcustomfields");?></th>
						<th style="width:250px;"><?php _e("Field Type", "nggcustomfields");?></th>
						<th><?php _e("Actions", "nggcustomfields");?></th>
					</tr>
				</thead>
				<?php
				foreach ((array)$fields as $key=>$val) {
					$linked = nggcf_get_linked_galleries($val->id);
					?>
					<tr>
						<td>
							<?php
							if($_GET["editname"] == $val->id) { 
								$fstyle = "block";
								$nstyle = "none";
							}else{
								$fstyle = "none";
								$nstyle = "block";
							} 
							?>
							<form id="edit_field_form_<?php echo $val->id ?>" method="POST" action="<?php echo $filepath; ?>" accept-charset="utf-8" style="display:<?php echo $fstyle; ?>;">
								<input type="hidden" name="conf[id]" value="<?php echo $val->id; ?>" />
								<input type="text" name="conf[field_name]" value="<?php echo stripslashes($val->field_name);  ?>" />
								<input class="button-primary" type="submit" value="<?php _e("Save", "nggcustomfields") ;?>"/>
							</form>
							<span id="edit_field_name_<?php echo $val->id ?>" style="display:<?php echo $nstyle; ?>"><?php echo stripslashes($val->field_name); ?></span>
						</td>
						<td>
							<?php
							switch($val->field_type) {
							case NGGCF_FIELD_TYPE_INPUT : echo "Text Input"; break;
							case NGGCF_FIELD_TYPE_TEXTAREA : echo "Text Area"; break;
							case NGGCF_FIELD_TYPE_SELECT : echo "Drop Down"; break;
							}
							?>
						</td>
						<td>
							[ <a id="nggcf_edit_field_name_<?php echo $val->id; ?>" class="nggcf_edit_field_name" href="<?php echo $filepath; ?>&editname=<?php echo $val->id; ?>">Edit Name</a> ]
							[ <a id="nggcf_edit_field_link_<?php echo $val->id; ?>" class="nggcf_edit_field_link" href="<?php echo $filepath; ?>&editlink=<?php echo $val->id; ?>">Edit Linked Galleries</a> ]
							[ <a class="nggcf_del_field" href="<?php echo $filepath; ?>&delete=<?php echo $val->id; ?>">Delete Field</a> ]
							<?php if($val->field_type == NGGCF_FIELD_TYPE_SELECT) { ?>
								[ <a id="nggcf_edit_field_<?php echo $val->id; ?>" class="nggcf_edit_field" href="<?php echo $filepath; ?>&edit=<?php echo $val->id; ?>">Edit Options</a> ]
							<?php } ?>

							<div id="nggcf-edit-link-<?php echo $val->id; ?>" class="nggcf-edit-link" style="display:<?php echo($_GET["editlink"] == $val->id ? "block" : "none"); ?>;">
								<form id="" method="POST" action="<?php echo $filepath; ?>" accept-charset="utf-8" >
									<input type="hidden" name="conf[id]" value="<?php echo $val->id; ?>" />
									<input type="hidden" name="conf[linkedit]" value="1" /> <!-- just so the api know what we are trying to save -->
									<?php
									foreach ($nggGalleries as $gval) {
										$isLinked = "";
										foreach ($linked as $link) {
											if($gval->gid == $link->gid) {
												$isLinked = "checked";
												break;
											}
										}
										echo "<input type='checkbox' name='conf[galleries][".$gval->gid."]' value='1' ".$isLinked." /> ".$gval->name."<br />";
									}
									?>
									
									<br /><strong>(If you unselect a gallery, any values saved for this field in that gallery will be deleted too!)</strong>
									<div class="submit">
										<input class="button-primary" type="submit" value="<?php _e("Save Links", "nggcustomfields") ;?>"/>
									</div>
								</form>
							</div>
							
							<?php if($val->field_type == NGGCF_FIELD_TYPE_SELECT) { ?>
								<div id="nggcf-edit-options-<?php echo $val->id; ?>" class="nggcf-edit-options" style="display:<?php echo($_GET["edit"] == $val->id ? "block" : "none"); ?>;">
									<form id="" method="POST" action="<?php echo $filepath; ?>" accept-charset="utf-8" >
										<input type="hidden" name="conf[id]" value="<?php echo $val->id; ?>" />
										<textarea cols="33" name="conf[drop_options]"><?php echo stripslashes($val->drop_options); ?></textarea><br /><i>eg: Some Option, Another Option, Third Option</i>
										<div class="submit">
											<input class="button-primary" type="submit" value="<?php _e("Save Field", "nggcustomfields") ;?>"/>
										</div>
									</form>
								</div>
								<?php } ?>
						</td>
					</tr>
					<?php
				}
			?>
			</table>
			<?php
		}
		?>
		
		<br />
		<div id="poststuff">
			<form id="" method="POST" action="<?php echo $filepath; ?>" accept-charset="utf-8" >
				<input type="hidden" name="conf[ngg_type]" value="<?php echo $nggtype; ?>" />
				<div class="postbox">
					<h3><?php _e("Add New Field", "nggcustomfields") ;?></h3>
					<table class="form-table">
						<tr valign="top"> 
							<th><?php _e("Display Name", "nggcustomfields") ;?>:</th> 
							<td><input type="text" size="35" name="conf[field_name]" value="" /></td>
						</tr>
						
						<tr valign="top"> 
							<th><?php _e("Show on Galleries", "nggcustomfields") ;?>:</th> 
							<td>
							<?php
							if($nggGalleries) {
								foreach ($nggGalleries as $key=>$val) {
									echo "<input type='checkbox' name='conf[galleries][".$val->gid."]' value='1' checked /> ".$val->name."<br />";
								}
							}else{
								_e("No Galleries Found Yet", "nggcustomfields");
								echo "!";
							}
							?>
							</td>
						</tr>

					
						<tr valign="top"> 
							<th><?php _e("Field Type", "nggcustomfields") ;?>:</th> 
							<td>
								<select id="field_type" name="conf[field_type]" onchange="toggleDropOps(this.value);">
								<option value="<?php echo NGGCF_FIELD_TYPE_INPUT; ?>">Text Input</option>
								<option value="<?php echo NGGCF_FIELD_TYPE_TEXTAREA; ?>">Text Area</option>
								<option value="<?php echo NGGCF_FIELD_TYPE_SELECT; ?>">Select Drop Down</option>
								</select>
							</td>
						</tr>
						
						<tr valign="top" id="drop_options"> 
							<th><?php _e("Drop Down Options (comma seperated list)", "nggcustomfields") ;?>:</th> 
							<td><textarea cols="33" name="conf[drop_options]"></textarea><br /><i>eg: Some Option, Another Option, Third Option</i></td>
						</tr>
					</table>
					
					<div class="submit">
						<input class="button-primary" type="submit" value="<?php _e("Create Field", "nggcustomfields") ;?>"/>
					</div>
				</div>
			</form>
		</div>
		
		<script>
		jQuery(document).ready(function(){
				//hide drop opts boxes for fields not needing them
				if(document.getElementById("field_type").value != <?php echo NGGCF_FIELD_TYPE_SELECT; ?>) {
					document.getElementById("drop_options").style.display = "none";
				}
				
				//js confirm on the delete links
				jQuery("a.nggcf_del_field").each(function() {
						this.onclick = function() {
							if(confirm("Are you sure you want to permanently remove this field and all its saved values?")) {
								return true;
							}else{
								return false;
							}
						}
				});
				
				jQuery("a.nggcf_edit_field").each(function() {
						this.onclick = function() {
							var fid = this.id.substr(17); //get the db row id off the string id of the el
							jQuery('#nggcf-edit-options-'+fid).toggle("normal");
							return false;
						}
				});

				jQuery("a.nggcf_edit_field_name").each(function() {
						this.onclick = function() {
							var fid = this.id.substr(22); //get the db row id off the string id of the el
							jQuery('#edit_field_form_'+fid).toggle("normal");
							jQuery('#edit_field_name_'+fid).toggle("normal");
							return false;
						}
				});
				
				jQuery("a.nggcf_edit_field_link").each(function() {
						this.onclick = function() {
							var fid = this.id.substr(22); //get the db row id off the string id of the el
							jQuery('#nggcf-edit-link-'+fid).toggle("normal");
							return false;
						}
				});
				
				
		});
		
		function toggleDropOps(val) {
			if(val == <?php echo NGGCF_FIELD_TYPE_SELECT; ?>) {
				document.getElementById("drop_options").style.display = "";
			}else{
				document.getElementById("drop_options").style.display = "none";
			}
		}
		</script>
		<?php
	}
	
	//add the col to array of cols
	function nggcf_manage_cols($gallery_columns) {
		global $wpdb;
		$fields = nggcf_get_field_list(NGGCF_IMAGES, $_GET["gid"]);
		
		foreach ((array)$fields as $key=>$val) {
			$gallery_columns[$val->field_name] = stripslashes($val->field_name);
		}
		
		return $gallery_columns;
	}
	
	//the field for managing the images in a gallery
	function nggcf_admin_col($gallery_column_key, $pid) {
		global $wpdb, $ngg_edit_gallery;
		
		$custCol = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."nggcf_fields WHERE field_name = '".addslashes($gallery_column_key)."'");
		$value = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."nggcf_field_values WHERE fid = '".$custCol->id."' AND pid = '$pid'");
		
		switch($custCol->field_type) {
		case NGGCF_FIELD_TYPE_INPUT :?>
			<input name="nggcf_fields[<?php echo $pid ?>][<?php echo $custCol->id ?>]" style="width:95%;" value="<?php echo stripslashes($value->field_value); ?>" />
			<?php	break;
		case NGGCF_FIELD_TYPE_TEXTAREA :?>
			<textarea name="nggcf_fields[<?php echo $pid ?>][<?php echo $custCol->id ?>]" style="width:95%;"><?php echo stripslashes($value->field_value); ?></textarea>
			<?php	break;
		case NGGCF_FIELD_TYPE_SELECT :
			$opts = explode(",", $custCol->drop_options);
			?>
			<select name="nggcf_fields[<?php echo $pid ?>][<?php echo $custCol->id ?>]">
			<option value=""></option>
			<?php
				foreach ((array)$opts as $key=>$val) {
					?>
					<option value="<?php echo stripslashes(trim($val)); ?>"<?php echo trim($val) == $value->field_value ? " selected" : "" ?>><?php echo stripslashes(trim($val)); ?></option>
					<?php
				}
			?>
			</select>
			<?php	break;
		}
		
		if(!$ngg_edit_gallery) {
			$ngg_edit_gallery = true;
			
			$fields = nggcf_get_field_list(NGGCF_GALLERY, $_GET["gid"]);
			?>
			<script type="text/javascript"> 
				jQuery(document).ready(function() {
						jQuery("#gallerydiv table.form-table").each(function(item) { //the table with gallery fields
								var row = this.insertRow(this.rows.length);
								var cell = row.insertCell(0);
								cell.align = "left";
								cell.colSpan = 4;
								cell.innerHTML = "Custom Columns<hr /><input type='hidden' name='nggcf_gallery[ngg_gallery_id]' value='<?php echo $_GET["gid"]; ?>' />";
								
								<?php
								foreach ((array)$fields as $key=>$val) {
									?>
									row = this.insertRow(this.rows.length);
									cell = row.insertCell(0);
									cell.align = "right";
									cell.innerHTML = '<?php echo $val->field_name; ?>';
									
									cell = row.insertCell(1);
									
									<?php
									$value = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."nggcf_field_values WHERE pid = '".$wpdb->escape($_GET["gid"])."' AND fid = '".$val->id."' AND ngg_type = '".NGGCF_GALLERY."'");
									
									switch($val->field_type) {
									case NGGCF_FIELD_TYPE_INPUT :?>
										cell.innerHTML = '<input name="nggcf_gallery[<?php echo $val->id; ?>]" style="width:95%;" value="<?php echo $value->field_value; ?>" />';
										<?php	break;
									case NGGCF_FIELD_TYPE_TEXTAREA :?>
										cell.innerHTML = '<textarea name="nggcf_gallery[<?php echo $val->id; ?>]" style="width:95%;"><?php echo str_replace(array("\r","\n"), array("\\r", "\\n"), $value->field_value); ?></textarea>';
										<?php	break;
									case NGGCF_FIELD_TYPE_SELECT :
										$opts = explode(",", $val->drop_options);
										?>
										var str;
										str = '<select name="nggcf_gallery[<?php echo $val->id; ?>]">';
										str += '<option value=""></option>';
										<?php
										foreach ((array)$opts as $optVal) {
											?>
											str += '<option value="<?php echo trim($optVal); ?>"<?php if(trim($optVal) == $value->field_value) {echo " selected";} ?>><?php echo trim($optVal); ?></option>';
											<?php
										}
										?>
										str += '</select>';
										cell.innerHTML = str;
										<?php	break;
									}
								}
								?>
						});
				});
			</script>
			<?php
		}
	}
		
	//returns a specific fields value for a specific image
	function nggcf_get_field($pid, $fname) {
		global $nggcf_values;
		nggcf_hold_field_values($pid);
		
		return stripslashes($nggcf_values[$pid][$fname]->field_value);			
	}
	
	//new filter in ngg 1.2.1 allows us to add to the list of images (later to be passed to the templates), while its being created!  Thanks Alex
	function nggcf_image_obj($pictureObj, $pid) {
		global $nggcf_values;
		
		nggcf_hold_field_values($pid);
		
		@$pictureObj->ngg_custom_fields = array();
		foreach ($nggcf_values[$pid] as $key=>$val) {
			$pictureObj->ngg_custom_fields[$key] = stripslashes($val->field_value);
		}
		
		return $pictureObj;
	}
		
	function nggcf_get_gallery_field($gid, $fname) {
		global $nggcf_field_values;
		
		nggcf_hold_gallery_field_values($gid);
		
		return $nggcf_field_values[$gid][$fname];
	}
	
	function nggcf_new_gallery_form() {
		$iList = nggcf_get_field_list(NGGCF_IMAGES);
		$gList = nggcf_get_field_list(NGGCF_GALLERY);
		
		if($iList) {
			?>
			<tr valign="top"> 
			<th scope="row"><?php _e('Link Image Custom Fields', 'nggcustomfields') ;?>:</th> 
			<td>
			<?php foreach ($iList as $key=>$val) { ?>
				<input type="checkbox" name="conf[nggcf_fields][<?php echo $val->id ?>]" value="1" checked /> <?php echo $val->field_name ?><br />
			<?php } ?>
			</td>
			</tr>
			<?php
		}

		if($gList) { 
			?>
			<tr valign="top"> 
			<th scope="row"><?php _e('Link Gallery Custom Fields', 'nggcustomfields') ;?>:</th> 
			<td>
			<?php foreach ($gList as $key=>$val) { ?>
				<input type="checkbox" name="conf[nggcf_fields][<?php echo $val->id ?>]" value="1" checked /> <?php echo $val->field_name ?><br />
			<?php } ?>
			</td>
			</tr>
			<?php
		}		
		
	}
	
	function nggcf_add_new_gallery($gid) {
		global $wpdb;
		if($fields = $_POST["conf"]["nggcf_fields"]) {
			foreach ((array)$fields as $key=>$val) {
				$qry = "INSERT INTO ".$wpdb->prefix."nggcf_fields_link (`id`, `field_id`, `gid`) VALUES(null, '".$wpdb->escape($key)."', '".$wpdb->escape($gid)."')";
				$wpdb->query($qry);
			}
		}
	}
//}
?>