=== NextGEN Custom Fields ===
Contributors: shauno
Donate link: http://shauno.co.za/donate/
Tags: nextgen-gallery, nextgen, custom, fields, ngg-custom-fields, nextgen-gallery-custom-fields
Requires at least: 2.7.1
Tested up to: 3.3
Stable tag: 1.2.1

Creates the ability to quickly and easily add custom fields to NextGEN Galleries and Images.

== Description ==

**Please use version 1.0.2 for version of NGG LOWER than 1.7.x.  Please use version 1.1.2 or greater for versions of NGG >= 1.7.x**

This plugin was developed to add custom columns to the excellent and popular NextGEN Gallery plugin.  Simply enter the name of your new field(s), select between "input", "textarea" or "dropdown", and the field(s) will be automatically added to the manage images form in the NGG admin panel.
And as of version 0.4, you can now add custom fields to NextGEN galleries too!

**QUESTIONS ASKED ON THE FORUM THAT ARE IN THE FAQ WILL NOT BE ANSWERED BY ME**

I was recently in a motorcycle accident, and am not online too much anymore anyway.  Feel free to donate via the link on the right to by me a beer and get me through this tough time :)

== Installation ==

1. Upload `ngg-custom-fields.php` to the `/wp-content/plugins/ngg-custom-fields/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Run the URL `http://www.example.com/wp-admin/admin.php?page=nextgen-gallery-custom-fields/ngg-custom-fields.php&mode=upgrade` where "example.com" is your site (be sure you are logged in)
1. Have a look at the FAQ to see how to work this thing

== Screenshots ==

None available yet

== Frequently Asked Questions ==

= Firstly, what exactly will this plugin do? =

Have you ever wanted to add just a little more information about a picture in your NextGEN Gallery?  Maybe you wanted to add the name of the photographer?  Or where the picture was taken?  Well, with this plugin you can add as many extra custom fields to the images as you need, and stop you trying to squeeze all the info into the description.

= Sounds good so far, but what else? =

Well, when it was originally developed, you could only add fields to images in a gallery.  But as of version 0.4, you can add custom fields to images AND galleries!

= Briefly, how do I use this plugin =

Here is the condensed version for those of you with short attention spans.  I do recommend reading the full FAQ below this if you have issues.

* Install
	* Download and unzip to the plugins directory
	* Activate the plugin
	* Run `http://www.example.com/wp-admin/admin.php?page=nextgen-gallery-custom-fields/ngg-custom-fields.php&mode=upgrade` where "example.com" is your site
	
* Setup Field
	* Click "NGG Custom Fields" from the administration menu on the left of WordPress
	* Choose to either create custom fields for "Images" or "Galleries"
	
* Add Data to Fields
	* Click "Manage Gallery" from under the "Gallery" menu option on the left of WordPress
	* Choose a gallery to manage
	* All gallery custom fields linked to this gallery should show in the "Gallery settings" section of the page under a heading of "Custom Fields"
	* All image custom fields linked to this gallery should show next to all images in the gallery

* Displaying Fields
 * For image custom fields, use the following tag: `<?php echo $image->ngg_custom_fields["Your Field Name Here"]; ?>`
 * For gallery custom fields, use the following tag: `<?php echo nggcf_get_gallery_field($gallery->ID, "My Gallery Field Name Here"); ?>`

Please remember, that was over simplified.  Please do take the time to read the full FAQ below.  If you are still having problems, post on the WordPress forums with the tag `nextgen-gallery-custom-fields`.  I do visit the forum from time to time, and will hopefully be able to help you out 

= OK, well lets start with images then =

Once the plugin is activated, a new menu item will appear on the left navigation of the WordPress admin called "NGG Custom Fields".  Under this option there is a "Setup Fields" option.
If you click on that, you will be presented with 2 options.  Since we are dealing with custom fields for images, select the "Image Custom Fields" option.
You will be presented with a screen asking you for a field name, linked galleries, and field type.  Enter the name of the field you want to add to and select which galleries you want it to show on (all are check by default).  Then and select from either "Text Input", "Text Area" or "Drop Down".
If you select "Drop Down" as the tpye, another text area will become visible allowing you to add the options you want the drop down to have.
Once you have captured those fields, click on the "Create Field" button.  This will save the field in the database.
Now if you manage a gallery from the "Manage Gallery" option under NextGEN Gallery, you will see the field you added for each image (make sure you select a gallery that you linked to your field).

= Fantastic! Now how do I show my fancy new field? =

There are a couple of ways to implement your new fields in the various template.  The method you should use if you are running the latest version of NGG (anything from 1.2.1), is by putting this tag where you want your field to show: `<?php echo $image->ngg_custom_fields["Your Field Name Here"]; ?>`

= That didn't work!? =
If you are using an older version on NGG, that might not work.  Then you need to use the following tag instead: `<?php echo nggcf_get_field((int)IMAGEID, (string)FIELDNAME); ?>`

= What the hell is "(int)IMAGEID" and/or "(string)FIELDNAME" =

Not a php coder are we?  No problemo!  You need to replace `(int)IMAGEID` with the id NGG has assigned the picture.  For instance, in `nextgen-gallery/views/gallery.php`, that would be `$image->pid` in the `foreach` loop (roughly line 38 in NGG 1.2.1)
The `(string)FIELDNAME` is the name of the field you previously set up.
So, if you setup a field called "Awesome field", the code you would add to the gallery template would look like this: `<?php echo nggcf_get_field($image->pid, 'Awesome field'); ?>`

= Well, what about custom fields for galleries? =

As of version 0.4, the ability to add custom fields to galleries has been added. It was a little janky until 1.1.3, where support for new NGG hooks was used making it more 'native'.

= I've done all that, now what? =

Now you can add the fields in the exact same way as for images.  Just select the "Gallery Custom Fields" option from the menu and add the fields exactly as you would have for images.
Once you've added your custom fields for the gallery, go to the "Manage Gallery" of NextGEN Gallery, and select a gallery.  Under the "Gallery settings" section of the page, you should now see a "Custom Fields" heading, with your custom fields listed!  You can now capture your values for the fields, and save the gallery.

= And how do I now show this field? =

Simply enter put the following tag where you want your field to display: `<?php echo nggcf_get_gallery_field($gallery->ID, "My Gallery Field Name"); ?>` obviously replacing "My Gallery Field Name" with your field name.

= Common Problems =

* Make sure you add the fields you want to the correct place.  Image fields added from the "Image Custom Fields" menu option and gallery fields from the "Gallery Custom Fields" option.  Sounds simple, but you can overlook it.

* Is the custom field linked to the correct gallery?

* If you have unusual characters in your fields names, it can break the output.  Stick to upper and lower case letters, and numbers to avoid any issues.  As of version 0.5 there is some basic sanitation done to the names of fields and their values, but it is far from perfect.  It should allow characters such as apostrophes well enough though.

== Changelog ==

= 1.2.1 =
* Changed `field_value` column back to TEXT from VARCHAR(255), to allow more than 255 characters saved (thanks to ksemel for the find and bug report)

= 1.2 =
* Converted table to UTF8. This is much more compatible with internet safe languages.
* Fixed quotes in field names and values

= 1.1.3 =
* Made gallery fields not rely on having an image custom field and JavaScript
* Refactored some code to just clean it up a little

= 1.1.2 =
* I screwed up the backwards compatibility, sorry.  Use 1.0.2 for < NGG 1.7

= 1.1.1 =
* Made it backwards compatible with NGG 1.6.x and lower. Should have been done with the last update, but I was spaced on pain meds

= 1.1 =
* Made this plugin compatibile with NextGEN Galley 1.7.x and greater, which breaks compatibility with lower versions of NGG

= 1.0.2 =
* Fixed a bug that would break gallery custom fields (textareas) if you had new lines in them.  (thanks mygraphicfriend again for pointing it out)

= 1.0.1 =
* Fixed a bug that would delete all data for a custom field (all galleries or images in ngg), when it was unlinked from only a specific gallery (thanks to mygraphicfriend for pointing that out)

= 1.0 =
* Added the ability to link custom images when creating a new gallery. (Needs NextGEN 1.4.0 or later, thanks to maxx10 for the request)

= 0.6 =
* Added the ability to select which galleries to link fields to (thanks to vividlilac and goto10 for pushing me into doing that)
	
= 0.5 =
* Added a little sanitation to field names and values, to allow apostrophes and some other none alphanumeric characters
* Added the ability to edit a field's name
	
= 0.4 =
* Added gallery custom fields
* Fixed a bug that stopped the deletion of a custom field unless there was data saved for that field
	
= 0.3 =
* Added the ability to edit drop down options on existing fields
* Added the "Change Log" section to this file :)
	
= 0.2 =
* Minor code reformat
	
= 0.1 =
* Initial release!

== Upgrade Notice ==

= 1.2.1 =
Fixed field values to allow more than 255 characters.

= 1.2 =
Fixed quotes in field names and values. Also converted database tables to UTF8. This is much more compatible with internet safe languages. You may see extra backslashes in some values if you had quotes saved before. Just remove them and re-save.
