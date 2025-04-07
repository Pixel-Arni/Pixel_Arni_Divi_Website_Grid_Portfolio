<?php

/**
 * Die Frontend-spezifische Funktionalität des Plugins definieren.
 *
 * @package Portfolio_Grid_Builder
 * @author Dein Name
 */
class Portfolio_Grid_Builder_Public {

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
	 * @param string $plugin_name Der Name des Plugins.
	 * @param string $version Die Version des Plugins.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * Registriere die Stylesheets für den Frontend-Bereich.
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name . '-public', plugin_dir_url( __FILE__ ) . 'css/portfolio-grid-builder-public.css', array(), $this->version, 'all' );
	}

	/**
	 * Gibt das HTML für das Portfolio-Grid basierend auf dem Shortcode zurück.
	 *
	 * @param array $atts Die Attribute des Shortcodes.
	 * @return string Das HTML für das Portfolio-Grid.
	 */
	public function display_portfolio_grid( $atts ) {
		$atts = shortcode_atts(
			array(
				'id' => 0,
			),
			$atts,
			'portfolio_grid'
		);

		$grid_id   = intval( $atts['id'] );
		$grid_data = get_option( 'portfolio_grids', array() );

		if ( isset( $grid_data[ $grid_id ] ) ) {
			$grid = $grid_data[ $grid_id ];
			$output = '<div class="portfolio-grid-container" style="--grid-gap: ' . esc_attr( $grid['styles']['grid_gap'] ) . 'px;">';
			foreach ( $grid['items'] as $item ) {
				$output .= '<div class="portfolio-grid-item" style="width: ' . esc_attr( $grid['styles']['thumbnail_width'] ) . 'px; border-color: ' . esc_attr( $grid['styles']['border_color'] ) . ';">';
				$output .= '<a href="' . esc_url( $item['url'] ) . '" target="_blank">';
				if ( ! empty( $item['thumbnail'] ) ) {
					$output .= '<img src="' . esc_url( $item['thumbnail'] ) . '" alt="' . esc_attr( $item['title'] ) . '" style="max-width: 100%; height: auto; display: block;">';
				} else {
					$output .= '<div class="no-thumbnail">' . esc_html( $item['title'] ) . '</div>';
				}
				$output .= '</a>';
				$output .= '</div>';
			}
			$output .= '</div>';
			return $output;
		} else {
			return '<p>' . esc_html__( 'Portfolio Grid nicht gefunden.', 'portfolio-grid-builder' ) . '</p>';
		}
	}
}