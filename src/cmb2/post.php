<?php
// add_action('cmb2_admin_init', 'fields_for_post');

// function fields_for_post()
// {
// 	$prefix = 'post_cf_';

// 	$cmb_term = new_cmb2_box(array(
// 		'id'			 => $prefix . 'other_info',
// 		'title'			 => __('Other info', 'cmb2'), // Doesn't output for term boxes
// 		'object_types'	 => array('post'), // Tells CMB2 to use term_meta vs post_meta

// 	));


// 	$cmb_term->add_field(array(
// 		'name'	 => __('Gallery', 'cmb2'),
// 		'desc'	 => __('Gallery show in if Category Post view type is gallery ', 'cmb2'),
// 		'id'	 => $prefix . 'gallery',
// 		'type'    => 'file_list',
// 		// Optional:
// 		'options' => array(
// 			'url' => false, // Hide the text input for the url
// 		),
// 		'text'    => array(
// 			'add_upload_file_text' => 'Add File' // Change upload button text. Default: "Add or Upload File"
// 		),
// 		// query_args are passed to wp.media's library query.
// 		'query_args' => array(
// 			'type' => array(
// 				'image/gif',
// 				'image/jpeg',
// 				'image/png',
// 			),
// 		),
// 		'preview_size' => array(100, 100), // Image size to use when previewing in the admin.
// 	));
// }
