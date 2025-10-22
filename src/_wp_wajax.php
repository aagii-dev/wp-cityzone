<?php
// ajax
foreach (glob(get_template_directory() . '/src/ajax/*.php') as $filename) {
    include_once $filename;
}
