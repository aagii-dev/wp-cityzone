<?php
// permission
// site moderator, admin & remove other

/* * ******************** CUSTOM ROLE **************************** */
//check if role exist before removing it
if (get_role('subscriber')) {
    remove_role('subscriber');
}
//check if role exist before removing it
if (get_role('contributor')) {
    remove_role('contributor');
}
//check if role exist before removing it

if (get_role('editor')) {
    // remove_role('editor');
}
//check if role exist before removing it
if (get_role('author')) {
    remove_role('author');
}
// remove_role('wpseo_editor');
// remove_role('wpseo_manager');
remove_role('companyman');

// add_role(
//     'companyman',
//     __('Companyman'),
//     array(
//         'read'            => true, // Allows a user to read
//         'create_posts'    => true, // Allows user to create new posts
//         'edit_posts'      => true, // Allows user to edit their own posts
//     )
// );



function remove_menu_pages()
{

    global $user_ID;

    if (!current_user_can('publish_posts')) {
        remove_menu_page('edit-comments.php'); // Comments
        remove_menu_page('edit.php?post_type=page'); // Pages
        remove_menu_page('wpcf7'); // Contact Form 7 Menu
        remove_menu_page('vc-welcome'); // wpbackery Menu
        remove_menu_page( 'tools.php' );
    }
}
add_action('admin_init', 'remove_menu_pages');
