<?php

// add_action('cmb2_admin_init', 'fields_for_category');

// function fields_for_category()
// {
// 	$prefix = 'category_'; //post header

// 	// page menu

// 	$cmb2 = new_cmb2_box(array(
// 		'id'            => $prefix . 'setting',
// 		'title'         => __('Category setting', 'cmb2'),
// 		'object_types'  => array('term'), // Post type
// 		'taxonomies' => array('category')
// 	));


// 	$cmb2->add_field(array(
// 		'name'	 => __('Post view type', 'cmb2'),
// 		'id'	 => $prefix . 'postview_type',
// 		'type'             => 'select',
// 		'show_option_none' => true,
// 		'default'          => '0',
// 		'options'          => array('list' => 'list', 'gallery' => 'gallery', 'video' => 'video'),
// 	));
// }
