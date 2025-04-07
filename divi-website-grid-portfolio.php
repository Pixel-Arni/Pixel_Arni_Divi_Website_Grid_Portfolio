<?php
/**
 * Plugin Name: Pixel Arni - Divi Website Grid Portfolio
 * Plugin URI: https://pixelarni.de/
 * Description: Ein responsives Grid-Modul für das Divi Theme zum Anzeigen von Website-Links als Portfolio.
 * Version: 1.0.1
 * Author: Pixel Arni
 * Author URI: https://pixelarni.de/
 * License: GPL2
 */

// Sicherstellen, dass der Zugriff nur über WordPress erfolgt
if (!defined('ABSPATH')) exit;

class Divi_Website_Grid_Portfolio {
    
    function __construct() {
        // Make sure we're running after Divi is loaded
        add_action('et_builder_framework_loaded', array($this, 'register_module'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
    }
    
    function register_module() {
        if (class_exists('ET_Builder_Module')) {
            include_once(plugin_dir_path(__FILE__) . 'includes/modules/WebsiteGrid/WebsiteGrid.php');
        }
    }
    
    function enqueue_scripts() {
        wp_enqueue_style('divi-website-grid-styles', plugin_dir_url(__FILE__) . 'assets/css/divi-website-grid.css', array(), '1.0.1');
        wp_enqueue_script('divi-website-grid-script', plugin_dir_url(__FILE__) . 'assets/js/divi-website-grid.js', array('jquery'), '1.0.1', true);
    }
    
    public static function activate() {
        // Sicherstellen, dass Divi installiert ist
        if (!class_exists('ET_Builder_Module')) {
            deactivate_plugins(plugin_basename(__FILE__));
            wp_die('Dieses Plugin benötigt das Divi Theme oder Divi Builder Plugin, um zu funktionieren.', 'Plugin Aktivierungsfehler', array('back_link' => true));
        }
    }
}

// Plugin initialisieren
$divi_website_grid = new Divi_Website_Grid_Portfolio();

// Aktivierungshook
register_activation_hook(__FILE__, array('Divi_Website_Grid_Portfolio', 'activate'));