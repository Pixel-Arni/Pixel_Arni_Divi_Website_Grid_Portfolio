<?php

/**
 * Plugin Name: Pixel Arni - Grid Web Portfolio
 * Plugin URI: https://pixelarni.de/
 * Description: Erstellt ein responsives Portfolio-Grid mit anpassbaren Links und Thumbnails im WordPress Dashboard.
 * Version: 1.0.0
 * Author: Dein Name
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
	if ( false === strpos( $class_name, 'Portfolio_Grid_Builder' ) ) {
		return;
	}

	$file_base = dirname( __FILE__ ) . '/';
	$class_path = str_replace( '_', '-', strtolower( str_replace( 'Portfolio_Grid_Builder_', '', $class_name ) ) );
	$file_name  = 'class-' . $class_path . '.php';

	if ( file_exists( $file_base . 'includes/' . $file_name ) ) {
		require_once $file_base . 'includes/' . $file_name;
	} elseif ( file_exists( $file_base . 'admin/' . $file_name ) ) {
		require_once $file_base . 'admin/' . $file_name;
	} elseif ( file_exists( $file_base . 'admin/partials/' . $file_name ) ) {
		require_once $file_base . 'admin/partials/' . $file_name;
	} elseif ( file_exists( $file_base . 'public/' . $file_name ) ) {
		require_once $file_base . 'public/' . $file_name;
	} elseif ( file_exists( $file_base . 'public/partials/' . $file_name ) ) {
		require_once $file_base . 'public/partials/' . $file_name;
	}
}

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