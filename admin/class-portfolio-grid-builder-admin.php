<?php

/**
 * Die Admin-spezifische Funktionalität des Plugins definieren.
 *
 * @package Portfolio_Grid_Builder
 * @author Dein Name
 */
class Portfolio_Grid_Builder_Admin {

	/**
	 * Der Name dieses Plugins.
	 *
	 * @access private
	 * @var string $plugin_name Der Name, der dieses Plugin eindeutig identifiziert.
	 */
	private $plugin_name;

	/**
	 * Die Version dieses Plugins.
	 *
	 * @access private
	 * @var string $version Die aktuelle Version des Plugins.
	 */
	private $version;

	/**
	 * Initialisiere die Klasse und setze ihre Eigenschaften.
	 *
	 * @param string $plugin_name Der Name dieses Plugins.
	 * @param string $version Die Version dieses Plugins.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * Registriere die Stylesheets für den Admin-Bereich.
	 */
	public function enqueue_styles( $hook_suffix ) {
		if ( 'toplevel_page_' . $this->plugin_name === $hook_suffix ) {
			wp_enqueue_style( $this->plugin_name . '-admin', plugin_dir_url( __FILE__ ) . 'css/portfolio-grid-builder-admin.css', array(), $this->version, 'all' );
			wp_enqueue_style( 'wp-color-picker' );
		}
	}

	/**
	 * Registriere die JavaScripts für den Admin-Bereich.
	 */
	public function enqueue_scripts( $hook_suffix ) {
		if ( 'toplevel_page_' . $this->plugin_name === $hook_suffix ) {
			wp_enqueue_media();
			wp_enqueue_script( $this->plugin_name . '-admin', plugin_dir_url( __FILE__ ) . 'js/portfolio-grid-builder-admin.js', array( 'jquery', 'wp-color-picker' ), $this->version, false );
			wp_localize_script(
				$this->plugin_name . '-admin',
				'portfolioGridBuilderAdmin',
				array(
					'ajax_url' => admin_url( 'admin-ajax.php' ),
					'nonce'    => wp_create_nonce( 'portfolio_grid_builder_nonce' ),
				)
			);
		}
	}

	/**
	 * Füge die Admin-Menüseite für das Plugin hinzu.
	 */
	public function add_plugin_admin_menu() {
		add_menu_page(
			__( 'Portfolio Grid', 'portfolio-grid-builder' ),
			__( 'Portfolio Grid', 'portfolio-grid-builder' ),
			'manage_options',
			$this->plugin_name,
			array( $this, 'display_admin_page' ),
			'dashicons-grid-view'
		);
	}

	/**
	 * Zeige die Admin-Seite des Plugins an.
	 */
	public function display_admin_page() {
		require_once plugin_dir_path( __FILE__ ) . 'partials/portfolio-grid-builder-admin-display.php';
	}

	/**
	 * Speichert ein neues oder aktualisiert ein bestehendes Portfolio-Grid.
	 */
	public function save_portfolio_grid() {
		$this->check_ajax_nonce();

		$grid_id   = isset( $_POST['grid_id'] ) ? intval( $_POST['grid_id'] ) : 0;
		$grid_name = sanitize_text_field( $_POST['grid_name'] );
		$grid_data = get_option( 'portfolio_grids', array() );

		$styles = array(
			'grid_gap'        => sanitize_text_field( $_POST['grid_gap'] ),
			'thumbnail_width' => sanitize_text_field( $_POST['thumbnail_width'] ),
			'border_color'    => sanitize_hex_color( $_POST['border_color'] ),
			// Füge hier weitere Style-Optionen hinzu
		);

		if ( $grid_id > 0 && isset( $grid_data[ $grid_id ] ) ) {
			$grid_data[ $grid_id ]['name']   = $grid_name;
			$grid_data[ $grid_id ]['styles'] = $styles;
		} else {
			$new_grid_id                      = time(); // Einfache ID-Generierung
			$grid_data[ $new_grid_id ]        = array(
				'id'    => $new_grid_id,
				'name'  => $grid_name,
				'items' => array(),
				'styles' => $styles,
			);
		}

		update_option( 'portfolio_grids', $grid_data );
		wp_send_json_success( array( 'message' => __( 'Grid gespeichert!', 'portfolio-grid-builder' ) ) );
	}

	/**
	 * Lädt die Daten eines bestimmten Portfolio-Grids.
	 */
	public function load_portfolio_grid() {
		$this->check_ajax_nonce();

		$grid_id   = isset( $_POST['grid_id'] ) ? intval( $_POST['grid_id'] ) : 0;
		$grid_data = get_option( 'portfolio_grids', array() );

		if ( isset( $grid_data[ $grid_id ] ) ) {
			wp_send_json_success( $grid_data[ $grid_id ] );
		} else {
			wp_send_json_error( array( 'message' => __( 'Grid nicht gefunden.', 'portfolio-grid-builder' ) ) );
		}
	}

	/**
	 * Löscht ein Portfolio-Grid.
	 */
	public function delete_portfolio_grid() {
		$this->check_ajax_nonce();

		$grid_id   = isset( $_POST['grid_id'] ) ? intval( $_POST['grid_id'] ) : 0;
		$grid_data = get_option( 'portfolio_grids', array() );

		if ( isset( $grid_data[ $grid_id ] ) ) {
			unset( $grid_data[ $grid_id ] );
			update_option( 'portfolio_grids', $grid_data );
			wp_send_json_success( array( 'message' => __( 'Grid gelöscht!', 'portfolio-grid-builder' ) ) );
		} else {
			wp_send_json_error( array( 'message' => __( 'Grid nicht gefunden.', 'portfolio-grid-builder' ) ) );
		}
	}

	/**
	 * Fügt ein neues leeres Item zu einem Portfolio-Grid hinzu.
	 */
	public function add_grid_item() {
		$this->check_ajax_nonce();

		$grid_id   = isset( $_POST['grid_id'] ) ? intval( $_POST['grid_id'] ) : 0;
		$grid_data = get_option( 'portfolio_grids', array() );

		if ( isset( $grid_data[ $grid_id ] ) ) {
			$item_id = time(); // Einfache ID für das Item
			$grid_data[ $grid_id ]['items'][ $item_id ] = array(
				'id'        => $item_id,
				'title'     => '',
				'url'       => '',
				'thumbnail' => '',
			);
			update_option( 'portfolio_grids', $grid_data );
			wp_send_json_success( array( 'item_id' => $item_id ) );
		} else {
			wp_send_json_error( array( 'message' => __( 'Grid nicht gefunden.', 'portfolio-grid-builder' ) ) );
		}
	}

	/**
	 * Speichert die Daten eines Grid-Items.
	 */
	public function save_grid_item() {
		$this->check_ajax_nonce();

		$grid_id = isset( $_POST['grid_id'] ) ? intval( $_POST['grid_id'] ) : 0;
		$item_id = isset( $_POST['item_id'] ) ? intval( $_POST['item_id'] ) : 0;
		$title   = sanitize_text_field( $_POST['title'] );
		$url     = esc_url_raw( $_POST['url'] );
		$thumbnail = esc_url_raw( $_POST['thumbnail'] );

		$grid_data = get_option( 'portfolio_grids', array() );

		if ( isset( $grid_data[ $grid_id ] ) && isset( $grid_data[ $grid_id ]['items'][ $item_id ] ) ) {
			$grid_data[ $grid_id ]['items'][ $item_id ]['title']     = $title;
			$grid_data[ $grid_id ]['items'][ $item_id ]['url']       = $url;
			$grid_data[ $grid_id ]['items'][ $item_id ]['thumbnail'] = $thumbnail;
			update_option( 'portfolio_grids', $grid_data );
			wp_send_json_success( array( 'message' => __( 'Item gespeichert!', 'portfolio-grid-builder' ) ) );
		} else {
			wp_send_json_error( array( 'message' => __( 'Grid oder Item nicht gefunden.', 'portfolio-grid-builder' ) ) );
		}
	}

	/**
	 * Löscht ein Grid-Item.
	 */
	public function delete_grid_item() {
		$this->check_ajax_nonce();

		$grid_id = isset( $_POST['grid_id'] ) ? intval( $_POST['grid_id'] ) : 0;
		$item_id = isset( $_POST['item_id'] ) ? intval( $_POST['item_id'] ) : 0;

		$grid_data = get_option( 'portfolio_grids', array() );

		if ( isset( $grid_data[ $grid_id ] ) && isset( $grid_data[ $grid_id ]['items'][ $item_id ] ) ) {
			unset( $grid_data[ $grid_id ]['items'][ $item_id ] );
			update_option( 'portfolio_grids', $grid_data );
			wp_send_json_success( array( 'message' => __( 'Item gelöscht!', 'portfolio-grid-builder' ) ) );
		} else {
			wp_send_json_error( array( 'message' => __( 'Grid oder Item nicht gefunden.', 'portfolio-grid-builder' ) ) );
		}
	}

	/**
	 * Überprüft den AJAX-Nonce.
	 */
	private function check_ajax_nonce() {
		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'portfolio_grid_builder_nonce' ) ) {
			wp_send_json_error( array( 'message' => __( 'Sicherheitsüberprüfung fehlgeschlagen.', 'portfolio-grid-builder' ) ) );
		}
	}
}