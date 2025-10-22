<?php
function get_post_children($post_ID = null)
{
    if ($post_ID === null) {
        global $post;
        $post_ID = $post->ID;
    }
    $query = new WP_Query(array('post_parent' => $post_ID, 'post_type' => 'any'));

    return $query->have_posts();
}

function get_same_level_page($pageID)
{
    $parentID = wp_get_post_parent_id($pageID);
    $loop = new WP_Query(array(
        'post_type' => 'page',
        'post_parent' => $parentID,
        'posts_per_page' => -1,
        'orderby' => 'menu_order',
        'order' => 'ASC',
    ));
    $output = $loop->posts;

    return $output;
}
