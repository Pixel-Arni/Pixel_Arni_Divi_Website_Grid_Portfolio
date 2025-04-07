<?php
function pa_render_linkgrid_shortcode($atts) {
    $atts = shortcode_atts(['id' => 0], $atts);
    $entries = get_post_meta($atts['id'], '_pa_links', true);

    ob_start();
    echo '<div class="pa-grid">';
    foreach ($entries as $entry) {
        echo '<a href="'. esc_url($entry['url']) .'" class="pa-grid-item" target="_blank">';
        echo '<img src="'. esc_url($entry['thumb']) .'" alt="Grid Thumbnail" />';
        echo '</a>';
    }
    echo '</div>';

    return ob_get_clean();
}
add_shortcode('par_linkgrid', 'pa_render_linkgrid_shortcode');

$style = get_post_meta($atts['id'], '_pa_grid_style', true) ?: 'style-default';
echo '<div class="pa-grid '. esc_attr($style) .'">';
