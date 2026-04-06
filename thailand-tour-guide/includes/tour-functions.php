<?php
/**
 * Helper functions for tours
 */

/**
 * Get tour price
 */
function ttg_get_tour_price($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    return get_post_meta($post_id, '_tour_price_per_person', true);
}

/**
 * Check if tour is customizable
 */
function ttg_is_customizable($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    return get_post_meta($post_id, '_tour_customizable', true) === '1';
}

/**
 * Get tour custom note
 */
function ttg_get_custom_note($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    return get_post_meta($post_id, '_tour_custom_note', true);
}

/**
 * Get tour itinerary
 */
function ttg_get_itinerary($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    $itinerary = get_post_meta($post_id, '_tour_itinerary', true);
    return is_array($itinerary) ? $itinerary : array();
}

/**
 * Format price
 */
function ttg_format_price($price) {
    return number_format((float)$price, 0) . ' THB';
}

/**
 * AJAX handler for tour filtering
 */
add_action('wp_ajax_ttg_filter_tours', 'ttg_filter_tours');
add_action('wp_ajax_nopriv_ttg_filter_tours', 'ttg_filter_tours');

function ttg_filter_tours() {
    check_ajax_referer('ttg_filter_nonce', 'nonce');

    $city = isset($_POST['city']) ? sanitize_text_field($_POST['city']) : '';
    $duration = isset($_POST['duration']) ? sanitize_text_field($_POST['duration']) : '';

    $args = array(
        'post_type' => 'tour',
        'posts_per_page' => -1,
        'post_status' => 'publish'
    );

    $tax_query = array('relation' => 'AND');

    if (!empty($city)) {
        $tax_query[] = array(
            'taxonomy' => 'tour_city',
            'field' => 'slug',
            'terms' => $city
        );
    }

    if (!empty($duration)) {
        $tax_query[] = array(
            'taxonomy' => 'tour_duration',
            'field' => 'slug',
            'terms' => $duration
        );
    }

    if (count($tax_query) > 1) {
        $args['tax_query'] = $tax_query;
    }

    $query = new WP_Query($args);

    ob_start();
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            include TTG_PLUGIN_DIR . 'templates/tour-card.php';
        }
        wp_reset_postdata();
    } else {
        echo '<p class="no-tours-found">' . __('No tours found matching your criteria.', 'thailand-tour-guide') . '</p>';
    }

    $html = ob_get_clean();

    wp_send_json_success(array('html' => $html));
}
