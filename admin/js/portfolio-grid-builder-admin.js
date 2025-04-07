jQuery(document).ready(function($) {
    var $gridList = $('#the-list');
    var $gridEditor = $('#portfolio-grid-editor');
    var $gridForm = $('#portfolio-grid-form');
    var $gridIdInput = $('#grid-id');
    var $gridNameInput = $('#grid-name');
    var $gridGapInput = $('#grid-gap');
    var $thumbnailWidthInput = $('#thumbnail-width');
    var $borderColorInput = $('#border-color');
    var $gridItemsContainer = $('#grid-items-container');
    var $addNewGridButton = $('#add-new-grid');
    var $saveGridButton = $('#save-grid');
    var $cancelEditGridButton = $('#cancel-edit-grid');
    var $addNewGridItemButton = $('#add-new-grid-item');
    var $portfolioGridItemEditor = $('#portfolio-grid-item-editor');
    var $portfolioGridItemForm = $('#portfolio-grid-item-form');
    var $itemIdInput = $('#item-id');
    var $itemGridIdInput = $('#item-grid-id');
    var $itemTitleInput = $('#item-title');
    var $itemUrlInput = $('#item-url');
    var $itemThumbnailInput = $('#item-thumbnail');
    var $saveItemButton = $('#save-item');
    var $cancelEditItemButton = $('#cancel-edit-item');
    var $notices = $('#portfolio-grid-builder-notices');

    function showNotice(message, type = 'success') {
        $notices.append(`<div class="notice notice-${type} is-dismissible"><p>${message}</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Diese Meldung ausblenden.</span></button></div>`);
        $('.notice-dismiss').on('click', function() {
            $(this).parent().remove();
        });
    }

    function loadGrids() {
        $.ajax({
            url: portfolioGridBuilderAdmin.ajax_url,
            type: 'POST',
            data: {
                action: 'load_portfolio_grid', // Wir verwenden die gleiche Action, um alle Grids zu laden
                nonce: portfolioGridBuilderAdmin.nonce,
                grid_id: 0 // Spezifische ID ist hier nicht relevant
            },
            success: function(response) {
                if (response && typeof response === 'object') {
                    $gridList.empty();
                    $.each(response, function(gridId, gridData) {
                        $gridList.append(`
                            <tr>
                                <td><strong>${gridData.name}</strong></td>
                                <td><code>[portfolio_grid id="${gridId}"]</code></td>
                                <td>
                                    <button class="edit-grid button button-secondary" data-grid-id="${gridId}">${portfolioGridBuilderAdmin.edit}</button>
                                    <button class="delete-grid button button-secondary" data-grid-id="${gridId}">${portfolioGridBuilderAdmin.delete}</button>
                                </td>
                            </tr>
                        `);
                    });
                    if ($gridList.is(':empty')) {
                        $gridList.append('<tr><td colspan="3">' + portfolioGridBuilderAdmin.no_grids + '</td></tr>');
                    }
                } else {
                    $gridList.empty().append('<tr><td colspan="3">' + portfolioGridBuilderAdmin.error_loading + '</td></tr>');
                }
            },
            error: function() {
                $gridList.empty().append('<tr><td colspan="3">' + portfolioGridBuilderAdmin.error_loading + '</td></tr>');
            }
        });
    }

    function loadGridData(gridId) {
        $.ajax({
            url: portfolioGridBuilderAdmin.ajax_url,
            type: 'POST',
            data: {
                action: 'load_portfolio_grid',
                nonce: portfolioGridBuilderAdmin.nonce,
                grid_id: gridId
            },
            success: function(response) {
                if (response.success) {
                    var grid = response.data;
                    $gridIdInput.val(grid.id);
                    $gridNameInput.val(grid.name);
                    $gridGapInput.val(grid.styles.grid_gap);
                    $thumbnailWidthInput.val(grid.styles.thumbnail_width);
                    $borderColorInput.wpColorPicker('color', grid.styles.border_color);

                    $gridItemsContainer.empty();
                    if (grid.items && Object.keys(grid.items).length > 0) {
                        $.each(grid.items, function(itemId, itemData) {
                            $gridItemsContainer.append(createGridItemElement(grid.id, itemId, itemData.title, itemData.thumbnail));
                        });
                    }
                } else {
                    showNotice(response.data.message, 'error');
                }
            },
            error: function() {
                showNotice(portfolioGridBuilderAdmin.error_loading_grid_data, 'error');
            }
        });
    }

    function createGridItemElement(gridId, itemId, title, thumbnail) {
        return $(`
            <div class="grid-item" data-item-id="${itemId}">
                <strong>${title || portfolioGridBuilderAdmin.new_item}</strong>
                ${thumbnail ? `<img src="${thumbnail}" style="max-width: 100px; height: auto; vertical-align: middle; margin-left: 10px;">` : ''}
                <div class="grid-item-actions">
                    <button class="edit-grid-item button button-secondary button-small" data-grid-id="${gridId}" data-item-id="${itemId}">${portfolioGridBuilderAdmin.edit}</button>
                    <button class="delete-grid-item button button-secondary button-small" data-grid-id="${gridId}" data-item-id="${itemId}">${portfolioGridBuilderAdmin.delete}</button>
                </div>
            </div>
        `);
    }

    $addNewGridButton.on('click', function() {
        $gridEditor.show();
        $('#portfolio-grid-list').hide();
        $gridForm[0].reset();
        $gridIdInput.val(0);
        $gridItemsContainer.empty();
    });

    $cancelEditGridButton.on('click', function() {
        $gridEditor.hide();
        $('#portfolio-grid-list').show();
    });

    $saveGridButton.on('click', function(e) {
        e.preventDefault();
        $.ajax({
            url: portfolioGridBuilderAdmin.ajax_url,
            type: 'POST',
            data: {
                action: 'save_portfolio_grid',
                nonce: portfolioGridBuilderAdmin.nonce,
                grid_id: $gridIdInput.val(),
                grid_name: $gridNameInput.val(),
                grid_gap: $gridGapInput.val(),
                thumbnail_width: $thumbnailWidthInput.val(),
                border_color: $borderColorInput.val()
            },
            success: function(response) {
                if (response.success) {
                    showNotice(response.data.message);
                    $gridEditor.hide();
                    $('#portfolio-grid-list').show();
                    loadGrids();
                } else {
                    showNotice(response.data.message, 'error');
                }
            },
            error: function() {
                showNotice(portfolioGridBuilderAdmin.error_saving, 'error');
            }
        });
    });

    $(document).on('click', '.edit-grid', function() {
        var gridId = $(this).data('grid-id');
        loadGridData(gridId);
        $gridEditor.show();
        $('#portfolio-grid-list').hide();
    });

    $(document).on('click', '.delete-grid', function() {
        var gridId = $(this).data('grid-id');
        if (confirm(portfolioGridBuilderAdmin.confirm_delete_grid)) {
            $.ajax({
                url: portfolioGridBuilderAdmin.ajax_url,
                type: 'POST',
                data: {
                    action: 'delete_portfolio_grid',
                    nonce: portfolioGridBuilderAdmin.nonce,
                    grid_id: gridId
                },
                success: function(response) {
                    if (response.success) {
                        showNotice(response.data.message);
                        loadGrids();
                    } else {
                        showNotice(response.data.message, 'error');
                    }
                },
                error: function() {
                    showNotice(portfolioGridBuilderAdmin.error_deleting, 'error');
                }
            });
        }
    });

    $addNewGridItemButton.on('click', function() {
        var gridId = $gridIdInput.val();
        if (!gridId) {
            showNotice(portfolioGridBuilderAdmin.save_grid_first, 'warning');
            return;
        }
        $.ajax({
            url: portfolioGridBuilderAdmin.ajax_url,
            type: 'POST',
            data: {
                action: 'add_grid_item',
                nonce: portfolioGridBuilderAdmin.nonce,
                grid_id: gridId
            },
            success: function(response) {
                if (response.success) {
                    $gridItemsContainer.append(createGridItemElement(gridId, response.data.item_id, portfolioGridBuilderAdmin.new_item, ''));
                } else {
                    showNotice(response.data.message, 'error');
                }
            },
            error: function() {
                showNotice(portfolioGridBuilderAdmin.error_adding_item, 'error');
            }
        });
    });

    $(document).on('click', '.edit-grid-item', function() {
        var gridId = $(this).data('grid-id');
        var itemId = $(this).data('item-id');
        var itemElement = $(this).closest('.grid-item');
        var title = itemElement.find('strong').text();
        var thumbnailSrc = itemElement.find('img').attr('src') || '';

        $portfolioGridItemEditor.show();
        $gridEditor.hide();
        $itemIdInput.val(itemId);
        $itemGridIdInput.val(gridId);
        $itemTitleInput.val(title);
        $itemUrlInput.val(''); // Hier ggf. URL laden, wenn wir sie im DOM speichern
        $itemThumbnailInput.val(thumbnailSrc);
        $('#thumbnail-preview').html(thumbnailSrc ? `<img src="${thumbnailSrc}" style="max-width: 100px; height: auto;">` : '');
    });

    $cancelEditItemButton.on('click', function() {
        $portfolioGridItemEditor.hide();
        $gridEditor.show();
    });

    $saveItemButton.on('click', function(e) {
        e.preventDefault();
        $.ajax({
            url: portfolioGridBuilderAdmin.ajax_url,
            type: 'POST',
            data: {
                action: 'save_grid_item',
                nonce: portfolioGridBuilderAdmin.nonce,
                grid_id: $itemGridIdInput.val(),
                item_id: $itemIdInput.val(),
                title: $itemTitleInput.val(),
                url: $itemUrlInput.val(),
                thumbnail: $itemThumbnailInput.val()
            },
            success: function(response) {
                if (response.success) {
                    showNotice(response.data.message);
                    $portfolioGridItemEditor.hide();
                    loadGridData($itemGridIdInput.val()); // Reload grid items
                    $gridEditor.show();
                } else {
                    showNotice(response.data.message, 'error');
                }
            },
            error: function() {
                showNotice(portfolioGridBuilderAdmin.error_saving_item, 'error');
            }
        });
    });

    $(document).on('click', '.delete-grid-item', function() {
        var gridId = $(this).data('grid-id');
        var itemId = $(this).data('item-id');
        var $itemElement = $(this).closest('.grid-item');
        if (confirm(portfolioGridBuilderAdmin.confirm_delete_item)) {
            $.ajax({
                url: portfolioGridBuilderAdmin.ajax_url,
                type: 'POST',
                data: {
                    action: 'delete_grid_item',
                    nonce: portfolioGridBuilderAdmin.nonce,
                    grid_id: gridId,
                    item_id: itemId
                },
                success: function(response) {
                    if (response.success) {
                        showNotice(response.data.message);
                        $itemElement.remove();
                    } else {
                        showNotice(response.data.message, 'error');
                    }
                },
                error: function() {
                    showNotice(portfolioGridBuilderAdmin.error_deleting_item, 'error');
                }
            });
        }
    });

    // Media Upload
    $(document).on('click', '.upload_image_button', function(e) {
        e.preventDefault();
        var $thumbnailInput = $(this).siblings('#item-thumbnail');
        var $preview = $(this).siblings('#thumbnail-preview');
        var image = wp.media({
            title: portfolioGridBuilderAdmin.upload_image_title,
            multiple: false
        }).open()
            .on('select', function(e) {
                var uploaded_image = image.state().get('selection').first();
                var image_url = uploaded_image.toJSON().url;
                $thumbnailInput.val(image_url);
                $preview.html(`<img src="${image_url}" style="max-width: 100px; height: auto;">`);
            });
    });

    // Color Picker
    $('.portfolio-color-picker').wpColorPicker();

    // Initial load of grids
    loadGrids();
});