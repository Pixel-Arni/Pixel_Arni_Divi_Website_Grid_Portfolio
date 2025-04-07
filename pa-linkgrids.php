<?php
/**
 * Plugin Name: P-A LinkGrids
 * Description: Erstelle schöne, responsive Link-Grids mit Hover-Effekten und manage sie bequem im Dashboard.
 * Version: 1.0
 * Author: Pixel-Arni
 * Text Domain: pa-linkgrids
 */

defined('ABSPATH') || exit;

// Konstanten definieren
define('PA_LINKGRIDS_PATH', plugin_dir_path(__FILE__));
define('PA_LINKGRIDS_URL', plugin_dir_url(__FILE__));

// Includes laden
require_once PA_LINKGRIDS_PATH . 'includes/post-type.php';
require_once PA_LINKGRIDS_PATH . 'includes/meta-boxes.php';
require_once PA_LINKGRIDS_PATH . 'includes/settings-page.php';
require_once PA_LINKGRIDS_PATH . 'includes/shortcode-handler.php';

// Assets laden
add_action('admin_enqueue_scripts', function($hook) {
    wp_enqueue_style('pa-admin-styles', PA_LINKGRIDS_URL . 'assets/css/admin-styles.css');
    wp_enqueue_script('pa-admin-scripts', PA_LINKGRIDS_URL . 'assets/js/admin-scripts.js', ['jquery'], null, true);
});

add_action('wp_enqueue_scripts', function() {
    wp_enqueue_style('pa-frontend-styles', PA_LINKGRIDS_URL . 'assets/css/frontend-styles.css');
});
