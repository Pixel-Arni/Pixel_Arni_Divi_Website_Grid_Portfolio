<?php
function pa_register_linkgrid_cpt() {
    register_post_type('par_linkgrid', [
        'labels' => [
            'name' => 'LinkGrids',
            'singular_name' => 'LinkGrid',
            'add_new_item' => 'Neues Grid erstellen',
            'edit_item' => 'Grid bearbeiten',
        ],
        'public' => false,
        'show_ui' => true,
        'menu_icon' => 'dashicons-screenoptions',
        'menu_position' => 5,
        'supports' => ['title'],
        'show_in_menu' => 'pa-linkgrids',
    ]);
}
add_action('init', 'pa_register_linkgrid_cpt');

add_action('admin_menu', function() {
    add_menu_page('P-A LinkGrids', 'P-A LinkGrids', 'manage_options', 'pa-linkgrids', function() {
        echo '<h1>Willkommen bei P-A LinkGrids</h1>';
    }, 'dashicons-grid-view', 26);
});
