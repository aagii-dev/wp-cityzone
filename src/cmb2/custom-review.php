<?php

//----------------------------------- review ---------------------------------------------
function add_my_review()
{
	$labels = array(
		'name' => _x('Review', 'post type general name'),
		'singular_name' => _x('Review', 'post type singular name'),
		'add_new' => _x('Add new', 'Review'),
		'add_new_item' => __('Add new Review'),
		'edit_item' => __('Edit'),
		'new_item' => __('Add new'),
		'all_items' => __('All review'),
		'view_item' => __('View'),
		'search_items' => __('Review search'),
		'not_found' => __('Review not found'),
		'not_found_in_trash' => __('Review not found in trash'),
		'parent_item_colon' => '',
		'menu_name' => 'Review',
	);

	$args = array(
		'labels' => $labels,
		'menu_icon' => 'dashicons-star-filled',
		'description' => 'Holds our review and review specific data',
		'public' => true,
		'has_archive' => true,
		'menu_position' => 29,
		'supports' => array('title'),
	);
	register_post_type('review', $args);
}

add_action('init', 'add_my_review');

function update_add_my_review_messages($messages)
{
	global $post, $post_ID;
	$messages['review'] = array(
		0 => '',
		1 => sprintf(__('review updated. <a href="%s">View review</a>'), esc_url(get_permalink($post_ID))),
		2 => __('Custom field updated.'),
		3 => __('Custom field deleted.'),
		4 => __('review updated.'),
		5 => isset($_GET['revision']) ? sprintf(__('review restored to revision from %s'), wp_post_revision_title((int) $_GET['revision'], false)) : false,
		6 => sprintf(__('review published. <a href="%s">View review</a>'), esc_url(get_permalink($post_ID))),
		7 => __('review saved.'),
		8 => sprintf(__('review submitted. <a target="_blank" href="%s">Preview review</a>'), esc_url(add_query_arg('preview', 'true', get_permalink($post_ID)))),
		9 => sprintf(__('review scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview review</a>'), date_i18n(__('M j, Y @ G:i'), strtotime($post->post_date)), esc_url(get_permalink($post_ID))),
		10 => sprintf(__('review draft updated. <a target="_blank" href="%s">Preview review</a>'), esc_url(add_query_arg('preview', 'true', get_permalink($post_ID)))),
	);
	return $messages;
}

add_filter('post_updated_messages', 'update_add_my_review_messages');





function register_review_category_taxonomy() {
  $labels = [
    'name'              => 'Review Categories',
    'singular_name'     => 'Review Category',
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
    'rewrite'           => ['slug' => 'review-category'],
    'show_in_rest'      => true, // Gutenberg болон REST API
  ];

  register_taxonomy('review_category', ['review'], $args);
}
add_action('init', 'register_review_category_taxonomy');