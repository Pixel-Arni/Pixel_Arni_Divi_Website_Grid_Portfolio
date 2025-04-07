<?php
if (!defined('ABSPATH')) exit;

function pa_render_linkgrid_shortcode($atts) {
    $atts = shortcode_atts([
        'id' => null
    ], $atts, 'par_linkgrid');

    if (!$atts['id']) {
        return '<p><strong>Fehler:</strong> Kein Grid ausgewählt.</p>';
    }

    $entries = get_post_meta($atts['id'], '_pa_links', true);
    $style = get_post_meta($atts['id'], '_pa_grid_style', true) ?: 'style-default';

    if (!$entries || !is_array($entries)) {
        return '<p><em>Keine Links vorhanden.</em></p>';
    }

    ob_start();
    echo '<div class="pa-grid ' . esc_attr($style) . '">';
    foreach ($entries as $entry) {
        $url = esc_url($entry['url'] ?? '#');
        $thumb = esc_url($entry['thumb'] ?? 'https://via.placeholder.com/300');
        echo '<a class="pa-grid-item" href="' . $url . '" target="_blank" rel="noopener noreferrer">';
        echo '<img src="' . $thumb . '" alt="Grid Item" />';
        echo '</a>';
    }
    echo '</div>';
    return ob_get_clean();
}
add_shortcode('par_linkgrid', 'pa_render_linkgrid_shortcode');
?>