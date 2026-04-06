<?php
/**
 * Template for displaying tour list with filters
 */

// Get all cities and durations
$cities = get_terms(array(
    'taxonomy' => 'tour_city',
    'hide_empty' => false
));

$durations = get_terms(array(
    'taxonomy' => 'tour_duration',
    'hide_empty' => false
));
?>

<div class="ttg-tour-list-container">
    <!-- Filters -->
    <div class="ttg-filters">
        <div class="ttg-filter-group">
            <label for="city-filter"><?php _e('Select City:', 'thailand-tour-guide'); ?></label>
            <select id="city-filter" class="ttg-filter-select">
                <option value=""><?php _e('All Cities', 'thailand-tour-guide'); ?></option>
                <?php foreach ($cities as $city): ?>
                    <option value="<?php echo esc_attr($city->slug); ?>">
                        <?php echo esc_html($city->name); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="ttg-filter-group">
            <label for="duration-filter"><?php _e('Number of Days:', 'thailand-tour-guide'); ?></label>
            <select id="duration-filter" class="ttg-filter-select">
                <option value=""><?php _e('All Durations', 'thailand-tour-guide'); ?></option>
                <?php foreach ($durations as $duration): ?>
                    <option value="<?php echo esc_attr($duration->slug); ?>">
                        <?php echo esc_html($duration->name); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="button" class="ttg-filter-button" id="apply-filters">
            <?php _e('Search Tours', 'thailand-tour-guide'); ?>
        </button>
        <button type="button" class="ttg-reset-button" id="reset-filters">
            <?php _e('Reset', 'thailand-tour-guide'); ?>
        </button>
    </div>

    <!-- Tour Grid -->
    <div class="ttg-tours-grid" id="tours-container">
        <?php
        $args = array(
            'post_type' => 'tour',
            'posts_per_page' => $atts['posts_per_page'],
            'post_status' => 'publish'
        );

        if (!empty($atts['city'])) {
            $args['tax_query'][] = array(
                'taxonomy' => 'tour_city',
                'field' => 'slug',
                'terms' => $atts['city']
            );
        }

        if (!empty($atts['duration'])) {
            $args['tax_query'][] = array(
                'taxonomy' => 'tour_duration',
                'field' => 'slug',
                'terms' => $atts['duration']
            );
        }

        $query = new WP_Query($args);

        if ($query->have_posts()):
            while ($query->have_posts()): $query->the_post();
                include TTG_PLUGIN_DIR . 'templates/tour-card.php';
            endwhile;
            wp_reset_postdata();
        else:
            echo '<p class="no-tours-found">' . __('No tours found.', 'thailand-tour-guide') . '</p>';
        endif;
        ?>
    </div>

    <!-- Loading spinner -->
    <div class="ttg-loading" id="loading-spinner" style="display: none;">
        <div class="spinner"></div>
        <p><?php _e('Loading tours...', 'thailand-tour-guide'); ?></p>
    </div>
</div>
