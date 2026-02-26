<?php
function add_theme_scripts()
{
    /** ==================================================== **/
    /*                 LIBRARIES                              */
    /** ==================================================== **/
    // jquery
    // wp_deregister_script('jquery'); // deregisters the default WordPress jQuery
    // wp_register_script('jquery', get_template_directory_uri() . '/assets/plugins/jquery/v3.5.1/jquery-3.5.1.min.js');
    // wp_enqueue_script('jquery');

    // jquery ui
    // wp_enqueue_style('jquery-ui', get_template_directory_uri() . '/assets/plugins/jquery/jquery-ui.css');
    // wp_enqueue_script('jquery-ui', get_template_directory_uri() . '/assets/plugins/jquery/jquery-ui.js');

    // jquery pie
    // wp_enqueue_script('jquery-pie', get_template_directory_uri() . '/assets/plugins/jquery-pie/jquery.easy-pie-chart.js');

    // aos
    // wp_enqueue_style('aos', get_template_directory_uri() . '/assets/plugins/aos/v2.3.1/aos.css');
    // wp_enqueue_script('aos', get_template_directory_uri() . '/assets/plugins/aos/v2.3.1/aos.js');

    // blurry
    wp_enqueue_style('blurry', get_template_directory_uri() . '/assets/plugins/blurry/blurry-load.css');
    wp_enqueue_script('blurry', get_template_directory_uri() . '/assets/plugins/blurry/blurry-load.js', '', '', true);

    // bootstrap
    wp_enqueue_style('bootstrap', get_template_directory_uri() . '/assets/plugins/bootstrap/v5.3.3/css/bootstrap.min.css');
    wp_enqueue_script('bootstrap', get_template_directory_uri() . '/assets/plugins/bootstrap/v5.3.3/js/bootstrap.bundle.min.js', '', '', true);

    // swiper
    wp_enqueue_style('swiper', get_template_directory_uri() . '/assets/plugins/swiper/v11.1.12/swiper-bundle.min.css');
    wp_enqueue_script('swiper', get_template_directory_uri() . '/assets/plugins/swiper/v11.1.12/swiper-bundle.min.js');

    // elevate zoom
    // wp_enqueue_script('elevate', get_template_directory_uri() . '/assets/plugins/elevate-zoom/v3.0.8/jquery.elevateZoom-3.0.8.min.js', '', '');

    // chartjs
    // wp_enqueue_script('chartjs', get_template_directory_uri() . '/assets/plugins/chartjs/v2.7.3/chart.bundle.min.js');

    // parallax
    // wp_enqueue_script('parallax-master', get_template_directory_uri() . '/assets/plugins/parallax-master/parallax.min.js');

    // selectize
    // wp_enqueue_script('selectize', get_template_directory_uri() . '/assets/plugins/selectize.js');

    // fontawesome
    // wp_enqueue_style('fontawesome', get_template_directory_uri() . '/assets/plugins/fontawesome/v5.6.1/fontawesome-5.6.1.min.css');


    // lightGallery
    // wp_enqueue_style('lightgallery', get_template_directory_uri() . '/assets/plugins/lightgallery/gallery-dist/css/lightgallery.min.css');
    // wp_enqueue_script('lightgalleryThumb', get_template_directory_uri() . '/assets/plugins/lightgallery/gallery-dist/js/picturefill.min.js');
    // wp_enqueue_script('lightgalleryZoom', get_template_directory_uri() . '/assets/plugins/lightgallery/gallery-dist/js/lightgallery-all.min.js');


    // lenis
    wp_enqueue_script('lenis', get_template_directory_uri() . '/assets/plugins/lenis/1.3.8/lenis.min.js', [], null, true);
    wp_enqueue_script('custom-lenis', get_template_directory_uri() . '/assets/js/lenis-init.js', ['lenis'], null, true);

    /** ==================================================== **/
    /*                CUSTOM STYLE & SCRIPTS                  */
    /** ==================================================== **/
    // css
    wp_enqueue_style('main', get_template_directory_uri() . '/assets/styles/main.css?v=43');
    // js
    // wp_enqueue_script('loader', get_template_directory_uri() . '/assets/js/loader.js','','',true);
    wp_enqueue_script('main', get_template_directory_uri() . '/assets/js/main.js?v=43', '', '');
}
add_action('wp_enqueue_scripts', 'add_theme_scripts');
