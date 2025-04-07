<?php
if (!defined('ABSPATH')) exit;

add_action('add_meta_boxes', function() {
    add_meta_box('pa_linkgrid_meta', 'Grid-Inhalte', 'pa_render_linkgrid_meta', 'pa_linkgrid', 'normal', 'high');
});

function pa_render_linkgrid_meta($post) {
    wp_nonce_field('pa_linkgrid_nonce', 'pa_linkgrid_nonce_field');
    $entries = get_post_meta($post->ID, '_pa_links', true) ?: [];
    $style = get_post_meta($post->ID, '_pa_grid_style', true) ?: 'style-default';

    echo '<label>Stil auswählen:</label> ';
    echo '<select name="pa_grid_style">';
    $styles = ['style-default' => 'Standard', 'style-border' => 'Border', 'style-darken' => 'Darken'];
    foreach ($styles as $key => $label) {
        echo '<option value="' . $key . '"' . selected($style, $key, false) . '>' . $label . '</option>';
    }
    echo '</select><br><br>';

    echo '<div id="pa-linkgrid-wrapper">';
    if (!empty($entries)) {
        foreach ($entries as $index => $entry) {
            echo pa_render_grid_item($entry['url'], $entry['thumb'], $index);
        }
    }
    echo '</div>';
    echo '<button type="button" class="button" id="pa-add-grid-item">+ Link hinzufügen</button>';

    echo '<script>
    let paIndex = ' . count($entries) . ';
    document.getElementById("pa-add-grid-item").addEventListener("click", function() {
        const container = document.getElementById("pa-linkgrid-wrapper");
        const html = `' . pa_render_grid_item('', '', '__index__') . '`.replace(/__index__/g, paIndex);
        container.insertAdjacentHTML("beforeend", html);
        paIndex++;
    });
    </script>';
}

function pa_render_grid_item($url, $thumb, $index) {
    return '<div class="pa-grid-item-admin" style="margin-bottom:10px;">
        <input type="url" name="pa_links['.$index.'][url]" value="'.esc_attr($url).'" placeholder="Link URL" style="width:40%;" />
        <input type="text" name="pa_links['.$index.'][thumb]" value="'.esc_attr($thumb).'" placeholder="Thumbnail URL" style="width:40%;" />
        <button type="button" class="button pa-media-upload">📁</button>
    </div>';
}

add_action('save_post', function($post_id) {
    if (!isset($_POST['pa_linkgrid_nonce_field']) || !wp_verify_nonce($_POST['pa_linkgrid_nonce_field'], 'pa_linkgrid_nonce')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

    update_post_meta($post_id, '_pa_links', $_POST['pa_links'] ?? []);
    update_post_meta($post_id, '_pa_grid_style', $_POST['pa_grid_style'] ?? 'style-default');
});
?>