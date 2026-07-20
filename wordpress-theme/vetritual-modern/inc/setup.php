<?php
if (! defined('ABSPATH')) {
    exit;
}

function vr_load_theme_assets() {
    if (function_exists('wp_enqueue_style')) {
        wp_enqueue_style('vetritual-theme-style');
    }
}

function vr_load_theme_json_defaults() {
    return array(
        'version' => '1.0',
        'theme_file' => get_template_directory() . '/theme.json',
    );
}
