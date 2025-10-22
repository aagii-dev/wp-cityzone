<?php

if (!defined('ABSPATH')) {
    exit;
}
include_once(ABSPATH . 'wp-admin/includes/plugin.php');

if (!function_exists('wild_setup')) {
    function wild_setup()
    {
        // thumb
        add_theme_support('post-thumbnails');
        update_option('large_size_w', 1300);
        update_option('medium_size_w', 595);
        update_option('medium_size_h', 0);
        update_option('thumbnail_size_w', 240);
        update_option('thumbnail_size_h', 240);


        add_image_size('hero_thumb', 1920, 1080, true);
        add_image_size('hero_blurry', 19, 10, true);
        add_image_size('size11_thumb', 1000, 1000, true);
        add_image_size('size11_blurry', 10, 10, true);
        



        add_post_type_support('page', 'excerpt');


        add_theme_support('admin-bar');
        // add_theme_support('html5', array(
        //     // 'search-form',
        //     // 'comment-form',
        //     // 'comment-list',
        //     // 'gallery',
        //     // 'caption',
        // ));
        add_theme_support('editor');
        add_theme_support('post-formats', array(
            // 'aside',
            // 'gallery',
            // 'link',
            // 'image',
            // 'quote',
            // 'status',
            // 'video',
            // 'audio',
            // 'chat',
        ));

    }
} // wild_setup


add_action('after_setup_theme', 'wild_setup');




/* Include all includes from source(src) folder */
foreach (glob(get_template_directory() . '/src/*.php') as $filename) {
    include_once $filename;
}

//----------------------------------- Set title to post, page and contents  -------------------------------------------
function wpdocs_filter_wp_title($title, $sep)
{
    global $paged, $page;

    // separator ашиглахгүй
    $sep2 = '';

    if (is_feed()) {
        return $title;
    }

    // ❌ энэ мөрийг болиулна:
    // $title .= get_bloginfo('name');

    // Add site description for home page
    $site_description = get_bloginfo('description', 'display');
    if ($site_description && (is_home() || is_front_page())) {
        $title = "$title $sep2 $site_description";
    }

    // Add page number if needed
    if ($paged >= 2 || $page >= 2) {
        $title = "$title $sep2 " . sprintf(__('Page %s', 'ardsec'), max($paged, $page));
    }

    return $title;
}
add_filter('wp_title', 'wpdocs_filter_wp_title', 10, 2);






// allow svg upload
function cc_mime_types($mimes)
{
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');


//remove editor text tab
function my_editor_settings($settings)
{
    $settings['quicktags'] = false;
    return $settings;
}

// add_filter('wp_editor_settings', 'my_editor_settings');


if (is_plugin_active('js_composer/js_composer.php')) {
    // remove front editro
    vc_disable_frontend();
}

// get top level page ID (ancestor)
function get_the_top_ancestor_id($id = null)
{
    global $post;
    if (!empty($id)) {
        $ancestors = array_reverse(get_post_ancestors($id));
        return $ancestors;
    } else if ($post->post_parent) {
        $ancestors = array_reverse(get_post_ancestors($post->ID));
        return $ancestors[0];
    } else {
        return $post->ID;
    }
}

// add classes to wp_list_pages
function wp_list_pages_filter($output)
{
    $output = str_replace('page_item', 'nav-item', $output);
    return $output;
}
add_filter('wp_list_pages', 'wp_list_pages_filter');




add_shortcode('cmb-form', 'cmb2_do_frontend_form_shortcode');
/**
 * Shortcode to display a CMB2 form for a post ID.
 * @param  array  $atts Shortcode attributes
 * @return string       Form HTML markup
 */
function cmb2_do_frontend_form_shortcode($atts = array())
{
    global $post;

    /**
     * Depending on your setup, check if the user has permissions to edit_posts
     */
    if (!current_user_can('edit_posts')) {
        return __('You do not have permissions to edit this post.', 'lang_domain');
    }

    /**
     * Make sure a WordPress post ID is set.
     * We'll default to the current post/page
     */
    if (!isset($atts['post_id'])) {
        $atts['post_id'] = $post->ID;
    }

    // If no metabox id is set, yell about it
    if (empty($atts['id'])) {
        return __("Please add an 'id' attribute to specify the CMB2 form to display.", 'lang_domain');
    }

    $metabox_id = esc_attr($atts['id']);
    $object_id = absint($atts['post_id']);
    // Get our form
    $form = cmb2_get_metabox_form($metabox_id, $object_id);

    return $form;
}







add_action('wp_nav_menu_item_custom_fields', function ($item_id, $item) {
    $id = get_post_meta($item_id, '_jump-section-id', true);
    ?>
    <p class="awp-show-as-button description description-wide">
        <label for="awp-menu-item-button-<?php echo $item_id; ?>">
            <?php _e('Element ID for jump to section. Ex: about', 'awp'); ?>
            <br />
            <input type="text" class="widefat " value="<?php echo $id; ?>" id="awp-menu-item-button-<?php echo $item_id; ?>" name="awp-menu-item-button[<?php echo $item_id; ?>]" />
        </label>
    </p>
    <?php
}, 10, 2);

add_action('wp_update_nav_menu_item', function ($menu_id, $menu_item_db_id) {
    $button_value = (isset($_POST['awp-menu-item-button'][$menu_item_db_id]) && !empty($_POST['awp-menu-item-button'][$menu_item_db_id])) ? $_POST['awp-menu-item-button'][$menu_item_db_id] : "";
    update_post_meta($menu_item_db_id, '_jump-section-id', $button_value);
}, 10, 2);




remove_filter('the_content', 'wptexturize');
remove_filter('comment_text', 'wptexturize');
remove_filter('the_title', 'wptexturize');
















// functions.php
function calculate_percentage($count, $total) {
    if ($total == 0) {
        return 0;
    }
    return round(($count / $total) * 100, 2);
}
