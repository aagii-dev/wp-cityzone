<?php
// cmb2, polylang, wpbakery

// cmb2
foreach (glob(get_template_directory() . '/src/cmb2/*.php') as $filename) {
    include_once $filename;
}

// polylang
foreach (glob(get_template_directory() . '/src/polylang/*.php') as $filename) {
    include_once $filename;
}

// wpbakery
$vc_components = glob(get_template_directory() . '/src/wpbakery/*.php');
foreach ($vc_components as $file) {
    include_once $file;
}
add_action('vc_before_init', function () use ($vc_components) {
    foreach ($vc_components as $file) {
        $class = pathinfo($file, PATHINFO_FILENAME); // t-video
        $class = 'vc' . str_replace('-', '', ucfirst($class)); // vcTvideo
        if (class_exists($class)) {
            new $class(); // dynamic class үүсгэнэ
        }
    }
});
