<?php

function wpb_custom_logo()
{
    echo '
    <style type="text/css">
        #wpadminbar #wp-admin-bar-wp-logo > .ab-item .ab-icon:before {
            background-image: url('. get_stylesheet_directory_uri().'/assets/images/yld-logo.svg) !important;
            position: absolute;
            width: 100%; height: 100%;
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            color:rgba(0, 0, 0, 0);
        }
        #wpadminbar #wp-admin-bar-wp-logo .ab-item .ab-icon {
            width: 107px !important;
        }
    </style>
    ';
}

//hook into the administrative header output
add_action('wp_before_admin_bar_render', 'wpb_custom_logo');

// update toolbar
function update_adminbar($wp_adminbar)
{

    // remove unnecessary items
    // $wp_adminbar->remove_node('about');
    // $wp_adminbar->remove_node('wporg');
    $wp_adminbar->remove_node('documentation');
    $wp_adminbar->remove_node('support-forums');
    // $wp_adminbar->remove_node('feedback');

    $wp_adminbar->remove_node('customize');
    $wp_adminbar->remove_node('comments');

    // Add "About WordPress" link
    $wp_adminbar->add_menu(array(
        'id' => 'wp-logo',
        'href' => 'https://yld.mn',
    ));
    // Add "About WordPress" link
    $wp_adminbar->add_menu(array(
        'parent' => 'wp-logo',
        'id' => 'about',
        'title' => __('About Yld'),
        'href' => 'https://yld.mn/about',
    ));
    $wp_adminbar->add_menu(array(
        'parent' => 'wp-logo-external',
        'id' => 'wporg',
        'title' => __('Yld.mn'),
        'href' => 'https://yld.mn',
    ));
    $wp_adminbar->add_menu(array(
        'parent' => 'wp-logo-external',
        'id' => 'feedback',
        'title' => __('Contact'),
        'href' => 'https://yld.mn/support',
    ));
}

// admin_bar_menu hook
add_action('admin_bar_menu', 'update_adminbar', 999);



// Admin footer modification
function remove_footer_admin () 
{
    echo '<span id="footer-thankyou">by <a href="https://yld.mn" target="_blank">Yld.mn</a></span>';
}
add_filter('admin_footer_text', 'remove_footer_admin');
