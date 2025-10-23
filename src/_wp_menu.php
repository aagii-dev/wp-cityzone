<?php

/* * ***************************************  MENU SETTINGS ******************************************** */

function register_my_menu()
{
    register_nav_menu('main_menu', __('Main menu'));
}

add_action('init', 'register_my_menu');

function remove_admin_submenus()
{
    //    remove_submenu_page( 'index.php', 'update-core.php' ); // Dashboard - Updates
    //    remove_submenu_page( 'themes.php', 'themes.php' ); // Appearance - Themes
    //    remove_submenu_page( 'themes.php', 'theme-editor.php' ); // Appearance - Theme Editor
}

add_action('admin_init', 'remove_admin_submenus');

// remove links/menus from the admin bar( from headbar)
function create_dwb_menu()
{
    global $wp_admin_bar;
    // $wp_admin_bar->add_menu( 'comments' );
    $wp_admin_bar->remove_menu('comments');
    // $wp_admin_bar->remove_menu( 'new-content' );
    // $wp_admin_bar->remove_menu( 'updates' );

    // $menu_id = 'dwb';
    // $wp_admin_bar->add_menu(
    //     array(
    //         'parent' => $menu_id,
    //         'title' => __('Pending Comments'),
    //         'id' => 'dwb-pending',
    //         'href' => 'edit-comments.php?comment_status=moderated'
    //     )
    // );
}

add_action('admin_bar_menu', 'create_dwb_menu');

add_action('wp_before_admin_bar_render', 'wpse200296_before_admin_bar_render');

function wpse200296_before_admin_bar_render()
{
    global $wp_admin_bar;

    $wp_admin_bar->remove_menu('customize');
}

function as_remove_menus()
{
    //    remove_menu_page( 'index.php' ); //Dashboard
    //    remove_menu_page( 'jetpack' ); //Jetpack*
    //    remove_menu_page( 'edit.php' ); //Posts
    // if (current_user_can('companyman')) {
    //     remove_menu_page('upload.php'); //Media
    // }
    //    remove_menu_page( 'edit.php?post_type=page' ); //Pages
    remove_menu_page('edit-comments.php'); //Comments
    //    add_menu_page( 'edit-comments.php' ); //Comments
    //    remove_menu_page( 'themes.php' ); //Appearance
    //    remove_menu_page( 'plugins.php' ); //Plugins
    //    remove_menu_page( 'users.php' ); //Users
    // remove_menu_page('tools.php'); //Tools
    //    remove_menu_page( 'options-general.php' ); //Settings
    //    remove_menu_page( 'post-new.php' ); //Settings

    remove_submenu_page('edit.php', 'edit-tags.php'); //hide tags


    // remove_submenu_page('themes.php', 'widgets.php');
    global $submenu;
    // Appearance Menu
    unset($submenu['themes.php'][6]); // Customize
}
add_action('admin_menu', 'as_remove_menus', 9999);


// add bootstrap style
// add_filter('nav_menu_css_class', 'add_classes_on_li', 1, 3);
// function add_classes_on_li($classes, $item, $args)
// {
//     $classes[] = 'nav-item';

//     return $classes;
// }

// add_filter('wp_nav_menu', 'add_classes_on_a');
// function add_classes_on_a($ulclass)
// {
//     return preg_replace('/<a /', '<a class="nav-link btn btn-lg btn-ghost-gray"', $ulclass);
// }

add_filter('nav_menu_css_class', 'add_active_class', 10, 2);

function add_active_class($classes, $item)
{

    if (
        $item->menu_item_parent == 0 &&
        in_array('current-menu-item', $classes) ||
        in_array('current-menu-ancestor', $classes) ||
        in_array('current-menu-parent', $classes) ||
        in_array('current_page_parent', $classes) ||
        in_array('current_page_ancestor', $classes)
    ) {

        $classes[] = "active";
    }

    return $classes;
}


class Main_Nav_Walker extends Walker_Nav_Menu {
  // <ul> оронд <nav> ашиглах
  public function start_lvl( &$output, $depth = 0, $args = null ) {
    $output .= ''; // footer-д submenu байхгүй бол хоосон орхино
  }

  public function end_lvl( &$output, $depth = 0, $args = null ) {
    $output .= '';
  }

  // <li><a>...</a></li> оронд зөвхөн <a> гаргана
  public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
    $atts = [];
    $atts['href'] = !empty($item->url) ? $item->url : '';
    $atts['class'] = 'nav-link'; // хүсвэл өөр classname өгч болно

    $attributes = '';
    foreach ($atts as $attr => $value) {
      if (!empty($value)) {
        $attributes .= ' ' . $attr . '="' . esc_attr($value) . '"';
      }
    }

    $title = apply_filters('the_title', $item->title, $item->ID);
    $output .= '<a' . $attributes . '>' . $title . '</a>';
  }

  public function end_el( &$output, $item, $depth = 0, $args = null ) {
    $output .= "\n";
  }
}
