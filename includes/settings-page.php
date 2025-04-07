<?php
if (!defined('ABSPATH')) exit;

add_action('admin_menu', function() {
    add_submenu_page(
        'edit.php?post_type=pa_linkgrid',
        'Einstellungen',
        'Einstellungen',
        'manage_options',
        'pa-linkgrid-settings',
        'pa_render_settings_page'
    );
});

add_action('admin_init', function() {
    register_setting('pa_settings_group', 'pa_linkgrid_settings');

    add_settings_section('pa_settings_main', 'Allgemeine Einstellungen', null, 'pa-linkgrid-settings');

    add_settings_field('default_style', 'Standard-Stil', function() {
        $options = get_option('pa_linkgrid_settings');
        $value = $options['default_style'] ?? 'style-default';
        ?>
        <select name="pa_linkgrid_settings[default_style]">
            <option value="style-default" <?= selected($value, 'style-default', false); ?>>Standard (Fade + Zoom)</option>
            <option value="style-border" <?= selected($value, 'style-border', false); ?>>Border Hover</option>
            <option value="style-darken" <?= selected($value, 'style-darken', false); ?>>Darken Hover</option>
        </select>
        <?php
    }, 'pa-linkgrid-settings', 'pa_settings_main');

    add_settings_field('grid_gap', 'Abstand zwischen Grid-Elementen (px)', function() {
        $options = get_option('pa_linkgrid_settings');
        $value = $options['grid_gap'] ?? '20';
        echo '<input type="number" name="pa_linkgrid_settings[grid_gap]" value="' . esc_attr($value) . '" min="0" />';
    }, 'pa-linkgrid-settings', 'pa_settings_main');

    add_settings_field('grid_columns', 'Maximale Spaltenanzahl', function() {
        $options = get_option('pa_linkgrid_settings');
        $value = $options['grid_columns'] ?? '4';
        echo '<input type="number" name="pa_linkgrid_settings[grid_columns]" value="' . esc_attr($value) . '" min="1" max="12" />';
    }, 'pa-linkgrid-settings', 'pa_settings_main');
});

function pa_render_settings_page() {
    ?>
    <div class="wrap">
        <h1>LinkGrid Einstellungen</h1>
        <form method="post" action="options.php">
            <?php
                settings_fields('pa_settings_group');
                do_settings_sections('pa-linkgrid-settings');
                submit_button('Einstellungen speichern');
            ?>
        </form>
    </div>
    <?php
}
?>