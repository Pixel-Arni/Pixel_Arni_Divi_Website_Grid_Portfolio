<?php
/**
 * Plugin Name: Pixel Arni - Divi Website Grid Portfolio
 * Plugin URI: https://pixelarni.de/
 * Description: Ein responsives Grid-Modul für das Divi Theme zum Anzeigen von Website-Links als Portfolio.
 * Version: 1.0
 * Author: 
 * Author URI: 
 * License: GPL2
 */

// Sicherstellen, dass der Zugriff nur über WordPress erfolgt
if (!defined('ABSPATH')) exit;

class Divi_Website_Grid_Portfolio {
    
    function __construct() {
        add_action('et_builder_ready', array($this, 'register_module'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
    }
    
    function register_module() {
        if (class_exists('ET_Builder_Module')) {
            include_once('includes/modules/WebsiteGrid/WebsiteGrid.php');
        }
    }
    
    function enqueue_scripts() {
        wp_enqueue_style('divi-website-grid-styles', plugin_dir_url(__FILE__) . 'assets/css/divi-website-grid.css');
        wp_enqueue_script('divi-website-grid-script', plugin_dir_url(__FILE__) . 'assets/js/divi-website-grid.js', array('jquery'), '1.0', true);
    }
    
    public static function activate() {
        // Plugin-Aktivierung (optional)
    }
}

// Plugin initialisieren
$divi_website_grid = new Divi_Website_Grid_Portfolio();

// Aktivierungshook
register_activation_hook(__FILE__, array('Divi_Website_Grid_Portfolio', 'activate'));
```

## Ordner: includes/modules/WebsiteGrid/WebsiteGrid.php