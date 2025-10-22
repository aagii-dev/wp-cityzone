<?php
// functions.php эсвэл plugin дотроо бичиж ашиглана
function register_custom_post_type_job() {
  $labels = [
    'name'               => 'Jobs',
    'singular_name'      => 'Job',
    'menu_name'          => 'Jobs',
    'name_admin_bar'     => 'Job',
    'add_new'            => 'Add New',
    'add_new_item'       => 'Add New Job',
    'new_item'           => 'New Job',
    'edit_item'          => 'Edit Job',
    'view_item'          => 'View Job',
    'all_items'          => 'All Jobs',
    'search_items'       => 'Search Jobs',
    'not_found'          => 'No Jobs found.',
    'not_found_in_trash' => 'No Jobs found in Trash.',
  ];

  $args = [
    'labels'             => $labels,
    'public'             => true,
    'publicly_queryable' => true,
    'show_ui'            => true,
    'show_in_menu'       => true,
    'query_var'          => true,
    'rewrite'            => ['slug' => 'job'],
    'capability_type'    => 'post',
    'has_archive'        => true,
    'hierarchical'       => false,
    'menu_position'      => 21,
    'menu_icon'          => 'dashicons-businessman',
    'supports'           => ['title', 'editor'],
    'show_in_rest'       => true, // Gutenberg болон REST API-д харагддаг
  ];

  register_post_type('job', $args);
}
add_action('init', 'register_custom_post_type_job');




function register_job_category_taxonomy() {
  $labels = [
    'name'              => 'Job Categories',
    'singular_name'     => 'Job Category',
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
    'rewrite'           => ['slug' => 'job-category'],
    'show_in_rest'      => true, // Gutenberg болон REST API
  ];

  register_taxonomy('job_category', ['job'], $args);
}
add_action('init', 'register_job_category_taxonomy');



function register_job_time_taxonomy() {
  $labels = [
    'name'              => 'Job Times',
    'singular_name'     => 'Job Time',
    'search_items'      => 'Search Times',
    'all_items'         => 'All Times',
    'parent_item'       => 'Parent Time',
    'parent_item_colon' => 'Parent Time:',
    'edit_item'         => 'Edit Time',
    'update_item'       => 'Update Time',
    'add_new_item'      => 'Add New Time',
    'new_item_name'     => 'New Time Name',
    'menu_name'         => 'Times',
  ];

  $args = [
    'hierarchical'      => true, // true гэвэл category шиг мод бүтэцтэй (parent-child)
    'labels'            => $labels,
    'show_ui'           => true,
    'show_admin_column' => true,
    'query_var'         => true,
    'rewrite'           => ['slug' => 'job-time'],
    'show_in_rest'      => true, // Gutenberg болон REST API
  ];

  register_taxonomy('job_time', ['job'], $args);
}
add_action('init', 'register_job_time_taxonomy');







add_action('cmb2_admin_init', 'register_job_metabox');
function register_job_metabox() {
    $cmb = new_cmb2_box([
        'id'           => 'job_details',
        'title'        => __('Help Center Details', 'textdomain'),
        'object_types' => ['job'], // зөвхөн job дээр харагдана
    ]);

    $cmb->add_field([
        'name'         => 'Ажлын байрны линк',
        'id'           => 'job_link',
        'type'         => 'text_url',
    ]);

}
