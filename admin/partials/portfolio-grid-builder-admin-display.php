<?php
/**
 * Bietet die HTML für die Admin-Seite des Plugins.
 *
 * @package Portfolio_Grid_Builder
 */
?>
<div class="wrap">
	<h1><?php esc_html_e( 'Portfolio Grid Builder', 'portfolio-grid-builder' ); ?></h1>

	<div id="portfolio-grid-builder-notices"></div>

	<div id="portfolio-grid-list">
		<h2><?php esc_html_e( 'Vorhandene Grids', 'portfolio-grid-builder' ); ?></h2>
		<table class="wp-list-table widefat fixed striped">
			<thead>
				<tr>
					<th><?php esc_html_e( 'Name', 'portfolio-grid-builder' ); ?></th>
					<th><?php esc_html_e( 'Shortcode', 'portfolio-grid-builder' ); ?></th>
					<th><?php esc_html_e( 'Aktionen', 'portfolio-grid-builder' ); ?></th>
				</tr>
			</thead>
			<tbody id="the-list">
				</tbody>
			<tfoot>
				<tr>
					<th><?php esc_html_e( 'Name', 'portfolio-grid-builder' ); ?></th>
					<th><?php esc_html_e( 'Shortcode', 'portfolio-grid-builder' ); ?></th>
					<th><?php esc_html_e( 'Aktionen', 'portfolio-grid-builder' ); ?></th>
				</tr>
			</tfoot>
		</table>
		<p><button id="add-new-grid" class="button button-primary"><?php esc_html_e( 'Neues Grid hinzufügen', 'portfolio-grid-builder' ); ?></button></p>
	</div>

	<div id="portfolio-grid-editor" style="display: none;">
		<h2><?php esc_html_e( 'Grid bearbeiten', 'portfolio-grid-builder' ); ?></h2>
		<form id="portfolio-grid-form">
			<input type="hidden" id="grid-id" name="grid_id" value="">
			<table class="form-table">
				<tbody>
					<tr>
						<th scope="row"><label for="grid-name"><?php esc_html_e( 'Grid Name', 'portfolio-grid-builder' ); ?></label></th>
						<td><input type="text" id="grid-name" name="grid_name" class="regular-text"></td>
					</tr>
					<tr>
						<th scope="row"><label for="grid-gap"><?php esc_html_e( 'Abstand zwischen Elementen (in px)', 'portfolio-grid-builder' ); ?></label></th>
						<td><input type="number" id="grid-gap" name="grid_gap" value="10" class="small-text"> px</td>
					</tr>
					<tr>
						<th scope="row"><label for="thumbnail-width"><?php esc_html_e( 'Breite der Thumbnails (in px)', 'portfolio-grid-builder' ); ?></label></th>
						<td><input type="number" id="thumbnail-width" name="thumbnail_width" value="300" class="small-text"> px</td>
					</tr>
					<tr>
						<th scope="row"><label for="border-color"><?php esc_html_e( 'Rahmenfarbe', 'portfolio-grid-builder' ); ?></label></th>
						<td><input type="text" id="border-color" name="border_color" class="portfolio-color-picker" data-default-color="#eee"></td>
					</tr>
					</tbody>
			</table>

			<h3><?php esc_html_e( 'Grid Elemente', 'portfolio-grid-builder' ); ?></h3>
			<div id="grid-items-container">
				</div>
			<p><button type="button" id="add-new-grid-item" class="button"><?php esc_html_e( 'Neues Element hinzufügen', 'portfolio-grid-builder' ); ?></button></p>

			<p class="submit">
				<button type="button" id="save-grid" class="button button-primary"><?php esc_html_e( 'Grid speichern', 'portfolio-grid-builder' ); ?></button>
				<button type="button" id="cancel-edit-grid" class="button"><?php esc_html_e( 'Abbrechen', 'portfolio-grid-builder' ); ?></button>
			</p>
		</form>
	</div>

	<div id="portfolio-grid-item-editor" style="display: none;">
		<h2><?php esc_html_e( 'Element bearbeiten', 'portfolio-grid-builder' ); ?></h2>
		<form id="portfolio-grid-item-form">
			<input type="hidden" id="item-id" name="item_id" value="">
			<input type="hidden" id="item-grid-id" name="grid_id" value="">
			<table class="form-table">
				<tbody>
					<tr>
						<th scope="row"><label for="item-title"><?php esc_html_e( 'Titel', 'portfolio-grid-builder' ); ?></label></th>
						<td><input type="text" id="item-title" name="title" class="regular-text"></td>
					</tr>
					<tr>
						<th scope="row"><label for="item-url"><?php esc_html_e( 'URL', 'portfolio-grid-builder' ); ?></label></th>
						<td><input type="url" id="item-url" name="url" class="regular-text"></td>
					</tr>
					<tr>
						<th scope="row"><label for="item-thumbnail"><?php esc_html_e( 'Thumbnail', 'portfolio-grid-builder' ); ?></label></th>
						<td>
							<input type="text" id="item-thumbnail" name="thumbnail" class="regular-text">
							<button type="button" class="button upload_image_button"><?php esc_html_e( 'Bild hochladen', 'portfolio-grid-builder' ); ?></button>
							<p class="description"><?php esc_html_e( 'Oder füge die URL des Bildes ein.', 'portfolio-grid-builder' ); ?></p>
							<div id="thumbnail-preview" style="margin-top: 10px;"></div>
						</td>
					</tr>
				</tbody>
			</table>
			<p class="submit">
				<button type="button" id="save-item" class="button button-primary"><?php esc_html_e( 'Element speichern', 'portfolio-grid-builder' ); ?></button>
				<button type="button" id="cancel-edit-item" class="button"><?php esc_html_e( 'Abbrechen', 'portfolio-grid-builder' ); ?></button>
			</p>
		</form>
	</div>
</div>