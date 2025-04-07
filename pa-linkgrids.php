<?php
/*
Plugin Name: Pixel Arni LinkGrids
Description: Erstelle schöne, responsive Link-Grids mit Thumbnails und Hover-Effekten.
Version: 1.0
Author: Dein Name
*/

if (!defined('ABSPATH')) exit;

define('PA_LINKGRIDS_PATH', plugin_dir_path(__FILE__));
define('PA_LINKGRIDS_URL', plugin_dir_url(__FILE__));

// Includes
require_once PA_LINKGRIDS_PATH . 'includes/post-type.php';
require_once PA_LINKGRIDS_PATH . 'includes/meta-boxes.php';
require_once PA_LINKGRIDS_PATH . 'includes/shortcode-handler.php';
require_once PA_LINKGRIDS_PATH . 'includes/settings-page.php';

// Assets laden
add_action('admin_enqueue_scripts', function($hook) {
    if (strpos($hook, 'pa_linkgrid') !== false) {
        wp_enqueue_style('pa-admin-css', PA_LINKGRIDS_URL . 'assets/css/admin-styles.css');
    }
});

add_action('wp_enqueue_scripts', function() {
    wp_enqueue_style('pa-frontend-css', PA_LINKGRIDS_URL . 'assets/css/frontend-styles.css');
});
?>
