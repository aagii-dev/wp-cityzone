<?php
// functions.php эсвэл plugin дотроо бичиж ашиглана
function register_custom_post_type_help_center() {
  $labels = [
    'name'               => 'Help Center',
    'singular_name'      => 'Help Center',
    'menu_name'          => 'Help Center',
    'name_admin_bar'     => 'Help Center',
    'add_new'            => 'Add New',
    'add_new_item'       => 'Add New Help Center',
    'new_item'           => 'New Help Center',
    'edit_item'          => 'Edit Help Center',
    'view_item'          => 'View Help Center',
    'all_items'          => 'All Help Center',
    'search_items'       => 'Search Help Center',
    'not_found'          => 'No Help Center found.',
    'not_found_in_trash' => 'No Help Center found in Trash.',
  ];

  $args = [
    'labels'             => $labels,
    'public'             => true,
    'publicly_queryable' => true,
    'show_ui'            => true,
    'show_in_menu'       => true,
    'query_var'          => true,
    'rewrite'            => ['slug' => 'help-center'],
    'capability_type'    => 'post',
    'has_archive'        => true,
    'hierarchical'       => false,
    'menu_position'      => 22,
    'menu_icon'          => 'dashicons-search',
    'supports'           => ['title', 'editor', 'excerpt'],
    'show_in_rest'       => true, // Gutenberg болон REST API-д харагддаг
  ];

  register_post_type('help_center', $args);
}
add_action('init', 'register_custom_post_type_help_center');


function register_help_center_category_taxonomy() {
  $labels = [
    'name'              => 'Help Center Categories',
    'singular_name'     => 'Help Center Category',
    'search_items'      => 'Search Categories',
    'all_items'         => 'All Categories',
    'parent_item'       => 'Parent Category',
    'parent_item_colon' => 'Parent Category:',
    'edit_item'         => 'Edit Category',
    'update_item'       => 'Update Category',
    'add_new_item'      => 'Add New Category',
    'new_item_name'     => 'New Category Name',
    'menu_name'         => 'Categories',
  ];

  $args = [
    'hierarchical'      => true, // true гэвэл category шиг мод бүтэцтэй (parent-child)
    'labels'            => $labels,
    'show_ui'           => true,
    'show_admin_column' => true,
    'query_var'         => true,
    'rewrite'           => ['slug' => 'help_center-category'],
    'show_in_rest'      => true, // Gutenberg болон REST API
  ];

  register_taxonomy('help_center_category', ['help_center'], $args);
}
add_action('init', 'register_help_center_category_taxonomy');




// add_action('cmb2_admin_init', 'register_help_center_metabox');
// function register_help_center_metabox() {
//     $cmb = new_cmb2_box([
//         'id'           => 'help_center_details',
//         'title'        => __('Help Center Details', 'textdomain'),
//         'object_types' => ['help_center'], // зөвхөн help_center дээр харагдана
//     ]);

//     $cmb->add_field([
//         'name'         => 'Үнэ',
//         'id'           => 'help_center_price',
//         'type'         => 'text_money',
//         'before_field' => '$',
//     ]);

//     $cmb->add_field([
//         'name' => 'Жин',
//         'id'   => 'help_center_weight',
//         'type' => 'text_small',
//         'desc' => 'Жишээ нь: 1.5kg эсвэл 500g',
//     ]);

//     $cmb->add_field([
//         'name' => 'Иж бүрдэл',
//         'id'   => 'help_center_includes',
//         'type' => 'textarea',
//         'desc' => 'HTML ашиглан жагсаалт оруулж болно: <ul><li>Item 1</li><li>Item 2</li></ul>',
//     ]);

//     $cmb->add_field([
//         'name' => 'Багтаамж',
//         'id'   => 'help_center_capacity',
//         'type' => 'text_small',
//         'desc' => 'Жишээ нь: 1L, 500ml гэх мэт',
//     ]);

//     $cmb->add_field([
//         'name' => 'Gallery зурагнууд',
//         'id'   => 'help_center_gallery',
//         'type' => 'file_list', // CMB2-д gallery style бүхий field
//         'preview_size' => [100, 100], // thumbnail size
//         'desc' => 'Бүтээгдэхүүний зурагнуудаа оруулна уу',
//     ]);
// }



//  add_action('cmb2_admin_init', 'fields_for_help_center_category');

// function fields_for_help_center_category()
// {
// 	$prefix = 'help_center_category_'; //post header

// 	// page menu

// 	$cmb2 = new_cmb2_box(array(
// 		'id'            => $prefix . 'setting',
// 		// 'title'         => __('Category setting', 'cmb2'),
// 		'object_types'  => array('term'), // Post type
// 		'taxonomies' => array('help_center_category')
// 	));


// 	$cmb2->add_field(array(
// 		'name'	 => __('Post view type', 'cmb2'),
// 		'id'	 => $prefix . 'image_size',
// 		'type'             => 'select',
// 		'show_option_none' => true,
// 		'default'          => 'square',
// 		'options'          => array('square' => 'square', 'portrait' => 'portrait'),
// 	));
// }
