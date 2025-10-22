<?php

if (isset($polylang)) {
    function site_languages()
    {
        global $polylang;
        $Langs = $polylang->model->get_languages_list();
        return $Langs;
    }
    add_action('init', 'site_languages');
    $lang_args = array(
        array('description' => 'Copy right', 'keyboard' => 'copy_right'),
        array('description' => 'Footer text', 'keyboard' => 'footer_text'),
        array('description' => 'Хуудас олдсонгүй', 'keyboard' => 'not_found'),
        array('description' => 'Oops', 'keyboard' => 'oops'),
        array('description' => 'Нүүр хуудас', 'keyboard' => 'home_page'),
        array('description' => 'Нэвтэрсэн', 'keyboard' => 'already'),
        array('description' => 'Тун удахгүй', 'keyboard' => 'coming'),
        array('description' => 'Үнэлгээ өгөх', 'keyboard' => 'review_modal_title'),
        array('description' => 'үнэлгээ', 'keyboard' => 'reviewed'),
        array('description' => 'Нүүр', 'keyboard' => 'home'),
        array('description' => 'Нэвтрэх', 'keyboard' => 'login'),
        array('description' => 'Илгээх', 'keyboard' => 'send'),
        
    );
    //Declare and set language strings to Global variables
    foreach ($lang_args as $key => $value) {
        pll_register_string($value['description'], $value['keyboard'], 'Site-words');
    }
}
