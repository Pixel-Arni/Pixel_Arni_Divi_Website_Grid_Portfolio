<?php

/**
 * Plugin Name: Pixel Arni - Grid Web Portfolio
 * Plugin URI: https://pixelarni.de/
 * Description: Erstellt ein responsives Portfolio-Grid mit anpassbaren Links und Thumbnails im WordPress Dashboard.
 * Version: 1.0.0
 * Author: Arnold Diez
 * Author URI: https://pixelarni.de/
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 *
 * @package Portfolio_Grid_Builder
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Aktiviere die Autoload-Funktion für Klassen.
 */
spl_autoload_register( 'portfolio_grid_builder_autoload' );

/**
 * Autoload-Funktion für Plugin-Klassen.
 *
 * @param string $class_name Der Name der Klasse.
 */
function portfolio_grid_builder_autoload( $class_name ) {
	if ( strpos( $class_name, 'Portfolio_Grid_Builder' ) === 0 ) {
		$file_name = 'class-' . str_replace( '_', '-', strtolower( str_replace( 'Portfolio_Grid_Builder_', '', $class_name ) ) ) . '.php';
		$directories = array(
			'includes',
			'admin',
			'admin/partials',
			'public',
			'public/partials',
		);
		foreach ( $directories as $dir ) {
			$path = plugin_dir_path( __FILE__ ) . $dir . '/' . $file_name;
			if ( file_exists( $path ) ) {
				require_once $path;
				return;
			}
		}
	}
}

/**
 * Include the activator class directly.
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/class-portfolio-grid-builder-activator.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-portfolio-grid-builder-deactivator.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-portfolio-grid-builder.php';
require_once plugin_dir_path( __FILE__ ) . 'admin/class-portfolio-grid-builder-admin.php';
require_once plugin_dir_path( __FILE__ ) . 'public/class-portfolio-grid-builder-public.php';

/**
 * Das Core-Plugin laden.
 */
function run_portfolio_grid_builder() {
	$plugin = Portfolio_Grid_Builder::get_instance();
	$plugin->run();
}
run_portfolio_grid_builder();

/**
 * Aktivierungs-Hook.
 */
register_activation_hook( __FILE__, array( 'Portfolio_Grid_Builder_Activator', 'activate' ) );

/**
 * Deaktivierungs-Hook.
 */
register_deactivation_hook( __FILE__, array( 'Portfolio_Grid_Builder_Deactivator', 'deactivate' ) );