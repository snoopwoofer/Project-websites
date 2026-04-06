/**
 * Admin JavaScript for Thailand Tour Guide
 */

(function($) {
    'use strict';

    $(document).ready(function() {

        var itemIndex = $('#itinerary-items .itinerary-item').length;

        // Add new itinerary item
        $('#add-itinerary-item').on('click', function() {
            var template = $('#itinerary-item-template').html();
            template = template.replace(/\{\{INDEX\}\}/g, itemIndex);
            $('#itinerary-items').append(template);
            updateItemNumbers();
            itemIndex++;
        });

        // Remove itinerary item
        $(document).on('click', '.remove-itinerary-item', function() {
            if (confirm('Are you sure you want to remove this stop?')) {
                $(this).closest('.itinerary-item').fadeOut(300, function() {
                    $(this).remove();
                    updateItemNumbers();
                });
            }
        });

        // Update item numbers
        function updateItemNumbers() {
            $('#itinerary-items .itinerary-item').each(function(index) {
                $(this).find('.item-number').text(index + 1);
                $(this).attr('data-index', index);
            });
        }

        // Media uploader for itinerary images
        var mediaUploader;

        $(document).on('click', '.upload-itinerary-image', function(e) {
            e.preventDefault();

            var button = $(this);
            var container = button.closest('.itinerary-image-container');
            var imageIdInput = container.find('.itinerary-image-id');
            var imagePreview = container.find('.itinerary-image-preview');
            var removeButton = container.find('.remove-itinerary-image');

            // If the media uploader already exists, open it
            if (mediaUploader) {
                mediaUploader.open();
                return;
            }

            // Create the media uploader
            mediaUploader = wp.media({
                title: 'Select Location Image',
                button: {
                    text: 'Use this image'
                },
                multiple: false
            });

            // When an image is selected
            mediaUploader.on('select', function() {
                var attachment = mediaUploader.state().get('selection').first().toJSON();

                // Set the image ID
                imageIdInput.val(attachment.id);

                // Display the image
                var imgUrl = attachment.sizes.medium ? attachment.sizes.medium.url : attachment.url;
                imagePreview.html('<img src="' + imgUrl + '" alt="" style="max-width: 200px; height: auto;" />');

                // Show remove button
                removeButton.show();
            });

            // Open the media uploader
            mediaUploader.open();
        });

        // Remove itinerary image
        $(document).on('click', '.remove-itinerary-image', function(e) {
            e.preventDefault();

            var button = $(this);
            var container = button.closest('.itinerary-image-container');
            var imageIdInput = container.find('.itinerary-image-id');
            var imagePreview = container.find('.itinerary-image-preview');

            if (confirm('Are you sure you want to remove this image?')) {
                imageIdInput.val('');
                imagePreview.html('');
                button.hide();
            }
        });

        // Make itinerary items sortable
        if ($.fn.sortable) {
            $('#itinerary-items').sortable({
                handle: '.itinerary-item-header',
                placeholder: 'ui-sortable-placeholder',
                start: function(e, ui) {
                    ui.placeholder.height(ui.item.height());
                },
                stop: function() {
                    updateItemNumbers();
                    updateItemIndexes();
                }
            });
        }

        // Update input names when items are reordered
        function updateItemIndexes() {
            $('#itinerary-items .itinerary-item').each(function(index) {
                $(this).find('input, textarea').each(function() {
                    var name = $(this).attr('name');
                    if (name) {
                        name = name.replace(/\[\d+\]/, '[' + index + ']');
                        $(this).attr('name', name);
                    }
                });
            });
        }

        // Initialize item numbers on load
        updateItemNumbers();
    });

})(jQuery);
