<?php

/**
 * Die Core-Klasse des Plugins.
 *
 * Definiert den Plugin-Namen, die Version und registriert alles, was für das Plugin funktioniert.
 *
 * @package Portfolio_Grid_Builder
 * @author Dein Name
 */
class Portfolio_Grid_Builder {

	/**
	 * Die einzige Instanz der Klasse.
	 *
	 * @var Portfolio_Grid_Builder
	 */
	private static $instance;

	/**
	 * Der Name des Plugins.
	 *
	 * @access protected
	 * @var string $plugin_name Der Name, der dieses Plugin eindeutig identifiziert.
	 */
	protected $plugin_name;

	/**
	 * Die Version des Plugins.
	 *
	 * @access protected
	 * @var string $version Die aktuelle Version des Plugins.
	 */
	protected $version;

	/**
	 * Gibt die einzige Instanz der Klasse zurück.
	 *
	 * @return Portfolio_Grid_Builder Die Instanz der Klasse.
	 */
	public static function get_instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Definiert die Kernfunktionen des Plugins.
	 *
	 * Setzt den Plugin-Namen und die Plugin-Version, um sie später im Plugin zu verwenden.
	 * Lädt die Abhängigkeiten, erstellt die Admin- und Frontend-Klassen und definiert die Hooks.
	 *
	 * @access private
	 */
	private function __construct() {
		$this->plugin_name = 'portfolio-grid-builder';
		$this->version     = '1.0.0';

		$this->load_dependencies();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	/**
	 * Lädt die erforderlichen Abhängigkeiten für das Plugin.
	 *
	 * Inklusive der Admin- und Frontend-Klassen.
	 *
	 * @access private
	 */
	private function load_dependencies() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-portfolio-grid-builder-admin.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-portfolio-grid-builder-public.php';
	}

	/**
	 * Registriert die Hooks, die spezifisch für den Admin-Bereich des Plugins sind.
	 *
	 * @access private
	 */
	private function define_admin_hooks() {
		$plugin_admin = new Portfolio_Grid_Builder_Admin( $this->get_plugin_name(), $this->get_version() );
		add_action( 'admin_enqueue_scripts', array( $plugin_admin, 'enqueue_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $plugin_admin, 'enqueue_scripts' ) );
		add_action( 'admin_menu', array( $plugin_admin, 'add_plugin_admin_menu' ) );
		add_action( 'wp_ajax_save_portfolio_grid', array( $plugin_admin, 'save_portfolio_grid' ) );
		add_action( 'wp_ajax_load_portfolio_grid', array( $plugin_admin, 'load_portfolio_grid' ) );
		add_action( 'wp_ajax_delete_portfolio_grid', array( $plugin_admin, 'delete_portfolio_grid' ) );
		add_action( 'wp_ajax_add_grid_item', array( $plugin_admin, 'add_grid_item' ) );
		add_action( 'wp_ajax_save_grid_item', array( $plugin_admin, 'save_grid_item' ) );
		add_action( 'wp_ajax_delete_grid_item', array( $plugin_admin, 'delete_grid_item' ) );
	}

	/**
	 * Registriert die Hooks, die spezifisch für den Frontend-Bereich des Plugins sind.
	 *
	 * @access private
	 */
	private function define_public_hooks() {
		$plugin_public = new Portfolio_Grid_Builder_Public( $this->get_plugin_name(), $this->get_version() );
		add_action( 'wp_enqueue_scripts', array( $plugin_public, 'enqueue_styles' ) );
		add_shortcode( 'portfolio_grid', array( $plugin_public, 'display_portfolio_grid' ) );
	}

	/**
	 * Gibt den Namen des Plugins zurück.
	 *
	 * @return string Der Name des Plugins.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * Gibt die Version des Plugins zurück.
	 *
	 * @return string Die Version des Plugins.
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * Lässt das Plugin laufen.
	 */
	public function run() {
		// Nichts Besonderes hier im Moment.
	}
}