<?php
function pa_add_linkgrid_meta_box() {
    add_meta_box(
        'pa_linkgrid_links',
        'Link-Einträge',
        'pa_render_linkgrid_meta_box',
        'par_linkgrid',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'pa_add_linkgrid_meta_box');

function pa_render_linkgrid_meta_box($post) {
    $entries = get_post_meta($post->ID, '_pa_links', true) ?: [];
    $style = get_post_meta($post->ID, '_pa_grid_style', true) ?: 'style-default';

    echo '<div id="pa-link-repeater">';
    echo '<button type="button" class="button add-link">+ Link hinzufügen</button>';
    echo '<div class="link-items">';

    foreach ($entries as $entry) {
        echo '<div class="link-item">';
        echo '<input type="text" class="pa-link-url" name="pa_links[url][]" value="' . esc_attr($entry['url']) . '" placeholder="Link URL" />';
        
        echo '<div class="thumb-selector">';
        echo '<input type="text" class="pa-thumb-url" name="pa_links[thumb][]" value="' . esc_attr($entry['thumb']) . '" placeholder="Thumbnail URL" />';
        echo '<button class="button select-thumb">Bild auswählen</button>';
        echo '</div>';

        echo '<button class="button remove-link">– Entfernen</button>';
        echo '</div>';
    }

    echo '</div></div>';

    // Grid Style Auswahl
    echo '<h3>Grid Stil & Hover</h3>';
    echo '<select name="pa_grid_style">';
    $options = [
        'style-default' => 'Standard (Fade + Zoom)',
        'style-border' => 'Hover mit Border',
        'style-darken' => 'Dunkler Overlay beim Hover'
    ];
    foreach ($options as $key => $label) {
        echo '<option value="'. esc_attr($key) .'" ' . selected($key, $style, false) . '>' . esc_html($label) . '</option>';
    }
    echo '</select>';

    // Live Vorschau
    echo '<div id="pa-grid-preview" class="pa-grid '. esc_attr($style) .'" style="margin-top: 20px;">';
    echo '<div class="pa-grid-item"><img src="https://via.placeholder.com/150" /></div>';
    echo '<div class="pa-grid-item"><img src="https://via.placeholder.com/150" /></div>';
    echo '</div>';
}


function pa_save_linkgrid_meta($post_id) {
    if (!isset($_POST['pa_links'])) return;
    $urls = $_POST['pa_links']['url'];
    $thumbs = $_POST['pa_links']['thumb'];

    $data = [];
    for ($i = 0; $i < count($urls); $i++) {
        if (!empty($urls[$i])) {
            $data[] = ['url' => esc_url($urls[$i]), 'thumb' => esc_url($thumbs[$i])];
        }
    }

    update_post_meta($post_id, '_pa_links', $data);
	if (isset($_POST['pa_grid_style'])) {
    update_post_meta($post_id, '_pa_grid_style', sanitize_text_field($_POST['pa_grid_style']));
}

}
add_action('save_post', 'pa_save_linkgrid_meta');
