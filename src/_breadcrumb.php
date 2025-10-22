<?php
function bootstrap_breadcrumb($custom_home_icon = false, $custom_post_types = false)
{
    wp_reset_query();
    global $post;

    $is_custom_post = $custom_post_types ? is_singular($custom_post_types) : false;



    if (!is_front_page() && !is_home()) {
        echo '<ul class="breadcrumb d-flex flex-row justify-content-start">';
        echo '<li class="breadcrumb-item"><a href="/">';
        echo pll__('home');
        echo "</a></li>";

        if (has_category()) {
            // echo '<li class="breadcrumb-item active"><a href="' . esc_url(get_permalink(get_page(get_the_category($post->ID)))) . '">';
            // the_category(', ');
            // echo '</a></li>';
        }
        if ( is_search() ) {
            echo '<li class="breadcrumb-item active">' . pll__('search') . '</li>';
        }
        if (is_category() || is_single() || $is_custom_post) {
            if (is_category())
            // echo '<li class="active"><a href="' . esc_url( get_permalink( get_page( get_the_category( $post->ID ) ) ) ) . '">' . get_the_category( $post->ID )[ 0 ]->name . '</a></li>';
            {
                // if ($is_custom_post) {
                //     echo '<li class="breadcrumb-item active"><a href="' . get_option('home') . '/' . get_post_type_object(get_post_type($post))->name . '">' . get_post_type_object(get_post_type($post))->label . '</a></li>';
                //     if ($post->post_parent) {
                //         $home = get_page(get_option('page_on_front'));
                //         for ($i = count($post->ancestors) - 1; $i >= 0; $i--) {
                //             if (($home->ID) != ($post->ancestors[$i])) {
                //                 echo '<li class="breadcrumb-item"><a href="';
                //                 echo get_permalink($post->ancestors[$i]);
                //                 echo '">';
                //                 echo get_the_title($post->ancestors[$i]);
                //                 echo "</a></li>";
                //             }
                //         }
                //     }
                // }
            } else if ($is_custom_post) {
                if ($custom_post_types == "procurement") {
                    $parentID = cmb2_get_option('mcs_options', 'parent_procurement_id_' . pll_current_language('slug'));
                }
                if ($custom_post_types == "srproject") {
                    $parentID = cmb2_get_option('mcs_options', 'parent_srproject_id_' . pll_current_language('slug'));
                }
                if ($custom_post_types == "post") {
                    $parentID = cmb2_get_option('mcs_options', 'parent_news_id_' . pll_current_language('slug'));
                }
                $ancestors = get_the_top_ancestor_id($parentID);
                foreach ($ancestors as $id) {
                    echo '<li class="breadcrumb-item"><a href="';
                    echo get_permalink($id);
                    echo '">';
                    echo get_the_title($id);
                    echo "</a>";
                    echo "</li>";
                }
                echo '<li class="breadcrumb-item"><a href="';
                echo get_permalink($parentID);
                echo '">';
                echo get_the_title($parentID);
                echo "</a>";
                echo "</li>";

                echo '<li class="breadcrumb-item active">' . get_the_title($post->ID) . '</li>';
            } else if (is_single()) {
                echo '<li class="breadcrumb-item active">' . get_the_title($post->ID) . '</li>';
            }
        } elseif (is_page() && $post->post_parent) {
            $home = get_page(get_option('page_on_front'));
            for ($i = count($post->ancestors) - 1; $i >= 0; $i--) {
                if (($home->ID) != ($post->ancestors[$i])) {
                    echo '<li class="breadcrumb-item"><a href="';
                    echo get_permalink($post->ancestors[$i]);
                    echo '">';
                    echo get_the_title($post->ancestors[$i]);
                    echo "</a>";
                    echo "</li>";
                }
            }
            echo '<li class="breadcrumb-item active">' . get_the_title($post->ID) . '</li>';
        } elseif (is_tax()) {
            $customtaxonomy = get_queried_object();
            if (is_tax('reporttype')) {
                echo '<li class="breadcrumb-item active">' . $customtaxonomy->name . '</li>';
            }
        } elseif (is_page()) {
            echo '<li class="breadcrumb-item active">' . get_the_title($post->ID) . '</li>';
        } elseif (is_404()) {
            echo '<li class="breadcrumb-item active">404</li>';
        }
        echo '</ul>';
    }
}
