jQuery(document).ready(function($){
    // Repeater
    $('.add-link').on('click', function(e){
        e.preventDefault();
        const newField = `
            <div class="link-item">
                <input type="text" class="pa-link-url" name="pa_links[url][]" placeholder="Link URL" />
                <div class="thumb-selector">
                    <input type="text" class="pa-thumb-url" name="pa_links[thumb][]" placeholder="Thumbnail URL" />
                    <button class="button select-thumb">Bild auswählen</button>
                </div>
                <button class="button remove-link">– Entfernen</button>
            </div>`;
        $('.link-items').append(newField);
    });

    $(document).on('click', '.remove-link', function(e){
        e.preventDefault();
        $(this).closest('.link-item').remove();
    });

    // Media Uploader
    $(document).on('click', '.select-thumb', function(e){
        e.preventDefault();
        const button = $(this);
        const input = button.prev('.pa-thumb-url');

        const frame = wp.media({
            title: 'Bild auswählen',
            multiple: false,
            library: { type: 'image' },
            button: { text: 'Verwenden' }
        });

        frame.on('select', function(){
            const attachment = frame.state().get('selection').first().toJSON();
            input.val(attachment.url);
        });

        frame.open();
    });

    // Vorschau-Wechsel bei Styleauswahl
    $('select[name="pa_grid_style"]').on('change', function(){
        const style = $(this).val();
        $('#pa-grid-preview').attr('class', 'pa-grid ' + style);
    });
});
