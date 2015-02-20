/**
 *
 * -------------------------------------------
 * Script for the GK Taxonomy Images
 * -------------------------------------------
 *
 **/

(function($) {
    "use strict";

    var gk_taxonomy_images_init = function(selector, button_selector)  {
        var clicked_button = false;
 
        $(selector).each(function (i, input) {
            var button = $(input).next(button_selector);
            button.click(function (event) {
                event.preventDefault();
                var selected_img;
                clicked_button = $(this);
     
                // Singleton-like check for the media manager popup instance
                if(wp.media.frames.gk_taxonomy_images_frame) {
                    wp.media.frames.gk_taxonomy_images_frame.open();
                    return;
                }
                // Configure media manager popup
                wp.media.frames.gk_taxonomy_images_frame = wp.media({
                    multiple: false,
                    library: {
                        type: 'image'
                    }
                });
                
                // Function used on the image selection
                var gk_taxonomy_images_set_image = function() {
                    var selection = wp.media.frames.gk_taxonomy_images_frame.state().get('selection');
                    // No selected images
                    if (!selection) {
                        return;
                    }

                    // Iterating through selection
                    selection.each(function(attachment) {
                        var url = attachment.attributes.url;
                        clicked_button.prev(selector).val(url);
                        var preview = clicked_button.parent().find('.gk_taxonomy_images_preview');
                        preview.html('<img src="'+url+'" class="gk_taxonomy_images_preview_img" alt="" />');
                    });
                };
                // Image selection event
                wp.media.frames.gk_taxonomy_images_frame.on('select', gk_taxonomy_images_set_image);
                // Opening the media manager popup
                wp.media.frames.gk_taxonomy_images_frame.open();
            });
       });
    };
    // Init the code on DOMContentLoaded event
    $(document).ready(function() {
        gk_taxonomy_images_init('.gk_taxonomy_images', '.gk_taxonomy_images_btn');
        $('.gk_taxonomy_images_btn_remove').click(function(e) {
            e.preventDefault();
            $(this).parent().find('.gk_taxonomy_images_preview').html('');
            $(this).parent().find('.gk_taxonomy_images').val('');
        });
    });
})(jQuery);