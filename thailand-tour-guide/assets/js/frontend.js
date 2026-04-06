/**
 * Frontend JavaScript for Thailand Tour Guide
 */

(function($) {
    'use strict';

    $(document).ready(function() {

        // Filter functionality
        $('#apply-filters').on('click', function() {
            filterTours();
        });

        // Reset filters
        $('#reset-filters').on('click', function() {
            $('#city-filter').val('');
            $('#duration-filter').val('');
            filterTours();
        });

        // Filter on select change
        $('.ttg-filter-select').on('change', function() {
            filterTours();
        });

        // Filter function
        function filterTours() {
            var city = $('#city-filter').val();
            var duration = $('#duration-filter').val();

            // Show loading spinner
            $('#loading-spinner').show();
            $('#tours-container').css('opacity', '0.5');

            $.ajax({
                url: ttgAjax.ajaxurl,
                type: 'POST',
                data: {
                    action: 'ttg_filter_tours',
                    nonce: ttgAjax.nonce,
                    city: city,
                    duration: duration
                },
                success: function(response) {
                    if (response.success) {
                        $('#tours-container').html(response.data.html);

                        // Animate in
                        $('#tours-container').css('opacity', '1');

                        // Scroll to results (smooth scroll)
                        $('html, body').animate({
                            scrollTop: $('#tours-container').offset().top - 100
                        }, 500);
                    }
                },
                error: function() {
                    alert('An error occurred while filtering tours. Please try again.');
                },
                complete: function() {
                    $('#loading-spinner').hide();
                    $('#tours-container').css('opacity', '1');
                }
            });
        }

        // Smooth scroll for anchor links
        $('a[href^="#"]').on('click', function(e) {
            var target = $(this.getAttribute('href'));
            if(target.length) {
                e.preventDefault();
                $('html, body').stop().animate({
                    scrollTop: target.offset().top - 80
                }, 800);
            }
        });

        // Add animation on scroll (optional)
        function isInViewport(element) {
            var elementTop = $(element).offset().top;
            var elementBottom = elementTop + $(element).outerHeight();
            var viewportTop = $(window).scrollTop();
            var viewportBottom = viewportTop + $(window).height();
            return elementBottom > viewportTop && elementTop < viewportBottom;
        }

        function animateOnScroll() {
            $('.ttg-itinerary-item').each(function() {
                if (isInViewport(this)) {
                    $(this).addClass('fade-in');
                }
            });
        }

        $(window).on('scroll resize', animateOnScroll);
        animateOnScroll(); // Initial check

        // Add fade-in animation class
        if (!$('style:contains("fade-in")').length) {
            $('<style>')
                .prop('type', 'text/css')
                .html(`
                    .ttg-itinerary-item {
                        opacity: 0;
                        transform: translateY(20px);
                        transition: opacity 0.6s ease, transform 0.6s ease;
                    }
                    .ttg-itinerary-item.fade-in {
                        opacity: 1;
                        transform: translateY(0);
                    }
                `)
                .appendTo('head');
        }
    });

})(jQuery);
