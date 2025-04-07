<?php
if (!defined('ABSPATH')) exit;

add_action('init', function() {
    register_post_type('pa_linkgrid', [
        'labels' => [
            'name' => 'P-A LinkGrids',
            'singular_name' => 'LinkGrid',
            'add_new_item' => 'Neues LinkGrid erstellen',
            'edit_item' => 'LinkGrid bearbeiten'
        ],
        'public' => false,
        'show_ui' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-screenoptions',
        'supports' => ['title'],
        'has_archive' => false
    ]);
});
?>