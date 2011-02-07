<?php

/**
* Add actions to the admin
*/
add_action('admin_menu', 'hybrid_create_meta_box');
add_action('save_post', 'hybrid_save_meta_data');

/**
* Function for adding meta boxes to the admin
* Separate the post and page meta boxes
*
* @since 0.3
*/
function hybrid_create_meta_box() {
	global $theme_name;

	add_meta_box('post-meta-boxes', __('Hybrid Settings','hybrid'), 'post_meta_boxes', 'post', 'normal', 'high');
	add_meta_box('page-meta-boxes', __('Hybrid Settings','hybrid'), 'page_meta_boxes', 'page', 'normal', 'high');
}

/**
* Array of variables for post meta boxes
* Make the function filterable to add options through child themes
*
* @since 0.3
* @return Array $meta_boxes
* @filter
*/
function hybrid_post_meta_boxes() {
	$meta_boxes = array(
		'title' => array(
			'name' => 'Title',
			'default' => '',
			'title' => __('Title','hybrid'),
			'type' => 'text',
			'show_description' => false,
			'description' => __('Add a title that will be seen by search engines.','hybrid'),
			),
		'description' => array(
			'name' => 'Description',
			'default' => '',
			'title' => __('Description','hybrid'),
			'type' => 'textarea',
			'show_description' => false,
			'description' => __('Add a description that will be seen by search engines.','hybrid'),
			),
		'keywords' => array(
			'name' => 'Keywords',
			'default' => '',
			'title' => __('Keywords:','hybrid'),
			'type' => 'text',
			'show_description' => false,
			'description' => __('Add keywords that will be seen by search engines.','hybrid'),
			),
		'thumbnail' => array(
			'name' => 'Thumbnail',
			'default' => '',
			'title' => __('Thumbnail:','hybrid'),
			'type' => 'text',
			'show_description' => false,
			'description' => __('Add an image URL here.','hybrid'),
			),
		);

	return apply_filters('hybrid_post_meta_boxes', $meta_boxes);
}

/**
* Array of variables for meta boxes to pages
* Make the function filterable to add options through child themes
*
* @since 0.3
* @return Array $meta_boxes
* @filter
*/
function hybrid_page_meta_boxes() {
	$meta_boxes = array(
		'title' => array(
			'name' => 'Title',
			'default' => '',
			'title' => __('Title','hybrid'),
			'type' => 'text',
			'show_description' => false,
			'description' => __('Add a title that will be seen by search engines.','hybrid'),
			),
		'description' => array(
			'name' => 'Description',
			'default' => '',
			'title' => __('Description','hybrid'),
			'type' => 'textarea',
			'show_description' => false,
			'description' => __('Add a title that will be seen by search engines.','hybrid'),
			),
		'keywords' => array(
			'name' => 'Keywords',
			'default' => '',
			'title' => __('Keywords:','hybrid'),
			'type' => 'text',
			'show_description' => false,
			'description' => __('Add a title that will be seen by search engines.','hybrid'),
			),
		);

	return apply_filters('hybrid_page_meta_boxes', $meta_boxes);
}

/**
* Displays meta boxes on the Write Post panel
* Loops through each meta box in the $meta_boxes variable
* Gets array from hybrid_post_meta_boxes()
*
* @since 0.3
*/
function post_meta_boxes() {
	global $post;
	$meta_boxes = hybrid_post_meta_boxes();
?>

<table class="form-table">
<?php
	foreach($meta_boxes as $meta) :

		$value = get_post_meta($post->ID, $meta['name'], true);

		if($meta['type'] == 'text') :
			get_meta_text_input($meta, $value);
		elseif($meta['type'] == 'textarea') :
			get_meta_textarea($meta, $value);
		elseif($meta['type'] == 'select') :
			get_meta_select($meta, $value);
		endif;

	endforeach;
?>
</table>
<?php
}

/**
* Displays meta boxes on the Write Page panel
* Loops through each meta box in the $meta_boxes variable
* Gets array from hybrid_page_meta_boxes()
*
* @since 0.3
*/
function page_meta_boxes() {
	global $post;
	$meta_boxes = hybrid_page_meta_boxes();
?>

<table class="form-table">
<?php
	foreach($meta_boxes as $meta) :

		$value = stripslashes(get_post_meta($post->ID, $meta['name'], true));

		if($meta['type'] == 'text') :
			get_meta_text_input($meta, $value);
		elseif($meta['type'] == 'textarea') :
			get_meta_textarea($meta, $value);
		elseif($meta['type'] == 'select') :
			get_meta_select($meta, $value);
		endif;

	endforeach;
?>
</table>
<?php
}

/**
* Outputs a text input box with arguments from the parameters
* Used for both the post/page meta boxes
*
* @since 0.3
*/
function get_meta_text_input($args = array(), $value = false) {
	extract($args);
?>

	<tr>
		<th style="width:10%;">
		<label for="<?php echo $name; ?>"><?php echo $title; ?></label>
		</th>
		<td>
		<input type="text" name="<?php echo $name; ?>" id="<?php echo $name; ?>" value="<?php echo htmlentities($value, ENT_QUOTES); ?>" size="30" tabindex="30" style="width: 97%;" />
		<input type="hidden" name="<?php echo $name; ?>_noncename" id="<?php echo $name; ?>_noncename" value="<?php echo wp_create_nonce(plugin_basename(__FILE__)); ?>" />
		</td>
	</tr>
<?php
}

/**
* Outputs a select box with arguments from the parameters
* Used for both the post/page meta boxes
*
* @since 0.3
*/
function get_meta_select($args = array(), $value = false) {
	extract($args);
?>

	<tr>
		<th style="width:10%;">
		<label for="<?php echo $name; ?>"><?php echo $title; ?></label>
		</th>
		<td>
		<select vname="<?php echo $name; ?>" id="<?php echo $name; ?>">
		<?php foreach($options as $option) : ?>
			<option <?php if(htmlentities($value, ENT_QUOTES) == $option) echo ' selected="selected"'; ?>>
				<?php echo $option; ?>
			</option>
		<?php endforeach; ?>
		<input type="hidden" name="<?php echo $name; ?>_noncename" id="<?php echo $name; ?>_noncename" value="<?php echo wp_create_nonce(plugin_basename(__FILE__)); ?>" />
		</td>
	</tr>
<?php
}

/**
* Outputs a textarea with arguments from the parameters
* Used for both the post/page meta boxes
*
* @since 0.3
*/
function get_meta_textarea($args = array(), $value = false) {
	extract($args);
?>
	<tr>
		<th style="width:10%;">
		<label for="<?php echo $name; ?>"><?php echo $title; ?></label>
		</th>
		<td>
		<textarea name="<?php echo $name; ?>" id="<?php echo $name; ?>" cols="60" rows="4" tabindex="30" style="width: 97%;"><?php echo $value; ?></textarea>
		<input type="hidden" name="<?php echo $name; ?>_noncename" id="<?php echo $name; ?>_noncename" value="<?php echo wp_create_nonce(plugin_basename(__FILE__)); ?>" />
		</td>
	</tr>
<?php
}

/**
* Loops through each meta box's set of variables
* Saves them to the database as custom fields
*
* @since 0.3
*/
function hybrid_save_meta_data($post_id) {
	global $post;

	if('page' == $_POST['post_type'])
		$meta_boxes = array_merge(hybrid_page_meta_boxes());
	else
		$meta_boxes = array_merge(hybrid_post_meta_boxes());

	foreach($meta_boxes as $meta_box) :

		if(!wp_verify_nonce($_POST[$meta_box['name'] . '_noncename'], plugin_basename(__FILE__))) :
			return $post_id;
		endif;

		if('page' == $_POST['post_type']) :
			if(!current_user_can('edit_page', $post_id)) :
				return $post_id;
			endif;
		else :
			if(!current_user_can('edit_post', $post_id)) :
				return $post_id;
			endif;
		endif;

		$data = $_POST[$meta_box['name']];

		if(get_post_meta($post_id, $meta_box['name']) == '')
			add_post_meta($post_id, $meta_box['name'], $data, true);

		elseif($data != get_post_meta($post_id, $meta_box['name'], true))
			update_post_meta($post_id, $meta_box['name'], $data);

		elseif($data == '')
			delete_post_meta($post_id, $meta_box['name'], get_post_meta($post_id, $meta_box['name'], true));

	endforeach;
}
?>