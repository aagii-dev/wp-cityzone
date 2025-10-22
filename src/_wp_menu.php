<?php

/* * ***************************************  MENU SETTINGS ******************************************** */

function register_my_menu()
{
    register_nav_menu('core-menu-1', __('Core menu'));
    register_nav_menu('footer-menu-1', __('Footer menu 1'));
    register_nav_menu('footer-menu-2', __('Footer menu 2'));
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


if (!class_exists('My_Custom_Nav_Walker')) {
    class My_Custom_Nav_Walker extends Walker_Nav_Menu
    {
        function display_element($element, &$children_elements, $max_depth, $depth, $args, &$output)
        {
            if (!$element) return;
            $id_field = $this->db_fields['id'];

            if (is_array($args[0])) $args[0]['has_children'] = !empty($children_elements[$element->$id_field]);
            else if (is_object($args[0])) $args[0]->has_children = !empty($children_elements[$element->$id_field]);

            $cb_args = array_merge(array(&$output, $element, $depth), $args);
            call_user_func_array(array(&$this, 'start_el'), $cb_args);

            $id = $element->$id_field;
            if (($max_depth == 0 || $max_depth > $depth + 1) && isset($children_elements[$id])) {
                foreach ($children_elements[$id] as $child) {
                    if (!isset($newlevel)) {
                        $newlevel = true;
                        $cb_args = array_merge(array(&$output, $depth), $args);
                        call_user_func_array(array(&$this, 'start_lvl'), $cb_args);
                    }
                    $this->display_element($child, $children_elements, $max_depth, $depth + 1, $args, $output);
                }
                unset($children_elements[$id]);
            }

            if (isset($newlevel) && $newlevel) {
                $cb_args = array_merge(array(&$output, $depth), $args);
                call_user_func_array(array(&$this, 'end_lvl'), $cb_args);
            }

            $cb_args = array_merge(array(&$output, $element, $depth), $args);
            call_user_func_array(array(&$this, 'end_el'), $cb_args);
        }

        public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
        {
            if ((is_object($item) && $item->title == null) || (!is_object($item))) return;

            $indent = ($depth) ? str_repeat("\t", $depth) : '';

            $li_attributes = '';
            $class_names = $value = '';

            $classes = empty($item->classes) ? array() : (array) $item->classes;
            if (is_object($args) && !empty($args->has_children)) {
                $classes[] = 'dropdown';
                $li_attributes .= ' data-dropdown="dropdown"';
            }

            // ---- 🔹 Hash (#section) дэмжлэг
            $hash_id = get_post_meta($item->ID, '_jump-section-id', true);
            $hash = !empty($hash_id) ? '#' . $hash_id : '';

            $classes[] = 'menu-item-' . $item->ID;
            $classes[] = ($item->current) ? 'active' : '';

            $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
            $class_names = ' class="' . esc_attr($class_names) . '"';

            $id_attr = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
            $id_attr = strlen($id_attr) ? ' id="' . esc_attr($id_attr) . '"' : '';

            // ---- 🔹 Depth 0 үед description-оос attachment ID унших
            $bg_url = '';
            if ($depth === 1 && !empty($item->description)) {
                if (preg_match('/(\d{1,})/', $item->description, $m)) {
                    $att_id = intval($m[1]);
                    if ($att_id > 0) {
                        $maybe_url = wp_get_attachment_image_url($att_id, 'full');
                        if ($maybe_url) $bg_url = $maybe_url;
                    }
                }
            }

            // LI нээх
            $output .= $indent . '<li' . $id_attr . $value . $class_names . $li_attributes . '>';

            // 👉 Хэрэв bg олдсон бол дотроос нь background div оруулъя
          

            // <a> атрибутууд
            $attributes  = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
            $attributes .= !empty($item->target)     ? ' target="' . esc_attr($item->target) . '"' : '';
            $attributes .= !empty($item->xfn)        ? ' rel="' . esc_attr($item->xfn) . '"' : '';
            $attributes .= !empty($item->url)        ? ' href="' . esc_attr($item->url) . $hash . '"' : '';

            // ---- 🔹 depth 0 link class, data-slug
            if ($depth === 0) {
                $a_class = []; // ИНИЦИАЛИЗ!
                $a_class[] = "nav-link";
                if (!empty($item->current)) $a_class[] = 'active';
                $attributes .= ' class="' . implode(" ", array_filter($a_class)) . '"';

                $slug = basename(trim(parse_url($item->url ?? '', PHP_URL_PATH) ?? '', '/'));
                $tmpslug = ($slug === '' ? 'нүүр' : $slug);
                $attributes .= ' data-slug="' . esc_attr($tmpslug) . '"';
            }

            $item_output  = (is_object($args)) ? $args->before : '';
            $item_output .= '<a' . $attributes . '>';
            if ($bg_url) {
                $item_output .= '<img class="aspect-img" src="'.esc_url(get_template_directory_uri()).'/assets/images/aspect-68-36.png" />';
                $item_output .= '<div class="menu-bg" style="background-image:url(' . esc_url($bg_url) . ');"></div><div class="menu-bg-overlay"></div>';
                
                $item_output .= '<div class="menu-card-content">';
                $item_output .= (is_object($args) ? $args->link_before : '') . "<div class='menu-card-title'>".apply_filters('the_title', $item->title, $item->ID)."</div>" . (is_object($args) ? $args->link_after : '');
                $item_output .= "<svg width='44' height='44' viewBox='0 0 44 44' fill='none' ><rect y='0.000488281' width='44' height='44' rx='22' fill='white'/><path d='M20.5 16.7505C20.0858 16.7505 19.75 17.0863 19.75 17.5005C19.75 17.9147 20.0858 18.2505 20.5 18.2505H24.6893L16.9697 25.9702C16.6768 26.2631 16.6768 26.7379 16.9697 27.0308C17.2626 27.3237 17.7374 27.3237 18.0303 27.0308L25.75 19.3111V23.5005C25.75 23.9147 26.0858 24.2505 26.5 24.2505C26.9142 24.2505 27.25 23.9147 27.25 23.5005V17.5005C27.25 17.0863 26.9142 16.7505 26.5 16.7505H20.5Z' fill='#282828'/></svg>";
                $item_output .= "</div>";
            
                // Эсвэл зөвхөн датагаар дамжуулахыг хүсвэл:
                // $output = rtrim($output, ">") . ' data-bg="' . esc_url($bg_url) . '">';
            }else{
                $item_output .= (is_object($args) ? $args->link_before : '') . "<div class='menu-card-title'>".apply_filters('the_title', $item->title, $item->ID)."</div>" . (is_object($args) ? $args->link_after : '');
            }
           
            
         

            $item_output .= '</a>';
            $item_output .= (is_object($args) ? $args->after : '');

            $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
        }

        public function start_lvl( &$output, $depth = 0, $args = null ) {
            $depth_class = "depth" . $depth;
            $indent = str_repeat("\t", $depth);
            $output .= "\n{$indent}<div class=\"sub-menu-container\"><div class=\"container\">\n";
            $output .= "{$indent}<ul class=\"sub-menu {$depth_class}\">\n";
        }

        public function end_lvl( &$output, $depth = 0, $args = null ) {
            $indent = str_repeat("\t", $depth);
            $output .= "{$indent}</ul>\n";
            $output .= "{$indent}</div></div>\n";
        }
    }
}








if ( ! class_exists('Footer_Menu_Walker') ) {
    class Footer_Menu_Walker extends Walker_Nav_Menu {

        public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
            $hash_id = get_post_meta($item->ID, '_jump-section-id', true);
            $hash = !empty($hash_id) ? '#' . $hash_id : '';

            $classes     = empty( $item->classes ) ? [] : (array) $item->classes;
            $class_names = implode( ' ', array_map( 'sanitize_html_class', $classes ) );

            $output .= '<li class="footer-menu-item ' . esc_attr( $class_names ) . '">';

            // <> аттрибутууд
            $atts  = ' href="' . esc_url( $item->url ?: '#' ) . $hash .  '"';
            $atts .= ! empty( $item->attr_title ) ? ' title="' . esc_attr( $item->attr_title ) . '"' : '';
            $atts .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target ) . '"'     : '';
            $atts .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn )    . '"'     : '';

            $output .= '<a' . $atts . '>';

            $output .= esc_html( $item->title );
                  // Зөвхөн үндсэн түвшин (depth = 0) дээр SVG нэмнэ
            if ( $depth === 0 ) {
                $output .= '<svg width="18" height="19" viewBox="0 0 18 19" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" class="icon">
<path d="M7.5 4.41797C7.08579 4.41797 6.75 4.75376 6.75 5.16797C6.75 5.58218 7.08579 5.91797 7.5 5.91797H11.6893L3.96967 13.6376C3.67678 13.9305 3.67678 14.4054 3.96967 14.6983C4.26256 14.9912 4.73744 14.9912 5.03033 14.6983L12.75 6.97863V11.168C12.75 11.5822 13.0858 11.918 13.5 11.918C13.9142 11.918 14.25 11.5822 14.25 11.168V5.16797C14.25 4.75376 13.9142 4.41797 13.5 4.41797H7.5Z" fill="#98D84E"/>
</svg> ';
            }
            
            $output .= '</a>';

        }

        public function end_el( &$output, $item, $depth = 0, $args = null ) {
            $output .= "</li>\n";
        }

        // Хэрэв submenu-ийн <ul> дээр классууд нэмэх хэрэгтэй бол:
        public function start_lvl( &$output, $depth = 0, $args = null ) {
            $output .= "\n<ul class='footer-sub-menu depth-{$depth}'>\n";
        }
        public function end_lvl( &$output, $depth = 0, $args = null ) {
            $output .= "</ul>\n";
        }
    }
}
